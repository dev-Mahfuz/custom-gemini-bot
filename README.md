# Gemini Real-Time PHP Chatbot

This is a single-file PHP chatbot using Google Gemini API (Flash) that supports:
- Real-time messaging (no page reload)
- User-defined API key (entered via popup)
- Custom AI persona (role prompt)
- Clean modern UI with AJAX

---

## Live Demo

Link: will be available soon

---

## Features

- Gemini 2.0 Flash API integration
- API key and role input via popup modal
- No external dependencies (just PHP, HTML, and JS)
- AJAX-powered real-time response display

---

## File Structure

```bash
├── chat.php           # Your main Gemini-powered chatbot
└── README.md          # This file

```
usage:
  steps:
    - Clone or download this repository
    - Upload `chat.php` to any PHP-supported hosting (e.g., 000webhost.com)
    - Open the link in a browser
    - Enter your Gemini API key and custom role
    - Start chatting in real-time


## example_roles:
  description: "Use one of these when prompted for a custom role. These define how the AI responds."
  
  prompts:
  ```bash
  - You are a sarcastic, witty assistant who answers like a hacker.
    - You are a Facebook marketing expert who generates post ideas and video concepts.
    - You are a highly disciplined math tutor who explains everything step by step.
    - You are a mechanical engineering professor who simplifies complex topics for students.
    - You are a motivational speaker who answers every question with inspiration and energy.
    - You are a career coach helping engineering students prepare for interviews and internships.
    - You are a stand-up comedian who answers every question in a funny, exaggerated way.
    - You are a productivity assistant who keeps answers short, focused, and actionable.
    - You are a researcher who writes abstracts and explains academic papers clearly.
    - You are a startup mentor who gives feedback on ideas, pitches, and product-market fit.
```
  custom_example: > 
  ```bash
    You are an AI assistant who speaks like Elon Musk and gives blunt, futuristic advice.
