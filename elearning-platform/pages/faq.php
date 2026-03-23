<?php
// FAQ Page

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../includes/header.php';
?>

<!-- ============================================
     FAQ PAGE HEADER
     ============================================ -->
<section class="page-header">
    <div class="container">
        <h1>Frequently Asked Questions</h1>
        <p>Find answers to common questions about EduLearn</p>
    </div>
</section>

<!-- ============================================
     FAQ SECTION
     ============================================ -->
<section class="faq-section">
    <div class="container">
        <div class="faq-content">
            <div class="faq-item">
                <h3>How do I enroll in a course?</h3>
                <p>To enroll in a course, first create an account or log in to your existing account. Browse available courses and click "Enroll Now" on any course page. Once enrolled, you'll have instant access to all course materials.</p>
            </div>

            <div class="faq-item">
                <h3>Can I get a refund if I'm not satisfied?</h3>
                <p>Yes! We offer a 30-day money-back guarantee on all courses. If you're not satisfied with your purchase, contact our support team within 30 days for a full refund.</p>
            </div>

            <div class="faq-item">
                <h3>Do I get a certificate when I complete a course?</h3>
                <p>Yes! Upon successful completion of any course, you'll receive a certificate of completion that you can add to your resume or LinkedIn profile.</p>
            </div>

            <div class="faq-item">
                <h3>How long do I have access to the course materials?</h3>
                <p>You have lifetime access to all course materials! Once enrolled, you can access and review the content whenever you want, forever.</p>
            </div>

            <div class="faq-item">
                <h3>Can I download course videos for offline viewing?</h3>
                <p>Yes, most course videos can be downloaded through the course player. You can watch them offline on any device and sync your progress when you're back online.</p>
            </div>

            <div class="faq-item">
                <h3>How do I contact my instructor?</h3>
                <p>Each course has a discussion forum where you can ask questions and interact with your instructor and other students. For direct inquiries, you can find the instructor's contact information in the course details.</p>
            </div>

            <div class="faq-item">
                <h3>Can I share my account with others?</h3>
                <p>No, course accounts are personal and non-transferable. Each person needs to create their own account and enroll individually.</p>
            </div>

            <div class="faq-item">
                <h3>How often are new courses added?</h3>
                <p>We add new courses regularly! New content is released multiple times per week. Check back often or enable notifications to stay updated on new course releases.</p>
            </div>

            <div class="faq-item">
                <h3>Is there student support available?</h3>
                <p>Yes! Our support team is available Monday-Friday, 9 AM - 6 PM. Contact us through the contact page or email support@edulearn.com for assistance.</p>
            </div>

            <div class="faq-item">
                <h3>Can I become an instructor?</h3>
                <p>Yes! We're always looking for expert instructors. If you're interested in creating courses, contact us for more information about our instructor program.</p>
            </div>
        </div>
    </div>
</section>

<?php
include '../includes/footer.php';
?>
