<?php
// Blog Page

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../includes/header.php';
?>

<!-- ============================================
     BLOG PAGE HEADER
     ============================================ -->
<section class="page-header">
    <div class="container">
        <h1>EduLearn Blog</h1>
        <p>Tips, insights, and updates from the EduLearn team</p>
    </div>
</section>

<!-- ============================================
     BLOG SECTION
     ============================================ -->
<section class="blog-section">
    <div class="container">
        <div class="blog-content">
            <h2>Coming Soon</h2>
            <p>We're currently building our blog section. Soon you'll be able to read articles about online learning, course tips, student success stories, and industry insights.</p>

            <h2>Featured Topics</h2>
            <p>When our blog launches, you can expect to find content about:</p>
            <ul>
                <li><strong>Learning Strategies:</strong> Tips and techniques for effective online learning</li>
                <li><strong>Student Success Stories:</strong> Inspiring stories from our students</li>
                <li><strong>Career Development:</strong> How to advance your career through continuous learning</li>
                <li><strong>Industry Updates:</strong> Latest trends in education and technology</li>
                <li><strong>Instructor Resources:</strong> Guides for creating engaging courses</li>
                <li><strong>EduLearn News:</strong> Updates and announcements from our platform</li>
            </ul>

            <h2>Stay Updated</h2>
            <p>Subscribe to our newsletter below to be notified when new blog posts are published.</p>
            <form class="newsletter-form" style="max-width: 500px; margin-top: 2rem;">
                <input type="email" placeholder="Your email address" required>
                <button type="submit" class="btn btn-primary">Subscribe</button>
            </form>
        </div>
    </div>
</section>

<?php
include '../includes/footer.php';
?>
