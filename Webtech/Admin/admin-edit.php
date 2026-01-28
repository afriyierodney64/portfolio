<?php
require 'config.php';


if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

// Initialize variables
$title = $description = $technologies = '';
$isEdit = false;

// Handle edit mode
if (isset($_GET['id'])) {
    $isEdit = true;
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM projects WHERE id = $id");
    if ($result->num_rows > 0) {
        $project = $result->fetch_assoc();
        $title = $project['title'];
        $description = $project['description'];
        $technologies = $project['technologies'];
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $technologies = trim($_POST['technologies']);
    
    if ($isEdit) {
        $conn->query("UPDATE projects SET 
            title = '$title', 
            description = '$description', 
            technologies = '$technologies' 
            WHERE id = $id");
    } else {
        $conn->query("INSERT INTO projects (title, description, technologies) 
            VALUES ('$title', '$description', '$technologies')");
    }
    header("Location: admin-projects.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $isEdit ? 'Edit' : 'Add'; ?> Project</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Admin Portal</h1>
        <nav>
            <a href="admin-dashboard.php">Dashboard</a>
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
        <h2><?php echo $isEdit ? 'Edit Project' : 'Add New Project'; ?></h2>
        <form method="POST">
            <label>Title</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" required>

            <label>Description</label>
            <textarea name="description" required><?php echo htmlspecialchars($description); ?></textarea>

            <label>Technologies (comma-separated)</label>
            <input type="text" name="technologies" value="<?php echo htmlspecialchars($technologies); ?>" required>

            <button type="submit">Save</button>
            <a href="admin-projects.php" style="margin-left: 1rem;">Cancel</a>
        </form>
    </div>
</body>
</html>