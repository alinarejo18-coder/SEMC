/**
 * SEMC - main.js
 * Shared behaviour loaded on every page:
 *  - sticky header shadow on scroll
 *  - close the mobile menu after choosing a link
 *  - AOS initialisation (with safe fallback)
 *  - image-reveal observer
 *  - back-to-top button
 */
(function () {
    'use strict';

    var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ---------- Sticky header: add class after scrolling ---------- */
    var header = document.querySelector('.site-header');
    var backToTop = document.getElementById('backToTop');

    function onScroll() {
        var y = window.pageYOffset || document.documentElement.scrollTop;
        if (header) { header.classList.toggle('is-scrolled', y > 10); }
        if (backToTop) { backToTop.hidden = y < 600; }
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    /* ---------- Close mobile menu when a nav link is clicked ---------- */
    var navCollapse = document.getElementById('mainNav');
    if (navCollapse && window.bootstrap) {
        navCollapse.querySelectorAll('a.nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                if (navCollapse.classList.contains('show')) {
                    window.bootstrap.Collapse.getOrCreateInstance(navCollapse).hide();
                }
            });
        });
    }

    /* ---------- Back to top (smooth unless reduced motion) ---------- */
    if (backToTop) {
        backToTop.addEventListener('click', function (e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
        });
    }

    /* ---------- AOS (scroll reveal) ---------- */
    // animations.css keeps content visible unless .aos-ready is set,
    // so a failed CDN load can never hide page content.
    if (window.AOS && !reduceMotion) {
        try {
            window.AOS.init({ duration: 700, easing: 'ease-out-cubic', once: true, offset: 60 });
            document.documentElement.classList.add('aos-ready');
        } catch (err) {
            document.documentElement.classList.remove('aos-ready');
        }
    }

    /* ---------- Image reveal (clip-path) ---------- */
    var reveals = document.querySelectorAll('.img-reveal');
    if (reveals.length) {
        if (!reduceMotion && 'IntersectionObserver' in window) {
            document.documentElement.classList.add('js-reveal');
            var io = new IntersectionObserver(function (entries, obs) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        obs.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });
            reveals.forEach(function (el) { io.observe(el); });
        } else {
            reveals.forEach(function (el) { el.classList.add('is-visible'); });
        }
    }

    /* ---------- Shared helper for page scripts ---------- */
    window.SEMC = window.SEMC || {};
    window.SEMC.reduceMotion = reduceMotion;

    /** Animate a number from 0 to `end` (respects reduced motion). */
    window.SEMC.countUp = function (el, end, decimals, duration) {
        decimals = decimals || 0;
        duration = duration || 1200;
        if (reduceMotion) { el.textContent = end.toFixed(decimals); return; }
        var start = null;
        function step(ts) {
            if (start === null) { start = ts; }
            var p = Math.min((ts - start) / duration, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            el.textContent = (end * eased).toFixed(decimals);
            if (p < 1) { window.requestAnimationFrame(step); } else { el.textContent = end.toFixed(decimals); }
        }
        window.requestAnimationFrame(step);
    };
})();
