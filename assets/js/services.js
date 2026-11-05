/**
 * SEMC - services.js (services.php only)
 * Accessible show/hide toggle for each service card's "How to access" panel.
 * Panels are hidden by default via the `hidden` attribute and toggled here.
 */
(function () {
    'use strict';
    document.querySelectorAll('.service-toggle').forEach(function (btn) {
        var panel = document.getElementById(btn.getAttribute('aria-controls'));
        if (!panel) { return; }

        btn.addEventListener('click', function () {
            var open = btn.getAttribute('aria-expanded') === 'true';
            btn.setAttribute('aria-expanded', String(!open));
            panel.hidden = open;
            panel.classList.toggle('is-open', !open);
            var label = btn.querySelector('.toggle-label');
            if (label) { label.textContent = open ? 'How to access' : 'Hide details'; }
        });
    });
})();
