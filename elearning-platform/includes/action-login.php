<?php
// Action Handler: Login
// Purpose: Handle user login form submission
// This file validates user credentials and starts a session

// Include database connection
include 'database.php';

// Start session to store user information
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form data and sanitize it
    $email = stripslashes(htmlspecialchars($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';  // Don't htmlspecialchars password

    // Initialize error array
    $errors = array();

    // Validation: Check if fields are not empty
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }

    // If validation passed, check credentials in database
    if (empty($errors)) {
        
        // Prepare query to find user by email
        $query = "SELECT id, fullname, email, password FROM users WHERE email = '" . mysqli_real_escape_string($connection, $email) . "' AND role = 'student'";
        $result = mysqli_query($connection, $query);

        // Check if user exists
        if (mysqli_num_rows($result) == 1) {
            
            // Fetch user data
            $user = mysqli_fetch_assoc($result);

            // Verify password using plain-text comparison (beginner-friendly)
            if ($password === $user['password']) {
                
                // Password is correct - create session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['fullname'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['logged_in'] = true;

                // Redirect to student dashboard
                header("Location: ../pages/dashboard.php");
                exit();

            } else {
                // Password incorrect
                $errors[] = "Incorrect password";
            }

        } else {
            // Email not found or not a student account
            $errors[] = "Email not found";
        }
    }

    // If there are errors, redirect back with error message
    if (!empty($errors)) {
        $_SESSION['error_messages'] = $errors;
        header("Location: ../pages/login.php");
        exit();
    }

} else {
    // If not a POST request, redirect to login page
    header("Location: ../pages/login.php");
    exit();
}

// Close database connection
mysqli_close($connection);
?>
