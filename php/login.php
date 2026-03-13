<?php
session_start();
$error = '';
if (isset($_SESSION['login_error'])) {
    $error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Verse  Login</title>
    <link rel="icon" href="../img\Screenshot_2025-06-29_121809-removebg-preview.png" type="image/png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/font.css">
<style>
.divider {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 25px 0 15px;
    gap: 12px;
    color: rgba(16, 14, 14, 0.42);
    font-size: 14px;
    text-shadow: 0 0 8px rgba(255, 255, 255, 0.3);
}

.divider-line {
    flex: 1;
    height: 1px;
    background: linear-gradient(to right, 
        transparent, 
        rgba(14, 13, 13, 0.53), 
        rgba(5, 1, 1, 0.8), 
        rgba(16, 12, 12, 0.24), 
        transparent);
    box-shadow: 0 0 12px rgba(255, 255, 255, 0.2);
}

.divider-text {
    white-space: nowrap;
    font-weight: 500;
    letter-spacing: 1px;
}

.social-buttons {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    padding: 10px 0;
}

.social-btn {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    padding: 14px 28px;
    border-radius: 16px;
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    overflow: hidden;
    transition: all 0.6s cubic-bezier(0.25, 1, 0.5, 1);
    z-index: 1;
    color: white;
    background: rgba(150, 191, 241, 0.54);
    backdrop-filter: blur(20px) saturate(180%);
    -webkit-backdrop-filter: blur(20px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 
        0 6px 24px rgba(0, 0, 0, 0.15),
        inset 0 0 16px rgba(255, 255, 255, 0.1),
        0 0 0 1px rgba(255, 255, 255, 0.05);
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

/* Liquid shine effect - More dynamic */
.social-btn::before {
    content: '';
    position: absolute;
    top: -150%;
    left: -150%;
    width: 400%;
    height: 400%;
    background: linear-gradient(
        to bottom right,
        transparent,
        transparent,
        rgba(255, 255, 255, 0.2),
        rgba(255, 255, 255, 0.4),
        rgba(255, 255, 255, 0.2),
        transparent,
        transparent
    );
    transform: rotate(25deg);
    transition: all 0.8s ease;
    z-index: -1;
    opacity: 0;
    animation: preShine 8s infinite linear;
}

/* Color wave layer */
.social-btn::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: transparent;
    transition: all 0.7s cubic-bezier(0.645, 0.045, 0.355, 1);
    z-index: -2;
    border-radius: 14px;
    opacity: 0;
}

/* Floating micro-bubbles */
.social-btn .bubbles {
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 16px;
    overflow: hidden;
    z-index: -1;
}

.social-btn .bubbles span {
    position: absolute;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 50%;
    pointer-events: none;
    transform: translate(-50%, -50%);
    animation: bubbleFloat 6s linear infinite;
}

/* Hover effects - Liquid transformation */
.social-btn:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 
        0 12px 32px rgba(0, 0, 0, 0.25),
        inset 0 0 24px rgba(255, 255, 255, 0.2),
        0 0 8px var(--brand-glow);
    border-color: rgba(255, 255, 255, 0.3);
}

.social-btn:hover::before {
    opacity: 1;
    animation: liquidShine 2.5s ease-in-out infinite;
}

.social-btn:hover::after {
    opacity: 0.9;
    background: var(--brand-gradient);
    animation: liquidFill 0.8s cubic-bezier(0.68, -0.6, 0.32, 1.6) forwards;
}

/* Brand-specific effects */
.social-btn.google {
    --brand-gradient: linear-gradient(135deg, #4285F4 0%, #DB4437 35%, #F4B400 65%, #0F9D58 100%);
    --brand-glow: rgba(244, 180, 0, 0.4);
}
.social-btn.facebook {
    --brand-gradient: linear-gradient(135deg, #1877F2 0%, #0A5AC2 100%);
    --brand-glow: rgba(24, 119, 242, 0.4);
}
.social-btn.twitter {
    --brand-gradient: linear-gradient(135deg, #1DA1F2 0%, #0D8ECF 100%);
    --brand-glow: rgba(29, 161, 242, 0.4);
}

/* Icon styling - Enhanced */
.social-icon {
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 3;
    transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.3));
}

.social-text {
    z-index: 3;
    transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    letter-spacing: 0.5px;
}.error-msg {
    color: #ff4d4f;
    font-size: 15px;
    font-weight: 600;
    text-align: center;
    margin-top: 15px;
    padding: 10px 20px;
    border-radius: 12px;
    background: rgba(255, 77, 79, 0.1);
    border: 1px solid rgba(255, 77, 79, 0.3);
    box-shadow: 0 4px 15px rgba(255, 77, 79, 0.2);
    animation: pulseShake 1s ease-in-out;
    position: relative;
}

/* Animated border pulse */
.error-msg::before {
    content: '';
    position: absolute;
    top: -2px; left: -2px; right: -2px; bottom: -2px;
    border-radius: 14px;
    border: 2px solid rgba(255, 77, 79, 0.5);
    animation: borderPulse 1.5s infinite;
    pointer-events: none;
}

/* Shake + fade-in */
@keyframes pulseShake {
    0% { transform: translateX(0) scale(1); opacity: 0; }
    20% { transform: translateX(-5px) scale(1.05); opacity: 1; }
    40% { transform: translateX(5px) scale(1.05); }
    60% { transform: translateX(-5px) scale(1.05); }
    80% { transform: translateX(5px) scale(1.05); }
    100% { transform: translateX(0) scale(1); opacity: 1; }
}

/* Glowing border pulse */
@keyframes borderPulse {
    0% { box-shadow: 0 0 5px rgba(255, 77, 79, 0.3); }
    50% { box-shadow: 0 0 15px rgba(255, 77, 79, 0.7); }
    100% { box-shadow: 0 0 5px rgba(255, 77, 79, 0.3); }
}
     

/* Hover effects on icon and text */
.social-btn:hover .social-icon {
    transform: scale(1.25) rotate(5deg);
    filter: drop-shadow(0 0 6px rgba(255, 255, 255, 0.5));
}

.social-btn:hover .social-text {
    transform: translateX(4px);
    text-shadow: 0 2px 8px rgba(255, 255, 255, 0.4);
}

/* Animations */
@keyframes liquidShine {
    0% { transform: rotate(25deg) translate(-20%, -20%); }
    100% { transform: rotate(25deg) translate(20%, 20%); }
}

@keyframes liquidFill {
    0% { 
        clip-path: polygon(0 100%, 100% 100%, 100% 100%, 0% 100%);
        opacity: 0;
    }
    50% {
        opacity: 0.5;
    }
    100% { 
        clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%);
        opacity: 0.9;
    }
}

@keyframes preShine {
    0% { transform: rotate(25deg) translate(-30%, -30%); }
    100% { transform: rotate(25deg) translate(30%, 30%); }
}

@keyframes bubbleFloat {
    0% {
        transform: translate(-50%, -50%) scale(0);
        opacity: 0;
    }
    10% {
        opacity: 0.5;
    }
    100% {
        transform: translate(-50%, -150vh) scale(0.8);
        opacity: 0;
    }
}

/* Dynamic bubble creation */
.social-btn .bubbles {
    position: absolute;
    width: 100%;
    height: 100%;
    overflow: hidden;
    border-radius: 16px;
}

/* Ripple effect - Enhanced */
.ripple-effect {
    position: absolute;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255,255,255,0.8) 0%, rgba(255,255,255,0) 70%);
    transform: scale(0);
    animation: ripple 0.8s linear;
    pointer-events: none;
    filter: blur(1px);
}
@keyframes ripple {
    to {
        transform: scale(4);
        opacity: 0;
    }
}

</style>
</head>
<body>
    <div class="floating-elements" id="floating-elements"></div>
    
    <div class="login-container">
        <div class="welcome-message">
            <h1>👋🏼 Welcome to AI Verse</h1>
            <p>Where artificial intelligence meets human creativity. Log in to explore infinite possibilities.</p>
        </div>
        
        <form action="login_validation.php" method="POST">
            <div class="input-group">
                <input type="text" id="username" name="username" required>
                <label for="username">Username or Email</label>
            </div>                       
            <div class="input-group">
                <input type="password" id="password" name="password" required>
                <label for="password">Password</label>
            </div>
            
            <button type="submit" class="login-btn">Enter the AI Verse</button><div class="social-auth">
                <?php if ($error != ''): ?>
                    <div class="error-msg"><?php echo $error; ?></div>
                <?php endif; ?>
            <div class="divider">
                <span class="divider-line"></span>
                <span class="divider-text">Or continue with</span>
                <span class="divider-line"></span>
            </div>
            
            <div class="social-buttons">
                <a href="#" class="social-btn google" aria-label="Continue with Google">
                    <span class="social-icon"><i class="fab fa-google"></i></span>
                    <span class="social-text">Google</span>
                </a>

                <a href="#" class="social-btn facebook" aria-label="Continue with Facebook">
                    <span class="social-icon"><i class="fab fa-facebook-f"></i></span>
                    <span class="social-text">Facebook</span>
                </a>

                <a href="#" class="social-btn twitter" aria-label="Continue with Twitter">
                    <span class="social-icon"><i class="fab fa-twitter"></i></span>
                    <span class="social-text">Twitter</span>
                </a>
            </div>
        </div>

            <div class="links">
                <a href="registration.php">Create Account</a>
                <a href="#">Forgot Password?</a>
            </div>
        </form>
    </div>

    <script>
        
        // GSAP Animations
        function initGSAPAnimations() {
            // Login container entrance
            gsap.from('.login-container', {
                duration: 1.5,
                y: 50,
                opacity: 0,
                rotationX: 15,
                ease: 'power3.out',
                delay: 0.5
            });
            
            // Welcome text animation
            gsap.from('.welcome-message h1', {
                duration: 1,
                y: -30,
                opacity: 0,
                ease: 'back.out',
                delay: 1
            });
            
            gsap.from('.welcome-message p', {
                duration: 1,
                y: 20,
                opacity: 0,
                ease: 'power2.out',
                delay: 1.2
            });
            
            // Input fields animation
            gsap.from('.input-group', {
                duration: 0.8,
                y: 20,
                opacity: 0,
                stagger: 0.1,
                ease: 'power2.out',
                delay: 1.4
            });
            
            // Button animation
            gsap.from('.login-btn', {
                duration: 1,
                y: 20,
                opacity: 0,
                ease: 'elastic.out(1, 0.5)',
                delay: 1.8
            });
            
            // Links animation
            gsap.from('.links a', {
                duration: 0.8,
                y: 20,
                opacity: 0,
                stagger: 0.1,
                ease: 'power2.out',
                delay: 2
            });
            
            // Create floating elements
            const floatingContainer = document.getElementById('floating-elements');
            for (let i = 0; i < 15; i++) {
                const element = document.createElement('div');
                element.classList.add('floating-element');
                
                const size = Math.random() * 100 + 50;
                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                const duration = Math.random() * 20 + 20;
                const delay = Math.random() * 5;
                
                element.style.width = `${size}px`;
                element.style.height = `${size}px`;
                element.style.left = `${posX}%`;
                element.style.top = `${posY}%`;
                
                floatingContainer.appendChild(element);
                
                // Animate with GSAP
                gsap.to(element, {
                    x: `+=${(Math.random() - 0.5) * 100}`,
                    y: `+=${(Math.random() - 0.5) * 100}`,
                    duration: duration,
                    delay: delay,
                    repeat: -1,
                    yoyo: true,
                    ease: 'sine.inOut'
                });
            }
        }
        
        // Initialize everything when the page loads
        window.addEventListener('load', () => {
            initGSAPAnimations();
            
            // Add hover effect to login container
            const loginContainer = document.querySelector('.login-container');
            loginContainer.addEventListener('mousemove', (e) => {
                const x = e.clientX / window.innerWidth;
                const y = e.clientY / window.innerHeight;
                
                gsap.to(loginContainer, {
                    rotationY: 10 * (x - 0.5),
                    rotationX: -10 * (y - 0.5),
                    transformPerspective: 1000,
                    ease: 'power2.out',
                    duration: 1
                });
            });
            
            loginContainer.addEventListener('mouseleave', () => {
                gsap.to(loginContainer, {
                    rotationY: 0,
                    rotationX: 0,
                    duration: 1,
                    ease: 'elastic.out(1, 0.5)'
                });
            });
        });
    </script>
    <script>
        // Add this script for enhanced interactions
document.addEventListener('DOMContentLoaded', () => {
    const socialButtons = document.querySelectorAll('.social-btn');
    
    socialButtons.forEach(button => {
        // Ripple effect
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const x = e.clientX - e.target.getBoundingClientRect().left;
            const y = e.clientY - e.target.getBoundingClientRect().top;
            
            const ripple = document.createElement('span');
            ripple.classList.add('ripple-effect');
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
                
                // Simulate authentication loading
                const originalContent = this.innerHTML;
                this.innerHTML = `
                    <span class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                        </svg>
                    </span>
                    <span class="social-text">Authenticating...</span>
                `;
                
                // Reset after animation
                setTimeout(() => {
                    this.innerHTML = originalContent;
                }, 1500);
            }, 600);
        });
        
        // Enhanced hover effect
        button.addEventListener('mouseenter', () => {
            gsap.to(button, {
                scale: 1.05,
                duration: 0.3,
                ease: 'power2.out'
            });
        });
        
        button.addEventListener('mouseleave', () => {
            gsap.to(button, {
                scale: 1,
                duration: 0.3,
                ease: 'power2.out'
            });
        });
    });
});

// Add this to your CSS for the ripple effect
.ripple-effect {
    position: absolute;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.4);
    transform: scale(0);
    animation: ripple 0.6s linear;
    pointer-events: none;
}

@keyframes ripple {
    to {
        transform: scale(4);
        opacity: 0;
    }
}
    </script>
</body>
</html>