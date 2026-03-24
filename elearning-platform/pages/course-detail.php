<?php
// Modern Course Detail Page
// Enhanced design with better instructor info and learning outcomes

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../includes/header.php';
include '../includes/database.php';

function get_course_thumbnail_path_detail($thumbnail, $category) {
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

// Get course ID from URL
$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Check if user is logged in
$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Fetch course details with instructor and instructor info
$course_query = "
    SELECT c.*, u.fullname as instructor_name, u.email as instructor_email, 
           u.bio as instructor_bio, u.profile_picture as instructor_picture,
           i.title as instructor_title, i.expertise, i.experience_years, i.rating as instructor_rating,
           i.courses_created, i.students_taught
    FROM courses c 
    LEFT JOIN users u ON c.instructor_id = u.id 
    LEFT JOIN instructors i ON u.id = i.user_id
    WHERE c.id = " . $course_id;
$course_result = mysqli_query($connection, $course_query);

// Check if course exists
if (!$course_result || mysqli_num_rows($course_result) === 0) {
    header("Location: courses.php");
    exit();
}

$course = mysqli_fetch_assoc($course_result);
$instructor_photo = 'instructor-sarah.png';
if (!empty($course['instructor_picture'])) {
    $candidate_path = dirname(__DIR__) . '/images/' . $course['instructor_picture'];
    if (file_exists($candidate_path)) {
        $instructor_photo = $course['instructor_picture'];
    }
}

$instructor_title = !empty($course['instructor_title'])
    ? $course['instructor_title']
    : (!empty($course['experience_years']) ? ((int) $course['experience_years'] . '+ years teaching experience') : 'Expert Instructor');

$instructor_bio = !empty($course['instructor_bio'])
    ? $course['instructor_bio']
    : 'Dedicated instructor focused on practical learning and measurable student progress.';

$instructor_specialization = !empty($course['expertise'])
    ? $course['expertise']
    : 'Software development and mentoring';

// Check if user is already enrolled
$is_enrolled = false;
if ($is_logged_in && $user_id) {
    $enrollment_query = "SELECT id FROM enrollments WHERE student_id = " . $user_id . " AND course_id = " . $course_id;
    $enrollment_result = mysqli_query($connection, $enrollment_query);
    $is_enrolled = mysqli_num_rows($enrollment_result) > 0;
}

// Fetch course lessons
$lessons_query = "SELECT * FROM lessons WHERE course_id = " . $course_id . " AND status = 'published' ORDER BY lesson_number";
$lessons_result = mysqli_query($connection, $lessons_query);
$lessons = array();

if ($lessons_result) {
    while ($row = mysqli_fetch_assoc($lessons_result)) {
        $lessons[] = $row;
    }
}

// Define learning outcomes (in real app, would come from database)
$learning_outcomes = array(
    "Master core concepts and fundamentals",
    "Build real-world projects and applications",
    "Understand industry best practices",
    "Get certified upon course completion",
    "Access lifetime course materials",
    "Join our community of successful students"
);
?>

<!-- PAGE HEADER -->
<section class="page-header">
    <div class="container">
        <h1><?php echo htmlspecialchars($course['title']); ?></h1>
        <p><?php echo htmlspecialchars($course['description']); ?></p>
    </div>
</section>

<!-- MAIN COURSE CONTENT -->
<section class="course-detail">
    <div class="container">
        
        <!-- COURSE INFO AND ENROLLMENT -->
        <div class="course-detail-grid">
            
            <!-- LEFT: Course Description & Content -->
            <div class="course-detail-content">
                
                <!-- Course Meta Information -->
                <div class="course-info-bar">
                    <div class="course-info-item">
                        <span>📊</span>
                        <strong><?php echo $course['level'] ? ucfirst($course['level']) : 'Beginner'; ?></strong> Level
                    </div>
                    <div class="course-info-item">
                        <span>⏱️</span>
                        <strong><?php echo $course['duration_hours'] ?? 20; ?></strong> Hours
                    </div>
                    <div class="course-info-item">
                        <span>📚</span>
                        <strong><?php echo $course['lessons_count'] ?? 15; ?></strong> Lessons
                    </div>
                    <div class="course-info-item">
                        <span>⭐</span>
                        <strong><?php echo $course['rating'] ?? 4.8; ?></strong> Rating
                    </div>
                    <div class="course-info-item">
                        <span>👥</span>
                        <strong><?php echo number_format($course['students_count'] ?? 0); ?></strong> Students
                    </div>
                </div>

                <!-- LEARNING OUTCOMES -->
                <div class="learning-outcomes">
                    <h3>What You'll Learn</h3>
                    <ul class="outcomes-list">
                        <?php foreach ($learning_outcomes as $outcome): ?>
                            <li><?php echo htmlspecialchars($outcome); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- COURSE DESCRIPTION -->
                <div>
                    <h3>About This Course</h3>
                    <p><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>
                    <p>This comprehensive course is designed to take you from beginner to advanced level in the subject matter. You'll learn through a combination of video lectures, hands-on projects, and real-world examples. Our experienced instructors bring years of industry experience to ensure you're learning the most relevant and up-to-date content.</p>
                </div>

                <!-- COURSE CURRICULUM -->
                <?php if (!empty($lessons)): ?>
                    <div class="mt-3xl">
                        <h3>Course Curriculum</h3>
                        <div class="curriculum-list">
                            <?php foreach ($lessons as $lesson): ?>
                                <div class="curriculum-item">
                                    <div class="curriculum-header">
                                        <h4>Lesson <?php echo $lesson['lesson_number']; ?>: <?php echo htmlspecialchars($lesson['title']); ?></h4>
                                        <span class="curriculum-duration">⏱️ <?php echo $lesson['duration_minutes'] ?? 30; ?> min</span>
                                    </div>
                                    <?php if ($lesson['description']): ?>
                                        <p class="curriculum-description"><?php echo htmlspecialchars(substr($lesson['description'], 0, 100)); ?>...</p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <!-- RIGHT: SIDEBAR - Enrollment & Course Info -->
            <div>
                <div class="course-sidebar">
                    <!-- Course Thumbnail -->
                    <div class="course-thumbnail">
                        <img class="course-sidebar-thumbnail" src="<?php echo htmlspecialchars(get_course_thumbnail_path_detail($course['thumbnail'] ?? '', $course['category'] ?? '')); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>">
                    </div>

                    <!-- Price -->
                    <div class="course-price-block">
                        <p class="course-price-label">Course Price</p>
                        <h2 class="course-price-value">$<?php echo number_format($course['price'] ?? 49.99, 2); ?></h2>
                    </div>

                    <!-- Enrollment Button -->
                    <div style="margin-bottom: 1.2rem;">
                        <?php if ($is_logged_in): ?>
                            <?php if ($is_enrolled): ?>
                                <button class="btn btn-success btn-large" disabled style="cursor: default; opacity: 0.8;">✓ Already Enrolled</button>
                            <?php else: ?>
                                <form method="POST" action="../includes/action-enroll.php" style="width: 100%;">
                                    <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                    <button type="submit" class="btn btn-primary btn-large">Enroll Now</button>
                                </form>
                            <?php endif; ?>
                        <?php else: ?>
                            <button class="btn btn-primary btn-large" onclick="window.location.href='login.php'">Login to Enroll</button>
                        <?php endif; ?>
                    </div>

                    <!-- Course Features -->
                    <div class="course-features" style="margin-bottom: 1.2rem;">
                        <h4>This course includes:</h4>
                        <ul class="feature-list">
                            <li><span>🎥</span> <span>Full HD Videos</span></li>
                            <li><span>📚</span> <span>Downloadable Resources</span></li>
                            <li><span>♾️</span> <span>Lifetime Access</span></li>
                            <li><span>📜</span> <span>Certificate of Completion</span></li>
                            <li><span>💬</span> <span>24/7 Support</span></li>
                            <li><span>📱</span> <span>Mobile Friendly</span></li>
                        </ul>
                    </div>

                    <!-- Category -->
                    <div class="course-category-box" style="text-align: center;">
                        <p style="color: #94a3b8; margin-bottom: 0.5rem; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">Category</p>
                        <p style="font-weight: 600; color: #f1f5f9; margin: 0;"><?php echo htmlspecialchars($course['category']); ?></p>
                    </div>

                </div>

            </div>

        </div>

        <!-- INSTRUCTOR PROFILE SECTION -->
        <div class="mt-3xl">
            <h2 style="margin-bottom: 2rem;">Meet Your Instructor</h2>
            <div class="instructor-card">
                <div class="instructor-profile-grid">
                    <div>
                        <img class="instructor-photo" src="<?php echo $path_prefix; ?>images/<?php echo htmlspecialchars($instructor_photo); ?>" alt="<?php echo htmlspecialchars($course['instructor_name'] ?? 'Instructor'); ?>">
                    </div>
                    <div class="instructor-info">
                        <h3><?php echo htmlspecialchars($course['instructor_name'] ?? 'Expert Instructor'); ?></h3>
                        <p class="instructor-title">
                            <?php echo htmlspecialchars($instructor_title); ?>
                        </p>
                        <p class="instructor-bio">
                            <?php echo htmlspecialchars($instructor_bio); ?>
                        </p>

                        <div class="instructor-facts">
                            <div><strong>Profile:</strong> <?php echo htmlspecialchars($course['instructor_email'] ?? 'Not available'); ?></div>
                            <div><strong>Teaching Experience:</strong> <?php echo (int) ($course['experience_years'] ?? 0); ?>+ years</div>
                            <div><strong>Courses Created:</strong> <?php echo (int) ($course['courses_created'] ?? 0); ?></div>
                            <div><strong>Specialization:</strong> <?php echo htmlspecialchars($instructor_specialization); ?></div>
                        </div>
                    </div>
                </div>

                <!-- Instructor Stats -->
                <div class="instructor-stats">
                    <div class="stat">
                        <span class="stat-value"><?php echo $course['courses_created'] ?? 1; ?></span>
                        <span class="stat-label">Courses Created</span>
                    </div>
                    <div class="stat">
                        <span class="stat-value"><?php echo number_format($course['students_taught'] ?? 0); ?></span>
                        <span class="stat-label">Students Taught</span>
                    </div>
                    <div class="stat">
                        <span class="stat-value">⭐ <?php echo $course['instructor_rating'] ?? 4.9; ?></span>
                        <span class="stat-label">Instructor Rating</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<?php
// Include footer
include '../includes/footer.php';
?>
