<?php
// Footer Include File
// This file contains the footer section for all pages

// Set default path_prefix if not already set (in case footer is included independently)
if (!isset($path_prefix)) {
    $current_dir = basename(dirname($_SERVER['PHP_SELF']));
    $is_in_subdirectory = ($current_dir !== 'elearning-platform' && $current_dir !== '');
    $path_prefix = $is_in_subdirectory ? '../' : '';
}
?>

<!-- ============================================
     FOOTER SECTION
     ============================================ -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <!-- Footer Brand -->
            <div class="footer-section">
                <h4>EduLearn</h4>
                <p>Empowering learners worldwide with quality online education and expert instruction.</p>
            </div>

            <!-- Quick Links -->
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="<?php echo $path_prefix; ?>index.php">Home</a></li>
                    <li><a href="<?php echo $path_prefix; ?>pages/courses.php">Courses</a></li>
                    <li><a href="<?php echo $path_prefix; ?>pages/about.php">About Us</a></li>
                    <li><a href="<?php echo $path_prefix; ?>pages/contact.php">Contact</a></li>
                </ul>
            </div>

            <!-- Company -->
            <div class="footer-section">
                <h4>Company</h4>
                <ul>
                    <li><a href="<?php echo $path_prefix; ?>pages/about.php">About Us</a></li>
                    <li><a href="<?php echo $path_prefix; ?>pages/contact.php">Contact Info</a></li>
                    <li><a href="<?php echo $path_prefix; ?>pages/careers.php">Careers</a></li>
                    <li><a href="<?php echo $path_prefix; ?>pages/blog.php">Blog</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div class="footer-section">
                <h4>Support</h4>
                <ul>
                    <li><a href="<?php echo $path_prefix; ?>pages/faq.php">FAQ</a></li>
                    <li><a href="<?php echo $path_prefix; ?>pages/contact.php">Contact Support</a></li>
                    <li><a href="<?php echo $path_prefix; ?>pages/help.php">Help Center</a></li>
                    <li><a href="<?php echo $path_prefix; ?>pages/terms.php">Terms of Service</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="footer-section">
                <h4>Stay Updated</h4>
                <p class="newsletter-text">Subscribe to our newsletter for updates and special offers</p>
                <form class="newsletter-form" action="#" method="POST" novalidate>
                    <div class="newsletter-input-wrap">
                        <input type="email" name="newsletter_email" placeholder="Your email address" aria-label="Email address for newsletter">
                        <button type="submit" class="btn newsletter-submit">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; 2026 EduLearn. All rights reserved. | Empowering learners worldwide with quality education</p>
        </div>
    </div>
</footer>

</body>

<!-- JavaScript Files -->
<script src="<?php echo $path_prefix; ?>js/main.js"></script>

</html>
