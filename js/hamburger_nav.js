//Hamborger nav
// Hamburger menu toggle
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('nav ul');
const navOverlay = document.querySelector('.nav-overlay');
const navLinks = document.querySelectorAll('nav ul li a');

// Toggle menu
hamburger.addEventListener('click', () => {
  hamburger.classList.toggle('active');
  navMenu.classList.toggle('active');
  navOverlay.classList.toggle('active');
  document.body.style.overflow = hamburger.classList.contains('active') ? 'hidden' : '';
});

// Close menu when clicking overlay
navOverlay.addEventListener('click', () => {
  hamburger.classList.remove('active');
  navMenu.classList.remove('active');
  navOverlay.classList.remove('active');
  document.body.style.overflow = '';
});

// Close menu when clicking a link
navLinks.forEach(link => {
  link.addEventListener('click', () => {
    hamburger.classList.remove('active');
    navMenu.classList.remove('active');
    navOverlay.classList.remove('active');
    document.body.style.overflow = '';
  });
});

