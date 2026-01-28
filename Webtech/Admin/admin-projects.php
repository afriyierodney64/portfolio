<?php
require 'config.php';

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

// Handle deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM projects WHERE id = $id");
    header("Location: admin-projects.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Projects</title>
    <link href="style.css" rel="stylesheet">
    <style>
        .projects-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
            background: #CAC8C1
        }
        .project-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background: #CAC8C1;
        }
        .delete-btn {
            background: #ff4444;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 4px;
            cursor: pointer;
        }
        
    </style>
</head>
<body>
     <header>
        <h1>Admin Portal</h1>
        <nav>
            <a href="admin-dashboard.php">Dashboard</a>
            <a href="admin-projects.php"class="active">Projects</a>
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
        <h2>Manage Projects</h2>
        <a href="project-create.php" style="display: inline-block; margin-bottom: 1rem;">+ Add New Project</a>
<div class="projects-container">
    <?php
    $projects = $conn->query("SELECT * FROM projects ORDER BY created_at DESC");
    while ($project = $projects->fetch_assoc()):
    ?>
    <div class="project-card">
        <div class="project-body">
            <div class="project-main">
                <h3 class="project-title"><?php echo htmlspecialchars($project['title']); ?></h3>
                <p class="project-description"><?php echo htmlspecialchars($project['description']); ?></p>

                <div class="project-tech">
                    <strong>Technologies:</strong>
                    <div class="tech-tags">
                        <?php 
                        if (!empty($project['technologies'])) {
                            $techs = explode(',', $project['technologies']);
                            foreach ($techs as $tech): 
                                $tech = trim($tech);
                                if (!empty($tech)):
                        ?>
                            <span class="tech-tag"><?php echo htmlspecialchars($tech); ?></span>
                        <?php 
                                endif;
                            endforeach;
                        } else {
                            echo '<span class="no-tech">None specified</span>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="project-actions">
                <form action="admin-projects.php" method="GET" class="delete-form">
                    <input type="hidden" name="delete" value="<?php echo $project['id']; ?>">
                    <button type="submit" class="delete-btn"
                        onclick="return confirm('Delete <?php echo addslashes($project['title']); ?> permanently?')">
                        🗑️ Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>  
</div>
</div>
</body>
</html>