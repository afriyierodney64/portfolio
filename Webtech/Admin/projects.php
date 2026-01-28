<?php
require 'config.php'; // Make sure this connects to your DB and starts a session if needed

// Fetch projects
$projects = $conn->query("SELECT * FROM projects ORDER BY created_at DESC");
$projectList = [];
while ($row = $projects->fetch_assoc()) {
    $projectList[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Projects</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
  <link href="style.css" rel="stylesheet"/>
</head>
<body>
  <header>
    <a href="index.html"><h1>Rodney</h1></a>
    <nav>
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="projects.php" class="active">Projects</a>
      <a href="contact.php">Contact</a>
    </nav>
  </header>

  <section>
    <h2>My Projects</h2>

    <?php foreach ($projectList as $index => $project): ?>
      <?php 
        $previewId = 'preview' . ($index + 1); 
        $title = htmlspecialchars($project['title']);
        $description = htmlspecialchars($project['description']);
      ?>
      <div class="project" onclick="openPreview('<?php echo $previewId; ?>')">
        <h3><?php echo $title; ?></h3>
        <p><?php echo $description; ?></p>
      </div>
    <?php endforeach; ?>
  </section>

  <!-- Static image preview modals -->
  <div id="preview1" class="preview-modal">
    <div class="preview-content">
      <span class="close-btn" onclick="closePreview('preview1')">&times;</span>
      <h3>Car Rental Application</h3>
      <div class="gallery">
        <img src="images/project1_1.jpg">
        <img src="images/project1_2.jpg">
        <img src="images/project1_3.jpg">
        <img src="images/project1_4.jpg">
      </div>
    </div>
  </div>

  <div id="preview2" class="preview-modal">
    <div class="preview-content">
      <span class="close-btn" onclick="closePreview('preview2')">&times;</span>
      <h3>Bluetooth-Controlled Lamp</h3>
      <div class="gallery">
        <img src="images/project2_1.jpg">
        <img src="images/project2_2.jpg">
        <img src="images/project2_3.jpg">
        <img src="images/project2_4.jpg">
      </div>
    </div>
  </div>

  <div id="preview3" class="preview-modal">
    <div class="preview-content">
      <span class="close-btn" onclick="closePreview('preview3')">&times;</span>
      <h3>Proposal Website</h3>
      <div class="gallery">
        <img src="images/project3_2.jpg">
        <img src="images/project3_1.jpg">
        <img src="images/project3_4.jpg">
        <img src="images/project3_3.jpg">
      </div>
    </div>
  </div>

  <div id="preview4" class="preview-modal">
    <div class="preview-content">
      <span class="close-btn" onclick="closePreview('preview4')">&times;</span>
      <h3>Affiliate Marketing Website</h3>
      <div class="gallery">
        <img src="images/project4_1.jpg" class="landscape">
        <img src="images/project4_3.jpg" class="landscape">
        <img src="images/project4_2.jpg" class="landscape">
        <img src="images/project4_4.jpg" class="landscape">
      </div>
    </div>
  </div>

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
  <script src="projects.js"></script>
</body>
</html>
