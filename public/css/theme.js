// Mode gelap/terang untuk seluruh aplikasi Ekskul SMK.
(function () {
  function apply(theme) {
    if (theme === 'dark' || theme === 'light') {
      document.documentElement.setAttribute('data-theme', theme);
    } else {
      document.documentElement.removeAttribute('data-theme');
    }
    document.querySelectorAll('.theme-toggle').forEach(function (b) {
      var dark = document.documentElement.getAttribute('data-theme') === 'dark'
        || (!document.documentElement.getAttribute('data-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);
      b.textContent = dark ? '☀️' : '🌙';
    });
  }
  window.toggleTheme = function () {
    var cur = localStorage.getItem('ekskul_theme');
    var isDark = cur === 'dark' || (!cur && window.matchMedia('(prefers-color-scheme: dark)').matches);
    var next = isDark ? 'light' : 'dark';
    try { localStorage.setItem('ekskul_theme', next); } catch (e) {}
    apply(next);
  };
  try { apply(localStorage.getItem('ekskul_theme')); } catch (e) { apply(null); }
})();
