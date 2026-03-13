<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit;
}

$username = $_SESSION['admin_username'];
$stmt = mysqli_prepare($conn, "SELECT * FROM admin WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$admin = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Profile</title>
  <link rel="icon" href="img/logo2.png" type="image/png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/admin_profile.css">
</head>

<?php include 'background.php' ?>
<body>

  <div class="container">
    <h2 class="mb-4 text-center">👤 Admin Profile</h2>

    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="glass-card flip-box">
          <div class="flip-box-inner" id="flipCard">
            <!-- Front Side -->
            <div class="flip-box-front">
              <h4><?= htmlspecialchars($admin['username']) ?></h4>
              <p><strong>Email:</strong> <?= htmlspecialchars($admin['email']) ?></p>
              <p><strong>Created At:</strong> <?= date('d M Y h:i A', strtotime($admin['created_at'])) ?></p>
              <?php if ($admin['is_protected']): ?>
                <span class="super-badge">🌟<span></span><i class="fa-brands fa-superpowers"></i> Super Admin</span>
              <?php endif; ?>
              <button class="btn btn-sm btn-outline-primary mt-3" onclick="flipProfile()">✏️ Edit Profile</button>
            </div>

            <!-- Back Side -->
            <div class="flip-box-back">
              <form method="POST" action="update_profile.php">
                <input type="hidden" name="id" value="<?= $admin['id'] ?>">
                <div class="mb-2">
                  <label>Username</label>
                  <input type="text" name="username" value="<?= htmlspecialchars($admin['username']) ?>" class="form-control" required>
                </div>
                <div class="mb-2">
                  <label>Email</label>
                  <input type="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" class="form-control">
                </div>
                <div class="mb-2">
                  <label>New Password</label>
                  <input type="password" name="password" class="form-control">
                </div>
                <div class="d-flex justify-content-between">
                  <button class="btn btn-primary btn-sm">Update</button>
                  <button type="button" class="btn btn-secondary btn-sm" onclick="flipProfile()">Cancel</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function flipProfile() {
      document.getElementById('flipCard').classList.toggle('flipped');
    }
  </script>
  <script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
  // Add loaded class to body immediately
  document.body.classList.add('loaded');

  // Check for GSAP and load if needed
  if (typeof gsap === 'undefined') {
    const script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js';
    script.onload = initAnimations;
    script.onerror = handleGSAPError;
    document.head.appendChild(script);
  } else {
    initAnimations();
  }

  function handleGSAPError() {
    console.warn('GSAP failed to load - using fallback animations');
    document.body.classList.add('no-gsap');
    showElements();
  }

  function showElements() {
    // Fallback to make sure elements are visible
    const elements = document.querySelectorAll('.glass-card, .flip-box-inner');
    elements.forEach(el => {
      el.style.opacity = '1';
      el.style.visibility = 'visible';
    });
  }

  function initAnimations() {
    try {
      // First ensure elements are visible
      gsap.set(['.glass-card', '.flip-box-inner'], {
        opacity: 1,
        visibility: 'visible'
      });

      // Header animation
      gsap.from('h2', {
        duration: 1,
        y: -30,
        opacity: 0,
        ease: 'back.out(1.7)',
        delay: 0.2
      });

      // Card entrance animation
      gsap.from('.glass-card', {
        duration: 1.2,
        y: 50,
        opacity: 0,
        rotationX: 15,
        ease: 'power3.out',
        delay: 0.4,
        immediateRender: false
      });

      // Subtle floating effect
      gsap.to('.glass-card', {
        y: -10,
        duration: 3,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
      });

      // Create particles
      createParticles();

    } catch (error) {
      console.error('Animation error:', error);
      document.body.classList.add('no-gsap');
      showElements();
    }
  }

  function createParticles() {
    try {
      const particleCount = 15;
      const colors = ['rgba(13, 110, 253, 0.1)', 'rgba(108, 117, 125, 0.08)'];
      
      for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');
        
        const size = Math.random() * 100 + 50;
        const posX = Math.random() * 100;
        const posY = Math.random() * 100;
        
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        particle.style.left = `${posX}%`;
        particle.style.top = `${posY}%`;
        particle.style.background = colors[Math.floor(Math.random() * colors.length)];
        particle.style.opacity = Math.random() * 0.3 + 0.1;
        
        document.body.appendChild(particle);
        
        gsap.to(particle, {
          x: `${Math.random() * 100 - 50}px`,
          y: `${Math.random() * 100 - 50}px`,
          duration: Math.random() * 20 + 20,
          delay: Math.random() * -20,
          repeat: -1,
          yoyo: true,
          ease: 'sine.inOut'
        });
      }
    } catch (error) {
      console.error('Particle animation error:', error);
    }
  }

  // Enhanced flip function with better checks
  window.flipProfile = function() {
    const flipCard = document.getElementById('flipCard');
    if (!flipCard) {
      console.warn('Flip card element not found');
      return;
    }
    
    const isFlipped = flipCard.classList.contains('flipped');
    
    if (typeof gsap !== 'undefined') {
      gsap.to(flipCard, {
        rotationY: isFlipped ? 0 : 180,
        duration: 0.8,
        ease: 'back.out(1.2)',
        onStart: () => flipCard.classList.toggle('flipped')
      });
    } else {
      // Fallback animation
      flipCard.style.transition = 'transform 0.8s ease-out';
      flipCard.style.transform = isFlipped ? 'rotateY(0deg)' : 'rotateY(180deg)';
      flipCard.classList.toggle('flipped');
    }
  };
});
</script>
  </script>
  
<?php include 'sidebar.php'; ?>
</body>
</html>

<?php include 'footer.php'; ?>