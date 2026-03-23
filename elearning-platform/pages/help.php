<?php
// Help Center Page

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../includes/header.php';
?>

<!-- ============================================
     HELP CENTER HEADER
     ============================================ -->
<section class="page-header">
    <div class="container">
        <h1>Help Center</h1>
        <p>Get help with EduLearn</p>
    </div>
</section>

<!-- ============================================
     HELP CENTER SECTION
     ============================================ -->
<section class="help-section">
    <div class="container">
        <div class="help-content">
            <h2>Getting Started</h2>
            <div class="help-items">
                <div class="help-item">
                    <h3>Creating Your Account</h3>
                    <p>Click "Sign Up" and fill in your details. You'll need your email address and a strong password. After registration, you can start exploring courses immediately.</p>
                </div>

                <div class="help-item">
                    <h3>Enrolling in Courses</h3>
                    <p>Browse our course catalog, select a course that interests you, and click "Enroll Now". You'll have instant access to all course materials.</p>
                </div>

                <div class="help-item">
                    <h3>Resetting Your Password</h3>
                    <p>On the login page, click "Forgot password?" and follow the instructions. You'll receive an email to reset your password.</p>
                </div>
            </div>

            <h2>Learning</h2>
            <div class="help-items">
                <div class="help-item">
                    <h3>Watching Videos</h3>
                    <p>Once enrolled in a course, click on any lesson to access its video content. Videos can be streamed online or downloaded for offline viewing.</p>
                </div>

                <div class="help-item">
                    <h3>Tracking Progress</h3>
                    <p>Your progress is automatically tracked in your dashboard. You can see completion percentage and continue from where you left off.</p>
                </div>

                <div class="help-item">
                    <h3>Completing Quizzes</h3>
                    <p>Some lessons include quizzes. Complete them to test your knowledge. Your scores are saved and contribute to your overall course progress.</p>
                </div>
            </div>

            <h2>Account & Billing</h2>
            <div class="help-items">
                <div class="help-item">
                    <h3>Managing Your Profile</h3>
                    <p>Update your profile information in your account settings. You can change your name, email, phone, and profile picture.</p>
                </div>

                <div class="help-item">
                    <h3>Subscription & Refunds</h3>
                    <p>We offer a 30-day money-back guarantee. If you're not satisfied, contact support@edulearn.com for a refund.</p>
                </div>

                <div class="help-item">
                    <h3>Contact Support</h3>
                    <p>For additional help, visit our <a href="contact.php">contact page</a> to reach our support team. We're available Monday-Friday, 9 AM - 6 PM.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include '../includes/footer.php';
?>
