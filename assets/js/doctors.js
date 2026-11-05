/**
 * SEMC - doctors.js (doctors.php only)
 * Filters doctor cards by specialisation. The filter buttons are only rendered
 * by doctors.php when real profiles with two or more specialisations exist,
 * so this does nothing while the page shows placeholders.
 */
(function () {
    'use strict';
    var buttons = document.querySelectorAll('.filter-btn');
    var cards = document.querySelectorAll('.doctor-col');
    if (!buttons.length || !cards.length) { return; }

    buttons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var filter = btn.getAttribute('data-filter');
            buttons.forEach(function (b) {
                b.classList.toggle('is-active', b === btn);
                b.setAttribute('aria-pressed', String(b === btn));
            });
            cards.forEach(function (card) {
                card.hidden = !(filter === 'all' || card.getAttribute('data-spec') === filter);
            });
        });
    });
})();
