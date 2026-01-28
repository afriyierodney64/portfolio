<?php
require 'config.php';

// Redirect to login if not authenticated
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="style.css" rel="stylesheet">
    <style>
        .dashboard {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        .stat-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        .menu {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        .menu-card {
            background: #1e293b;
            color: white;
            padding: 2rem;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.3s;
        }
        .menu-card:hover {
            transform: translateY(-5px);
        }
        .menu-card a {
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            display: block;
            height: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Portal</h1>
        <nav>
            <a href="admin-dashboard.php" class="active">Dashboard</a>
            <a href="admin-projects.php">Projects</a>
             <?php if ($_SESSION['admin_role'] === 'superadmin'): ?>
                <a href="admin-create.php">Create Admin</a>
            <?php endif; ?>
            <a href="admin-messages.php">Messages</a>
            <a href="admin-settings.php">Account Settings</a>
            <a href="logout.php">Logout</a>
            <a href="index.php" target="_blank" style="margin-left:auto; color: #0a66c2; font-weight: bold;">🌐 Back to Site</a>
        </nav>
    </header>

    <div class="dashboard">
        <h2>Welcome, <?php echo $_SESSION['admin_role'] === 'superadmin' ? 'Super Admin' : 'Admin'; ?></h2>
        
       <div class="stats">
    <div class="stat-card">
        <h3>Total Projects</h3>
        <p>
            <?php
            $result = $conn->query("SHOW TABLES LIKE 'projects'");
            echo $result->num_rows > 0 ? $conn->query("SELECT COUNT(*) FROM projects")->fetch_row()[0] : '0';
            ?>
        </p>
    </div>
    <div class="stat-card">
        <h3>Unread Messages</h3>
        <p>
            <?php
            $result = $conn->query("SHOW TABLES LIKE 'messages'");
            echo $result->num_rows > 0 ? $conn->query("SELECT COUNT(*) FROM messages WHERE is_read = 0")->fetch_row()[0] : '0';
            ?>
        </p>
    </div>
    <div class="stat-card">
        <h3>Admins</h3>
        <p>
            <?php
            echo $conn->query("SELECT COUNT(*) FROM admins")->fetch_row()[0];
            ?>
        </p>
    </div>
</div>

        <div class="menu">
            <div class="menu-card">
                <a href="admin-projects.php">Manage Projects</a>
            </div>
            <div class="menu-card">
                <a href="admin-messages.php">View Messages</a>
            </div>
            <?php if ($_SESSION['admin_role'] === 'superadmin'): ?>
                <div class="menu-card">
                    <a href="admin-create.php">Create New Admin</a>
                </div>
            <?php endif; ?>
            <div class="menu-card">
                <a href="admin-settings.php">Account Settings</a>
            </div>
        </div>
    </div>
</body>
</html>