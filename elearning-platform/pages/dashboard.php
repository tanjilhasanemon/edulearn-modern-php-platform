<?php
// Student Dashboard Page
// This is a simplified, student-only dashboard showing enrolled courses

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../includes/header.php';
include '../includes/database.php';

function get_course_thumbnail_path_dashboard($thumbnail, $category) {
    $image_root = dirname(__DIR__) . '/images/';
    $fallback_by_category = array(
        'Web Development' => 'course-web-design.png',
        'Database' => 'course-database.png',
        'JavaScript' => 'course-javascript.png',
        'Programming' => 'course-python.png'
    );

    if (!empty($thumbnail) && file_exists($image_root . $thumbnail)) {
        return '../images/' . $thumbnail;
    }

    $fallback = $fallback_by_category[$category] ?? 'course-web-design.png';
    if (!file_exists($image_root . $fallback)) {
        $fallback = 'about-platform.png';
    }

    return '../images/' . $fallback;
}

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Fetch user info
$user_query = "SELECT * FROM users WHERE id = " . $user_id;
$user_result = mysqli_query($connection, $user_query);
$user = mysqli_fetch_assoc($user_result);

// Fetch enrolled courses
$enrolled_query = "
    SELECT c.*, e.enrollment_date, e.completion_percentage, e.status as enrollment_status 
    FROM courses c 
    JOIN enrollments e ON c.id = e.course_id 
    WHERE e.student_id = " . $user_id . " 
    ORDER BY e.enrollment_date DESC
";
$enrolled_result = mysqli_query($connection, $enrolled_query);
$enrolled_courses = array();

if ($enrolled_result) {
    while ($row = mysqli_fetch_assoc($enrolled_result)) {
        $enrolled_courses[] = $row;
    }
}

// Calculate statistics
$total_enrolled = count($enrolled_courses);
$total_hours_spent = 0;
$completed_courses = 0;

foreach ($enrolled_courses as $course) {
    if ($course['enrollment_status'] === 'completed') {
        $completed_courses++;
    }
    $total_hours_spent += $course['duration_hours'] ?? 0;
}
?>

<!-- ============================================
     DASHBOARD HEADER
     ============================================ -->
<section class="page-header">
    <div class="container">
        <h1>My Learning Dashboard</h1>
        <p>Welcome back, <?php echo htmlspecialchars($user_name); ?>!</p>
    </div>
</section>

<!-- ============================================
     DASHBOARD STATS
     ============================================ -->
<section class="dashboard-stats">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <h3><?php echo $total_enrolled; ?></h3>
                <p>Courses Enrolled</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $completed_courses; ?></h3>
                <p>Courses Completed</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $total_hours_spent; ?></h3>
                <p>Total Hours</p>
            </div>
            <div class="stat-card">
                <h3>00:00</h3>
                <p>This Week</p>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     ENROLLED COURSES SECTION
     ============================================ -->
<section class="dashboard-courses">
    <div class="container">
        <div class="section-header">
            <h2>My Enrolled Courses</h2>
            <?php if ($total_enrolled === 0): ?>
                <p>You haven't enrolled in any courses yet.</p>
            <?php else: ?>
                <p><?php echo $total_enrolled; ?> course<?php echo $total_enrolled !== 1 ? 's' : ''; ?> in progress</p>
            <?php endif; ?>
        </div>

        <?php if (empty($enrolled_courses)): ?>
            <div class="no-courses">
                <h3>No Enrolled Courses</h3>
                <p>Start learning by enrolling in our available courses.</p>
                <a href="courses.php" class="btn btn-primary">Browse Courses</a>
            </div>
        <?php else: ?>
            <div class="enrolled-courses-grid">
                <?php foreach ($enrolled_courses as $course): ?>
                    <div class="enrolled-course-card">
                        <div class="course-card-header">
                            <h3><?php echo htmlspecialchars($course['title']); ?></h3>
                            <span class="course-level"><?php echo ucfirst($course['level']); ?></span>
                        </div>
                        <p class="course-category"><?php echo htmlspecialchars($course['category']); ?></p>
                        
                        <div class="progress-section">
                            <div class="progress-info">
                                <span>Progress</span>
                                <strong><?php echo $course['completion_percentage']; ?>%</strong>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?php echo $course['completion_percentage']; ?>%"></div>
                            </div>
                        </div>

                        <div class="course-stats">
                            <span><?php echo $course['lessons_count']; ?> lessons</span>
                            <span><?php echo $course['duration_hours']; ?> hours</span>
                            <span>Enrolled: <?php echo date('M d, Y', strtotime($course['enrollment_date'])); ?></span>
                        </div>

                        <div class="course-actions">
                            <a href="course-detail.php?id=<?php echo $course['id']; ?>" class="btn btn-primary">Continue Learning</a>
                            <?php if ($course['enrollment_status'] !== 'completed'): ?>
                                <a href="course-detail.php?id=<?php echo $course['id']; ?>" class="btn btn-secondary">View Lessons</a>
                            <?php else: ?>
                                <button class="btn btn-success" disabled>✓ Completed</button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ============================================
     RECOMMENDATIONS SECTION
     ============================================ -->
<section class="dashboard-recommendations">
    <div class="container">
        <div class="section-header">
            <h2>Recommended Courses</h2>
            <p>Courses you might be interested in</p>
        </div>

        <?php
        // Fetch recommended courses (courses not yet enrolled in)
        $recommended_query = "SELECT * FROM courses 
                             WHERE id NOT IN (SELECT course_id FROM enrollments WHERE student_id = " . $user_id . ") 
                             AND status = 'published' 
                             LIMIT 3";
        $recommended_result = mysqli_query($connection, $recommended_query);
        $recommended_courses = array();

        if ($recommended_result) {
            while ($row = mysqli_fetch_assoc($recommended_result)) {
                $recommended_courses[] = $row;
            }
        }
        ?>

        <?php if (empty($recommended_courses)): ?>
            <p>You're all set! Check back soon for more courses.</p>
        <?php else: ?>
            <div class="courses-grid">
                <?php foreach ($recommended_courses as $course): ?>
                    <div class="course-card">
                        <div class="course-image">
                            <img src="<?php echo htmlspecialchars(get_course_thumbnail_path_dashboard($course['thumbnail'] ?? '', $course['category'] ?? '')); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>">
                            <span class="course-badge"><?php echo ucfirst($course['level']); ?></span>
                        </div>
                        <div class="course-body">
                            <h3><?php echo htmlspecialchars($course['title']); ?></h3>
                            <p><?php echo htmlspecialchars(substr($course['description'], 0, 80)); ?>...</p>
                            <div class="course-meta">
                                <span class="category"><?php echo htmlspecialchars($course['category']); ?></span>
                                <span class="rating">★★★★★ <?php echo htmlspecialchars($course['rating']); ?></span>
                            </div>
                            <div class="course-footer">
                                <span class="price">$<?php echo number_format($course['price'], 2); ?></span>
                                <a href="course-detail.php?id=<?php echo $course['id']; ?>" class="btn btn-small">View Course</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div style="text-align: center; margin-top: 2rem;">
                <a href="courses.php" class="btn btn-primary">Browse All Courses</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
// Include footer
include '../includes/footer.php';
?>
