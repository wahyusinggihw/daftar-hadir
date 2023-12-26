function togglePassword(inputId) {
  const passwordField = document.getElementById(inputId);
  const toggleButton = document.querySelector(`[onclick="togglePassword('${inputId}')"]`);

  if (passwordField.type === 'password') {
    passwordField.type = 'text';
    toggleButton.innerHTML = '<i class="fas fa-eye-slash"></i>';
  } else {
    passwordField.type = 'password';
    toggleButton.innerHTML = '<i class="fas fa-eye"></i>';
  }
}