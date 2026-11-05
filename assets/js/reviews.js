/**
 * SEMC - reviews.js (reviews.php only)
 * Counts the Google rating up when it scrolls into view. The final value is
 * already in the HTML, so the page is correct without JavaScript.
 */
(function () {
    'use strict';
    var el = document.getElementById('ratingNumber');
    if (!el || !window.SEMC) { return; }

    var target = parseFloat(el.getAttribute('data-value'));
    if (isNaN(target) || window.SEMC.reduceMotion || !('IntersectionObserver' in window)) { return; }

    el.textContent = '0.0';
    var io = new IntersectionObserver(function (entries, obs) {
        if (entries[0].isIntersecting) {
            window.SEMC.countUp(el, target, 1, 1400);
            obs.disconnect();
        }
    }, { threshold: 0.6 });
    io.observe(el);
})();
