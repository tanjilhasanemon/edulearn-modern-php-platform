<?php
// Action Handler: Contact
// Purpose: Handle contact form submissions and store messages in database
// This file validates and stores contact messages

// Include database connection
include 'database.php';

// Start session to store messages
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form data and sanitize it
    $name = stripslashes(htmlspecialchars($_POST['name'] ?? ''));
    $email = stripslashes(htmlspecialchars($_POST['email'] ?? ''));
    $subject = stripslashes(htmlspecialchars($_POST['subject'] ?? ''));
    $message = stripslashes(htmlspecialchars($_POST['message'] ?? ''));

    // Initialize error array
    $errors = array();

    // Validation: Check if all required fields are filled
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    if (empty($subject)) {
        $errors[] = "Subject is required";
    }
    if (empty($message)) {
        $errors[] = "Message is required";
    }

    // Validation: Check email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    // If no validation errors, proceed with saving message
    if (empty($errors)) {
        
        // Prepare SQL query to insert contact message
        $insert_query = "INSERT INTO contact_messages (name, email, subject, message, created_at, status) 
                        VALUES (
                            '" . mysqli_real_escape_string($connection, $name) . "',
                            '" . mysqli_real_escape_string($connection, $email) . "',
                            '" . mysqli_real_escape_string($connection, $subject) . "',
                            '" . mysqli_real_escape_string($connection, $message) . "',
                            NOW(),
                            'new'
                        )";

        // Execute query
        if (mysqli_query($connection, $insert_query)) {
            // Message saved successfully
            $_SESSION['success_message'] = "Thank you! Your message has been sent. We'll get back to you soon.";
            header("Location: ../pages/contact.php");
            exit();
        } else {
            // Database error
            $errors[] = "Error saving message: " . mysqli_error($connection);
        }
    }

    // If there are errors, redirect back with error message
    if (!empty($errors)) {
        $_SESSION['error_messages'] = $errors;
        header("Location: ../pages/contact.php");
        exit();
    }

} else {
    // If not a POST request, redirect to contact page
    header("Location: ../pages/contact.php");
    exit();
}

// Close database connection
mysqli_close($connection);

?>
