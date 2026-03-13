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
    <link rel="icon" href="../img\Screenshot_2025-06-29_121809-removebg-preview.png" type="image/png">
    <title>About Us - Aiverse</title>
    <link rel="stylesheet" href="../css\font.css">
    <style>
        
        :root {
            --primary: #4a9ff5;
            --primary-light: rgba(74, 159, 245, 0.1);
            --primary-dark: #2a70b5;
            --text: #2d3748;
            --text-light: #4a5568;
            --white: #ffffff;
            --card-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            --border-radius: 16px;
            --section-padding: 120px 0;
            --content-width: 1200px;
            --content-padding: 0 40px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
           
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            max-width: var(--content-width);
            margin: 0 auto;
            padding: var(--content-padding);
            z-index: 1;
        }

        section {
            position: relative;
            padding: var(--section-padding);
            overflow: hidden;
            z-index: 1;
        }

        .section-title {
            font-size: 3rem;
            margin-bottom: 60px;
            color: var(--primary-dark);
            font-weight: 800;
            position: relative;
            padding-bottom: 15px;
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .section-title.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 5px;
            background: var(--primary);
            border-radius: 3px;
        }

        .about-text {
            font-size: 1.2rem;
            color: var(--text-light);
            margin-bottom: 40px;
            line-height: 1.8;
            max-width: 800px;
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.165, 0.84, 0.44, 1) 0.2s;
        }

        .about-text.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin: 60px 0;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: var(--border-radius);
            padding: 40px;
            text-align: center;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.4);
            transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            opacity: 0;
            transform: translateY(40px);
        }

        .stat-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .stat-card:nth-child(1) { transition-delay: 0.1s; }
        .stat-card:nth-child(2) { transition-delay: 0.2s; }
        .stat-card:nth-child(3) { transition-delay: 0.3s; }
        .stat-card:nth-child(4) { transition-delay: 0.4s; }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(74, 159, 245, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
            z-index: -1;
            transition: opacity 0.6s ease;
            opacity: 0;
            border-radius: var(--border-radius);
        }

        .stat-card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 15px 50px rgba(74, 159, 245, 0.2);
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 15px;
            transition: all 0.6s ease;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-card:hover .stat-number {
            transform: scale(1.1);
        }

        .stat-label {
            font-size: 1.1rem;
            color: var(--text-light);
            transition: all 0.6s ease;
            font-weight: 500;
        }

        .stat-card:hover .stat-label {
            color: var(--text);
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }

        .team-card {
            height:100%;
            width: 70%;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: all 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.4);
            transform-style: preserve-3d;
            will-change: transform;
            opacity: 0;
            transform: translateY(40px) rotateX(15deg);
        }

        .team-card.visible {
            opacity: 1;
            transform: translateY(0) rotateX(0);
        }

        .team-card:hover {
            box-shadow: 0 20px 60px rgba(74, 159, 245, 0.25);
        }

        .team-img {
            width: 100%;
            height:500px;
            object-fit: cover;
            transition: all 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
            transform-origin: bottom;
        }

        .team-card:hover .team-img {
            transform: scale(1.05);
        }

        .team-info {
            padding: 30px;
            position: relative;
        }

        .team-name {
            font-size: 1.5rem;
            margin-bottom: 8px;
            color: var(--text);
            transition: all 0.6s ease;
            font-weight: 700;
        }

        .team-card:hover .team-name {
            color: var(--primary-dark);
        }

        .team-role {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1rem;
            transition: all 0.6s ease;
        }

        .team-card:hover .team-role {
            color: var(--primary-dark);
        }

        .team-bio {
            color: var(--text-light);
            font-size: 1rem;
            line-height: 1.7;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }

        .value-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: var(--border-radius);
            padding: 45px;
            box-shadow: var(--card-shadow);
            border-left: 5px solid var(--primary);
            transition: all 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            overflow: hidden;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.4);
            opacity: 0;
            transform: translateY(40px);
        }

        .value-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .value-card:nth-child(1) { transition-delay: 0.1s; }
        .value-card:nth-child(2) { transition-delay: 0.2s; }
        .value-card:nth-child(3) { transition-delay: 0.3s; }

        .value-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(74, 159, 245, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
            z-index: -1;
            transition: opacity 0.6s ease;
            opacity: 0;
        }

        .value-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 50px rgba(74, 159, 245, 0.2);
        }

        .value-card:hover::before {
            opacity: 1;
        }

        .value-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 25px;
            transition: all 0.6s ease;
        }

        .value-card:hover .value-icon {
            transform: scale(1.2);
            color: var(--primary-dark);
        }

        .value-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: var(--text);
            transition: all 0.6s ease;
            font-weight: 700;
        }

        .value-card:hover .value-title {
            color: var(--primary-dark);
        }

        /* Timeline styles */
        .timeline {
            position: relative;
            max-width: 900px;
            margin: 60px auto;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            width: 5px;
            background: linear-gradient(to bottom, var(--primary-light), var(--primary), var(--primary-light));
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -2.5px;
            border-radius: 5px;
        }
        
        .timeline-item {
            padding: 20px 0;
            position: relative;
            width: 50%;
            box-sizing: border-box;
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        
        .timeline-item.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .timeline-item:nth-child(1) { transition-delay: 0.1s; }
        .timeline-item:nth-child(2) { transition-delay: 0.2s; }
        .timeline-item:nth-child(3) { transition-delay: 0.3s; }
        .timeline-item:nth-child(4) { transition-delay: 0.4s; }
        .timeline-item:nth-child(5) { transition-delay: 0.5s; }
        
        .timeline-item:nth-child(odd) {
            left: 0;
            padding-right: 60px;
            text-align: right;
        }
        
        .timeline-item:nth-child(even) {
            left: 50%;
            padding-left: 60px;
        }
        
        .timeline-content {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.4);
            transition: all 0.6s ease;
        }
        
        .timeline-item:hover .timeline-content {
            transform: scale(1.03);
            box-shadow: 0 15px 40px rgba(74, 159, 245, 0.2);
        }
        
        .timeline-date {
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        
        .timeline-content h3 {
            font-size: 1.4rem;
            margin-bottom: 15px;
            color: var(--text);
        }
        
        .timeline-content p {
            color: var(--text-light);
            line-height: 1.7;
        }
        
        .timeline-item::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: var(--primary);
            border: 4px solid var(--white);
            border-radius: 50%;
            top: 30px;
            z-index: 1;
            box-shadow: 0 0 0 4px var(--primary-light);
        }
        
        .timeline-item:nth-child(odd)::after {
            right: -10px;
        }
        
        .timeline-item:nth-child(even)::after {
            left: -10px;
        }
        
        .tech-stack {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }
        
        .tech-item {
            background: rgba(74, 159, 245, 0.15);
            padding: 10px 18px;
            border-radius: 30px;
            font-size: 0.95rem;
            color: var(--primary-dark);
            font-weight: 500;
            transition: all 0.4s ease;
        }
        
        .value-card:hover .tech-item {
            background: rgba(74, 159, 245, 0.25);
            transform: translateY(-3px);
        }
        
        .testimonial-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            padding: 40px;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            margin: 30px 0;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.4);
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        
        .testimonial-card.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .testimonial-card:nth-child(1) { transition-delay: 0.1s; }
        .testimonial-card:nth-child(2) { transition-delay: 0.2s; }
        
        .testimonial-card::before {
            content: '"';
            position: absolute;
            font-size: 6rem;
            color: rgba(74, 159, 245, 0.1);
            top: 20px;
            left: 30px;
            line-height: 1;
            font-family: Georgia, serif;
        }
        
        .testimonial-card p {
            font-size: 1.2rem;
            line-height: 1.8;
            color: var(--text-light);
            position: relative;
            z-index: 1;
            font-style: italic;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
            margin-top: 30px;
        }
        
        .testimonial-author img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 20px;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .author-info h4 {
            margin-bottom: 5px;
            color: var(--text);
            font-size: 1.2rem;
        }
        
        .author-info p {
            color: var(--text-light);
            font-size: 0.95rem;
        }
        
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            color: white;
            padding: 16px 32px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 10px 30px rgba(74, 159, 245, 0.3);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            transform: translateY(0);
            opacity: 0;
        }
        
        .btn.visible {
            opacity: 1;
            transform: translateY(0);
            transition-delay: 0.3s;
        }
        
        .btn:hover {
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0 15px 40px rgba(74, 159, 245, 0.4);
        }
        
        /* Parallax background elements */
        .parallax-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            overflow: hidden;
        }
        
        .bg-circle {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(74, 159, 245, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            filter: blur(20px);
        }
        
        .bg-circle-1 {
            width: 600px;
            height: 600px;
            top: -300px;
            right: -300px;
        }
        
        .bg-circle-2 {
            width: 800px;
            height: 800px;
            bottom: -400px;
            left: -400px;
        }
        
        /* Responsive styles */
        @media (max-width: 1024px) {
            :root {
                --section-padding: 100px 0;
                --content-padding: 0 30px;
            }
            
            .section-title {
                font-size: 2.5rem;
            }
            
            .timeline::before {
                left: 40px;
            }
            
            .timeline-item {
                width: 100%;
                padding-left: 80px;
                padding-right: 20px;
                text-align: left;
            }
            
            .timeline-item:nth-child(even) {
                left: 0;
            }
            
            .timeline-item::after {
                left: 30px;
            }
            
            .timeline-item:nth-child(odd)::after {
                right: auto;
                left: 30px;
            }
        }
        
        @media (max-width: 768px) {
            :root {
                --section-padding: 80px 0;
                --content-padding: 0 20px;
            }
            
            .section-title {
                font-size: 2.2rem;
                margin-bottom: 40px;
            }
            
            .about-text {
                font-size: 1.1rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
            
            .values-grid, .team-grid {
                grid-template-columns: 1fr;
            }
            
            .stat-card, .value-card {
                padding: 30px;
            }
            
            .team-img {
                height: 280px;
            }
        }
        
        @media (max-width: 480px) {
            :root {
                --section-padding: 60px 0;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
            
            .testimonial-card {
                padding: 30px 20px;
            }
            
            .testimonial-card::before {
                font-size: 4rem;
                top: 15px;
                left: 15px;
            }
            
            .testimonial-card p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php';?>
    <div style="padding: 20px 30px; background: linear-gradient(to right, #e0f7fa39, #f0fcff54); border-radius: 12px; margin: 30px auto; max-width: 600px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); color: #0077b6; display: flex; align-items: center; gap: 10px; font-size: 18px; margin-top:150px;">
  <i class="fa-solid fa-house" style="color: #00b4d8;"></i>
  <a href="index.php" style="color: #0077b6; text-decoration: none; font-weight: 500;">Home</a>
  <span>/</span>
  <span style="font-weight: bold;">About Us</span>
</div>
    <section id="nexbot-container" style="height: 100vh; width: 100%; background: linear-gradient(135deg,rgba(247, 247, 248, 0) 0%,rgba(252, 252, 252, 0) 100%); overflow: hidden; display: flex; align-items: center; justify-content: center;">
        <iframe src="https://my.spline.design/nexbotrobotcharacterconcept-cZ3uGGms0wws9hbCX887Xgif/" 
            frameborder="0" 
            width="100%" 
            height="100%" 
            allow="autoplay; fullscreen; accelerometer; gyroscope;">
        </iframe>
    </section>

    <div class="parallax-bg">
        <div class="bg-circle bg-circle-1"></div>
        <div class="bg-circle bg-circle-2"></div>
    </div>

    <section id="about">
        <div class="container">
            <h1 class="section-title">About Aiverse</h1>
            <p class="about-text">
                AIverse is a next-generation platform that brings together the power of multiple artificial intelligence tools under one unified interface. Designed with simplicity and scalability in mind, AIverse allows users to interact with cutting-edge AI models through intuitive web experiences and live API integrations. 
            </p>
            <p class="about-text">
                We believe AI should be accessible to everyone—whether you're exploring creativity, improving productivity, or building smart systems. That’s why we’ve created a space where users can effortlessly access tools like AI-powered chat, image generation, text summarization, and real-time weather forecasting.
            </p>
            
    </section>
    <section id="technology">
        <div class="container">
            <h2 class="section-title">Our Technology</h2>
            <p class="about-text">
                At AIverse, we integrate diverse AI models through seamless APIs, empowering users with smart tools that automate, generate, and predict with precision.
            </p>
            
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">🧠</div>
                    <h3 class="value-title">Services</h3>
                    <p class="about-text">Our patented neural network designs achieve state-of-the-art results with 40% fewer parameters than conventional models.</p>
                    <div class="tech-stack">
                        <span class="tech-item">Transformer Models</span>
                        <span class="tech-item">GNNs</span>
                        <span class="tech-item">Capsule Networks</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonials">
        <div class="container">
            <h2 class="section-title">Client Success Stories</h2>
            <div class="testimonial-card">
                <p>"Aiverse's AI platform transformed our patient diagnosis accuracy by 32% while reducing false positives. Their team understood our unique healthcare challenges and delivered beyond expectations."</p>
                <div class="testimonial-author">
                    <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Dr. Sarah Chen">
                    <div class="author-info">
                        <h4>Dr. Sarah Chen</h4>
                        <p>Chief Medical Officer, HealthPlus</p>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <p>"Implementing Aiverse's fraud detection system saved our fintech company $4.7M in its first year. Their solution adapts to new fraud patterns faster than any system we've tested."</p>
                <div class="testimonial-author">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Michael Rodriguez">
                    <div class="author-info">
                        <h4>Michael Rodriguez</h4>
                        <p>VP of Security, PaySecure</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="team">
        <div class="container">
            <h2 class="section-title">Our Team</h2>
            <div class="team-grid">
                <div class="team-card">
                    <img src="#" alt="AI Researcher" class="team-img">
                    <div class="team-info">
                        <h3 class="team-name">Jatin Prajapati </h3>
                        <p class="team-role">Chief AI Scientist</p>
                        <p class="team-bio">PhD in Machine Learning from MIT, specializes in neural architecture design.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="values">
        <div class="container">
            <h2 class="section-title">Our Values</h2>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">💡</div>
                    <h3 class="value-title">Innovation</h3>
                    <p class="about-text">We push boundaries to develop AI solutions that solve real problems in novel ways.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">🤝</div>
                    <h3 class="value-title">Collaboration</h3>
                    <p class="about-text">We work closely with clients and partners to create tailored AI solutions.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">🌍</div>
                    <h3 class="value-title">Impact</h3>
                    <p class="about-text">We measure success by the positive difference our technology makes.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="join">
        <div class="container">
            <h2 class="section-title">Join Our Mission</h2>
            <p class="about-text">
                We're always looking for talented individuals who share our passion for ethical, transformative AI. 
                Whether you're a researcher, engineer, or business professional, explore opportunities to grow with us.
            </p>
            <div style="text-align: center; margin-top: 60px;">
                <a href="#" class="btn">View Open Positions</a>
            </div>
        </div>
    </section>

    <script>
        // Enhanced counter animation with smoother increments
        function animateValue(id, start, end, duration) {
            const obj = document.getElementById(id);
            const range = end - start;
            const increment = end > start ? 1 : -1;
            const stepTime = Math.abs(Math.floor(duration / range));
            let current = start;
            
            const timer = setInterval(() => {
                current += increment;
                obj.innerHTML = current + "+";
                
                if (current == end) {
                    clearInterval(timer);
                }
            }, stepTime);
        }

        // Improved tilt effect with perspective
        function initTiltEffect() {
            const teamCards = document.querySelectorAll('.team-card');
            
            teamCards.forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    const angleX = (y - centerY) / 15;
                    const angleY = (centerX - x) / 15;
                    
                    card.style.transform = `perspective(1000px) rotateX(${angleX}deg) rotateY(${angleY}deg) translateY(-10px) scale(1.03)`;
                    card.style.boxShadow = `0 25px 60px rgba(74, 159, 245, 0.3)`;
                });
                
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0) scale(1)';
                    card.style.boxShadow = 'var(--card-shadow)';
                });
            });
        }

        // Parallax effect for background elements
        // Parallax effect for background elements
function initParallax() {
    const bgCircle1 = document.querySelector('.bg-circle-1');
    const bgCircle2 = document.querySelector('.bg-circle-2');
    
    window.addEventListener('scroll', () => {
        const scrollPosition = window.pageYOffset;
        
        // Move circles at different speeds for parallax effect
        if (bgCircle1) {
            bgCircle1.style.transform = `translateY(${scrollPosition * 0.2}px)`;
        }
        
        if (bgCircle2) {
            bgCircle2.style.transform = `translateY(${scrollPosition * 0.1}px) rotate(${scrollPosition * 0.05}deg)`;
        }
    });
}

// Intersection Observer for scroll animations
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                
                // Animate counters when stats section is visible
                if (entry.target.id === 'stats-section') {
                    animateValue('clients-count', 0, 250, 2000);
                    animateValue('projects-count', 0, 500, 2000);
                    animateValue('team-count', 0, 45, 2000);
                    animateValue('countries-count', 0, 15, 2000);
                }
            }
        });
    }, observerOptions);

    // Observe all elements with animation classes
    document.querySelectorAll('.section-title, .about-text, .stat-card, .timeline-item, .value-card, .testimonial-card, .team-card, .btn').forEach(el => {
        observer.observe(el);
    });
}

// Initialize all effects when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    initTiltEffect();
    initParallax();
    initScrollAnimations();
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});

// Optional: Add a subtle floating animation to the background circles
function floatCircles() {
    const bgCircle1 = document.querySelector('.bg-circle-1');
    const bgCircle2 = document.querySelector('.bg-circle-2');
    
    if (bgCircle1 && bgCircle2) {
        let angle1 = 0;
        let angle2 = 0;
        
        setInterval(() => {
            angle1 += 0.01;
            angle2 += 0.007;
            
            const y1 = Math.sin(angle1) * 20;
            const x1 = Math.cos(angle1) * 15;
            
            const y2 = Math.sin(angle2) * 30;
            const x2 = Math.cos(angle2) * 20;
            
            bgCircle1.style.transform = `translate(${x1}px, ${y1}px)`;
            bgCircle2.style.transform = `translate(${x2}px, ${y2}px) rotate(${angle2 * 10}deg)`;
        }, 50);
    }
}

// Call the floating animation after page load
window.addEventListener('load', floatCircles);
</script>
</body>
</html>
<?php include 'footer.php'?>