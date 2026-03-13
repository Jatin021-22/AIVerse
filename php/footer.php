<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AIverse Footer</title>
    <style>

        body {
            background-color: white;
        }

        .footer {
            background-color: white;
            padding: 50px 0 30px;
            border-top: 1px solid rgba(173, 216, 230, 0.3);
            position: relative;
            overflow: hidden;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .footer-logo {
            margin-bottom: 30px;
        }

        .footer-logo h2 {
            color: #4da6ff;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
            position: relative;
            display: inline-block;
        }

        .footer-logo h2::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #4da6ff, #b3d9ff);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.4s ease;
        }

        .footer-logo h2:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        .footer-links {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-bottom: 40px;
        }

        .footer-link-item {
            list-style: none;
        }

        .footer-link {
            text-decoration: none;
            color: #666;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            padding: 5px 0;
        }

        .footer-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 1px;
            background-color: #4da6ff;
            transition: width 0.3s ease;
        }

        .footer-link:hover {
            color: #4da6ff;
        }

        .footer-link:hover::after {
            width: 100%;
        }

        .footer-social {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e6f2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4da6ff;
            font-size: 18px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .social-icon:hover {
            background-color: #4da6ff;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(77, 166, 255, 0.3);
        }

        .footer-copyright {
            color: #999;
            font-size: 14px;
            text-align: center;
            margin-top: 20px;
            position: relative;
        }

        .footer-copyright::before {
            content: '';
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            height: 1px;
            background: linear-gradient(90deg, transparent, #b3d9ff, transparent);
        }

        .footer-bubbles {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 20px;
            overflow: hidden;
        }

        .bubble {
            position: absolute;
            bottom: 0;
            background-color: #e6f2ff;
            border-radius: 50%;
            animation: rise 10s infinite ease-in;
            opacity: 0.5;
        }

        @keyframes rise {
            0% {
                bottom: -100px;
                transform: translateX(0);
            }
            50% {
                opacity: 0.7;
            }
            100% {
                bottom: 100%;
                transform: translateX(200px);
                opacity: 0;
            }
        }

        @media (max-width: 768px) {
            .footer-links {
                flex-direction: column;
                align-items: center;
                gap: 20px;
            }
            
            .footer-social {
                gap: 15px;
            }
            
            .social-icon {
                width: 36px;
                height: 36px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <h2>AIverse</h2>
            </div>
            
            <ul class="footer-links">
                <li class="footer-link-item">
                    <a href="about.php" class="footer-link">About</a>
                </li>
                <li class="footer-link-item">
                    <a href="service.php" class="footer-link">Features</a>
                </li>
                <li class="footer-link-item">
                    <a href="feedback.php" class="footer-link">Contact</a>
                </li>
                <li class="footer-link-item">
                    <a href="profile.php" class="footer-link">Profile</a>
                </li>
            </ul>
            
            <div class="footer-social">
                <div class="social-icon">
                    <i class="fab fa-twitter"></i>
                </div>
                <div class="social-icon">
                    <i class="fab fa-linkedin-in"></i>
                </div>
                <div class="social-icon">
                    <i class="fab fa-github"></i>
                </div>
                <div class="social-icon">
                    <i class="fab fa-discord"></i>
                </div>
            </div>
            
            <p class="footer-copyright">
                © 2026 AIverse. All rights reserved.
            </p>
        </div>
        
        <div class="footer-bubbles" id="bubbles"></div>
    </footer>

    <!-- Font Awesome for icons (you can use any icon library) -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    
    <!-- JavaScript for bubbles animation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bubblesContainer = document.getElementById('bubbles');
            
            function createBubbles() {
                const bubble = document.createElement('div');
                bubble.classList.add('bubble');
                
                // Random size between 5 and 15px
                const size = Math.random() * 10 + 5;
                bubble.style.width = `${size}px`;
                bubble.style.height = `${size}px`;
                
                // Random position
                bubble.style.left = `${Math.random() * 100}%`;
                
                // Random animation duration
                const duration = Math.random() * 10 + 10;
                bubble.style.animationDuration = `${duration}s`;
                
                bubblesContainer.appendChild(bubble);
                
                // Remove bubble after animation completes
                setTimeout(() => {
                    bubble.remove();
                }, duration * 1000);
            }
            
            // Create initial bubbles
            for (let i = 0; i < 10; i++) {
                createBubbles();
            }
            
            // Create new bubbles periodically
            setInterval(createBubbles, 2000);
        });
    </script>
</body>
</html>