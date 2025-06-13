<?php
session_start();

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: pages/homepage.php');
} else {
    header('Location: login.php');
}
exit;
?>