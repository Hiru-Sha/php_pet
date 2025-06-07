// Toggle password visibility
document.addEventListener('DOMContentLoaded', function () {
  const toggles = document.querySelectorAll('.toggle-password');

  toggles.forEach(toggle => {
    toggle.addEventListener('click', function () {
      const targetId = this.getAttribute('data-target');
      const input = document.getElementById(targetId);

      if (input.type === 'password') {
        input.type = 'text';
        this.textContent = '🙈';
      } else {
        input.type = 'password';
        this.textContent = '👁️';
      }
    });
  });

  // Handle sign-in form submission
  const form = document.getElementById('signInForm');
  form.addEventListener('submit', function (e) {
    e.preventDefault();

    // You can add form validation here if needed
    window.location.href = 'index.html'; // Redirect after sign-in
  });
});
