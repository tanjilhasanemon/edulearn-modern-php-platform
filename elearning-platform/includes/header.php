<?php
// Header Include File
// This file contains the navigation and page header for all pages

// Start session to check login status
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determine the base path based on file location
// Check if we're in a subdirectory (like /pages/) or in the root
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
$is_in_subdirectory = ($current_dir !== 'elearning-platform' && $current_dir !== '');
$path_prefix = $is_in_subdirectory ? '../' : '';

// Check if user is logged in
$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLearn - Modern E-Learning Platform</title>
    
    <!-- Dark Theme CSS Stylesheet -->
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>css/theme.css">
</head>
<body>

<!-- ============================================
     NAVIGATION BAR
     ============================================ -->
<nav class="navbar">
    <div class="nav-container">
        <!-- Logo -->
        <div class="nav-brand">
            <a href="<?php echo $path_prefix; ?>index.php" class="logo">
                <span class="logo-icon">📚</span>
                <span class="logo-text">EduLearn</span>
            </a>
        </div>

        <!-- Navigation Links -->
        <ul class="nav-menu">
            <li><a href="<?php echo $path_prefix; ?>index.php" class="nav-link">Home</a></li>
            <li><a href="<?php echo $path_prefix; ?>pages/courses.php" class="nav-link">Courses</a></li>
            <li><a href="<?php echo $path_prefix; ?>pages/about.php" class="nav-link">About</a></li>
            <li><a href="<?php echo $path_prefix; ?>pages/contact.php" class="nav-link">Contact</a></li>
        </ul>

        <!-- Auth Buttons -->
        <div class="nav-auth">
            <?php if ($is_logged_in): ?>
                <!-- User is logged in -->
                <span class="nav-user-greeting">Welcome, <?php echo htmlspecialchars($user_name); ?>!</span>
                <a href="<?php echo $path_prefix; ?>pages/dashboard.php" class="btn btn-secondary">Dashboard</a>
                <a href="<?php echo $path_prefix; ?>includes/action-logout.php" class="btn btn-outline">Logout</a>
            <?php else: ?>
                <!-- User is not logged in -->
                <button class="btn btn-outline" onclick="window.location.href='<?php echo $path_prefix; ?>pages/login.php'">Login</button>
                <button class="btn btn-primary" onclick="window.location.href='<?php echo $path_prefix; ?>pages/register.php'">Sign Up</button>
            <?php endif; ?>
        </div>

        <!-- Mobile Menu Toggle -->
        <div class="hamburger" onclick="toggleMobileMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</nav>

<!-- Mobile Menu (hidden by default) -->
<div class="mobile-menu" id="mobileMenu">
    <a href="<?php echo $path_prefix; ?>index.php">Home</a>
    <a href="<?php echo $path_prefix; ?>pages/courses.php">Courses</a>
    <a href="<?php echo $path_prefix; ?>pages/about.php">About</a>
    <a href="<?php echo $path_prefix; ?>pages/contact.php">Contact</a>
    <?php if ($is_logged_in): ?>
        <a href="<?php echo $path_prefix; ?>pages/dashboard.php" class="auth-link">Dashboard</a>
        <a href="<?php echo $path_prefix; ?>includes/action-logout.php" class="auth-link">Logout</a>
    <?php else: ?>
        <a href="<?php echo $path_prefix; ?>pages/login.php" class="auth-link">Login</a>
        <a href="<?php echo $path_prefix; ?>pages/register.php" class="auth-link">Sign Up</a>
    <?php endif; ?>
</div>
