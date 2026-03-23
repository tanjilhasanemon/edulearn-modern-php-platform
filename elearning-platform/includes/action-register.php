<?php
// Action Handler: Register
// Purpose: Handle user registration form submission
// This file processes the registration data and adds new users to the database

// Include database connection
include 'database.php';

// Start session to store messages
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form data and sanitize it
    $fullname = stripslashes(htmlspecialchars($_POST['fullname'] ?? ''));
    $email = stripslashes(htmlspecialchars($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $terms_accepted = isset($_POST['terms']) && $_POST['terms'] === 'on';

    // Initialize error array
    $errors = array();

    // Validation: Check if all required fields are filled
    if (empty($fullname)) {
        $errors[] = "Full name is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    if (empty($confirm_password)) {
        $errors[] = "Please confirm password";
    }

    // Validation: Terms must be accepted
    if (!$terms_accepted) {
        $errors[] = "You must agree to the Terms of Service and Privacy Policy";
    }

    // Validation: Check if passwords match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }

    // Validation: Check password strength (minimum 6 characters)
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }

    // Validation: Check email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    // If no validation errors, proceed with registration
    if (empty($errors)) {
        
        // Check if email already exists in database
        $check_email_query = "SELECT id FROM users WHERE email = '" . mysqli_real_escape_string($connection, $email) . "'";
        $check_email_result = mysqli_query($connection, $check_email_query);

        if (mysqli_num_rows($check_email_result) > 0) {
            $errors[] = "Email already registered";
        } else {
            // Store password as plain-text (beginner-friendly - not secure but as requested)
            // In production, use password_hash() for security
            $plain_password = $password;

            // Prepare SQL query to insert new user
            $insert_query = "INSERT INTO users (fullname, email, password, created_at) 
                            VALUES (
                                '" . mysqli_real_escape_string($connection, $fullname) . "',
                                '" . mysqli_real_escape_string($connection, $email) . "',
                                '" . mysqli_real_escape_string($connection, $plain_password) . "',
                                NOW()
                            )";

            // Execute query
            if (mysqli_query($connection, $insert_query)) {
                // Registration successful - redirect to login
                $_SESSION['success_message'] = "Registration successful! Please login.";
                header("Location: ../pages/login.php");
                exit();
            } else {
                // Database error
                $errors[] = "Database error: " . mysqli_error($connection);
            }
        }
    }

    // If there are errors, redirect back with error message
    if (!empty($errors)) {
        $_SESSION['error_messages'] = $errors;
        header("Location: ../pages/register.php");
        exit();
    }

} else {
    // If not a POST request, redirect to register page
    header("Location: ../pages/register.php");
    exit();
}

// Close database connection
mysqli_close($connection);

?>
