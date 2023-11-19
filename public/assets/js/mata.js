function togglePasswordVisibility() {
  const passwordField = document.getElementById('password');
  const passwordToggleIcon = document.getElementById('password-toggle-icon');

  if (passwordField.type === 'password') {
    passwordField.type = 'text';
    passwordToggleIcon.classList.remove('fa-eye');
    passwordToggleIcon.classList.add('fa-eye-slash');
  } else {
    passwordField.type = 'password';
    passwordToggleIcon.classList.remove('fa-eye-slash');
    passwordToggleIcon.classList.add('fa-eye');
  }
}
