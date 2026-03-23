<?php
// Careers Page

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../includes/header.php';
?>

<!-- ============================================
     CAREERS PAGE HEADER
     ============================================ -->
<section class="page-header">
    <div class="container">
        <h1>Careers at EduLearn</h1>
        <p>Join our mission to empower learners worldwide</p>
    </div>
</section>

<!-- ============================================
     CAREERS SECTION
     ============================================ -->
<section class="careers-section">
    <div class="container">
        <div class="careers-content">
            <h2>Work With Us</h2>
            <p>EduLearn is dedicated to providing quality educational content to learners around the world. We're looking for passionate team members to join us in this mission.</p>

            <h2>Open Positions</h2>
            <p>Currently, we don't have any open positions available. However, we're always interested in hearing from talented individuals.</p>

            <h2>Become an Instructor</h2>
            <p>Are you an expert in your field? Would you like to share your knowledge with students around the world? We're always looking for passionate instructors to create new courses.</p>
            <p><strong>Benefits of being an EduLearn instructor:</strong></p>
            <ul>
                <li>Reach millions of eager learners worldwide</li>
                <li>Earn attractive revenue from course sales</li>
                <li>Complete creative freedom over course content</li>
                <li>Dedicated support from our team</li>
                <li>Marketing and promotional assistance</li>
            </ul>

            <p>If you're interested in becoming an instructor, <a href="contact.php">contact us</a> to learn more about our instructor program.</p>

            <h2>Internships</h2>
            <p>We occasionally offer internship opportunities for students and recent graduates. Check back soon for details about any upcoming internship programs.</p>
        </div>
    </div>
</section>

<?php
include '../includes/footer.php';
?>
