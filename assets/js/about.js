/**
 * SEMC - about.js (about.php only)
 * Highlights the in-page sub-navigation link for the section currently in view.
 * Links work as normal anchors without JS.
 */
(function () {
    'use strict';
    var links = Array.prototype.slice.call(document.querySelectorAll('.subnav-link'));
    if (!links.length || !('IntersectionObserver' in window)) { return; }

    var map = {};
    links.forEach(function (a) { map[a.getAttribute('href').slice(1)] = a; });

    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting && map[entry.target.id]) {
                links.forEach(function (a) { a.classList.remove('is-active'); a.removeAttribute('aria-current'); });
                map[entry.target.id].classList.add('is-active');
                map[entry.target.id].setAttribute('aria-current', 'true');
            }
        });
    }, { rootMargin: '-35% 0px -55% 0px' });

    Object.keys(map).forEach(function (id) {
        var section = document.getElementById(id);
        if (section) { io.observe(section); }
    });
})();
