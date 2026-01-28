<?php
require 'config.php';

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address!";
    } else {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        
        if ($stmt->execute()) {
            $success = "Thank you! Your message has been sent.";
            // Clear form fields
            $name = $email = $message = '';
        } else {
            $error = "Error sending message. Please try again later.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
  <link href="style.css" rel="stylesheet"/>
</head>
<body>
  <header>
    <h1>Rodney</h1>
    <nav>
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="projects.php">Projects</a>
      <a href="contact.php" class="active">Contact</a>
    </nav>
  </header>

  <section>
    <h2>Contact Me</h2>
    
    <?php if ($error): ?>
      <div class="alert error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
      <div class="alert success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <form method="POST">
      <label for="name">Name</label>
      <input type="text" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>

      <label for="email">Email</label>
      <input type="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>

      <label for="message">Message</label>
      <textarea name="message" required><?php echo htmlspecialchars($message ?? ''); ?></textarea>

      <button type="submit">Send</button>
    </form>
  </section>

 <footer>
    <p>&copy; 2025 Rodney. All rights reserved.</p>
    <div class="social-icons">
      <a href="https://www.linkedin.com/in/rodney-afriyie-882338365" target="_blank">
        <img src="images/linkedin.png" alt="LinkedIn">
      </a>
      <a href="https://www.instagram.com/rodney.afriyie/?hl=en" target="_blank">
        <img src="images/instagram.png" alt="Instagram">
      </a>
      <a href="https://www.tiktok.com/@rodney_appiah?is_from_webapp=1&sender_device=pc" target="_blank">
        <img src="images/tiktok.png" alt="TikTok">
      </a>
    </div>
  </footer>  
</body>
</html>