<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit;
}

// Fetch current user info
$current_user = $_SESSION['admin_username'];
$current_admin = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admin WHERE username = '$current_user'"));

// Fetch all admins
$result = mysqli_query($conn, "SELECT * FROM admin ORDER BY is_protected DESC, created_at DESC");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Admins</title>
  <link rel="icon" href="img/logo2.png" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/manage_admin.css">
</head>
<body>
  <div class="container">
    <h2 class="mb-4 text-center">👑 Admin Management</h2>

    <?php if ($current_admin['is_protected']): ?>
    <div class="text-end">
      <button class="glass-btn" data-bs-toggle="modal" data-bs-target="#addAdminModal">➕ Add Admin</button>
    </div>
    <?php endif; ?>

    <div class="row">
      <?php while ($admin = mysqli_fetch_assoc($result)): ?>
        <div class="col-md-4">
          <div class="admin-card">
            <div class="card-header">
              <h5><?= htmlspecialchars($admin['username']) ?></h5>
              <?php if ($admin['is_protected']): ?>
                <span class="super-badge"><i class="fa-brands fa-superpowers"></i>     Super Admin</span>
                <?php else: ?>
                <span class="admin-badge"><i class="fa-solid fa-user-tie"></i>   Admin</span>
            <?php endif; ?>

            </div>
            <p><strong>Email:</strong> <?= htmlspecialchars($admin['email']) ?></p>
            <p><strong>Created At:</strong> <?= date('d M Y, h:i A', strtotime($admin['created_at'])) ?></p>

            <div class="action-btns">
              <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editAdminModal<?= $admin['id'] ?>">Edit</button>
              <?php if (!$admin['is_protected']): ?>
                <a href="delete_admin.php?id=<?= $admin['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
              <?php else: ?>
                <button class="btn btn-sm btn-secondary" disabled>Protected</button>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Edit Admin Modal -->
        <div class="modal fade" id="editAdminModal<?= $admin['id'] ?>" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content p-4">
              <h4 class="mb-3 text-center">Edit Admin</h4>
              <form method="POST" action="update_profile.php">
                <input type="hidden" name="id" value="<?= $admin['id'] ?>">

                <div class="mb-3">
                  <label class="form-label">Username</label>
                  <input type="text" name="username" value="<?= htmlspecialchars($admin['username']) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                  <label class="form-label">New Password (leave blank to keep unchanged)</label>
                  <input type="password" name="password" class="form-control">
                </div>

                <div class="mb-3">
                  <label class="form-label">Email</label>
                  <input type="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" class="form-control">
                </div>

                <div class="form-check mb-3">
                  <input class="form-check-input" type="checkbox" name="is_protected" id="protect<?= $admin['id'] ?>" <?= $admin['is_protected'] ? 'checked' : '' ?>>
                  <label class="form-check-label" for="protect<?= $admin['id'] ?>">Mark as protected</label>
                </div>

                <button type="submit" class="btn btn-primary w-100">Update</button>
              </form>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <!-- Add Admin Modal -->
  <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content p-4">
        <h4 class="mb-3 text-center">Register New Admin</h4>
        <form method="POST" action="register_admin.php">
          <div class="mb-3">
            <label class="form-label">Username *</label>
            <input type="text" name="username" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Password *</label>
            <input type="password" name="password" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Email (optional)</label>
            <input type="email" name="email" class="form-control">
          </div>

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_protected" id="is_protected">
            <label class="form-check-label" for="is_protected">Mark as protected (non-deletable)</label>
          </div>

          <button type="submit" class="btn btn-success w-100">Register Admin</button>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Enhanced GSAP Implementation with Error Handling
document.addEventListener('DOMContentLoaded', function() {
  // First check if GSAP is already loaded
  if (typeof gsap === 'undefined') {
    loadGSAP();
  } else {
    initializeAnimations();
  }

  function loadGSAP() {
    const script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js';
    script.onload = initializeAnimations;
    script.onerror = function() {
      console.error('Failed to load GSAP. Using fallback animations.');
      fallbackAnimations();
    };
    document.head.appendChild(script);
  }

  function initializeAnimations() {
    try {
      // Ensure elements exist before animating
      const cards = document.querySelectorAll('.admin-card');
      const header = document.querySelector('h2');
      const glassBtn = document.querySelector('.glass-btn');
      const modals = document.querySelectorAll('.modal');

      // Fallback if GSAP didn't load properly
      if (!gsap || !cards.length) {
        fallbackAnimations();
        return;
      }

      // Reset initial states
      gsap.set([cards, header, glassBtn], { opacity: 1, y: 0, x: 0 });

      // Card animations
      gsap.from(cards, {
        duration: 0.8,
        y: 30,
        opacity: 0,
        stagger: 0.1,
        ease: 'power2.out',
        delay: 0.2
      });

      // Header animation
      if (header) {
        gsap.from(header, {
          duration: 0.8,
          y: -20,
          opacity: 0,
          ease: 'back.out(1.7)',
          delay: 0.1
        });
      }

      // Button animation
      if (glassBtn) {
        gsap.from(glassBtn, {
          duration: 0.8,
          x: 20,
          opacity: 0,
          ease: 'power2.out',
          delay: 0.4
        });
      }

      // Modal animations
      modals.forEach(modal => {
        modal.addEventListener('show.bs.modal', function() {
          const content = this.querySelector('.modal-content');
          if (content) {
            gsap.from(content, {
              duration: 0.6,
              y: 50,
              opacity: 0,
              ease: 'back.out(1.7)'
            });
          }
        });
      });

      // Create particles only if GSAP loaded successfully
      createParticles();

    } catch (error) {
      console.error('Animation error:', error);
      fallbackAnimations();
    }
  }

  function createParticles() {
    try {
      const particleCount = 15;
      const colors = ['rgba(13, 110, 253, 0.1)', 'rgba(108, 117, 125, 0.08)'];
      
      for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');
        
        // Size between 50-150px
        const size = Math.random() * 100 + 50;
        
        // Position within viewport
        const posX = Math.random() * 100;
        const posY = Math.random() * 100;
        
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        particle.style.left = `${posX}%`;
        particle.style.top = `${posY}%`;
        particle.style.background = colors[Math.floor(Math.random() * colors.length)];
        particle.style.opacity = Math.random() * 0.3 + 0.1;
        
        document.body.appendChild(particle);
        
        // Animate with GSAP
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

  function fallbackAnimations() {
    // Simple fade-in as fallback
    const elements = document.querySelectorAll('.admin-card, h2, .glass-btn');
    elements.forEach(el => {
      el.style.opacity = '0';
      el.style.transition = 'opacity 0.5s ease';
      setTimeout(() => {
        el.style.opacity = '1';
      }, 100);
    });
  }
});
  </script>
  
<?php include 'sidebar.php'; ?>
</body>
</html>

<?php include 'footer.php'; ?>