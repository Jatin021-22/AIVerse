<!DOCTYPE html>
<html>
<head>
  <title>Register - AIverse</title>
  <link rel="icon" href="../img\Screenshot_2025-06-29_121809-removebg-preview.png" type="image/png">
  <link rel="stylesheet" href="../css/font.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: white;
      color: #333;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .floating-elements {
      position: fixed;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      z-index: -1;
      pointer-events: none;
      overflow: hidden;
    }

    .floating-element {
      position: absolute;
      background: rgba(0, 180, 216, 0.1);
      border-radius: 50%;
      filter: blur(1px);
    }

    .register-wrapper {
      width: 100%;
      max-width: 500px;
      margin: 20px auto;
    }

    h2 {
      font-size: 2.2rem;
      margin-bottom: 20px;
      font-weight: 700;
      background: linear-gradient(45deg, #00b4d8, #0077b6);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      text-align: center;
    }

    form {
      width: 100%;
      background: white;
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 15px 35px rgba(0, 150, 255, 0.1);
      border: 1px solid rgba(173, 216, 230, 0.3);
      position: relative;
      overflow: hidden;
    }

    form::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(
        to bottom right,
        rgba(173, 216, 230, 0.1),
        rgba(173, 216, 230, 0.05),
        transparent
      );
      transform: rotate(30deg);
      z-index: -1;
    }

    .input-group {
      position: relative;
      margin-bottom: 25px;
    }

    input {
      width: 100%;
      padding: 15px 20px;
      border: none;
      background: rgba(240, 248, 255, 0.8);
      border-radius: 10px;
      font-size: 1rem;
      color: #333;
      transition: all 0.3s ease;
      border: 1px solid rgba(173, 216, 230, 0.5);
    }

    input:focus {
      outline: none;
      box-shadow: 0 0 0 2px rgba(0, 180, 216, 0.3);
      background: white;
    }

    button {
      width: 100%;
      padding: 15px;
      border: none;
      background: linear-gradient(45deg, #00b4d8, #0077b6);
      color: white;
      font-size: 1rem;
      font-weight: 600;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(0, 180, 216, 0.3);
      margin-top: 10px;
    }

    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 7px 20px rgba(0, 180, 216, 0.4);
    }

    button:active {
      transform: translateY(0);
    }

    .login-link {
      text-align: center;
      margin-top: 20px;
      font-size: 0.9rem;
      color: #666;
    }

    .login-link a {
      color: #0077b6;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .login-link a:hover {
      color: #00b4d8;
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      form {
        padding: 30px;
      }
      
      h2 {
        font-size: 1.8rem;
      }
      
      body {
        padding: 10px;
      }
    }

    @media (max-width: 480px) {
      form {
        padding: 25px;
      }
    }
  </style>
</head>
<body>
  <div class="floating-elements" id="floating-elements"></div>
  
  <div class="register-wrapper">
    <h2>AIverse Registration</h2>
    
    <form action="register_validation.php" method="POST">
      <div class="input-group">
        <input type="text" name="fname" placeholder="First Name" required>
      </div>
      
      <div class="input-group">
        <input type="text" name="lname" placeholder="Last Name" required>
      </div>
      
      <div class="input-group">
        <input type="email" name="email" placeholder="Email" required>
      </div>
      
      <div class="input-group">
        <input type="tel" name="phone" placeholder="Phone Number" required pattern="[0-9]{10}">
      </div>
      
      <div class="input-group">
        <input type="text" name="username" placeholder="Username" required>
      </div>
      
      <div class="input-group">
        <input type="password" name="password" placeholder="Password" required minlength="6">
      </div>
      
      <div class="input-group">
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
      </div>
      
      <div class="input-group">
        <input type="text" name="pincode" placeholder="Pincode" required>
      </div>
      
      <button type="submit">Register</button>
      
      <div class="login-link">
        Already have an account? <a href="login.php">Login</a>
      </div>
    </form>
  </div>

  <script>
    function initGSAPAnimations() {
      gsap.from('form', {
        duration: 1.5,
        y: 50,
        opacity: 0,
        rotationX: 15,
        ease: 'power3.out',
        delay: 0.5
      });
      
      gsap.from('h2', {
        duration: 1,
        y: -30,
        opacity: 0,
        ease: 'back.out',
        delay: 1
      });
      
      gsap.from('.input-group', {
        duration: 0.8,
        y: 20,
        opacity: 0,
        stagger: 0.1,
        ease: 'power2.out',
        delay: 1.4
      });
      
      gsap.from('button', {
        duration: 1,
        y: 20,
        opacity: 0,
        ease: 'elastic.out(1, 0.5)',
        delay: 1.8
      });
      
      gsap.from('.login-link', {
        duration: 0.8,
        y: 20,
        opacity: 0,
        ease: 'power2.out',
        delay: 2
      });
      
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
    
    window.addEventListener('load', () => {
      initGSAPAnimations();
      
      const form = document.querySelector('form');
      form.addEventListener('mousemove', (e) => {
        const x = e.clientX / window.innerWidth;
        const y = e.clientY / window.innerHeight;
        
        gsap.to(form, {
          rotationY: 10 * (x - 0.5),
          rotationX: -10 * (y - 0.5),
          transformPerspective: 1000,
          ease: 'power2.out',
          duration: 1
        });
      });
      
      form.addEventListener('mouseleave', () => {
        gsap.to(form, {
          rotationY: 0,
          rotationX: 0,
          duration: 1,
          ease: 'elastic.out(1, 0.5)'
        });
      });
    });
  </script>
</body>
</html>