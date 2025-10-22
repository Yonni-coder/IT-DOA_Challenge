// Set current year
document.getElementById('currentYear').textContent = new Date().getFullYear();

// Theme Toggle
const themeToggle = document.getElementById('themeToggle');
const mobileThemeToggle = document.getElementById('mobileThemeToggle');
const themeIcon = themeToggle.querySelector('i');
const mobileThemeIcon = mobileThemeToggle.querySelector('i');

// Check for saved theme preference or default to light
const savedTheme = localStorage.getItem('theme') || 'light';
if (savedTheme === 'dark') {
    document.body.classList.add('dark');
    themeIcon.classList.remove('fa-moon');
    themeIcon.classList.add('fa-sun');
    mobileThemeIcon.classList.remove('fa-moon');
    mobileThemeIcon.classList.add('fa-sun');
}

function toggleTheme() {
    document.body.classList.toggle('dark');
    
    if (document.body.classList.contains('dark')) {
        themeIcon.classList.remove('fa-moon');
        themeIcon.classList.add('fa-sun');
        mobileThemeIcon.classList.remove('fa-moon');
        mobileThemeIcon.classList.add('fa-sun');
        localStorage.setItem('theme', 'dark');
    } else {
        themeIcon.classList.remove('fa-sun');
        themeIcon.classList.add('fa-moon');
        mobileThemeIcon.classList.remove('fa-sun');
        mobileThemeIcon.classList.add('fa-moon');
        localStorage.setItem('theme', 'light');
    }
}

themeToggle.addEventListener('click', toggleTheme);
mobileThemeToggle.addEventListener('click', toggleTheme);

// Mobile Menu
const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const mobileMenu = document.getElementById('mobileMenu');
const mobileMenuIcon = mobileMenuBtn.querySelector('i');

function toggleMobileMenu() {
    mobileMenu.classList.toggle('active');
    
    if (mobileMenu.classList.contains('active')) {
        mobileMenuIcon.classList.remove('fa-bars');
        mobileMenuIcon.classList.add('fa-times');
        
        if (window.motionAnimate) {
            window.motionAnimate(
                mobileMenu,
                { opacity: [0, 1], y: [-20, 0] },
                { duration: 0.4, easing: [0.4, 0, 0.2, 1] }
            );
        }
    } else {
        mobileMenuIcon.classList.remove('fa-times');
        mobileMenuIcon.classList.add('fa-bars');
    }
}

mobileMenuBtn.addEventListener('click', toggleMobileMenu);

// Close mobile menu when clicking outside
document.addEventListener('click', (e) => {
    if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target) && mobileMenu.classList.contains('active')) {
        toggleMobileMenu();
    }
});

// Navbar scroll effect
window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    navbar.classList.toggle('scrolled', window.scrollY > 20);
    
    // Show/hide back to top button
    const backToTop = document.getElementById('backToTop');
    if (window.scrollY > 500) {
        backToTop.classList.add('visible');
    } else {
        backToTop.classList.remove('visible');
    }
});

// Back to top functionality
document.getElementById('backToTop').addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// Animated counters
function animateCounter(element) {
    const target = parseInt(element.getAttribute('data-target'));
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;
    
    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            element.textContent = target + '+';
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

// Scroll reveal with Motion.js
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && window.motionAnimate) {
            window.motionAnimate(
                entry.target,
                { opacity: [0, 1], y: [40, 0] },
                { duration: 0.8, easing: [0.4, 0, 0.2, 1] }
            );
            entry.target.classList.add('active');
            
            // Animate counters when stats section is visible
            if (entry.target.classList.contains('stats')) {
                document.querySelectorAll('.stat-value[data-target]').forEach(animateCounter);
            }
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

// Accordion
function toggleAccordion(header) {
    const content = header.nextElementSibling;
    const icon = header.querySelector('span:last-child');
    const isActive = content.classList.contains('active');
    
    document.querySelectorAll('.accordion-content').forEach(c => {
        c.classList.remove('active');
        if (window.motionAnimate) {
            window.motionAnimate(
                c,
                { maxHeight: 0 },
                { duration: 0.4, easing: [0.4, 0, 0.2, 1] }
            );
        }
    });
    document.querySelectorAll('.accordion-header span:last-child').forEach(i => i.style.transform = 'rotate(0deg)');
    
    if (!isActive) {
        content.classList.add('active');
        if (window.motionAnimate) {
            window.motionAnimate(
                content,
                { maxHeight: [0, '500px'] },
                { duration: 0.4, easing: [0.4, 0, 0.2, 1] }
            );
        }
        icon.style.transform = 'rotate(180deg)';
    }
}

// Map initialization
let map;
window.mapInitialized = false;

function initMap() {
    if (window.mapInitialized) return;
    
    // Coordinates for Antsiranana, Madagascar
    const coords = [-12.2824, 49.3029];
    
    map = L.map('map').setView(coords, 15);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    L.marker(coords).addTo(map)
        .bindPopup('<strong>MADA-Digital</strong><br>Antsiranana, Madagascar')
        .openPopup();
    
    window.mapInitialized = true;
}

// Modal for event photos
const modal = document.getElementById('eventModal');
const modalImage = document.getElementById('modalImage');
const modalClose = document.getElementById('modalClose');

function openModal(imageSrc) {
    modalImage.src = imageSrc;
    modal.classList.add('active');
    
    if (window.motionAnimate) {
        window.motionAnimate(
            modal,
            { opacity: [0, 1] },
            { duration: 0.3 }
        );
    }
}

function closeModal() {
    modal.classList.remove('active');
}

modalClose.addEventListener('click', closeModal);
modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        closeModal();
    }
});

// Form submission
document.querySelector('.contact-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Merci pour votre message ! Nous vous contacterons bientôt.');
    this.reset();
});

// Newsletter form submission
document.querySelector('.newsletter-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const email = this.querySelector('input[type="email"]').value;
    alert(`Merci de vous être inscrit à notre newsletter avec l'adresse : ${email}`);
    this.reset();
});

// Initialize map if on contact page
if (window.location.pathname.includes('contact.html')) {
    // Initialize map when page loads
    document.addEventListener('DOMContentLoaded', function() {
        initMap();
    });
}

// Animate hero elements on page load for home page
if (window.location.pathname.endsWith('index.html') || window.location.pathname === '/') {
    document.addEventListener('DOMContentLoaded', function() {
        if (window.motionAnimate) {
            // Animate badge
            window.motionAnimate(
                '.badge',
                { y: [-20, 0], opacity: [0, 1] },
                { duration: 0.8, delay: 0.2 }
            );
            
            // Animate hero title
            window.motionAnimate(
                '.hero h1',
                { y: [30, 0], opacity: [0, 1] },
                { duration: 1, delay: 0.4 }
            );
            
            // Animate hero paragraph
            window.motionAnimate(
                '.hero p',
                { y: [20, 0], opacity: [0, 1] },
                { duration: 0.8, delay: 0.8 }
            );
            
            // Animate hero buttons
            window.motionAnimate(
                '.hero .btn',
                { y: [20, 0], opacity: [0, 1] },
                { duration: 0.8, delay: 1 }
            );
            
            // Floating animation for badge
            window.motionAnimate(
                '.badge',
                { y: [0, -10, 0] },
                { duration: 3, repeat: Infinity, easing: "easeInOut" }
            );
            
            // Glow animation
            window.motionAnimate(
                '.glow',
                { opacity: [1, 0.5, 1], scale: [1, 0.8, 1] },
                { duration: 2, repeat: Infinity, easing: "easeInOut" }
            );
            
            // Gradient text animation
            window.motionAnimate(
                '.gradient-text',
                { backgroundPosition: ['0% 50%', '100% 50%', '0% 50%'] },
                { duration: 3, repeat: Infinity, easing: "easeInOut" }
            );
        }
    });
}