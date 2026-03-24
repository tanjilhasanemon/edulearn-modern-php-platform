-- ============================================
-- E-LEARNING PLATFORM - STUDENT-FOCUSED DATABASE SCHEMA
-- ============================================
-- Simplified schema optimized for student experience
-- No instructor login complexity
--
-- SETUP INSTRUCTIONS:
-- 1. Open phpMyAdmin (http://localhost/phpmyadmin)
-- 2. Create new database named 'elearning_db'
-- 3. Select the database, go to SQL tab
-- 4. Copy and paste this entire file
-- 5. Click "Go" to execute
-- 6. Done! Database is ready

-- ============================================
-- CREATE DATABASE
-- ============================================
CREATE DATABASE IF NOT EXISTS elearning_db;
USE elearning_db;

-- ============================================
-- USERS TABLE (Students Only)
-- ============================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255),
    bio TEXT,
    role ENUM('student', 'instructor') DEFAULT 'student',
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (email),
    INDEX (role)
);

-- ============================================
-- CATEGORIES TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    icon VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- INSTRUCTORS TABLE (Read-Only Info)
-- ============================================
CREATE TABLE IF NOT EXISTS instructors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    title VARCHAR(100),
    expertise TEXT,
    experience_years INT DEFAULT 5,
    courses_created INT DEFAULT 0,
    students_taught INT DEFAULT 0,
    rating DECIMAL(3, 1) DEFAULT 0.0,
    bio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX (user_id)
);

-- ============================================
-- COURSES TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(100) NOT NULL,
    instructor_id INT NOT NULL,
    thumbnail VARCHAR(255),
    level ENUM('beginner', 'intermediate', 'advanced') DEFAULT 'beginner',
    price DECIMAL(10, 2) DEFAULT 49.99,
    rating DECIMAL(3, 1) DEFAULT 4.8,
    students_count INT DEFAULT 0,
    duration_hours INT DEFAULT 20,
    lessons_count INT DEFAULT 15,
    status ENUM('published', 'draft', 'archived') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (instructor_id) REFERENCES users(id),
    INDEX (category),
    INDEX (instructor_id),
    INDEX (status)
);

-- ============================================
-- LESSONS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS lessons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    video_url VARCHAR(255),
    content TEXT,
    duration_minutes INT DEFAULT 30,
    lesson_number INT,
    status ENUM('published', 'draft') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id),
    INDEX (course_id)
);

-- ============================================
-- ENROLLMENTS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completion_percentage INT DEFAULT 0,
    status ENUM('active', 'completed', 'dropped') DEFAULT 'active',
    certificate_earned BOOLEAN DEFAULT FALSE,
    last_access DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id),
    FOREIGN KEY (course_id) REFERENCES courses(id),
    UNIQUE KEY unique_enrollment (student_id, course_id),
    INDEX (student_id),
    INDEX (course_id),
    INDEX (status)
);

-- ============================================
-- PROGRESS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    enrollment_id INT NOT NULL,
    lesson_id INT NOT NULL,
    completed BOOLEAN DEFAULT FALSE,
    completion_date DATETIME,
    time_spent_minutes INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (enrollment_id) REFERENCES enrollments(id),
    FOREIGN KEY (lesson_id) REFERENCES lessons(id),
    UNIQUE KEY unique_progress (enrollment_id, lesson_id),
    INDEX (enrollment_id)
);

-- ============================================
-- TESTIMONIALS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    rating INT NOT NULL,
    comment TEXT,
    display_name VARCHAR(100),
    status ENUM('approved', 'pending', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id),
    FOREIGN KEY (course_id) REFERENCES courses(id),
    INDEX (course_id),
    INDEX (status)
);

-- ============================================
-- CONTACT MESSAGES TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'responded') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (email),
    INDEX (status)
);

-- ============================================
-- SAMPLE DATA - INSTRUCTORS (User Account)
-- ============================================
INSERT INTO users (fullname, email, password, role, profile_picture, bio) VALUES
('Sarah Anderson', 'sarah@example.com', 'password123', 'instructor', 'instructor-sarah.png', 'Passionate web designer with 10+ years in the industry'),
('Michael Chen', 'michael@example.com', 'password123', 'instructor', 'instructor-michael.png', 'Database expert and software architect'),
('Emily Rodriguez', 'emily@example.com', 'password123', 'instructor', 'instructor-emily.png', 'Full-stack developer passionate about JavaScript'),
('David Williams', 'david@example.com', 'password123', 'instructor', 'instructor-david.png', 'Backend specialist with expertise in PHP and MySQL'),
('Olivia Bennett', 'olivia@example.com', 'password123', 'instructor', 'instructor-olivia.png', 'Product design mentor focused on UX and research-led learning'),
('Daniel Novak', 'daniel@example.com', 'password123', 'instructor', 'instructor-daniel.png', 'Cloud and DevOps coach helping beginners deploy confidently'),
('Sophia Klein', 'sophia@example.com', 'password123', 'instructor', 'instructor-sophia.png', 'Frontend performance specialist focused on accessibility and speed'),
('James Carter', 'james@example.com', 'password123', 'instructor', 'instructor-james.png', 'Backend API architect teaching scalable systems to new developers');

-- ============================================
-- SAMPLE DATA - INSTRUCTOR PROFILES
-- ============================================
INSERT INTO instructors (user_id, title, expertise, experience_years, courses_created, students_taught, rating, bio) VALUES
(1, 'Senior Web Designer', 'UI/UX Design, Modern CSS, Responsive Design', 10, 3, 2500, 4.9, 'Sarah has helped over 2,500 students master web design.'),
(2, 'Database Architect', 'MySQL, Database Design, SQL Optimization', 12, 2, 1800, 4.8, 'Michael brings years of enterprise database experience.'),
(3, 'Full Stack Developer', 'JavaScript, React, Node.js, Web Development', 8, 4, 3200, 4.9, 'Emily is passionate about teaching JavaScript.'),
(4, 'Backend Specialist', 'PHP, MySQL, Server Architecture, API Design', 9, 3, 2100, 4.7, 'David specializes in building robust backend systems.'),
(5, 'Product Design Mentor', 'UX Research, Wireframing, Prototyping, UI Systems', 11, 2, 1600, 4.8, 'Olivia helps learners connect design thinking with practical product delivery.'),
(6, 'Cloud and DevOps Mentor', 'Cloud Basics, Docker, CI/CD, Deployment Workflows', 10, 2, 1900, 4.8, 'Daniel guides students through deployment and production-ready workflows.'),
(7, 'Frontend Performance Specialist', 'Core Web Vitals, Accessibility, CSS Architecture', 7, 1, 1200, 4.7, 'Sophia teaches optimization techniques that improve UX and maintainability.'),
(8, 'API Architecture Mentor', 'REST API Design, Auth, System Integration, Security', 13, 1, 1700, 4.9, 'James focuses on clear backend architecture and secure integration patterns.');

-- ============================================
-- SAMPLE DATA - STUDENTS
-- ============================================
INSERT INTO users (fullname, email, password, role, profile_picture) VALUES
('Demo Student', 'demo@example.com', 'password123', 'student', 'student-avatar-1.png'),
('Emma Wilson', 'emma@example.com', 'password123', 'student', 'student-avatar-1.png'),
('Liam Thompson', 'liam@example.com', 'password123', 'student', 'student-avatar-2.png'),
('Isabella Martinez', 'isabella@example.com', 'password123', 'student', 'student-avatar-3.png'),
('Noah Anderson', 'noah@example.com', 'password123', 'student', 'student-avatar-4.png'),
('Ava Richardson', 'ava@example.com', 'password123', 'student', 'student-avatar-5.png'),
('Lucas Rivera', 'lucas@example.com', 'password123', 'student', 'student-avatar-6.png'),
('Mia Roberts', 'mia@example.com', 'password123', 'student', 'student-avatar-7.png'),
('Ethan Cooper', 'ethan@example.com', 'password123', 'student', 'student-avatar-8.png');

-- ============================================
-- SAMPLE DATA - COURSES
-- ============================================
INSERT INTO courses (title, description, category, instructor_id, thumbnail, level, price, rating, duration_hours, lessons_count, status, students_count) VALUES
('Modern Web Design Fundamentals', 'Learn to create beautiful, responsive websites from scratch.', 'Web Development', 1, 'course-web-design.png', 'beginner', 49.99, 4.9, 20, 15, 'published', 1250),
('Responsive Web Design Mastery', 'Create mobile-first, responsive websites that work on all devices.', 'Web Development', 5, 'course-responsive.png', 'intermediate', 59.99, 4.8, 18, 14, 'published', 980),
('Advanced CSS Techniques', 'Take your CSS skills to the next level with animations and grid.', 'Web Development', 7, 'course-advanced-css.png', 'intermediate', 54.99, 4.7, 16, 12, 'published', 650),
('MySQL Database Design', 'Master database design and learn SQL from fundamentals.', 'Database', 2, 'course-database.png', 'intermediate', 59.99, 4.8, 25, 18, 'published', 850),
('SQL Mastery Bootcamp', 'Learn advanced SQL for complex queries and optimization.', 'Database', 2, 'course-sql.png', 'intermediate', 69.99, 4.9, 28, 20, 'published', 420),
('JavaScript for Beginners', 'Start your JavaScript journey with fundamentals and DOM.', 'JavaScript', 3, 'course-javascript.png', 'beginner', 49.99, 4.9, 22, 16, 'published', 2100),
('React.js Fundamentals', 'Build modern web applications with React and hooks.', 'JavaScript', 3, 'course-react.png', 'intermediate', 64.99, 4.8, 26, 19, 'published', 950),
('JavaScript Advanced Patterns', 'Master advanced JavaScript with closures and design patterns.', 'JavaScript', 8, 'course-js-advanced.png', 'advanced', 79.99, 4.7, 30, 22, 'published', 580),
('PHP for Dynamic Websites', 'Build dynamic web applications with PHP and databases.', 'Programming', 4, 'course-php.png', 'beginner', 49.99, 4.7, 24, 17, 'published', 750),
('Full Stack Web Development', 'Become a complete web developer with frontend and backend.', 'Web Development', 6, 'course-fullstack.png', 'advanced', 99.99, 4.9, 50, 32, 'published', 520),
('Python for Beginners', 'Start coding with Python and learn programming basics.', 'Programming', 6, 'course-python.png', 'beginner', 39.99, 4.8, 20, 15, 'published', 1500),
('Web Security & OWASP', 'Learn web security and protect applications from vulnerabilities.', 'Web Development', 4, 'course-security.png', 'advanced', 79.99, 4.9, 22, 16, 'published', 380);

-- ============================================
-- SAMPLE DATA - ENROLLMENTS
-- ============================================
INSERT INTO enrollments (student_id, course_id, enrollment_date, completion_percentage, status) VALUES
(9, 1, NOW(), 45, 'active'),
(9, 7, NOW(), 20, 'active'),
(10, 1, DATE_SUB(NOW(), INTERVAL 30 DAY), 100, 'completed'),
(10, 4, NOW(), 60, 'active'),
(11, 7, DATE_SUB(NOW(), INTERVAL 15 DAY), 75, 'active');

-- ============================================
-- SAMPLE DATA - TESTIMONIALS
-- ============================================
INSERT INTO testimonials (student_id, course_id, rating, comment, display_name, status, created_at) VALUES
(10, 7, 5, 'The lessons are clean, beginner friendly, and practical. I built my first portfolio project in 3 weeks.', 'Emma Wilson', 'approved', NOW()),
(11, 4, 5, 'Great structure and quality explanations. The database projects helped me perform better in my internship.', 'Liam Thompson', 'approved', NOW()),
(12, 1, 5, 'Everything looks professional and easy to follow. The feedback style made learning much less stressful.', 'Isabella Martinez', 'approved', NOW()),
(13, 9, 5, 'I liked the mix of theory and practice. The course flow feels premium and helped me finish real projects faster.', 'Noah Anderson', 'approved', NOW()),
(14, 2, 5, 'The structure is very clear and every module feels purpose-driven. I improved my UI work quality significantly.', 'Ava Richardson', 'approved', NOW()),
(15, 3, 5, 'Loved the practical assignments and design feedback style. The class helped me land freelance clients quickly.', 'Lucas Rivera', 'approved', NOW()),
(16, 10, 5, 'Excellent roadmap from basics to advanced concepts. I finally understood how frontend and backend connect in real projects.', 'Mia Roberts', 'approved', NOW()),
(17, 5, 5, 'The SQL practice tasks were realistic and interview-focused. I now write better queries with confidence.', 'Ethan Cooper', 'approved', NOW());

-- ============================================
-- DERIVED DATA SYNC (keep counts consistent)
-- ============================================
UPDATE courses c
SET students_count = (
        SELECT COUNT(*)
        FROM enrollments e
        WHERE e.course_id = c.id
            AND e.status IN ('active', 'completed')
);

UPDATE instructors i
SET
        courses_created = (
                SELECT COUNT(*)
                FROM courses c
                WHERE c.instructor_id = i.user_id
                    AND c.status = 'published'
        ),
        students_taught = (
                SELECT COALESCE(SUM(c.students_count), 0)
                FROM courses c
                WHERE c.instructor_id = i.user_id
                    AND c.status = 'published'
        );
