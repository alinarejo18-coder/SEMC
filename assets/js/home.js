/**
 * SEMC - home.js (index.php only)
 * Counts the Google rating up from 0 when the rating card scrolls into view.
 * The final value is already in the HTML, so nothing breaks without JS.
 */
(function () {
    'use strict';
    var el = document.getElementById('ratingNumber');
    if (!el || !window.SEMC) { return; }

    var target = parseFloat(el.getAttribute('data-value'));
    if (isNaN(target)) { return; }

    function run() { window.SEMC.countUp(el, target, 1, 1400); }

    if ('IntersectionObserver' in window && !window.SEMC.reduceMotion) {
        el.textContent = '0.0';
        var io = new IntersectionObserver(function (entries, obs) {
            if (entries[0].isIntersecting) { run(); obs.disconnect(); }
        }, { threshold: 0.6 });
        io.observe(el);
    }
})();
