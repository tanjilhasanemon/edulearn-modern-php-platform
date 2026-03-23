<?php
// Modern Courses Page
// Display all courses with beautiful card design

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../includes/header.php';
include '../includes/database.php';

function get_course_thumbnail_path_page($thumbnail, $category) {
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

// Get selected category from URL parameter
$selected_category = isset($_GET['category']) ? stripslashes(htmlspecialchars($_GET['category'])) : '';

// Check if user is logged in
$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Fetch all categories from database
$categories_query = "SELECT DISTINCT category FROM courses WHERE status = 'published' ORDER BY category";
$categories_result = mysqli_query($connection, $categories_query);
$categories = array();

if ($categories_result) {
    while ($row = mysqli_fetch_assoc($categories_result)) {
        $categories[] = $row['category'];
    }
}

// Prepare courses query based on selected category
if (!empty($selected_category)) {
    $courses_query = "
        SELECT c.*, u.fullname as instructor_name 
        FROM courses c 
        LEFT JOIN users u ON c.instructor_id = u.id 
        WHERE c.category = '" . mysqli_real_escape_string($connection, $selected_category) . "' 
        AND c.status = 'published' 
        ORDER BY c.students_count DESC
    ";
    $page_title = ucfirst($selected_category) . " Courses";
} else {
    $courses_query = "
        SELECT c.*, u.fullname as instructor_name 
        FROM courses c 
        LEFT JOIN users u ON c.instructor_id = u.id 
        WHERE c.status = 'published' 
        ORDER BY c.students_count DESC
    ";
    $page_title = "All Courses";
}

$courses_result = mysqli_query($connection, $courses_query);
$courses = array();

if ($courses_result) {
    while ($row = mysqli_fetch_assoc($courses_result)) {
        $courses[] = $row;
    }
}

// Get user's enrollments if logged in
$enrolled_courses = array();
if ($is_logged_in && $user_id) {
    $enrollments_query = "SELECT course_id FROM enrollments WHERE student_id = " . $user_id;
    $enrollments_result = mysqli_query($connection, $enrollments_query);
    
    if ($enrollments_result) {
        while ($row = mysqli_fetch_assoc($enrollments_result)) {
            $enrolled_courses[] = $row['course_id'];
        }
    }
}
?>

<!-- PAGE HEADER -->
<section class="page-header">
    <div class="container">
        <h1><?php echo $page_title; ?></h1>
        <p><?php echo count($courses); ?> remarkable course<?php echo count($courses) !== 1 ? 's' : ''; ?> to explore and master</p>
    </div>
</section>

<!-- FILTERS SECTION -->
<section class="filters-section">
    <div class="container">
        <div class="filters-wrap">
            <span class="filters-label">Filter by Category:</span>
            
            <a href="courses.php" class="btn filter-chip <?php echo empty($selected_category) ? 'btn-primary' : 'btn-outline'; ?>">
                All Courses
            </a>
            
            <?php foreach ($categories as $category): ?>
                <a href="?category=<?php echo urlencode($category); ?>" 
                   class="btn filter-chip <?php echo ($selected_category === $category) ? 'btn-primary' : 'btn-outline'; ?>">
                    <?php echo htmlspecialchars($category); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- COURSES GRID -->
<section class="courses-section">
    <div class="container">
        <?php if (empty($courses)): ?>
            <div class="empty-state">
                <p>No courses found in this category. Please try another!</p>
            </div>
        <?php else: ?>
            <div class="course-grid">
                <?php foreach ($courses as $course): ?>
                    <div class="course-card">
                        <!-- Course Image -->
                        <div class="course-card-image">
                            <img src="<?php echo htmlspecialchars(get_course_thumbnail_path_page($course['thumbnail'] ?? '', $course['category'] ?? '')); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>">
                        </div>

                        <!-- Course Body -->
                        <div class="course-card-body">
                            <!-- Category Badge -->
                            <div class="course-category">
                                <?php echo htmlspecialchars($course['category']); ?>
                            </div>

                            <!-- Title -->
                            <h3 class="course-card-title">
                                <?php echo htmlspecialchars($course['title']); ?>
                            </h3>

                            <!-- Description -->
                            <p class="course-card-description">
                                <?php echo htmlspecialchars(substr($course['description'], 0, 80)) . '...'; ?>
                            </p>

                            <!-- Instructor -->
                            <p class="course-card-instructor">
                                By: <?php echo htmlspecialchars($course['instructor_name']); ?>
                            </p>

                            <!-- Stats -->
                            <div class="course-card-meta">
                                <span>⏱️ <?php echo $course['duration_hours'] ?? 20; ?> hrs</span>
                                <span>📚 <?php echo $course['lessons_count'] ?? 15; ?> lessons</span>
                                <span>👥 <?php echo number_format($course['students_count']); ?></span>
                            </div>

                            <!-- Rating & Price -->
                            <div class="course-card-footer">
                                <div class="course-rating">
                                    ⭐ <?php echo $course['rating'] ?? 4.8; ?>
                                </div>
                                <div class="course-price">
                                    $<?php echo number_format($course['price'] ?? 49.99, 2); ?>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <a href="course-detail.php?id=<?php echo $course['id']; ?>" class="btn btn-primary btn-large">View Details</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
// Include footer
include '../includes/footer.php';
?>
