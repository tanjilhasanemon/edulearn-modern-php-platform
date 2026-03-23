<?php
// Modern Register Page
// Beautiful student registration form

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../includes/header.php';
include '../includes/database.php';
?>

<!-- REGISTER SECTION -->
<section class="auth-section">
    <div class="auth-container">
        
        <!-- REGISTER FORM (Left) -->
        <div class="auth-form-wrapper">
            <div class="auth-header">
                <h2>Get Started Learning</h2>
                <p>Create your free account in just 2 minutes</p>
            </div>

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
                    <strong>Success:</strong> <?php echo htmlspecialchars($_SESSION['success_message']); ?> <a href="login.php" style="color: #86efac; font-weight: 600;">Login now</a>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <!-- Register Form -->
            <form class="auth-form" method="POST" action="../includes/action-register.php">
                
                <!-- Full Name Field -->
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input 
                        type="text" 
                        id="fullname" 
                        name="fullname" 
                        placeholder="John Doe"
                        required
                    >
                </div>

                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="your@email.com"
                        required
                    >
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="••••••••"
                        required
                    >
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password" 
                        placeholder="••••••••"
                        required
                    >
                </div>

                <!-- Terms Checkbox -->
                <div class="checkbox" style="margin-bottom: 1.5rem;">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">I agree to the Terms of Service and Privacy Policy</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-large">Create Account</button>

                <!-- Login Link -->
                <p class="auth-footer">
                    Already have an account? <a href="login.php" style="color: #6366f1; font-weight: 600;">Sign in here</a>
                </p>

            </form>

        </div>

        <!-- BENEFITS PANEL (Right) -->
        <div style="display: flex; flex-direction: column; justify-content: center;">
            <div style="background: linear-gradient(135deg, #6366f1 0%, #10b981 100%); color: white; padding: 3rem; border-radius: 16px;">
                
                <h3 style="color: white; margin-bottom: 2rem; font-size: 1.5rem;">Start Your Learning Journey</h3>

                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    
                    <!-- Step 1 -->
                    <div style="display: flex; gap: 1rem;">
                        <div style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.2rem; flex-shrink: 0;">1</div>
                        <div>
                            <h4 style="color: white; margin-bottom: 0.25rem;">Sign Up Free</h4>
                            <p style="color: rgba(255, 255, 255, 0.8); margin: 0; font-size: 0.9rem;">Create your account in just 2 minutes</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div style="display: flex; gap: 1rem;">
                        <div style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.2rem; flex-shrink: 0;">2</div>
                        <div>
                            <h4 style="color: white; margin-bottom: 0.25rem;">Browse Courses</h4>
                            <p style="color: rgba(255, 255, 255, 0.8); margin: 0; font-size: 0.9rem;">Explore our comprehensive catalog of courses</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div style="display: flex; gap: 1rem;">
                        <div style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.2rem; flex-shrink: 0;">3</div>
                        <div>
                            <h4 style="color: white; margin-bottom: 0.25rem;">Start Learning</h4>
                            <p style="color: rgba(255, 255, 255, 0.8); margin: 0; font-size: 0.9rem;">Enroll and begin your learning journey today</p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div style="display: flex; gap: 1rem;">
                        <div style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.2rem; flex-shrink: 0;">4</div>
                        <div>
                            <h4 style="color: white; margin-bottom: 0.25rem;">Earn Certificate</h4>
                            <p style="color: rgba(255, 255, 255, 0.8); margin: 0; font-size: 0.9rem;">Get recognized credentials for your accomplishments</p>
                        </div>
                    </div>

                </div>

                <!-- CTA -->
                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid rgba(255, 255, 255, 0.2);">
                    <p style="margin: 0; color: rgba(255, 255, 255, 0.9); font-size: 0.9rem;">✓ No credit card required • ✓ 100% free • ✓ Start anytime</p>
                </div>

            </div>
        </div>

    </div>
</section>

<?php
include '../includes/footer.php';
?>
