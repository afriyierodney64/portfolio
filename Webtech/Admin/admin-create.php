<?php
require 'config.php';

// Only Super Admin can access this page
if (!isset($_SESSION['admin_id']) || $_SESSION['admin_role'] !== 'superadmin') {
    header("Location: admin-dashboard.php");
    exit();
}

$error = $success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    // Validate
    if (empty($username) || empty($password)) {
        $error = "Username and password are required!";
    } else {
        // Check if username exists
        $stmt = $conn->prepare("SELECT id FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        
        if ($stmt->get_result()->num_rows > 0) {
            $error = "Username already exists!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new admin
            $stmt = $conn->prepare("INSERT INTO admins (username, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashed_password, $role);
            
            if ($stmt->execute()) {
                $success = "Admin created successfully!";
            } else {
                $error = "Error creating admin: " . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New Admin</title>
    <link href="style.css" rel="stylesheet">
    <style>
        .admin-form {
            max-width: 500px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Portal</h1>
        <nav>
            <a href="admin-dashboard.php">Dashboard</a>
            <a href="admin-projects.php">Projects</a>
            <a href="admin-create.php" class="active">Create Admin</a>
            <a href="admin-messages.php">Messages</a>
            <a href="admin-settings.php">Account Settings</a>
            <a href="logout.php">Logout</a>
            <a href="index.php" target="_blank" style="margin-left:auto; color: #0a66c2; font-weight: bold;">🌐 Back to Site</a>
        </nav>
    </header>

    <div class="admin-form">
        <h2>Create New Admin</h2>
        
        <?php if ($error): ?>
            <div class="alert error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="superadmin">Super Admin</option>
                </select>
            </div>

            <button type="submit">Create Admin</button>
            <a href="admin-dashboard.php" style="margin-left: 1rem;">Cancel</a>
        </form>
    </div>
</body>
</html>