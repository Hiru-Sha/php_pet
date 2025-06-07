document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.querySelector('.search-input');
  const startSearchButtons = document.querySelectorAll('.start-search-btn');

  // Style on focus
  if (searchInput) {
    searchInput.addEventListener('focus', () => {
      searchInput.style.borderColor = '#1A94E5';
    });
    searchInput.addEventListener('blur', () => {
      searchInput.style.borderColor = '#ccc';
    });
  }

  // Smooth scroll
  startSearchButtons.forEach(button => {
    button.addEventListener('click', () => {
      const section = document.querySelector('.featured-pets');
      if (section) section.scrollIntoView({ behavior: 'smooth' });
    });
  });

  // Clickable pet cards
  document.querySelectorAll('.pet-card').forEach(card => {
    card.addEventListener('click', () => {
      alert(`You clicked on ${card.querySelector('h3').innerText}!`);
    });
  });

  // Hamburger menu toggle
  const menuToggle = document.getElementById('menuToggle');
  const navLinks = document.querySelector('.nav-links');

  if (menuToggle && navLinks) {
    menuToggle.addEventListener('click', () => {
      navLinks.classList.toggle('active');
    });
  }
});
