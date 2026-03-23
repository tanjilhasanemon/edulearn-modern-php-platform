# EduLearn Pro - Modern E-Learning Platform

A modern, beginner-friendly e-learning web application built with PHP, MySQL, HTML, CSS, and JavaScript, optimized for XAMPP.

This project includes a premium UI refresh, improved course visuals, consistent file naming, dynamic stats, robust image fallbacks, and production-ready project structure for GitHub portfolio use.

## Highlights

- Premium, responsive UI with a cohesive design system.
- Course cards and course detail pages with reliable thumbnail behavior.
- Expanded homepage sections:
  - Hero banner
  - Instructor showcase
  - Student testimonials
  - Featured courses and live stats
- Authentication flow:
  - Register
  - Login
  - Logout
  - Student dashboard
- Enrollment flow with progress-related data.
- Cleaned and consistent route naming.
- Beginner-friendly code structure and comments.

## Tech Stack

- PHP (procedural)
- MySQL
- HTML5
- CSS3
- JavaScript (vanilla)
- XAMPP (Apache + MySQL)

## Project Structure

```text
elearning-platform/
  index.php
  README.md
  css/
    theme.css
  database/
    schema.sql
  images/
    ...course, hero, instructor, and avatar assets...
  includes/
    database.php
    header.php
    footer.php
    action-contact.php
    action-enroll.php
    action-login.php
    action-logout.php
    action-register.php
  js/
    main.js
  pages/
    about.php
    blog.php
    careers.php
    contact.php
    course-detail.php
    courses.php
    dashboard.php
    faq.php
    help.php
    login.php
    register.php
    terms.php
```

## Key Improvements Already Included

1. Naming consistency updates:
   - `dark.css` -> `theme.css`
   - `courses-modern.php` -> `courses.php`
   - `course-detail-modern.php` -> `course-detail.php`
   - `login-modern.php` -> `login.php`
   - `register-modern.php` -> `register.php`
   - `db_connection.php` -> `database.php`
   - `process-*.php` -> `action-*.php`

2. UI/UX fixes:
   - Fixed button hover readability issues.
   - Improved subscribe/newsletter section styling.
   - Improved card spacing and action-button alignment.
   - Removed unnecessary signup phone field UI.

3. Logic fixes:
   - Better homepage metrics (learners/courses/mentors consistency).
   - Dynamic about page stats from database.
   - Server-side Terms acceptance validation on registration.
   - Fallback thumbnail logic to prevent broken course visuals.

## Requirements

- XAMPP (latest recommended)
- PHP 8.x recommended
- MySQL 5.7+ or MariaDB equivalent
- Modern browser (Chrome/Edge/Firefox)

## Local Setup (XAMPP)

1. Copy this folder into your XAMPP web root:
   - `C:/xampp/htdocs/elearning-platform`

2. Start Apache and MySQL in XAMPP Control Panel.

3. Create the database:
   - Open `http://localhost/phpmyadmin`
   - Create database: `elearning_db`
   - Import file: `database/schema.sql`

4. Open the app:
   - `http://localhost/elearning-platform`

## Demo Flow

1. Register a student account.
2. Login with that account.
3. Browse courses and open details.
4. Enroll in a course.
5. Open dashboard to view enrollments.

## Important Notes

- This project uses plain-text password storage for beginner simplicity.
- For production, replace with `password_hash` / `password_verify`.
- Course thumbnails are now resilient:
  - If a thumbnail is missing, category-based fallback image is shown.

## Suggested GitHub Sections To Add Later

- Screenshots (homepage, courses, dashboard, course detail)
- Live demo video/GIF
- Roadmap for next features
- Contribution guide

## Possible Next Enhancements

- Admin panel for courses and instructors
- Search and sorting on courses page
- Pagination and filters with query params
- Email verification and forgot-password
- Password hashing migration

## License

This project is shared for educational and portfolio purposes.
