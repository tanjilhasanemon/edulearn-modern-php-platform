// ============================================
// E-LEARNING PLATFORM - MAIN JAVASCRIPT FILE
// Purpose: Handle interactive features like mobile menu, animations, etc.
// ============================================

// ============================================
// MOBILE MENU TOGGLE FUNCTION
// ============================================
function toggleMobileMenu() {
    // Get the mobile menu element
    const mobileMenu = document.getElementById('mobileMenu');
    
    // Check if menu has 'active' class
    if (mobileMenu.classList.contains('active')) {
        // If active, remove the class (hide menu)
        mobileMenu.classList.remove('active');
    } else {
        // If not active, add the class (show menu)
        mobileMenu.classList.add('active');
    }
}

// ============================================
// SCROLL TO SECTION FUNCTION
// ============================================
// This function scrolls smoothly to a specific section
function scrollToSection(sectionId) {
    // Find the element with the given ID
    const element = document.getElementById(sectionId);
    
    // If element exists, scroll to it
    if (element) {
        // Use scrollIntoView for smooth scrolling
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// ============================================
// FORM VALIDATION
// ============================================

// Validate Register Form
function validateRegisterForm() {
    // Get form elements
    const fullname = document.getElementById('fullname');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm-password');

    // Create error array
    let errors = [];

    // Check if fullname is not empty
    if (!fullname || fullname.value.trim() === '') {
        errors.push('Full name is required');
    }

    // Check if email is valid format
    if (!email || !isValidEmail(email.value)) {
        errors.push('Please enter a valid email');
    }

    // Check if password is at least 6 characters
    if (!password || password.value.length < 6) {
        errors.push('Password must be at least 6 characters');
    }

    // Check if passwords match
    if (password && confirmPassword && password.value !== confirmPassword.value) {
        errors.push('Passwords do not match');
    }

    // If there are errors, show them
    if (errors.length > 0) {
        showErrors(errors);
        return false; // Prevent form submission
    }

    return true; // Allow form submission
}

// ============================================
// EMAIL VALIDATION HELPER
// ============================================
function isValidEmail(email) {
    // Regex pattern for email validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

// ============================================
// SHOW ERRORS FUNCTION
// ============================================
function showErrors(errors) {
    // Create error message
    let errorMessage = 'Please fix the following errors:\n\n';
    
    // Add each error to the message
    errors.forEach(error => {
        errorMessage += '• ' + error + '\n';
    });

    // Show alert with all errors
    alert(errorMessage);
}

// ============================================
// PAGE LOAD - AUTO-HIDE MOBILE MENU
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    // Get all navigation links
    const navLinks = document.querySelectorAll('.mobile-menu a');
    const mobileMenu = document.getElementById('mobileMenu');

    // Add click event to each link
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Close mobile menu when link is clicked
            if (mobileMenu) {
                mobileMenu.classList.remove('active');
            }
        });
    });
});

// ============================================
// CLICK OUTSIDE TO CLOSE MOBILE MENU
// ============================================
document.addEventListener('click', function(event) {
    // Get mobile menu and hamburger elements
    const mobileMenu = document.getElementById('mobileMenu');
    const hamburger = document.querySelector('.hamburger');

    // Check if click is outside menu and hamburger
    if (mobileMenu && hamburger &&
        !mobileMenu.contains(event.target) &&
        !hamburger.contains(event.target)) {
        // Remove active class to close menu
        mobileMenu.classList.remove('active');
    }
});

// ============================================
// SCROLL ANIMATIONS
// ============================================
// This function adds animation classes to elements when they come into view

function setupScrollAnimations() {
    // Get all elements that should animate
    const animatedElements = document.querySelectorAll(
        '.course-card, .feature-card, .stat-card, .instructor-card, .testimonial-card'
    );

    // Create an Intersection Observer to watch for visible elements
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            // If element is visible on screen
            if (entry.isIntersecting) {
                // Add animated class (you would define this in CSS)
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        // Start animation when element is 100px from bottom of viewport
        rootMargin: '0px 0px -100px 0px'
    });

    // Start observing all animated elements
    animatedElements.forEach(element => {
        // Set initial state
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        
        // Start observing
        observer.observe(element);
    });
}

// ============================================
// STICKY NAVBAR EFFECT
// ============================================
function setupStickyNavbar() {
    // Get navbar element
    const navbar = document.querySelector('.navbar');
    
    // Only run if navbar exists
    if (!navbar) return;
    
    // Add scroll event listener
    window.addEventListener('scroll', function() {
        // If page is scrolled more than 50px down
        if (window.scrollY > 50) {
            // Add shadow to navbar
            navbar.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.15)';
        } else {
            // Remove shadow
            navbar.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
        }
    });
}

// ============================================
// SMOOTH SCROLL FOR ALL ANCHOR LINKS
// ============================================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        // Get the target section ID
        const href = this.getAttribute('href');
        
        // Only prevent default for valid anchors (not just "#")
        if (href !== '#') {
            e.preventDefault();
            
            // Find the target element
            const target = document.querySelector(href);
            
            // If target exists, scroll to it
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});

// ============================================
// INITIALIZE ALL FUNCTIONS ON PAGE LOAD
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    // Setup scroll animations
    setupScrollAnimations();
    
    // Setup sticky navbar
    setupStickyNavbar();
    
    // Log that page has loaded (for debugging)
    console.log('EduLearn Platform loaded successfully');
});
