// Mode gelap/terang untuk seluruh aplikasi Ekskul SMK.
(function () {
  function isDark(t) { return t === 'dark' || (!t && window.matchMedia('(prefers-color-scheme: dark)').matches); }
  function apply(theme) {
    if (theme === 'dark' || theme === 'light') document.documentElement.setAttribute('data-theme', theme);
    else document.documentElement.removeAttribute('data-theme');
    document.querySelectorAll('.theme-toggle').forEach(function (b) { b.textContent = isDark(theme) ? '☀️' : '🌙'; });
  }
  window.toggleTheme = function () {
    var cur = null; try { cur = localStorage.getItem('ekskul_theme'); } catch (e) {}
    var next = isDark(cur) ? 'light' : 'dark';
    try { localStorage.setItem('ekskul_theme', next); } catch (e) {}
    apply(next);
  };
  var saved = null; try { saved = localStorage.getItem('ekskul_theme'); } catch (e) {}
  apply(saved);
})();
