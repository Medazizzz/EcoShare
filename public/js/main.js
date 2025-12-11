/ /Interactive toggle switches
document.addEventListener('DOMContentLoaded', function() {
  const toggleSwitches = document.querySelectorAll('.toggle-switch');
 
  toggleSwitches.forEach(toggle => {
    toggle.addEventListener('click', function() {
      this.classList.toggle('active');
     
      // Update device status text
      const deviceCard = this.closest('.device-card');
      if (deviceCard) {
        const statusElement = deviceCard.querySelector('.device-status');
        if (statusElement) {
          statusElement.textContent = this.classList.contains('active') ? 'ON' : 'OFF';
        }
      }
    });
  });

  // Temperature control buttons
  const tempButtons = document.querySelectorAll('.temp-btn');
  const tempValue = document.querySelector('.temperature-value');
 
  tempButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      if (tempValue) {
        let currentTemp = parseInt(tempValue.textContent);
        if (this.textContent === '+') {
          currentTemp = Math.min(25, currentTemp + 1);
        } else {
          currentTemp = Math.max(5, currentTemp - 1);
        }
        tempValue.textContent = currentTemp + '°C';
      }
    });
  });

  // Sidebar toggle
  const sidebarToggle = document.getElementById('sidebarToggle');
  const sidebar = document.getElementById('sidebar');
 
  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', function() {
      sidebar.classList.toggle('collapsed');
      // Update icon - show menu icon when collapsed, X when expanded
      const icon = this.querySelector('svg');
      if (sidebar.classList.contains('collapsed')) {
        // Show menu icon (hamburger)
        icon.innerHTML = '<line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line>';
      } else {
        // Show X icon (close)
        icon.innerHTML = '<line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>';
      }
      // Save state to localStorage
      localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
    });

    // Restore sidebar state from localStorage
    const savedState = localStorage.getItem('sidebarCollapsed');
    if (savedState === 'true') {
      sidebar.classList.add('collapsed');
      const icon = sidebarToggle.querySelector('svg');
      if (icon) {
        icon.innerHTML = '<line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line>';
      }
    }
  }

  // Update active sidebar link
  const currentPath = window.location.pathname;
  const sidebarLinks = document.querySelectorAll('.sidebar a');
  sidebarLinks.forEach(link => {
    if (link.getAttribute('href') === currentPath) {
      link.classList.add('active');
    } else {
      link.classList.remove('active');
    }
  });

  // Initialize circular progress bars
  const circularProgressBars = document.querySelectorAll('.circular-progress');
  circularProgressBars.forEach(bar => {
    const percent = bar.getAttribute('data-percent');
    if (percent) {
      bar.style.setProperty('--percent', percent);
    }
  });

  // Color scheme toggle (Dark Mode)
  const schemeButtons = document.querySelectorAll('.scheme-btn');
  const html = document.documentElement;
 
  // Initialize theme from localStorage
  const savedTheme = localStorage.getItem('theme') || 'light';
  html.setAttribute('data-theme', savedTheme);
 
  // Update active button based on saved theme
  schemeButtons.forEach(btn => {
    if (btn.getAttribute('data-scheme') === savedTheme) {
      btn.classList.add('active');
    } else {
      btn.classList.remove('active');
    }
  });
 
  schemeButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      const scheme = this.getAttribute('data-scheme');
     
      // Update theme
      html.setAttribute('data-theme', scheme);
      localStorage.setItem('theme', scheme);
     
      // Update active button
      schemeButtons.forEach(b => b.classList.remove('active'));
      this.classList.add('active');
    });
  });

  // Password Toggle for Login
  const passwordToggle = document.getElementById('passwordToggle');
  const passwordInput = document.getElementById('password');
 
  if (passwordToggle && passwordInput) {
    passwordToggle.addEventListener('click', function() {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
     
      const icon = this.querySelector('svg');
      if (type === 'text') {
        icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
      } else {
        icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
      }
    });
  }

  // Password Toggle for Signup
  const signupPasswordToggle = document.getElementById('signupPasswordToggle');
  const signupPasswordInput = document.getElementById('signup-password');
 
  if (signupPasswordToggle && signupPasswordInput) {
    signupPasswordToggle.addEventListener('click', function() {
      const type = signupPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      signupPasswordInput.setAttribute('type', type);
     
      const icon = this.querySelector('svg');
      if (type === 'text') {
        icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
      } else {
        icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
      }
    });
  }

  // Password Strength Indicator
  const signupPassword = document.getElementById('signup-password');
  const strengthFill = document.querySelector('.strength-fill');
  const strengthText = document.querySelector('.strength-text');
 
  if (signupPassword && strengthFill && strengthText) {
    signupPassword.addEventListener('input', function() {
      const password = this.value;
      let strength = 0;
      let strengthLabel = '';
      let strengthColor = '';
     
      if (password.length >= 8) strength++;
      if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
      if (password.match(/\d/)) strength++;
      if (password.match(/[^a-zA-Z\d]/)) strength++;
     
      switch(strength) {
        case 0:
        case 1:
          strengthLabel = 'Faible';
          strengthColor = '#ef4444';
          break;
        case 2:
          strengthLabel = 'Moyen';
          strengthColor = '#f59e0b';
          break;
        case 3:
          strengthLabel = 'Fort';
          strengthColor = '#3b82f6';
          break;
        case 4:
          strengthLabel = 'Très fort';
          strengthColor = '#10b981';
          break;
      }
     
      const width = (strength / 4) * 100;
      strengthFill.style.width = width + '%';
      strengthFill.style.background = strengthColor;
      strengthText.textContent = password.length > 0 ? strengthLabel : 'Force du mot de passe';
      strengthText.style.color = password.length > 0 ? strengthColor : 'var(--muted)';
    });
  }

  // Form Submission with Animations
  const loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const btn = this.querySelector('.auth-btn');
      const btnText = btn.querySelector('span');
      const originalText = btnText.textContent;
     
      btnText.textContent = 'Connexion...';
      btn.disabled = true;
      btn.style.opacity = '0.7';
     
      // Simulate API call
      setTimeout(() => {
        window.location.href = '/dashboard';
      }, 1500);
    });
  }

  const signupForm = document.getElementById('signupForm');
  if (signupForm) {
    signupForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const btn = this.querySelector('.auth-btn');
      const btnText = btn.querySelector('span');
      const originalText = btnText.textContent;
     
      btnText.textContent = 'Création du compte...';
      btn.disabled = true;
      btn.style.opacity = '0.7';
     
      // Simulate API call
      setTimeout(() => {
        window.location.href = '/dashboard';
      }, 1500);
    });
  }

  // Profile Tab Switching
  const tabButtons = document.querySelectorAll('.tab-btn');
  const tabContents = document.querySelectorAll('.tab-content');
 
  tabButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      const targetTab = this.getAttribute('data-tab');
     
      // Remove active class from all tabs and contents
      tabButtons.forEach(b => b.classList.remove('active'));
      tabContents.forEach(c => c.classList.remove('active'));
     
      // Add active class to clicked tab and corresponding content
      this.classList.add('active');
      const targetContent = document.getElementById(targetTab);
      if (targetContent) {
        targetContent.classList.add('active');
      }
    });
  });

  // Input Focus Animations
  const inputs = document.querySelectorAll('.input-wrapper input, .profile-input');
  inputs.forEach(input => {
    input.addEventListener('focus', function() {
      this.parentElement.style.transform = 'scale(1.02)';
      setTimeout(() => {
        this.parentElement.style.transform = 'scale(1)';
      }, 200);
    });
  });

  // Animate form groups on load
  const formGroups = document.querySelectorAll('.form-group');
  formGroups.forEach((group, index) => {
    group.style.opacity = '0';
    group.style.transform = 'translateY(20px)';
    setTimeout(() => {
      group.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
      group.style.opacity = '1';
      group.style.transform = 'translateY(0)';
    }, index * 100);
  });
});



document.addEventListener('DOMContentLoaded', function () {
  // Theme toggle
  var themeToggle = document.getElementById('themeToggle');
  var rootBody = document.body;
  var storedTheme = window.localStorage.getItem('ecoshare-theme');
  if (storedTheme === 'dark') {
    rootBody.setAttribute('data-theme', 'dark');
  }

  if (themeToggle) {
    themeToggle.addEventListener('click', function () {
      var current = rootBody.getAttribute('data-theme') || 'light';
      var next = current === 'light' ? 'dark' : 'light';
      rootBody.setAttribute('data-theme', next);
      window.localStorage.setItem('ecoshare-theme', next);
    });
  }

  // Sidebar collapse
  var sidebar = document.getElementById('sidebar');
  var sidebarToggle = document.getElementById('sidebarToggle');
  if (sidebar && sidebarToggle) {
    sidebarToggle.addEventListener('click', function () {
      sidebar.classList.toggle('collapsed');
    });
  }

  // Animated counters for elements with data-counter
  var counters = document.querySelectorAll('[data-counter]');
  counters.forEach(function (el) {
    var finalVal = parseInt(el.textContent, 10);
    if (isNaN(finalVal) || finalVal <= 0) {
      return;
    }
    var current = 0;
    var duration = 700;
    var start = null;

    function step(timestamp) {
      if (!start) start = timestamp;
      var progress = Math.min((timestamp - start) / duration, 1);
      current = Math.floor(progress * finalVal);
      el.textContent = current;
      if (progress < 1) {
        window.requestAnimationFrame(step);
      } else {
        el.textContent = finalVal;
      }
    }

    window.requestAnimationFrame(step);
  });
});
