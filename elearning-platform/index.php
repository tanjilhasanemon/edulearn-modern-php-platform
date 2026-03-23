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

$res_instructors = mysqli_query($connection, "SELECT COUNT(DISTINCT instructor_id) AS count FROM courses");
if ($res_instructors) {
    $total_instructors = (int) (mysqli_fetch_assoc($res_instructors)['count'] ?? 0);
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

$home_instructors = array(
    array(
        'name' => 'Sarah Anderson',
        'role' => 'Senior UI and Web Design Mentor',
        'photo' => 'instructor-sarah.png',
        'experience' => '10+ years teaching',
        'specialization' => 'Responsive design and accessibility'
    ),
    array(
        'name' => 'Michael Chen',
        'role' => 'Database Architecture Instructor',
        'photo' => 'instructor-michael.png',
        'experience' => '12 years in enterprise systems',
        'specialization' => 'SQL optimization and data modeling'
    ),
    array(
        'name' => 'Emily Rodriguez',
        'role' => 'Full Stack JavaScript Coach',
        'photo' => 'instructor-emily.png',
        'experience' => '8 years building products',
        'specialization' => 'React, Node.js, and frontend engineering'
    ),
    array(
        'name' => 'David Williams',
        'role' => 'Backend Development Expert',
        'photo' => 'instructor-david.png',
        'experience' => '9 years in PHP and APIs',
        'specialization' => 'Laravel, API architecture, and MySQL'
    ),
    array(
        'name' => 'Olivia Bennett',
        'role' => 'Product Design and UX Instructor',
        'photo' => 'instructor-olivia.png',
        'experience' => '11 years in product teams',
        'specialization' => 'Design thinking, UX writing, and wireframing'
    ),
    array(
        'name' => 'Daniel Novak',
        'role' => 'Cloud and DevOps Mentor',
        'photo' => 'instructor-daniel.png',
        'experience' => '10 years in cloud infrastructure',
        'specialization' => 'CI/CD, Docker, and AWS deployment workflows'
    ),
    array(
        'name' => 'Sophia Klein',
        'role' => 'Frontend Performance Specialist',
        'photo' => 'instructor-sophia.png',
        'experience' => '7 years optimizing web apps',
        'specialization' => 'Performance tuning, accessibility, and Core Web Vitals'
    ),
    array(
        'name' => 'James Carter',
        'role' => 'Backend API Architecture Mentor',
        'photo' => 'instructor-james.png',
        'experience' => '13 years in enterprise backend systems',
        'specialization' => 'REST API design, authentication, and scalable services'
    )
);

// Keep displayed instructor metric consistent with showcased homepage mentors.
$total_instructors = max($total_instructors, count($home_instructors));

$home_testimonials = array(
    array(
        'name' => 'Emma Wilson',
        'avatar' => 'student-avatar-1.png',
        'course' => 'React.js Fundamentals',
        'rating' => '4.9',
        'review' => 'The lessons are clean, beginner friendly, and practical. I built my first portfolio project in 3 weeks.'
    ),
    array(
        'name' => 'Liam Thompson',
        'avatar' => 'student-avatar-2.png',
        'course' => 'MySQL Database Design',
        'rating' => '4.8',
        'review' => 'Great structure and quality explanations. The database projects helped me perform better in my internship.'
    ),
    array(
        'name' => 'Isabella Martinez',
        'avatar' => 'student-avatar-3.png',
        'course' => 'Modern Web Design Fundamentals',
        'rating' => '5.0',
        'review' => 'Everything looks professional and easy to follow. The feedback style made learning much less stressful.'
    ),
    array(
        'name' => 'Noah Anderson',
        'avatar' => 'student-avatar-4.png',
        'course' => 'PHP for Dynamic Websites',
        'rating' => '4.9',
        'review' => 'I liked the mix of theory and practice. The course flow feels premium and helped me finish real projects faster.'
    ),
    array(
        'name' => 'Ava Richardson',
        'avatar' => 'student-avatar-5.png',
        'course' => 'Responsive Web Design Mastery',
        'rating' => '4.8',
        'review' => 'The structure is very clear and every module feels purpose-driven. I improved my UI work quality significantly.'
    ),
    array(
        'name' => 'Lucas Rivera',
        'avatar' => 'student-avatar-6.png',
        'course' => 'Advanced CSS Techniques',
        'rating' => '4.9',
        'review' => 'Loved the practical assignments and design feedback style. The class helped me land freelance clients quickly.'
    ),
    array(
        'name' => 'Mia Roberts',
        'avatar' => 'student-avatar-7.png',
        'course' => 'Full Stack Web Development',
        'rating' => '5.0',
        'review' => 'Excellent roadmap from basics to advanced concepts. I finally understood how frontend and backend connect in real projects.'
    ),
    array(
        'name' => 'Ethan Cooper',
        'avatar' => 'student-avatar-8.png',
        'course' => 'SQL Mastery Bootcamp',
        'rating' => '4.8',
        'review' => 'The SQL practice tasks were realistic and interview-focused. I now write better queries with confidence.'
    )
);

$hero_banner = 'images/hero-banner.png';
if (file_exists(__DIR__ . '/images/hero-banner-v2.png')) {
    $hero_banner = 'images/hero-banner-v2.png';
} elseif (file_exists(__DIR__ . '/images/hero-banner-v2.jpg')) {
    $hero_banner = 'images/hero-banner-v2.jpg';
} elseif (file_exists(__DIR__ . '/images/hero-banner-v2.webp')) {
    $hero_banner = 'images/hero-banner-v2.webp';
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
                <strong>4.8/5</strong>
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
            <div class="stat-card"><h3>4.8/5</h3><p>Average Rating</p></div>
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
                    <img class="instructor-profile-photo" src="images/<?php echo htmlspecialchars($instructor['photo']); ?>" alt="<?php echo htmlspecialchars($instructor['name']); ?>">
                    <h3 class="course-card-title"><?php echo htmlspecialchars($instructor['name']); ?></h3>
                    <p class="instructor-profile-role"><?php echo htmlspecialchars($instructor['role']); ?></p>
                    <p class="course-card-description">Focused on practical learning paths that help students move from beginner to confident practitioner.</p>
                    <div class="instructor-profile-meta">
                        <span><?php echo htmlspecialchars($instructor['experience']); ?></span>
                        <span><?php echo htmlspecialchars($instructor['specialization']); ?></span>
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
                    <p class="testimonial-rating">Rating: <?php echo htmlspecialchars($item['rating']); ?>/5</p>
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
