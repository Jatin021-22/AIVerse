<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AIverse - The Future of Artificial Intelligence</title>
    <link rel="icon" href="../img\Screenshot_2025-06-29_121809-removebg-preview.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/font.css">
    
</head>
<body>
    <!-- Header -->
    <header id="header">
        <nav class="container1">
            <a href="index.php" class="logo"><i class='bx  bx-planet'  ></i>AIverse</a>
            
            <div class="nav-center">
                <ul class="nav-links" id="navLinks">
                    <li><a href="about.php">About</a></li>
                    <li class="dropdown">
                        <a href="service.php">Services <i class="fas fa-chevron-down dropdown-icon"></i></a>
                        <div class="dropdown-menu">
                            <a href="chatbot.php">ChatBot</a>
                            <a href="weather.php">Weather</a>
                            <a href="Vision_Generator.php">Image Generator</a>
                            <a href="voice_converter.php">TTS</a>
                        </div>
                    </li>
                    <li><a href="feedback.php">Feedback</a></li>
                    <li class="dropdown">
                        <a href="profile.php">Profile <i class="fas fa-chevron-down dropdown-icon"></i></a>
                        <div class="dropdown-menu">
                            <a href="profile.php">View Profile</a>
                            <a href="update_profile.php">Update Profile</a>
                            <a href="update_password.php">Update Password</a>
                        </div>
                    </li>
                </ul>
            </div>
            
            <div class="nav-right">
                  <div class="aiverse-logout-button" style="padding: 10px 20px; background: transperent; color:  #f9fcfdff;  font-size: 16px; border: 2px solid #E0FFFF; border-radius: 25px;text-decoration: none;  box-shadow: 0 0 10px rgba(135, 206, 235, 0.7);"
                            onmouseover="this.style.background='linear-gradient(45deg, #40C4FF, #B0E0E6)'; this.style.boxShadow='0 0 15px rgba(135, 206, 235, 1)';"
                            onmouseout="this.style.background='linear-gradient(0deg, #f7fbfd, #40c3ff06)'; this.style.boxShadow='0 0 10px rgba(135, 206, 235, 0.7)';"
                            >  <a href="profile.php" class="" style="text-decoration: none;"><i class="fa-solid fa-user-tie"></i>
                            <?php
                            if (isset($_SESSION['username'])) {
                                echo htmlspecialchars($_SESSION['username']);
                            } else {
                                echo "Account";
                            }
                    ?></a></div>
                <a href="logout.php" class="logout-link">
                <i class="fa-solid fa-power-off"></i>
                </a>
                
            </div>
            <button class="mobile-menu-btn" id="mobileMenuBtn"><i class="fas fa-bars"></i></button>
        </nav>
    </header>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const navCenter = document.querySelector('.nav-center');
    const dropdowns = document.querySelectorAll('.dropdown');

    // Mobile menu toggle
    mobileMenuBtn.addEventListener('click', () => {
        navCenter.classList.toggle('active');
        mobileMenuBtn.innerHTML = navCenter.classList.contains('active') ? 
            '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
    });

    // Dropdown functionality for mobile
    dropdowns.forEach(dropdown => {
        const link = dropdown.querySelector('a');
        
        link.addEventListener('click', (e) => {
            if (window.innerWidth <= 992) {
                e.preventDefault();
                dropdown.classList.toggle('active');
            }
        });
    });

    // Header scroll effect
    const header = document.getElementById('header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 992 && 
            !e.target.closest('.nav-center') && 
            !e.target.closest('#mobileMenuBtn')) {
            navCenter.classList.remove('active');
            mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
        }
    });
});
    </script>
</body>
</html>