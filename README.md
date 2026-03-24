# EduLearn - E-Learning Platform

Clean, beginner-friendly E-Learning platform built with PHP, MySQL, HTML, CSS, and JavaScript for XAMPP environments.

## Overview

This repository is organized for direct GitHub submission and local XAMPP execution.

Core capabilities:

1. Student registration, login, logout
2. Course catalog with category filters
3. Course detail page with enrollment flow
4. Student dashboard with progress and recommendations
5. Homepage sections powered by database data (courses, instructors, testimonials, stats)
6. Contact form persistence

## Tech Stack

1. PHP (procedural)
2. MySQL / MariaDB
3. HTML5
4. CSS3
5. Vanilla JavaScript
6. XAMPP (Apache + MySQL)

## Final Project Structure

elearning-platform/
index.php
README.md
css/
theme.css
database/
schema.sql
erd-logical.drawio
erd-logical.md
images/
about-platform.png
hero-banner.png
hero-banner-v2.png
course-*.png
instructor-*.png
student-avatar-*.png
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

## Database Files

1. database/schema.sql
Creates all tables and inserts cleaned sample data.

2. database/erd-logical.md
ERD specification matching the current implemented schema.

3. database/erd-logical.drawio
Editable diagram source file.

## Local Setup (XAMPP)

1. Copy project to C:/xampp/htdocs/elearning-platform
2. Start Apache and MySQL from XAMPP Control Panel
3. Open phpMyAdmin and create database elearning_db
4. Import database/schema.sql
5. Open http://localhost/elearning-platform

## Demo Credentials

Student demo account from seed data:

Email: demo@example.com
Password: password123

## Quality Notes

1. Project remains framework-free and beginner-friendly.
2. Instructor and testimonial sections are database-driven for consistency.
3. Image fallback logic is included for course thumbnails.
4. Passwords are stored in plain text for beginner learning simplicity.

Production recommendation:
Use password_hash and password_verify before deploying publicly.

## License

Educational and portfolio use.
