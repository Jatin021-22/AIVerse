<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot | AIVerse</title>
    <link rel="icon" href="../img\Screenshot_2025-06-29_121809-removebg-preview.png" type="image/png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <link rel="stylesheet" href="../css/font.css">
    <style>

        body {
            
            min-height: 100vh;
        }

        .chatbot-container {
            width: 100%;
            max-width: 750px;
            height: 650px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1), 
                        0 5px 15px rgba(0, 0, 0, 0.07),
                        inset 0 0 15px rgba(255, 255, 255, 0.3);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
            transform-style: preserve-3d;
            perspective: 1000px;
            margin-top:100px;
            margin-left:390px;
            margin-bottom:20px;
            
        }

        .chatbot-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(74, 144, 226, 0.1) 0%, rgba(240, 248, 255, 0.05) 100%);
            pointer-events: none;
            z-index: -1;
        }

        .chat-header {
            padding: 20px;
            background: rgba(74, 144, 226, 0.9);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            gap: 12px;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        .bot-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4a90e2, #1877f2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
            box-shadow: 0 4px 10px rgba(74, 144, 226, 0.4);
        }

        .bot-info h3 {
            color: white;
            font-size: 16px;
            margin-bottom: 4px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .bot-status {
            color: rgba(255, 255, 255, 0.9);
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #76e063;
            animation: pulse 2s infinite;
            box-shadow: 0 0 5px rgba(118, 224, 99, 0.7);
        }

        @keyframes pulse {
            0% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(0.95); }
            100% { opacity: 1; transform: scale(1); }
        }

        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 16px;
            background-color: rgba(248, 250, 252, 0.7);
        }

        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: rgba(200, 220, 255, 0.1);
            border-radius: 3px;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: rgba(74, 144, 226, 0.5);
            border-radius: 3px;
        }

        .message {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            opacity: 0;
            transform: translateY(20px);
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.05));
        }

        .message.user {
            flex-direction: row-reverse;
        }

        .message-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            flex-shrink: 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .message.bot .message-avatar {
            background: linear-gradient(135deg, #4a90e2, #1877f2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            font-weight: bold;
        }

        .message.user .message-avatar {
            background: linear-gradient(135deg, #6c757d, #495057);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            font-weight: bold;
        }

        .message-content {
            max-width: 75%;
            padding: 12px 16px;
            border-radius: 18px;
            color: #333;
            font-size: 14px;
            line-height: 1.4;
            word-wrap: break-word;
            transition: all 0.3s ease;
        }

        .message.bot .message-content {
            background: rgba(227, 242, 253, 0.9);
            border-bottom-left-radius: 6px;
            color: #1a237e;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        .message.user .message-content {
            background: rgba(255, 255, 255, 0.9);
            border-bottom-right-radius: 6px;
            color: #333;
            border: 1px solid rgba(224, 224, 224, 0.5);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        .typing-indicator {
            display: flex;
            align-items: center;
            gap: 10px;
            opacity: 0;
            transform: translateY(20px);
        }

        .typing-dots {
            display: flex;
            gap: 4px;
            padding: 12px 16px;
            background: rgba(227, 242, 253, 0.9);
            border-radius: 18px;
            border-bottom-left-radius: 6px;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        .typing-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #4a90e2;
            animation: typingDot 1.4s infinite;
        }

        .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typingDot {
            0%, 60%, 100% { opacity: 0.3; transform: scale(0.8); }
            30% { opacity: 1; transform: scale(1); }
        }

        .chat-input {
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-top: 1px solid rgba(224, 224, 224, 0.5);
            display: flex;
            gap: 12px;
            align-items: center;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        .input-field {
            flex: 1;
            background: rgba(241, 245, 249, 0.9);
            border: 1px solid rgba(224, 224, 224, 0.7);
            border-radius: 25px;
            padding: 12px 20px;
            color: #333;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        .input-field::placeholder {
            color: #90a4ae;
        }

        .input-field:focus {
            border-color: #4a90e2;
            background: rgba(255, 255, 255, 0.95);
            transform: scale(1.02);
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
        }

        .send-button {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4a90e2, #1877f2);
            border: none;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.4);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        .send-button:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.6);
        }

        .send-button:active {
            transform: scale(0.95) rotate(0);
        }

        .send-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: scale(1) rotate(0);
        }

        /* Welcome animation */
        .welcome-message {
            text-align: center;
            color: #4a90e2;
            font-size: 14px;
            margin-bottom: 20px;
            opacity: 0;
            padding: 12px;
            background: rgba(227, 242, 253, 0.7);
            border-radius: 12px;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        /* Floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
                background-attachment: fixed;
            }
            
            .chatbot-container {
                height: 100vh;
                max-height: 100vh;
                border-radius: 0;
                backdrop-filter: blur(15px);
                -webkit-backdrop-filter: blur(15px);
            }
            
            .chat-messages {
                padding: 15px;
            }
            
            .chat-header {
                padding: 15px;
            }
            
            .chat-input {
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            .message-content {
                max-width: 85%;
                font-size: 13px;
            }
            
            .chat-header h3 {
                font-size: 14px;
            }
            
            .bot-status {
                font-size: 11px;
            }
        }
    </style>
</head>

<body>
    <?php include 'header.php'; include 'background.php'; ?>
        <div style="padding: 20px 30px; background: linear-gradient(to right, #e0f7faaa, #f0fcff54); border-radius: 12px; margin: 30px auto; max-width: 600px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); color: #0077b6; display: flex; align-items: center; gap: 10px; font-size: 18px; margin-top:150px;">
  <i class="fa-solid fa-house" style="color: #00b4d8;"></i>
  <a href="index.php" style="color: #0077b6; text-decoration: none; font-weight: 500;">Home</a>
  <span>/</span>
  <i class="fa-solid fa-briefcase" style="color: #00b4d8;"></i>
  <a href="service.php" style="color: #0077b6; text-decoration: none; font-weight: 500;">Services</a>
  <span>/</span>
  <span style="font-weight: bold;">Vision Generator</span>
</div>

    <div class="chatbot-container">
        <div class="chat-header">
            <div class="bot-avatar">AI</div>
            <div class="bot-info">
                <h3>ChatBot Assistant</h3>
                <div class="bot-status">
                    <div class="status-dot"></div>
                    Online
                </div>
            </div>
        </div>
        
        <div class="chat-messages" id="chatMessages">
            <div class="welcome-message">
                👋 Welcome! I'm your AI assistant. How can I help you today?
            </div>
        </div>
        
        <div class="chat-input">
            <input type="text" class="input-field" id="messageInput" placeholder="Type your message..." maxlength="500">
            <button class="send-button" id="sendButton">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 2L11 13"/>
                    <path d="M22 2L15 22L11 13L2 9L22 2Z"/>
                </svg>
            </button>
        </div>
    </div>
<!--
    <script>
        class ChatBot {
            constructor() {
                this.messagesContainer = document.getElementById('chatMessages');
                this.messageInput = document.getElementById('messageInput');
                this.sendButton = document.getElementById('sendButton');
                this.isTyping = false;
                this.messageCount = 0;
                
                this.init();
            }
            
            init() {
                this.setupEventListeners();
                this.showWelcomeMessage();
                this.animateContainer();
                this.setupHoverEffects();
            }
            
            setupEventListeners() {
                this.sendButton.addEventListener('click', () => this.sendMessage());
                this.messageInput.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        this.sendMessage();
                    }
                });
                
                this.messageInput.addEventListener('input', () => {
                    this.sendButton.disabled = !this.messageInput.value.trim();
                });
            }
            
            animateContainer() {
                // Initial container animation
                gsap.fromTo('.chatbot-container', 
                    {
                        scale: 0.8,
                        opacity: 0,
                        y: 50,
                        rotationX: 15,
                        transformPerspective: 1000
                    },
                    {
                        scale: 1,
                        opacity: 1,
                        y: 0,
                        rotationX: 0,
                        duration: 1,
                        ease: 'back.out(1.7)'
                    }
                );
                
            }
            
            showWelcomeMessage() {
                gsap.to('.welcome-message', {
                    opacity: 1,
                    scale: 1,
                    duration: 1,
                    delay: 0.5,
                    ease: 'elastic.out(1, 0.5)'
                });
            }
            
            sendMessage() {
                const message = this.messageInput.value.trim();
                if (!message || this.isTyping) return;
                
                this.addMessage(message, 'user');
                this.messageInput.value = '';
                this.sendButton.disabled = true;
                
                // Animate send button
                gsap.to(this.sendButton, {
                    scale: 0.9,
                    duration: 0.1,
                    yoyo: true,
                    repeat: 1,
                    ease: 'power2.inOut',
                    onComplete: () => {
                        setTimeout(() => {
                            this.showTypingIndicator();
                            setTimeout(() => {
                                this.hideTypingIndicator();
                                this.generateBotResponse(message);
                            }, 1500 + Math.random() * 1000);
                        }, 300);
                    }
                });
            }
            
            addMessage(text, type) {
                this.messageCount++;
                const messageElement = document.createElement('div');
                messageElement.className = `message ${type}`;
                
                const avatar = document.createElement('div');
                avatar.className = 'message-avatar';
                avatar.textContent = type === 'user' ? 'U' : 'AI';
                
                const content = document.createElement('div');
                content.className = 'message-content';
                content.textContent = text;
                
                messageElement.appendChild(avatar);
                messageElement.appendChild(content);
                
                this.messagesContainer.appendChild(messageElement);
                
                // Animate message appearance with different effects based on type
                if (type === 'user') {
                    gsap.fromTo(messageElement, 
                        {
                            opacity: 0,
                            x: 50,
                            scale: 0.9
                        },
                        {
                            opacity: 1,
                            x: 0,
                            scale: 1,
                            duration: 0.5,
                            ease: 'back.out(1.7)'
                        }
                    );
                } else {
                    gsap.fromTo(messageElement, 
                        {
                            opacity: 0,
                            x: -50,
                            scale: 0.9
                        },
                        {
                            opacity: 1,
                            x: 0,
                            scale: 1,
                            duration: 0.5,
                            ease: 'back.out(1.7)'
                        }
                    );
                }
                
                // Add hover animation
                messageElement.addEventListener('mouseenter', () => {
                    gsap.to(messageElement, {
                        y: -3,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                });
                
                messageElement.addEventListener('mouseleave', () => {
                    gsap.to(messageElement, {
                        y: 0,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                });
                
                this.scrollToBottom();
            }
            
            showTypingIndicator() {
                this.isTyping = true;
                const typingElement = document.createElement('div');
                typingElement.className = 'typing-indicator';
                typingElement.id = 'typingIndicator';
                
                const avatar = document.createElement('div');
                avatar.className = 'message-avatar';
                avatar.style.background = 'linear-gradient(135deg, #4a90e2, #1877f2)';
                avatar.style.display = 'flex';
                avatar.style.alignItems = 'center';
                avatar.style.justifyContent = 'center';
                avatar.style.color = 'white';
                avatar.style.fontSize = '14px';
                avatar.style.fontWeight = 'bold';
                avatar.textContent = 'AI';
                
                const dotsContainer = document.createElement('div');
                dotsContainer.className = 'typing-dots';
                
                for (let i = 0; i < 3; i++) {
                    const dot = document.createElement('div');
                    dot.className = 'typing-dot';
                    dotsContainer.appendChild(dot);
                }
                
                typingElement.appendChild(avatar);
                typingElement.appendChild(dotsContainer);
                
                this.messagesContainer.appendChild(typingElement);
                
                // Animate typing indicator with a bounce effect
                gsap.fromTo(typingElement, 
                    {
                        opacity: 0,
                        y: 20,
                        scale: 0.8
                    },
                    {
                        opacity: 1,
                        y: 0,
                        scale: 1,
                        duration: 0.4,
                        ease: 'back.out(1.7)'
                    }
                );
                
                this.scrollToBottom();
            }
            
            hideTypingIndicator() {
                const typingElement = document.getElementById('typingIndicator');
                if (typingElement) {
                    gsap.to(typingElement, {
                        opacity: 0,
                        y: -10,
                        scale: 0.9,
                        duration: 0.3,
                        ease: 'power2.in',
                        onComplete: () => {
                            typingElement.remove();
                            this.isTyping = false;
                        }
                    });
                }
            }
            generateBotResponse(userMessage) {
            fetch('chat.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: userMessage })
            })
            .then(res => res.json())
            .then(data => {
                const reply = data.reply || 'No response from AI.';
                this.addMessage(reply, 'bot');

                // Subtle glow animation on new bot message
                const lastMessage = this.messagesContainer.lastChild;
                if (lastMessage) {
                    gsap.fromTo(lastMessage.querySelector('.message-content'), 
                        { boxShadow: '0 0 10px rgba(74, 144, 226, 0.8)' },
                        { boxShadow: '0 0 0 rgba(74, 144, 226, 0)', duration: 1.5 }
                    );
                }
            })
            .catch(err => {
                this.addMessage('Error contacting AI.', 'bot');
                console.error(err);
            });
        }

                // Animate the response appearance
                setTimeout(() => {
                    this.addMessage(response, 'bot');
                    
                    // Add a subtle glow effect to new bot messages
                    const lastMessage = this.messagesContainer.lastChild;
                    if (lastMessage) {
                        gsap.fromTo(lastMessage.querySelector('.message-content'), 
                            { boxShadow: '0 0 10px rgba(74, 144, 226, 0.8)' },
                            { boxShadow: '0 0 0 rgba(74, 144, 226, 0)', duration: 1.5 }
                        );
                    }
                }, 300);
            }
            
            scrollToBottom() {
                gsap.to(this.messagesContainer, {
                    scrollTop: this.messagesContainer.scrollHeight,
                    duration: 0.5,
                    ease: 'power2.out'
                });
            }
            
            setupHoverEffects() {
                // Avatar hover effect
                const avatar = document.querySelector('.bot-avatar');
                avatar.addEventListener('mouseenter', () => {
                    gsap.to(avatar, {
                        scale: 1.1,
                        rotation: 10,
                        duration: 0.3,
                        ease: 'back.out(1.7)'
                    });
                });
                
                avatar.addEventListener('mouseleave', () => {
                    gsap.to(avatar, {
                        scale: 1,
                        rotation: 0,
                        duration: 0.3,
                        ease: 'back.out(1.7)'
                    });
                });
                
                // Input field hover effect
                this.messageInput.addEventListener('focus', () => {
                    gsap.to(this.messageInput, {
                        boxShadow: '0 0 0 2px rgba(74, 144, 226, 0.3)',
                        duration: 0.3
                    });
                });
                
                this.messageInput.addEventListener('blur', () => {
                    gsap.to(this.messageInput, {
                        boxShadow: 'none',
                        duration: 0.3
                    });
                });
            }
        }
        
        // Initialize the chatbot when the page loads
        document.addEventListener('DOMContentLoaded', () => {
            const chatbot = new ChatBot();
            
            // Add window resize animation
            window.addEventListener('resize', () => {
                gsap.to('.chatbot-container', {
                    scale: 0.98,
                    duration: 0.2,
                    yoyo: true,
                    repeat: 1,
                    ease: 'power2.inOut'
                });
            });
        });
    </script>-->
    <!-- Your Full Design and Animation Code Unchanged -->

<script>
class ChatBot {
    constructor() {
        this.messagesContainer = document.getElementById('chatMessages');
        this.messageInput = document.getElementById('messageInput');
        this.sendButton = document.getElementById('sendButton');
        this.isTyping = false;
        this.messageCount = 0;
        
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.showWelcomeMessage();
        this.animateContainer();
        this.setupHoverEffects();
    }
    
    setupEventListeners() {
        this.sendButton.addEventListener('click', () => this.sendMessage());
        this.messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                this.sendMessage();
            }
        });
        
        this.messageInput.addEventListener('input', () => {
            this.sendButton.disabled = !this.messageInput.value.trim();
        });
    }
    
    animateContainer() {
        gsap.fromTo('.chatbot-container', 
            { scale: 0.8, opacity: 0, y: 50, rotationX: 15, transformPerspective: 1000 },
            { scale: 1, opacity: 1, y: 0, rotationX: 0, duration: 1, ease: 'back.out(1.7)' }
        );
    }
    
    showWelcomeMessage() {
        gsap.to('.welcome-message', {
            opacity: 1,
            scale: 1,
            duration: 1,
            delay: 0.5,
            ease: 'elastic.out(1, 0.5)'
        });
    }
    
    sendMessage() {
        const message = this.messageInput.value.trim();
        if (!message || this.isTyping) return;
        
        this.addMessage(message, 'user');
        this.messageInput.value = '';
        this.sendButton.disabled = true;
        
        gsap.to(this.sendButton, {
            scale: 0.9,
            duration: 0.1,
            yoyo: true,
            repeat: 1,
            ease: 'power2.inOut',
            onComplete: () => {
                setTimeout(() => {
                    this.showTypingIndicator();
                    setTimeout(() => {
                        this.hideTypingIndicator();
                        this.generateBotResponse(message);
                    }, 1500 + Math.random() * 1000);
                }, 300);
            }
        });
    }
    
    addMessage(text, type) {
        this.messageCount++;
        const messageElement = document.createElement('div');
        messageElement.className = `message ${type}`;
        
        const avatar = document.createElement('div');
        avatar.className = 'message-avatar';
        avatar.textContent = type === 'user' ? 'U' : 'AI';
        
        const content = document.createElement('div');
        content.className = 'message-content';
        content.textContent = text;
        
        messageElement.appendChild(avatar);
        messageElement.appendChild(content);
        this.messagesContainer.appendChild(messageElement);
        
        if (type === 'user') {
            gsap.fromTo(messageElement, { opacity: 0, x: 50, scale: 0.9 },
                        { opacity: 1, x: 0, scale: 1, duration: 0.5, ease: 'back.out(1.7)' });
        } else {
            gsap.fromTo(messageElement, { opacity: 0, x: -50, scale: 0.9 },
                        { opacity: 1, x: 0, scale: 1, duration: 0.5, ease: 'back.out(1.7)' });
        }
        
        messageElement.addEventListener('mouseenter', () => {
            gsap.to(messageElement, { y: -3, duration: 0.3, ease: 'power2.out' });
        });
        messageElement.addEventListener('mouseleave', () => {
            gsap.to(messageElement, { y: 0, duration: 0.3, ease: 'power2.out' });
        });
        
        this.scrollToBottom();
    }
    
    showTypingIndicator() {
        this.isTyping = true;
        const typingElement = document.createElement('div');
        typingElement.className = 'typing-indicator';
        typingElement.id = 'typingIndicator';
        
        const avatar = document.createElement('div');
        avatar.className = 'message-avatar';
        avatar.style.background = 'linear-gradient(135deg, #4a90e2, #1877f2)';
        avatar.style.display = 'flex';
        avatar.style.alignItems = 'center';
        avatar.style.justifyContent = 'center';
        avatar.style.color = 'white';
        avatar.style.fontSize = '14px';
        avatar.style.fontWeight = 'bold';
        avatar.textContent = 'AI';
        
        const dotsContainer = document.createElement('div');
        dotsContainer.className = 'typing-dots';
        
        for (let i = 0; i < 3; i++) {
            const dot = document.createElement('div');
            dot.className = 'typing-dot';
            dotsContainer.appendChild(dot);
        }
        
        typingElement.appendChild(avatar);
        typingElement.appendChild(dotsContainer);
        this.messagesContainer.appendChild(typingElement);
        
        gsap.fromTo(typingElement, { opacity: 0, y: 20, scale: 0.8 },
                    { opacity: 1, y: 0, scale: 1, duration: 0.4, ease: 'back.out(1.7)' });
        
        this.scrollToBottom();
    }
    
    hideTypingIndicator() {
        const typingElement = document.getElementById('typingIndicator');
        if (typingElement) {
            gsap.to(typingElement, {
                opacity: 0, y: -10, scale: 0.9, duration: 0.3, ease: 'power2.in',
                onComplete: () => {
                    typingElement.remove();
                    this.isTyping = false;
                }
            });
        }
    }
    
    generateBotResponse(userMessage) {
        fetch('chat.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message: userMessage })
        })
        .then(res => res.json())
        .then(data => {
            const reply = data.reply || 'No response from AI.';
            this.addMessage(reply, 'bot');
            
            const lastMessage = this.messagesContainer.lastChild;
            if (lastMessage) {
                gsap.fromTo(lastMessage.querySelector('.message-content'), 
                    { boxShadow: '0 0 10px rgba(74, 144, 226, 0.8)' },
                    { boxShadow: '0 0 0 rgba(74, 144, 226, 0)', duration: 1.5 }
                );
            }
        })
        .catch(err => {
            this.addMessage('Error contacting AI.', 'bot');
            console.error(err);
        });
    }
    
    scrollToBottom() {
        gsap.to(this.messagesContainer, {
            scrollTop: this.messagesContainer.scrollHeight,
            duration: 0.5,
            ease: 'power2.out'
        });
    }
    
    setupHoverEffects() {
        const avatar = document.querySelector('.bot-avatar');
        avatar.addEventListener('mouseenter', () => {
            gsap.to(avatar, { scale: 1.1, rotation: 10, duration: 0.3, ease: 'back.out(1.7)' });
        });
        avatar.addEventListener('mouseleave', () => {
            gsap.to(avatar, { scale: 1, rotation: 0, duration: 0.3, ease: 'back.out(1.7)' });
        });
        
        this.messageInput.addEventListener('focus', () => {
            gsap.to(this.messageInput, { boxShadow: '0 0 0 2px rgba(74, 144, 226, 0.3)', duration: 0.3 });
        });
        this.messageInput.addEventListener('blur', () => {
            gsap.to(this.messageInput, { boxShadow: 'none', duration: 0.3 });
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const chatbot = new ChatBot();
    window.addEventListener('resize', () => {
        gsap.to('.chatbot-container', {
            scale: 0.98, duration: 0.2, yoyo: true, repeat: 1, ease: 'power2.inOut'
        });
    });
});
</script>

</body>
</html>

<?php include 'footer.php'?>