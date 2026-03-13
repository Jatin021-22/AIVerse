<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AIverse - The Future of Artificial Intelligence</title>
  <link rel="icon" href="img\Screenshot_2025-06-29_121809-removebg-preview.png" type="image/png">
    

    <link rel="apple-touch-icon" sizes="57x57" href="../img/IconFolder.ico/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../img/IconFolder.ico/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../img/IconFolder.ico/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../img/IconFolder.ico/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../img/IconFolder.ico/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../img/IconFolder.ico/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../img/IconFolder.ico/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../img/IconFolder.ico/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../img/IconFolder.ico/apple-icon-180x180.png">  
    <link rel="icon" type="image/png" sizes="192x192" href="../img/IconFolder.ico/android-icon-192x192.png"> 
    <link rel="icon" type="image/png" sizes="32x32" href="../img/IconFolder.ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/IconFolder.ico/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/IconFolder.ico/favicon-16x16.png">


  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
 
   <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Rajdhani:wght@600&display=swap" rel="stylesheet"><style>
    :root {
      --primary: #0066ff;
      --secondary: #00d2ff;
      --dark: #0f0f1a;
      --light: #f8f9fa;
      --particle: rgba(0, 210, 255, 0.6);
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body, html {
      height: 100vh;
      overflow: hidden;
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #f5f7fa 0%, #e2e8f0 100%);
      color: var(--dark);
    }

    canvas {
      position: fixed;
      top: 0;
      left: 0;
      z-index: 0;
      pointer-events: none;
    }

    .hero {
      position: relative;
      z-index: 1;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 0 2rem;
    }

    .hero-content {
      max-width: 800px;
      opacity: 0;
      animation: fadeIn 1s ease-out 0.3s forwards;
    }

    h1 {
      font-family: 'Chakra Petch', 'Orbitron', sans-serif;
      font-size: clamp(3rem, 8vw, 5.5rem);
      margin-bottom: 1.5rem;
      background: linear-gradient(to right, var(--primary), var(--secondary));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      line-height: 1;
      letter-spacing: 2px;
      text-transform: uppercase;
      text-shadow: 0 2px 15px rgba(0, 102, 255, 0.3);
      position: relative;
      display: inline-block;
      font-weight: 700;
      padding: 0 0.5rem;
    }

    h1::before {
      content: '';
      position: absolute;
      top: -5px;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(to right, transparent, var(--secondary), transparent);
      border-radius: 3px;
      animation: shine 3s infinite;
    }

    h1::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 70%;
      height: 3px;
      background: linear-gradient(to right, transparent, var(--secondary), transparent);
      border-radius: 3px;
      animation: shine 3s infinite 0.5s;
    }

    @keyframes shine {
      0% { opacity: 0.3; width: 0%; }
      50% { opacity: 1; width: 100%; }
      100% { opacity: 0.3; width: 0%; }
    }

    .tagline {
      font-family: 'Inter', sans-serif;
      font-size: clamp(1rem, 2vw, 1.3rem);
      margin-bottom: 2.5rem;
      color: var(--dark);
      opacity: 0.9;
      font-weight: 300;
      line-height: 1.6;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
    }

    .cta-button {
      display: inline-block;
      background: linear-gradient(45deg, var(--primary), var(--secondary));
      color: white;
      padding: 1rem 2.5rem;
      border-radius: 50px;
      font-size: 1rem;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s ease;
      box-shadow: 0 4px 20px rgba(0, 102, 255, 0.3);
      border: none;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      letter-spacing: 0.5px;
      position: relative;
      overflow: hidden;
      z-index: 1;
    }

    .cta-button::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, var(--secondary), var(--primary));
      z-index: -1;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .cta-button:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 25px rgba(0, 102, 255, 0.4);
    }

    .cta-button:hover::before {
      opacity: 1;
    }

    .cta-button:active {
      transform: translateY(1px);
    }

    .scroll-hint {
      position: absolute;
      bottom: 2rem;
      display: flex;
      flex-direction: column;
      align-items: center;
      opacity: 0;
      animation: fadeIn 1s ease-out 1s forwards;
    }

    .scroll-hint span {
      font-size: 0.8rem;
      margin-bottom: 0.5rem;
      color: var(--dark);
      opacity: 0.7;
      font-family: 'Inter', sans-serif;
    }

    .scroll-hint::after {
      content: '';
      width: 20px;
      height: 30px;
      border: 2px solid var(--dark);
      border-radius: 10px;
      opacity: 0.5;
      animation: bounce 2s infinite;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes bounce {
      0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
      40% { transform: translateY(-10px); }
      60% { transform: translateY(-5px); }
    }

    @media (max-width: 768px) {
      h1 {
        font-size: clamp(2.5rem, 8vw, 4rem);
      }
      
      .tagline {
        margin-bottom: 2rem;
      }
      
      .cta-button {
        padding: 0.8rem 2rem;
      }
    }
    /* Modal Styles */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(15, 15, 26, 0.8);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1000;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }
    
    .modal-overlay.active {
      opacity: 1;
      visibility: visible;
    }
    
    .modal-container {
      background: linear-gradient(135deg, #f8f9fa 0%, #e2e8f0 100%);
      border-radius: 16px;
      width: 90%;
      max-width: 450px;
      padding: 2.5rem;
      box-shadow: 0 15px 40px rgba(0, 102, 255, 0.2);
      transform: translateY(20px);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    
    .modal-overlay.active .modal-container {
      transform: translateY(0);
    }
    
    .modal-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(to right, var(--primary), var(--secondary));
    }
    
    .modal-close {
      position: absolute;
      top: 1rem;
      right: 1rem;
      background: none;
      border: none;
      font-size: 1.5rem;
      color: var(--dark);
      opacity: 0.6;
      cursor: pointer;
      transition: opacity 0.2s ease;
    }
    
    .modal-close:hover {
      opacity: 1;
    }
    
    .modal-title {
      font-family: 'Inter', sans-serif;
      font-size: 1.8rem;
      margin-bottom: 1.5rem;
      color: var(--dark);
      text-align: center;
      font-weight: 700;
      background: linear-gradient(to right, var(--primary), var(--secondary));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    
    .modal-subtitle {
      font-size: 1rem;
      color: var(--dark);
      opacity: 0.8;
      text-align: center;
      margin-bottom: 2rem;
      line-height: 1.6;
    }
    
    .modal-options {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    
    .modal-btn {
      padding: 1rem;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      text-decoration:none;
    }
    
    .modal-btn-primary {
      background: linear-gradient(45deg, var(--primary), var(--secondary));
      color: white;
      box-shadow: 0 4px 15px rgba(0, 102, 255, 0.3);
    }
    
    .modal-btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 102, 255, 0.4);
    }
    
    .modal-btn-secondary {
      background: white;
      color: var(--dark);
      border: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .modal-btn-secondary:hover {
      background: rgba(0, 102, 255, 0.05);
      border-color: rgba(0, 102, 255, 0.2);
    }
    
    .modal-features {
      margin-top: 2rem;
      padding-top: 1.5rem;
      border-top: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .modal-features-title {
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--dark);
      opacity: 0.6;
      margin-bottom: 1rem;
      text-align: center;
    }
    
    .modal-features-list {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }
    
    .modal-feature-item {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.9rem;
      color: var(--dark);
      opacity: 0.8;
    }
    
    .modal-feature-item::before {
      content: '✓';
      color: var(--primary);
      font-weight: bold;
    }
    
    @media (max-width: 480px) {
      .modal-container {
        padding: 1.5rem;
      }
      
      .modal-title {
        font-size: 1.5rem;
      }
    }
  </style> 
</head>
<body>

<canvas id="particleCanvas"></canvas>

<div class="hero">
  <div class="hero-content">
    <h1>AIVerse</h1>
    <p class="tagline">Access the power of many AIs—one platform, endless possibilities.</p>
    <a href="php/index.php" class="cta-button">Begin Your Journey</a>
  </div>
  
  <div class="scroll-hint">
    <span>Explore</span>
  </div>
</div>
<script>
// Enhanced Particle System
const canvas = document.getElementById('particleCanvas');
const ctx = canvas.getContext('2d');
let particles = [];
const particleCount = window.innerWidth < 768 ? 60 : 120;

// Set canvas size
function resizeCanvas() {
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
}

// Initialize particles
function initParticles() {
  particles = [];
  for (let i = 0; i < particleCount; i++) {
    particles.push({
      x: Math.random() * canvas.width,
      y: Math.random() * canvas.height,
      size: Math.random() * 2 + 1,
      speedX: (Math.random() - 0.5) * 0.5,
      speedY: (Math.random() - 0.5) * 0.5,
      baseSize: Math.random() * 2 + 1
    });
  }
}

// Animation loop
function animate() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  
  // Draw particles
  particles.forEach(p => {
    // Update position
    p.x += p.speedX;
    p.y += p.speedY;
    
    // Bounce off edges
    if (p.x < 0 || p.x > canvas.width) p.speedX *= -1;
    if (p.y < 0 || p.y > canvas.height) p.speedY *= -1;
    
    // Draw particle
    ctx.fillStyle = `rgba(0, 210, 255, ${0.5 + Math.random() * 0.5})`;
    ctx.beginPath();
    ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
    ctx.fill();
  });
  
  requestAnimationFrame(animate);
}

// Handle mouse movement for interactive effects
let mouse = { x: null, y: null };
window.addEventListener('mousemove', (e) => {
  mouse.x = e.x;
  mouse.y = e.y;
  
  // Make particles react to mouse
  particles.forEach(p => {
    const dx = mouse.x - p.x;
    const dy = mouse.y - p.y;
    const distance = Math.sqrt(dx * dx + dy * dy);
    
    if (distance < 100) {
      p.size = p.baseSize + 2;
      // Slight push effect
      p.x -= dx * 0.01;
      p.y -= dy * 0.01;
    } else {
      p.size = p.baseSize;
    }
  });
});

// Handle window resize
window.addEventListener('resize', () => {
  resizeCanvas();
  initParticles();
});

// Initialize
resizeCanvas();
initParticles();
animate();
</script>

</body>
</html>
