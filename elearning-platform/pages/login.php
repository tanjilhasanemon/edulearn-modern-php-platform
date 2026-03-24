<?php
// Modern Login Page
// Beautiful student login form

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../includes/header.php';
include '../includes/database.php';

$login_avg_rating = 0;
$login_total_students = 0;

$login_rating_result = mysqli_query($connection, "SELECT AVG(rating) AS avg_rating FROM courses WHERE status='published'");
if ($login_rating_result) {
    $login_avg_rating = (float) (mysqli_fetch_assoc($login_rating_result)['avg_rating'] ?? 0);
}

$login_students_result = mysqli_query($connection, "SELECT COALESCE(SUM(students_count), 0) AS count FROM courses WHERE status='published'");
if ($login_students_result) {
    $login_total_students = (int) (mysqli_fetch_assoc($login_students_result)['count'] ?? 0);
}
?>

<!-- LOGIN SECTION -->
<section class="auth-section">
    <div class="auth-container">
        
        <!-- LOGIN FORM (Left) -->
        <div class="auth-form-wrapper">
            <div class="auth-header">
                <h2>Welcome Back</h2>
                <p>Sign in to continue your learning journey</p>
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
                    <strong>Success:</strong> <?php echo htmlspecialchars($_SESSION['success_message']); ?>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <!-- Login Form -->
            <form class="auth-form" method="POST" action="../includes/action-login.php">
                
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

                <!-- Remember & Forgot -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <div class="checkbox">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember" style="margin: 0;">Remember for 30 days</label>
                    </div>
                    <a href="#" style="color: #6366f1; font-weight: 500; font-size: 0.9rem;">Forgot password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-large">Sign In</button>

                <!-- Register Link -->
                <p class="auth-footer">
                    Don't have an account? <a href="register.php" style="color: #6366f1; font-weight: 600;">Create one here</a>
                </p>

            </form>

            <!-- Demo Info Box -->
            <div class="demo-info">
                <p style="font-weight: 600; color: #f1f5f9; margin-bottom: 0.75rem;">🔓 Demo Credentials</p>
                <p style="margin: 0.5rem 0; color: #cbd5e1;"><strong>Email:</strong> demo@example.com</p>
                <p style="margin: 0; color: #cbd5e1;"><strong>Password:</strong> password123</p>
            </div>

        </div>

        <!-- BENEFITS PANEL (Right) -->
        <div style="display: flex; flex-direction: column; justify-content: center;">
            <div style="background: linear-gradient(135deg, #6366f1 0%, #10b981 100%); color: white; padding: 3rem; border-radius: 16px;">
                
                <h3 style="color: white; margin-bottom: 2rem; font-size: 1.5rem;">Why Join EduLearn?</h3>

                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    
                    <!-- Benefit 1 -->
                    <div style="display: flex; gap: 1rem;">
                        <div style="font-size: 2rem; flex-shrink: 0;">🎓</div>
                        <div>
                            <h4 style="color: white; margin-bottom: 0.25rem;">Expert-Led Courses</h4>
                            <p style="color: rgba(255, 255, 255, 0.8); margin: 0; font-size: 0.9rem;">Learn from industry professionals with real-world experience</p>
                        </div>
                    </div>

                    <!-- Benefit 2 -->
                    <div style="display: flex; gap: 1rem;">
                        <div style="font-size: 2rem; flex-shrink: 0;">♾️</div>
                        <div>
                            <h4 style="color: white; margin-bottom: 0.25rem;">Lifetime Access</h4>
                            <p style="color: rgba(255, 255, 255, 0.8); margin: 0; font-size: 0.9rem;">Once enrolled, access course materials forever</p>
                        </div>
                    </div>

                    <!-- Benefit 3 -->
                    <div style="display: flex; gap: 1rem;">
                        <div style="font-size: 2rem; flex-shrink: 0;">🏆</div>
                        <div>
                            <h4 style="color: white; margin-bottom: 0.25rem;">Earn Certificates</h4>
                            <p style="color: rgba(255, 255, 255, 0.8); margin: 0; font-size: 0.9rem;">Get recognized certificates for your achievements</p>
                        </div>
                    </div>

                    <!-- Benefit 4 -->
                    <div style="display: flex; gap: 1rem;">
                        <div style="font-size: 2rem; flex-shrink: 0;">💬</div>
                        <div>
                            <h4 style="color: white; margin-bottom: 0.25rem;">Community Support</h4>
                            <p style="color: rgba(255, 255, 255, 0.8); margin: 0; font-size: 0.9rem;">Learn with thousands of students worldwide</p>
                        </div>
                    </div>

                </div>

                <!-- Stats -->
                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid rgba(255, 255, 255, 0.2); display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; text-align: center;">
                    <div>
                        <div style="font-size: 1.75rem; font-weight: 800;"><?php echo number_format($login_avg_rating > 0 ? $login_avg_rating : 4.8, 1); ?>⭐</div>
                        <p style="color: rgba(255, 255, 255, 0.8); margin: 0; font-size: 0.85rem;">Avg. Rating</p>
                    </div>
                    <div>
                        <div style="font-size: 1.75rem; font-weight: 800;"><?php echo number_format($login_total_students); ?></div>
                        <p style="color: rgba(255, 255, 255, 0.8); margin: 0; font-size: 0.85rem;">Happy Learners</p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<?php
include '../includes/footer.php';
?>
