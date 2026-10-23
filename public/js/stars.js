// Menaburkan bintang kecil secara acak — dipakai di hero landing page dan sidebar dashboard.
(function () {
  function scatter(el, count, sizeMin, sizeMax) {
    if (!el) return;
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var html = '';
    for (var i = 0; i < count; i++) {
      var size = (Math.random() * (sizeMax - sizeMin) + sizeMin).toFixed(1);
      var top = (Math.random() * 100).toFixed(2);
      var left = (Math.random() * 100).toFixed(2);
      var dur = (Math.random() * 3 + 2).toFixed(2);
      var delay = (Math.random() * 5).toFixed(2);
      html += '<span class="star" style="width:' + size + 'px;height:' + size + 'px;top:' + top + '%;left:' + left + '%;' +
        (reduce ? '' : 'animation-duration:' + dur + 's;animation-delay:' + delay + 's;') + '"></span>';
    }
    el.innerHTML = html;
  }
  function init() {
    scatter(document.getElementById('starfield'), window.innerWidth < 640 ? 60 : 110, 1, 3);
    scatter(document.getElementById('sidebarStars'), 34, 1, 2);
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
