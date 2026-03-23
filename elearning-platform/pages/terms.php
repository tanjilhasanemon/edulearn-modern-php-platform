<?php
// Terms of Service Page

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../includes/header.php';
?>

<!-- ============================================
     TERMS OF SERVICE HEADER
     ============================================ -->
<section class="page-header">
    <div class="container">
        <h1>Terms of Service</h1>
        <p>Please read these terms carefully before using EduLearn</p>
    </div>
</section>

<!-- ============================================
     TERMS OF SERVICE SECTION
     ============================================ -->
<section class="terms-section">
    <div class="container">
        <div class="terms-content">
            <h2>1. Acceptance of Terms</h2>
            <p>By accessing and using the EduLearn platform, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.</p>

            <h2>2. Use License</h2>
            <p>Permission is granted to temporarily download one copy of the materials (information or software) on EduLearn's website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:</p>
            <ul>
                <li>Modifying or copying the materials</li>
                <li>Using the materials for any commercial purpose or for any public display</li>
                <li>Attempting to decompile or reverse engineer any software contained on EduLearn</li>
                <li>Removing any copyright or other proprietary notations from the materials</li>
                <li>Transferring the materials to another person or "mirroring" the materials on any other server</li>
            </ul>

            <h2>3. Disclaimer</h2>
            <p>The materials on EduLearn's website are provided on an 'as is' basis. EduLearn makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties including, without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.</p>

            <h2>4. Limitations</h2>
            <p>In no event shall EduLearn or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on EduLearn, even if EduLearn or an authorized representative has been notified orally or in writing of the possibility of such damage.</p>

            <h2>5. Accuracy of Materials</h2>
            <p>The materials appearing on EduLearn could include technical, typographical, or photographic errors. EduLearn does not warrant that any of the materials on its website are accurate, complete, or current. EduLearn may make changes to the materials contained on its website at any time without notice.</p>

            <h2>6. Materials and Content</h2>
            <p>EduLearn has not reviewed all of the sites linked to its website and is not responsible for the contents of any such linked site. The inclusion of any link does not imply endorsement by EduLearn of the site. Use of any such linked website is at the user's own risk.</p>

            <h2>7. Refund Policy</h2>
            <p>EduLearn offers a 30-day money-back guarantee on all course purchases. If you are not satisfied with a course, you can request a full refund within 30 days of enrollment.</p>

            <h2>8. Modifications</h2>
            <p>EduLearn may revise these terms of service for its website at any time without notice. By using this website, you are agreeing to be bound by the then current version of these terms of service.</p>

            <h2>9. Governing Law</h2>
            <p>These terms and conditions are governed by and construed in accordance with the laws of the United States, and you irrevocably submit to the exclusive jurisdiction of the courts in that location.</p>

            <h2>10. Contact Us</h2>
            <p>If you have any questions about these Terms of Service, please <a href="contact.php">contact us</a>.</p>
        </div>
    </div>
</section>

<?php
include '../includes/footer.php';
?>
