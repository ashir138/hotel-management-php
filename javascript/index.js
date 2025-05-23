// === Element References ===
const loginPanel = document.getElementById('Log_in');
const signupPanel = document.getElementById('sign_up');
const roleButtons = document.querySelectorAll('.btns');
const authForms = document.querySelectorAll('.authsection');

// === Login <-> Signup Toggle ===
function showSignup() {
  loginPanel.style.display = 'none';
  signupPanel.style.display = 'flex';
}

function showLogin() {
  signupPanel.style.display = 'none';
  loginPanel.style.display = 'flex';
}

// Expose to HTML onclick
window.signuppage = showSignup;
window.loginpage = showLogin;

// === Role-Based Form Switcher (User vs Employee) ===
function activateAuthForm(index) {
  roleButtons.forEach(btn => btn.classList.remove('active'));
  authForms.forEach(form => form.classList.remove('active'));

  if (roleButtons[index]) roleButtons[index].classList.add('active');
  if (authForms[index]) authForms[index].classList.add('active');
}

// Attach events
roleButtons.forEach((btn, index) => {
  btn.addEventListener('click', () => activateAuthForm(index));
});
