<?php
// Contact Page
// This page contains the contact form

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../includes/header.php';
?>

<!-- ============================================
     CONTACT PAGE
     ============================================ -->
<section class="page-header">
    <div class="container">
        <h1>Contact Us</h1>
        <p>We'd love to hear from you. Get in touch with us today!</p>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <div class="contact-content">
            <!-- Contact Info -->
            <div class="contact-info">
                <h2>Get In Touch</h2>
                <p>Have questions? We're here to help. Reach out to us through any of these channels.</p>

                <div class="contact-details">
                    <div class="contact-detail">
                        <h4>📧 Email</h4>
                        <p><a href="mailto:support@edulearn.com">support@edulearn.com</a></p>
                    </div>
                    <div class="contact-detail">
                        <h4>📞 Phone</h4>
                        <p><a href="tel:+1234567890">+1 (234) 567-890</a></p>
                    </div>
                    <div class="contact-detail">
                        <h4>📍 Address</h4>
                        <p>123 Learning Street<br>Education City, EC 12345<br>United States</p>
                    </div>
                    <div class="contact-detail">
                        <h4>🕐 Business Hours</h4>
                        <p>Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday - Sunday: Closed</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-wrapper">
                <h2>Send us a Message</h2>

                <!-- Error Messages -->
                <?php if (isset($_SESSION['error_messages'])): ?>
                    <div style="background-color: rgba(239, 68, 68, 0.15); border: 2px solid #ef4444; color: #fca5a5; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                        <strong>Error:</strong>
                        <ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">
                            <?php foreach ($_SESSION['error_messages'] as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php unset($_SESSION['error_messages']); ?>
                <?php endif; ?>

                <!-- Success Messages -->
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div style="background-color: rgba(16, 185, 129, 0.15); border: 2px solid #10b981; color: #86efac; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                        <strong>Success:</strong> <?php echo htmlspecialchars($_SESSION['success_message']); ?>
                    </div>
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>

                <form class="contact-form" method="POST" action="../includes/action-contact.php">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            placeholder="Your name"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            placeholder="Your email"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject *</label>
                        <input 
                            type="text" 
                            id="subject" 
                            name="subject" 
                            placeholder="Subject of your message"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea 
                            id="message" 
                            name="message" 
                            placeholder="Your message here..."
                            rows="6"
                            required
                        ></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-large">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
// Include footer
include '../includes/footer.php';
?>
