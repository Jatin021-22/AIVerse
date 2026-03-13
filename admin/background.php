<?php
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Smooth Liquid Background</title>
  <style>
    

    .particle {
      position: fixed;
      background: rgba(173, 216, 230, 0.25); /* light blue particles */
      border-radius: 50%;
      pointer-events: none;
      z-index: -1;
    }
  </style>
</head>

<body>

  <!-- Page content goes here -->

  <!-- GSAP animation script -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const particleCount = 25;
      const colors = ['rgba(173, 216, 230, 0.25)', 'rgba(173, 216, 230, 0.35)'];

      for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');

        const size = Math.random() * 50 + 30;
        const posX = Math.random() * 100;
        const posY = Math.random() * 100;

        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        particle.style.left = `${posX}%`;
        particle.style.top = `${posY}%`;
        particle.style.background = colors[Math.floor(Math.random() * colors.length)];
        particle.style.opacity = Math.random() * 0.4 + 0.3;

        document.body.appendChild(particle);

        gsap.to(particle, {
          x: `${Math.random() * 120 - 60}px`,
          y: `${Math.random() * 120 - 60}px`,
          duration: Math.random() * 6 + 4, // faster & smoother
          delay: Math.random() * -6,
          repeat: -1,
          yoyo: true,
          ease: 'sine.inOut'
        });
      }
    });
  </script>
</body>
</html>
