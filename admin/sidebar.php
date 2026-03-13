<?php
include 'db.php';

$admin_name = '';
$admin_email = '';
$current_admin = null;

if (isset($_SESSION['admin_username'])) {
    $username = $_SESSION['admin_username'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM admin WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $admin_name = ucfirst($row['username']);
        $admin_email = $row['email'];
        $current_admin = $row;
    }
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AIverse | Cybernetic Control Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <style>
        a {
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: center;
        }
        .nav-item {
            padding: 12px 15px;
            margin: 5px 0;
        }
        .nav-item.active {
            background-color: rgba(0, 150, 255, 0.2);
            border-left: 3px solid #0096ff;
        }
        .nav-item:hover {
            background-color: rgba(0, 150, 255, 0.1);
        }
        .nav-link {
            display: flex;
            align-items: center;
            width: 100%;
        }
        .nav-icon {
            margin-right: 15px;
            font-size: 1.1em;
            width: 24px;
            text-align: center;
        }
        .nav-text {
            flex-grow: 1;
        }
        .badge {
            background-color: #ff4757;
            color: white;
            border-radius: 10px;
            padding: 2px 6px;
            font-size: 0.7em;
            margin-left: 5px;
        }
        .user-avatar {
            margin-right: 15px;
            font-size: 1.5rem;
        }
        .user-info {
            line-height: 1.4;
        }
        .user-profile {
            display: flex;
            align-items: center;
            padding: 15px;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar" id="sidebar">
            <div class="logo-section">
                <div class="logo-icon"><img src="img/logo2.png" alt="logo" class="logoimg"></div>
                <div class="logo-text">AIverse</div>
            </div>

            <div class="user-profile">
                <div class="user-avatar">
                    <?php if (!empty($current_admin['is_protected'])): ?>
                        <i class="fa-brands fa-superpowers"></i>
                    <?php else: ?>
                        <i class="fa-solid fa-user-tie" style="color: #0d6efd;"></i>
                    <?php endif; ?>
                </div>
                <div class="user-info">
                    <div class="user-name"><?= htmlspecialchars($admin_name) ?></div>
                    <div class="user-email"><?= htmlspecialchars($admin_email) ?></div>
                </div>
            </div>

            <div class="divider"></div>

            <ul class="nav-menu">
                <li class="nav-item <?= ($current_page == 'index.php') ? 'active' : '' ?>">
                    <a href="index.php" class="nav-link">
                        <div class="nav-icon"><i class="fa-solid fa-list-check"></i></div>
                        <div class="nav-text">User Management</div>
                    </a>
                </li>
                <li class="nav-item <?= ($current_page == 'view_feedback.php') ? 'active' : '' ?>">
                    <a href="view_feedback.php" class="nav-link">
                        <div class="nav-icon"><i class="fa-regular fa-comment"></i></div>
                        <div class="nav-text">Feedback <span class="badge">New</span></div>
                    </a>
                </li>
                <div class="divider"></div>
                <li class="nav-item <?= ($current_page == 'admin_profile.php') ? 'active' : '' ?>">
                    <a href="admin_profile.php" class="nav-link">
                        <div class="nav-icon"><i class="fa-solid fa-id-card"></i></div>
                        <div class="nav-text">Profile</div>
                    </a>
                </li>
                <li class="nav-item <?= ($current_page == 'manage_admin.php') ? 'active' : '' ?>">
                    <a href="manage_admin.php" class="nav-link">
                        <div class="nav-icon"><i class="fas fa-user-astronaut"></i></div>
                        <div class="nav-text">Manage Admins</div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">
                        <div class="nav-icon"><i class="fa-solid fa-power-off"></i></div>
                        <div class="nav-text">Log-Out</div>
                    </a>
                </li>
            </ul>

            <div class="ai-data-stream" id="dataStream">
                <span>AI_VERSE_IS_ACTIVE</span>
            </div>

            <button class="toggle-btn" id="toggleSidebar">
                <i class="fas fa-chevron-left"></i>
            </button>
        </aside>

        <main class="main-content" id="mainContent">
            <!-- Content will be loaded here -->
        </main>

        <div class="theme-toggle" id="themeToggle">
            <i class="fas fa-moon"></i>
        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            const icon = toggleBtn.querySelector('i');
            icon.classList.toggle('fa-chevron-left');
            icon.classList.toggle('fa-chevron-right');
        });

        const themeToggle = document.getElementById('themeToggle');
        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            const icon = themeToggle.querySelector('i');
            icon.classList.toggle('fa-moon');
            icon.classList.toggle('fa-sun');
        });

        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
            const icon = themeToggle.querySelector('i');
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
        }
        // ===== AI DATA STREAM ANIMATION =====
const dataStream = document.getElementById('dataStream');
setInterval(() => {
    for (let i = 0; i < 12; i++) {
        const node = document.createElement('div');
        node.classList.add('data-node');
        node.style.position = 'absolute';
        node.style.width = '3px';
        node.style.height = '3px';
        node.style.background = '#3e8fdaff';
        node.style.borderRadius = '50%';
        node.style.left = `${Math.random() * 100}%`;
        node.style.animation = 'floatUp 2s linear infinite';
        dataStream.appendChild(node);

        setTimeout(() => node.remove(), 4000);
    }
}, 300);

// ===== ADD animation keyframes via JavaScript =====
const style = document.createElement('style');
style.textContent = `
@keyframes floatUp {
  from { transform: translateY(20px); opacity: 1; }
  to { transform: translateY(-40px); opacity: 0; }
}
`;
document.head.appendChild(style);

    </script>
</body>
</html>
