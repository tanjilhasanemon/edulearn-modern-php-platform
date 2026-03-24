# Logical ERD Specification

This document matches the current implementation in database/schema.sql.

## Current Modeling Notes

1. courses.instructor_id is a foreign key to users.id.
2. instructors is a one-to-one extension table for instructor-specific profile data and references users.id through instructors.user_id.
3. courses.category is currently stored as a VARCHAR label, not as a foreign key to categories.id.
4. categories exists for future normalization and taxonomy management but is not linked by FK in the current schema.
5. contact_messages is standalone and intentionally disconnected from user accounts.

## Entity Definitions

### 1) users

| Attribute | Type | Key/Constraint | Description |
|---|---|---|---|
| id | INT | PK, AUTO_INCREMENT | Unique user identifier |
| fullname | VARCHAR(100) | NOT NULL | Full name |
| email | VARCHAR(100) | NOT NULL, UNIQUE | Login and contact email |
| phone | VARCHAR(20) | NULL | Optional phone |
| password | VARCHAR(255) | NOT NULL | Password value |
| profile_picture | VARCHAR(255) | NULL | Image filename |
| bio | TEXT | NULL | Profile summary |
| role | ENUM('student','instructor') | DEFAULT 'student' | Account role |
| status | ENUM('active','inactive','suspended') | DEFAULT 'active' | Account status |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Created time |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Updated time |

### 2) instructors

| Attribute | Type | Key/Constraint | Description |
|---|---|---|---|
| id | INT | PK, AUTO_INCREMENT | Instructor profile row |
| user_id | INT | FK, UNIQUE, NOT NULL | References users.id |
| title | VARCHAR(100) | NULL | Professional title |
| expertise | TEXT | NULL | Expertise summary |
| experience_years | INT | DEFAULT 5 | Experience years |
| courses_created | INT | DEFAULT 0 | Cached aggregate |
| students_taught | INT | DEFAULT 0 | Cached aggregate |
| rating | DECIMAL(3,1) | DEFAULT 0.0 | Instructor rating |
| bio | TEXT | NULL | Long bio |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Created time |

### 3) categories

| Attribute | Type | Key/Constraint | Description |
|---|---|---|---|
| id | INT | PK, AUTO_INCREMENT | Category ID |
| name | VARCHAR(100) | NOT NULL, UNIQUE | Category name |
| description | TEXT | NULL | Category description |
| icon | VARCHAR(255) | NULL | Category icon |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Created time |

### 4) courses

| Attribute | Type | Key/Constraint | Description |
|---|---|---|---|
| id | INT | PK, AUTO_INCREMENT | Course ID |
| title | VARCHAR(255) | NOT NULL | Course title |
| description | TEXT | NOT NULL | Course description |
| category | VARCHAR(100) | NOT NULL | Category label |
| instructor_id | INT | FK, NOT NULL | References users.id |
| thumbnail | VARCHAR(255) | NULL | Course image filename |
| level | ENUM('beginner','intermediate','advanced') | DEFAULT 'beginner' | Difficulty level |
| price | DECIMAL(10,2) | DEFAULT 49.99 | Price |
| rating | DECIMAL(3,1) | DEFAULT 4.8 | Course rating |
| students_count | INT | DEFAULT 0 | Cached enrollment count |
| duration_hours | INT | DEFAULT 20 | Course duration |
| lessons_count | INT | DEFAULT 15 | Total lessons |
| status | ENUM('published','draft','archived') | DEFAULT 'published' | Publish state |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Created time |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Updated time |

### 5) lessons

| Attribute | Type | Key/Constraint | Description |
|---|---|---|---|
| id | INT | PK, AUTO_INCREMENT | Lesson ID |
| course_id | INT | FK, NOT NULL | References courses.id |
| title | VARCHAR(255) | NOT NULL | Lesson title |
| description | TEXT | NULL | Lesson description |
| video_url | VARCHAR(255) | NULL | Video URL |
| content | TEXT | NULL | Lesson content |
| duration_minutes | INT | DEFAULT 30 | Lesson duration |
| lesson_number | INT | NULL | Ordering number |
| status | ENUM('published','draft') | DEFAULT 'published' | Publish state |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Created time |

### 6) enrollments

| Attribute | Type | Key/Constraint | Description |
|---|---|---|---|
| id | INT | PK, AUTO_INCREMENT | Enrollment row |
| student_id | INT | FK, NOT NULL | References users.id |
| course_id | INT | FK, NOT NULL | References courses.id |
| enrollment_date | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Enrollment time |
| completion_percentage | INT | DEFAULT 0 | Progress 0-100 |
| status | ENUM('active','completed','dropped') | DEFAULT 'active' | Enrollment status |
| certificate_earned | BOOLEAN | DEFAULT FALSE | Certificate flag |
| last_access | DATETIME | NULL | Last activity |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Created time |

Important constraint: UNIQUE(student_id, course_id)

### 7) progress

| Attribute | Type | Key/Constraint | Description |
|---|---|---|---|
| id | INT | PK, AUTO_INCREMENT | Progress row |
| enrollment_id | INT | FK, NOT NULL | References enrollments.id |
| lesson_id | INT | FK, NOT NULL | References lessons.id |
| completed | BOOLEAN | DEFAULT FALSE | Completion state |
| completion_date | DATETIME | NULL | Completion time |
| time_spent_minutes | INT | DEFAULT 0 | Time spent |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Created time |

Important constraint: UNIQUE(enrollment_id, lesson_id)

### 8) testimonials

| Attribute | Type | Key/Constraint | Description |
|---|---|---|---|
| id | INT | PK, AUTO_INCREMENT | Testimonial ID |
| student_id | INT | FK, NOT NULL | References users.id |
| course_id | INT | FK, NOT NULL | References courses.id |
| rating | INT | NOT NULL | Rating value |
| comment | TEXT | NULL | Review text |
| display_name | VARCHAR(100) | NULL | Public name |
| status | ENUM('approved','pending','rejected') | DEFAULT 'pending' | Moderation |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Created time |

### 9) contact_messages

| Attribute | Type | Key/Constraint | Description |
|---|---|---|---|
| id | INT | PK, AUTO_INCREMENT | Message ID |
| name | VARCHAR(100) | NOT NULL | Sender name |
| email | VARCHAR(100) | NOT NULL | Sender email |
| subject | VARCHAR(255) | NOT NULL | Subject |
| message | TEXT | NOT NULL | Message body |
| status | ENUM('new','read','responded') | DEFAULT 'new' | Processing state |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Created time |

## Relationship Definitions (Implemented)

| # | Parent Entity | Child Entity | FK in Child | Cardinality |
|---|---|---|---|---|
| 1 | users | instructors | instructors.user_id -> users.id | 1 to 0..1 |
| 2 | users (instructor role) | courses | courses.instructor_id -> users.id | 1 to many |
| 3 | courses | lessons | lessons.course_id -> courses.id | 1 to many |
| 4 | users (student role) | enrollments | enrollments.student_id -> users.id | 1 to many |
| 5 | courses | enrollments | enrollments.course_id -> courses.id | 1 to many |
| 6 | enrollments | progress | progress.enrollment_id -> enrollments.id | 1 to many |
| 7 | lessons | progress | progress.lesson_id -> lessons.id | 1 to many |
| 8 | users (student role) | testimonials | testimonials.student_id -> users.id | 1 to many |
| 9 | courses | testimonials | testimonials.course_id -> courses.id | 1 to many |

## Conceptual Notes

1. students and courses are many-to-many through enrollments.
2. enrollments and lessons are many-to-many through progress.
3. categories is currently decoupled from courses.category and can be normalized later.

## Draw.io Update Reminder

When updating erd-logical.drawio, ensure these two points are reflected:

1. courses.instructor_id links to users.id (not instructors.id).
2. courses uses category VARCHAR currently (no FK from courses to categories).
