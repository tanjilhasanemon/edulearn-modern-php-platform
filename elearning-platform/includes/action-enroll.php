<?php
// Action Handler: Enroll
// Purpose: Handle course enrollment for logged-in users

// Include database connection
include 'database.php';

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Not logged in - redirect to login
    $_SESSION['error_messages'] = array("Please login to enroll in courses.");
    header("Location: ../pages/login.php");
    exit();
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user_id = $_SESSION['user_id'];
    $course_id = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;
    
    // Validate course_id
    if ($course_id <= 0) {
        $_SESSION['error_messages'] = array("Invalid course.");
        header("Location: ../pages/courses.php");
        exit();
    }
    
    // Check if course exists
    $course_query = "SELECT id FROM courses WHERE id = " . $course_id;
    $course_result = mysqli_query($connection, $course_query);
    
    if (!$course_result || mysqli_num_rows($course_result) === 0) {
        $_SESSION['error_messages'] = array("Course not found.");
        header("Location: ../pages/courses.php");
        exit();
    }
    
    // Check if user is already enrolled
    $check_enrollment_query = "SELECT id FROM enrollments WHERE student_id = " . $user_id . " AND course_id = " . $course_id;
    $check_enrollment_result = mysqli_query($connection, $check_enrollment_query);
    
    if ($check_enrollment_result && mysqli_num_rows($check_enrollment_result) > 0) {
        $_SESSION['success_message'] = "You are already enrolled in this course.";
        header("Location: ../pages/course-detail.php?id=" . $course_id);
        exit();
    }
    
    // Enroll the user
    $enroll_query = "INSERT INTO enrollments (student_id, course_id, enrollment_date, status) 
                    VALUES (" . $user_id . ", " . $course_id . ", NOW(), 'active')";
    
    if (mysqli_query($connection, $enroll_query)) {
        // Update student count in courses table
        $update_query = "UPDATE courses SET students_count = students_count + 1 WHERE id = " . $course_id;
        mysqli_query($connection, $update_query);
        
        $_SESSION['success_message'] = "Successfully enrolled in course! Enjoy learning.";
        header("Location: ../pages/course-detail.php?id=" . $course_id);
        exit();
    } else {
        $_SESSION['error_messages'] = array("Enrollment failed. Please try again.");
        header("Location: ../pages/course-detail.php?id=" . $course_id);
        exit();
    }
    
} else {
    // Not a POST request - redirect to courses
    header("Location: ../pages/courses.php");
    exit();
}

// Close database connection
mysqli_close($connection);

?>
