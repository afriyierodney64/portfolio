<?php
require 'config.php';

// Destroy all session data
$_SESSION = [];
session_destroy();

// Redirect to login page
header("Location: admin-login.php");
exit();
?>