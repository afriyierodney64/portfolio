<?php
require 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $technologies = $conn->real_escape_string($_POST['technologies']);
    
    $conn->query("INSERT INTO projects (title, description, technologies) 
                 VALUES ('$title', '$description', '$technologies')");
    
    header("Location: admin-projects.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Project</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Admin Portal</h1>
        <nav>
            <a href="admin-dashboard.php">Dashboard</a>
            <a href="admin-projects.php"  class="active">Projects</a>
             <?php if ($_SESSION['admin_role'] === 'superadmin'): ?>
                <a href="admin-create.php">Create Admin</a>
            <?php endif; ?>
            <a href="admin-messages.php">Messages</a>
            <a href="admin-settings.php">Account Settings</a>
            <a href="logout.php">Logout</a>
            <a href="index.php" target="_blank" style="margin-left:auto; color: #0a66c2; font-weight: bold;">🌐 Back to Site</a>
        </nav>
    </header> 
    <div class="admin-content">
        <h1>Add New Project</h1>
        
        <form method="POST">
            <div class="form-group">
                <label>Project Title</label>
                <input type="text" name="title" required>
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="4" required></textarea>
            </div>
            
            <div class="form-group">
                <label>Technologies (comma separated)</label>
                <input type="text" name="technologies" placeholder="HTML, CSS, PHP" required>
            </div>
            
            <button type="submit">Add Project</button>
            <a href="admin-projects.php" class="cancel-btn">Cancel</a>
        </form>
    </div>
</body>
</html>