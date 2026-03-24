<?php
include 'includes/header.php';
include 'includes/database.php';

$featured_courses = array();
$featured_courses_query = "
    SELECT c.*, u.fullname AS instructor_name
    FROM courses c
    LEFT JOIN users u ON c.instructor_id = u.id
    WHERE c.status = 'published'
    ORDER BY c.students_count DESC
    LIMIT 9
";
$featured_courses_result = mysqli_query($connection, $featured_courses_query);
if ($featured_courses_result) {
    while ($row = mysqli_fetch_assoc($featured_courses_result)) {
        $featured_courses[] = $row;
    }
}

$total_courses = 0;
$total_students = 0;
$total_instructors = 0;
$average_rating = 0;

$res_courses = mysqli_query($connection, "SELECT COUNT(*) AS count FROM courses WHERE status='published'");
if ($res_courses) {
    $total_courses = (int) (mysqli_fetch_assoc($res_courses)['count'] ?? 0);
}

// Prefer aggregate enrolled learners from course stats for public homepage metrics.
$res_students = mysqli_query($connection, "SELECT COALESCE(SUM(students_count), 0) AS count FROM courses WHERE status='published'");
if ($res_students) {
    $total_students = (int) (mysqli_fetch_assoc($res_students)['count'] ?? 0);
}

// Fallback if course stats are empty.
if ($total_students <= 0) {
    $res_students_fallback = mysqli_query($connection, "SELECT COUNT(DISTINCT student_id) AS count FROM enrollments");
    if ($res_students_fallback) {
        $total_students = (int) (mysqli_fetch_assoc($res_students_fallback)['count'] ?? 0);
    }
}

$res_instructors = mysqli_query($connection, "SELECT COUNT(*) AS count FROM instructors");
if ($res_instructors) {
    $total_instructors = (int) (mysqli_fetch_assoc($res_instructors)['count'] ?? 0);
}

$res_avg_rating = mysqli_query($connection, "SELECT AVG(rating) AS avg_rating FROM courses WHERE status='published'");
if ($res_avg_rating) {
    $average_rating = (float) (mysqli_fetch_assoc($res_avg_rating)['avg_rating'] ?? 0);
}

function get_course_thumbnail_path_home($thumbnail, $category) {
    $image_root = __DIR__ . '/images/';
    $fallback_by_category = array(
        'Web Development' => 'course-web-design.png',
        'Database' => 'course-database.png',
        'JavaScript' => 'course-javascript.png',
        'Programming' => 'course-python.png'
    );

    if (!empty($thumbnail) && file_exists($image_root . $thumbnail)) {
        return 'images/' . $thumbnail;
    }

    $fallback = $fallback_by_category[$category] ?? 'course-web-design.png';
    if (!file_exists($image_root . $fallback)) {
        $fallback = 'about-platform.png';
    }

    return 'images/' . $fallback;
}

$home_instructors = array();
$home_instructors_query = "
    SELECT
        u.fullname AS name,
        u.profile_picture AS photo,
        i.title,
        i.experience_years,
        i.expertise,
        i.bio,
        COUNT(c.id) AS published_courses,
        COALESCE(SUM(c.students_count), 0) AS taught_students
    FROM instructors i
    INNER JOIN users u ON i.user_id = u.id
    LEFT JOIN courses c ON c.instructor_id = u.id AND c.status = 'published'
    GROUP BY i.id, u.id
    ORDER BY taught_students DESC, published_courses DESC, u.fullname ASC
    LIMIT 8
";
$home_instructors_result = mysqli_query($connection, $home_instructors_query);
if ($home_instructors_result) {
    while ($row = mysqli_fetch_assoc($home_instructors_result)) {
        $home_instructors[] = $row;
    }
}

$home_testimonials = array();
$home_testimonials_query = "
    SELECT
        COALESCE(NULLIF(t.display_name, ''), u.fullname) AS name,
        COALESCE(NULLIF(u.profile_picture, ''), 'student-avatar-1.png') AS avatar,
        c.title AS course,
        t.rating,
        t.comment AS review
    FROM testimonials t
    INNER JOIN users u ON t.student_id = u.id
    INNER JOIN courses c ON t.course_id = c.id
    WHERE t.status = 'approved'
    ORDER BY t.created_at DESC
    LIMIT 8
";
$home_testimonials_result = mysqli_query($connection, $home_testimonials_query);
if ($home_testimonials_result) {
    while ($row = mysqli_fetch_assoc($home_testimonials_result)) {
        $home_testimonials[] = $row;
    }
}

$hero_banner = 'images/hero-banner.png';
if (file_exists(__DIR__ . '/images/hero-banner-v2.png')) {
    $hero_banner = 'images/hero-banner-v2.png';
}
?>

<section class="hero">
    <div class="hero-content">
        <span class="hero-kicker">Future-ready learning platform</span>
        <h1 class="hero-title">Learn Practical Skills That Move Your Career Forward</h1>
        <p class="hero-subtitle">Join beginner-friendly courses taught by experienced instructors. Study at your own pace and build real skills with guided lessons.</p>
        <div class="hero-buttons">
            <a class="btn btn-primary" href="pages/courses.php">Explore Courses</a>
            <a class="btn btn-outline" href="pages/register.php">Create Free Account</a>
        </div>

        <div class="hero-highlight-card">
            <div class="hero-highlight-item">
                <strong><?php echo number_format($total_courses); ?></strong>
                <span>Structured courses</span>
            </div>
            <div class="hero-highlight-item">
                <strong><?php echo number_format($total_students); ?></strong>
                <span>Active learners</span>
            </div>
            <div class="hero-highlight-item">
                <strong><?php echo number_format($average_rating > 0 ? $average_rating : 4.8, 1); ?>/5</strong>
                <span>Average course rating</span>
            </div>
        </div>
    </div>
    <div class="hero-image">
        <img src="<?php echo htmlspecialchars($hero_banner); ?>" alt="Online learning platform hero">
    </div>
</section>

<section id="courses" class="dashboard-courses home-section">
    <div class="container">
        <div class="section-header">
            <h2>Featured Courses</h2>
            <p>Most popular courses chosen by our students</p>
        </div>

        <div class="course-grid">
            <?php foreach ($featured_courses as $course): ?>
                <article class="course-card">
                    <div class="course-card-image">
                        <img src="<?php echo htmlspecialchars(get_course_thumbnail_path_home($course['thumbnail'] ?? '', $course['category'] ?? '')); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>">
                    </div>

                    <div class="course-card-body">
                        <span class="course-category"><?php echo htmlspecialchars($course['category']); ?></span>
                        <h3 class="course-card-title"><?php echo htmlspecialchars($course['title']); ?></h3>
                        <p class="course-card-description"><?php echo htmlspecialchars(substr($course['description'], 0, 95)); ?>...</p>
                        <p class="course-card-instructor">By <?php echo htmlspecialchars($course['instructor_name'] ?? 'Instructor'); ?></p>

                        <div class="course-card-meta">
                            <span>⏱️ <?php echo (int) ($course['duration_hours'] ?? 20); ?> hrs</span>
                            <span>📚 <?php echo (int) ($course['lessons_count'] ?? 15); ?> lessons</span>
                            <span>👥 <?php echo number_format((int) ($course['students_count'] ?? 0)); ?></span>
                        </div>

                        <div class="course-card-footer">
                            <span class="course-rating">⭐ <?php echo number_format((float) ($course['rating'] ?? 4.8), 1); ?></span>
                            <span class="course-price">$<?php echo number_format((float) ($course['price'] ?? 49.99), 2); ?></span>
                        </div>

                        <a href="pages/course-detail.php?id=<?php echo (int) $course['id']; ?>" class="btn btn-primary btn-large">View Course</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="section-header" style="margin-top: 1rem; margin-bottom: 0;">
            <a href="pages/courses.php" class="btn btn-primary">Browse All Courses</a>
        </div>
    </div>
</section>

<section class="dashboard-stats home-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card"><h3><?php echo number_format($total_courses); ?></h3><p>Published Courses</p></div>
            <div class="stat-card"><h3><?php echo number_format($total_students); ?></h3><p>Active Learners</p></div>
            <div class="stat-card"><h3><?php echo number_format($total_instructors); ?></h3><p>Featured Mentors</p></div>
            <div class="stat-card"><h3><?php echo number_format($average_rating > 0 ? $average_rating : 4.8, 1); ?>/5</h3><p>Average Rating</p></div>
        </div>
    </div>
</section>

<section class="dashboard-recommendations home-section">
    <div class="container">
        <div class="section-header">
            <h2>Why Students Choose EduLearn</h2>
            <p>Simple learning flow, practical curriculum, and reliable support</p>
        </div>

        <div class="values-grid">
            <div class="value-card"><h3>🎯 Focused Lessons</h3><p>Clear explanations and practical examples for every chapter.</p></div>
            <div class="value-card"><h3>📱 Learn Anywhere</h3><p>Continue from desktop or mobile whenever it suits your routine.</p></div>
            <div class="value-card"><h3>🏆 Real Progress</h3><p>Track completion, stay motivated, and build job-ready confidence.</p></div>
            <div class="value-card"><h3>💬 Friendly Support</h3><p>Get help quickly when you are stuck or need guidance.</p></div>
        </div>

        <div class="section-header" style="margin-top: 1.5rem; margin-bottom: 0;">
            <a class="btn btn-primary" href="pages/register.php">Get Started Now</a>
        </div>
    </div>
</section>

<section class="home-section">
    <div class="container">
        <div class="section-header">
            <h2>Meet Our Instructors</h2>
            <p>Experienced mentors who combine academic clarity with real industry practice</p>
        </div>

        <div class="instructors-grid">
            <?php foreach ($home_instructors as $instructor): ?>
                <article class="instructor-profile-card">
                    <img class="instructor-profile-photo" src="images/<?php echo htmlspecialchars(!empty($instructor['photo']) ? $instructor['photo'] : 'instructor-sarah.png'); ?>" alt="<?php echo htmlspecialchars($instructor['name']); ?>">
                    <h3 class="course-card-title"><?php echo htmlspecialchars($instructor['name']); ?></h3>
                    <p class="instructor-profile-role"><?php echo htmlspecialchars($instructor['title'] ?? 'Instructor'); ?></p>
                    <p class="course-card-description"><?php echo htmlspecialchars(substr((string) ($instructor['bio'] ?? 'Focused on practical learning paths that help students move from beginner to confident practitioner.'), 0, 115)); ?>...</p>
                    <div class="instructor-profile-meta">
                        <span><?php echo (int) ($instructor['experience_years'] ?? 0); ?>+ years teaching</span>
                        <span><?php echo htmlspecialchars(substr((string) ($instructor['expertise'] ?? 'Industry mentorship and guided projects'), 0, 55)); ?></span>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="home-section">
    <div class="container">
        <div class="section-header">
            <h2>Student Reviews</h2>
            <p>Real feedback from learners who completed courses on EduLearn</p>
        </div>

        <div class="testimonials-grid">
            <?php foreach ($home_testimonials as $item): ?>
                <article class="testimonial-card">
                    <div class="testimonial-header">
                        <img class="testimonial-avatar" src="images/<?php echo htmlspecialchars($item['avatar']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div>
                            <h4 style="margin-bottom: 0.1rem;"><?php echo htmlspecialchars($item['name']); ?></h4>
                            <p style="margin: 0; font-size: 0.86rem;"><?php echo htmlspecialchars($item['course']); ?></p>
                        </div>
                    </div>
                    <p class="testimonial-rating">Rating: <?php echo number_format((float) ($item['rating'] ?? 0), 1); ?>/5</p>
                    <p class="testimonial-text"><?php echo htmlspecialchars($item['review']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="cta-band">
            <div>
                <h3 style="margin-bottom: 0.25rem;">Ready to become job-ready?</h3>
                <p style="margin-bottom: 0;">Start with a beginner-friendly course and build momentum each week.</p>
            </div>
            <a class="btn btn-primary" href="pages/register.php">Create Your Learning Account</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
