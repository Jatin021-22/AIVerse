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
    <title>Service | AIVerse</title>
    <link rel="icon" href="../img\Screenshot_2025-06-29_121809-removebg-preview.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.11.4/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.7.0/dist/vanilla-tilt.min.js"></script>
    <link rel="stylesheet" href="../css\font.css">
    <link rel="stylesheet" href="../css/service.css">
</head>
<?php include 'header.php' ?>
<body>
    <div style="padding: 20px 30px; background: linear-gradient(to right, #e0f7faaa, #f0fcff54); border-radius: 12px; margin: 30px auto; max-width: 600px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); color: #0077b6; display: flex; align-items: center; gap: 10px; font-size: 18px; margin-top:150px;">
  <i class="fa-solid fa-house" style="color: #00b4d8;"></i>
  <a href="index.php" style="color: #0077b6; text-decoration: none; font-weight: 500;">Home</a>
  <span>/</span>
  <span style="font-weight: bold;">Services</span>
</div>

    
    <canvas id="particleCanvas"></canvas>
    <div class="container">

        <div class="services-grid">
            <div class="service-card" data-tilt data-tilt-max="5" data-tilt-speed="500" data-tilt-perspective="1000">
                <div class="card-icon">✨</div>
                <h3 class="card-title">AI Text Studio</h3>
                <p class="card-desc">✨ Generate, refine, and summarize text with our advanced AI writing assistant 📝🤖. Perfect for content creators 🎨, marketers 📢, and professionals 💼.</p>
                <a href="chatbot.php" class="card-btn">
                    Try Now <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="service-card" data-tilt data-tilt-max="5" data-tilt-speed="500" data-tilt-perspective="1000">
                <div class="card-icon">🎨</div>
                <h3 class="card-title">Vision Generator</h3>
                <p class="card-desc">🎨 Create stunning visuals from text prompts with our image generation AI 🖌️🤖. Generate artwork 🖼️, designs ✨, and illustrations in any style.</p>
                <a href="vision_generator.php" class="card-btn">
                    Create Art <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="service-card" data-tilt data-tilt-max="5" data-tilt-speed="500" data-tilt-perspective="1000">
                <div class="card-icon">🌐</div>
                <h3 class="card-title">SmartBot Chat</h3>
                <p class="card-desc">🤖 Engage with our intelligent chatbot for answers 💡, advice 🗨️, and conversation 💬. Available 24/7 🕒 with human-like understanding 🧠.</p>
                <a href="chatbot.php" class="card-btn">
                    Start Chatting <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="service-card" data-tilt data-tilt-max="5" data-tilt-speed="500" data-tilt-perspective="1000">
                <div class="card-icon">🔊</div>
                <h3 class="card-title">AI Voice Converter</h3>
                <p class="card-desc">🔊 Transform text into natural-sounding speech 🗣️ with multiple voice options 🎧. Ideal for audiobooks 📚, presentations 🎤, and accessibility ♿.</p>
                <a href="voice_converter.php" class="card-btn">
                    Listen Now <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="service-card" data-tilt data-tilt-max="5" data-tilt-speed="500" data-tilt-perspective="1000">
                <div class="card-icon">🌦️</div>
                <h3 class="card-title">AI Weather Insights</h3>
                <p class="card-desc">☁️ Get hyper-accurate weather forecasts 🌦️ with AI-powered analysis 🤖. More than just temperature 🌡️—get actionable insights 📊.</p>
                <a href="weather.php" class="card-btn">
                    Check Weather <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="service-card" data-tilt data-tilt-max="5" data-tilt-speed="500" data-tilt-perspective="1000">
                <div class="card-icon">🚀</div>
                <h3 class="card-title">More AI Magic</h3>
                <p class="card-desc">🚀 We're constantly expanding our universe 🌌 of AI services 🤖. Video generation 🎥, code assistance 💻, data analysis 📊, and more coming soon! ✨</p>
                <a href="/upcoming" class="card-btn">
                    Notify Me <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <script>
        // Initialize GSAP animations
        document.addEventListener('DOMContentLoaded', () => {
            // Animate tagline
            gsap.to('.tagline', {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: 'power3.out',
                delay: 0.5
            });

            // Stagger card animations
            gsap.to('.service-card', {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: 'elastic.out(1, 0.5)',
                stagger: 0.15,
                delay: 0.8
            });

            // Initialize VanillaTilt with glare effect
            VanillaTilt.init(document.querySelectorAll(".service-card"), {
                max: 5,
                speed: 500,
                glare: true,
                "max-glare": 0.2,
                perspective: 1000,
                scale: 1.02
            });
        });

        const canvas = document.getElementById('particleCanvas');
        const ctx = canvas.getContext('2d');
        let particlesArray = [];

        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            init();
        });

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 2 + 1;
                this.speedX = (Math.random() - 0.5) * 0.8;
                this.speedY = (Math.random() - 0.5) * 0.8;
            }
            update() {
                this.x += this.speedX;
                this.y += this.speedY;

                if (this.x > canvas.width || this.x < 0) this.speedX *= -1;
                if (this.y > canvas.height || this.y < 0) this.speedY *= -1;
            }
            draw() {
                ctx.fillStyle = '#8ED6FF';
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        function init() {
            particlesArray = [];
            for (let i = 0; i < 150; i++) {
                particlesArray.push(new Particle());
            }
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            particlesArray.forEach(particle => {
                particle.update();
                particle.draw();
            });

            requestAnimationFrame(animate);
        }

        init();
        animate();
    </script>
</body>
</html>
<?php include 'footer.php'?>