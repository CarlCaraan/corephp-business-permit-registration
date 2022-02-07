const toggleSwitch = document.querySelector('input[type="checkbox"]');
const toggleIcon = document.getElementById('toggle-icon');
const toggleDark = document.getElementById('toggle-dark');
const image1 = document.getElementById('image1');
const image2 = document.getElementById('image2');

// Dark or Light Images
function imageMode(color) {
  image1.src = `assets/images/registration_${color}.svg`;
  image2.src = `assets/images/footer/m83x_${color}.png`;
}

// Dark Mode Styles
function darkMode() {
  imageMode('secondary');
  toggleIcon.children[1].textContent = 'Dark';
  toggleIcon.children[0].classList.replace('fa-sun', 'fa-moon');
  toggleDark.children[0].classList.replace('light', 'dark');
}

// Light Mode Styles
function lightMode() {
  imageMode('primary');
  toggleIcon.children[1].textContent = 'Light';
  toggleIcon.children[0].classList.replace('fa-moon', 'fa-sun');
  toggleDark.children[0].classList.replace('dark', 'light');
}

// Switch Theme Dynamically
function switchTheme(event) {
  if (event.target.checked) {
    document.documentElement.setAttribute('data-theme', 'dark');
    localStorage.setItem('theme', 'dark');
    darkMode();
  } else {
    document.documentElement.setAttribute('data-theme', 'light');
    localStorage.setItem('theme', 'light');
    lightMode();
  }
}

// Event Listener
toggleSwitch.addEventListener('change', switchTheme);

// Check Local Storage For Theme
const currentTheme = localStorage.getItem('theme');
if (currentTheme) {
  document.documentElement.setAttribute('data-theme', currentTheme);

  if (currentTheme === 'dark') {
    toggleSwitch.checked = true;
    darkMode();
  }
}
