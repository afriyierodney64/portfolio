<?php
require 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

// Handle message actions
if (isset($_GET['mark'])) {
    $id = intval($_GET['mark']);
    $conn->query("UPDATE messages SET is_read = 1 WHERE id = $id");
    header("Location: admin-messages.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM messages WHERE id = $id");
    header("Location: admin-messages.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Messages</title>
    <link href="style.css" rel="stylesheet">
    <style>
        .messages-table {
            width: 100%;
            border-collapse: collapse;
        }
        .messages-table th, .messages-table td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        .messages-table th {
            background-color: #1e293b;
            color: white;
        }
        .unread {
            background-color: #f0f8ff;
        }
    </style>
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
            <a href="admin-messages.php" class="active">Messages</a>
            <a href="admin-settings.php">Account Settings</a>
            <a href="logout.php">Logout</a>
            <a href="index.php" target="_blank" style="margin-left:auto; color: #0a66c2; font-weight: bold;">🌐 Back to Site</a>
        </nav>
    </header>

    <div class="dashboard">
        <h2>Contact Messages</h2>
        <table class="messages-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
                while ($row = $result->fetch_assoc()):
                ?>
                <tr class="<?php echo $row['is_read'] ? '' : 'unread'; ?>">
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                    <td><?php echo date('M j, Y', strtotime($row['created_at'])); ?></td>
                    <td>
                        <?php if (!$row['is_read']): ?>
                            <a href="admin-messages.php?mark=<?php echo $row['id']; ?>">Mark Read</a>
                        <?php endif; ?>
                        <a href="admin-messages.php?delete=<?php echo $row['id']; ?>" 
                           onclick="return confirm('Delete this message?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>