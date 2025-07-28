<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prompt'])) {
    $apiKey = $_POST['key'] ?? ''; // get key from POST
    $role = $_POST['role'] ?? '';  // get role from POST
    $userPrompt = $_POST['prompt'];

    if (!$apiKey || !$role) {
        echo " Missing API key or role.";
        exit;
    }

    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $apiKey;

    $postData = [
        "contents" => [
            [
                "parts" => [
                    ["text" => $role . "\n\nUser: " . $userPrompt]
                ]
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? ' Error getting reply.';
    echo $reply;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Gemini Real-Time Chat</title>
  <style>
    body {
      background: #111;
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 40px;
    }
    h1 { color: #ffd700; }
    #chatBox {
      width: 100%;
      max-width: 600px;
      height: 400px;
      background: #1f1f1f;
      padding: 20px;
      border-radius: 10px;
      overflow-y: auto;
      white-space: pre-wrap;
      margin-bottom: 20px;
    }
    .user-msg { color: #33ccff; }
    .bot-msg  { color: #ff6666; }
    form {
      display: flex;
      gap: 10px;
      max-width: 600px;
      width: 100%;
    }
    input[type="text"] {
      flex: 1;
      padding: 12px;
      font-size: 16px;
      border-radius: 8px;
      border: none;
      background-color: #2a2a2a;
      color: #fff;
    }
    button {
      padding: 12px 20px;
      background-color: #ff3c3c;
      border: none;
      border-radius: 8px;
      color: #fff;
      cursor: pointer;
    }

    /* Modal */
    #setupModal {
      position: fixed;
      top: 0; left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0,0,0,0.8);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }
    .modal-content {
      background: #1e1e1e;
      padding: 30px;
      border-radius: 10px;
      text-align: center;
      max-width: 400px;
      width: 90%;
    }
    .modal-content input, .modal-content textarea {
      width: 100%;
      margin-top: 10px;
      padding: 10px;
      font-size: 14px;
      border-radius: 5px;
      border: none;
      background: #333;
      color: white;
    }
    .modal-content button {
      margin-top: 15px;
      padding: 10px 20px;
      background: #ff3c3c;
      border: none;
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>

<h1>🌟 Gemini Real-Time Chat</h1>

<div id="chatBox"></div>

<form id="chatForm">
  <input type="text" id="prompt" placeholder="Ask something..." required>
  <button type="submit">Send</button>
</form>

<!-- Modal for API key + role -->
<div id="setupModal">
  <div class="modal-content">
    <h2>🔐 Enter Gemini API Key & Role</h2>
    <input type="text" id="apiKeyInput" placeholder="Enter your Gemini API key" />
    <textarea id="roleInput" rows="4" placeholder="Enter custom role prompt..."></textarea>
    <button onclick="saveSetup()">Start Chat</button>
  </div>
</div>

<script>
  const form = document.getElementById('chatForm');
  const promptInput = document.getElementById('prompt');
  const chatBox = document.getElementById('chatBox');

  let apiKey = "";
  let customRole = "";

  function saveSetup() {
    apiKey = document.getElementById('apiKeyInput').value.trim();
    customRole = document.getElementById('roleInput').value.trim();
    if (!apiKey || !customRole) {
      alert("Please enter both API key and role.");
      return;
    }
    localStorage.setItem('gemini_key', apiKey);
    localStorage.setItem('gemini_role', customRole);
    document.getElementById('setupModal').style.display = 'none';
  }

  window.onload = () => {
    apiKey = localStorage.getItem('gemini_key') || '';
    customRole = localStorage.getItem('gemini_role') || '';
    if (!apiKey || !customRole) {
      document.getElementById('setupModal').style.display = 'flex';
    } else {
      document.getElementById('setupModal').style.display = 'none';
    }
  };

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const prompt = promptInput.value.trim();
    if (!prompt) return;

    const userLine = document.createElement('div');
    userLine.className = 'user-msg';
    userLine.textContent = 'You: ' + prompt;
    chatBox.appendChild(userLine);

    chatBox.scrollTop = chatBox.scrollHeight;
    promptInput.value = '';

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
      const botLine = document.createElement('div');
      botLine.className = 'bot-msg';
      botLine.textContent = 'Gemini: ' + this.responseText;
      chatBox.appendChild(botLine);
      chatBox.scrollTop = chatBox.scrollHeight;
    };
    xhr.send('prompt=' + encodeURIComponent(prompt) +
             '&key=' + encodeURIComponent(apiKey) +
             '&role=' + encodeURIComponent(customRole));
  });
</script>

</body>
</html>
