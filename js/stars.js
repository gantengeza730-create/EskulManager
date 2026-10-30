// Bintang (hero landing & sidebar) + adegan hero berganti tema:
//  - mode terang  : langit siang, matahari, awan bergerak
//  - mode gelap   : tata surya (matahari + 6 planet mengorbit)
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

  var DAY =
    '<div class="scene-day" aria-hidden="true">' +
      '<div class="day-sun"><span class="rays"></span><span class="disc"></span></div>' +
      '<span class="cloud" style="--w:240px;--top:13%;--t:85s;--dl:-14s;--sx:10vw;--o:.95"></span>' +
      '<span class="cloud" style="--w:340px;--top:27%;--t:110s;--dl:-60s;--sx:55vw;--o:.82"></span>' +
      '<span class="cloud" style="--w:190px;--top:50%;--t:70s;--dl:-35s;--sx:30vw;--o:.9"></span>' +
      '<span class="cloud" style="--w:280px;--top:64%;--t:125s;--dl:-90s;--sx:72vw;--o:.78"></span>' +
      '<span class="cloud" style="--w:150px;--top:7%;--t:95s;--dl:-70s;--sx:40vw;--o:.7"></span>' +
      '<span class="hills"></span>' +
    '</div>';

  function ring(d, t, dl, s, cls, inner) {
    return '<div class="ring" style="--d:' + d + 'px;--t:' + t + 's;--dl:' + dl + 's">' +
      '<i class="pl ' + cls + '" style="--s:' + s + 'px">' + (inner || '') + '</i></div>';
  }
  var NIGHT =
    '<div class="scene-night" aria-hidden="true"><div class="solar"><div class="sun"></div>' +
      ring(330, 20, -3, 8, 'mercury') +
      ring(500, 32, -20, 14, 'venus') +
      ring(680, 48, -30, 16, 'earth', '<b class="moon"></b>') +
      ring(860, 66, -8, 12, 'mars') +
      ring(1080, 100, -60, 36, 'jupiter') +
      ring(1320, 140, -90, 28, 'saturn') +
    '</div></div>';

  function init() {
    var hero = document.querySelector('.hero-space');
    if (hero && !hero.querySelector('.scene-night')) hero.insertAdjacentHTML('afterbegin', DAY + NIGHT);
    scatter(document.getElementById('starfield'), window.innerWidth < 640 ? 60 : 110, 1, 3);
    scatter(document.getElementById('sidebarStars'), 34, 1, 2);
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
