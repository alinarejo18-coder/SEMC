/**
 * SEMC - emergency.js (emergency.php only)
 * "Copy number" / "Copy address" buttons using the Clipboard API, with a
 * textarea fallback for older browsers or non-secure contexts.
 * The call buttons themselves are plain tel: links and need no JavaScript.
 */
(function () {
    'use strict';

    function fallbackCopy(text) {
        var ta = document.createElement('textarea');
        ta.value = text;
        ta.setAttribute('readonly', '');
        ta.style.position = 'fixed';
        ta.style.left = '-9999px';
        document.body.appendChild(ta);
        ta.select();
        var ok = false;
        try { ok = document.execCommand('copy'); } catch (err) { ok = false; }
        document.body.removeChild(ta);
        return ok;
    }

    function copyText(text) {
        if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(text).then(function () { return true; }, function () { return fallbackCopy(text); });
        }
        return Promise.resolve(fallbackCopy(text));
    }

    document.querySelectorAll('[data-copy]').forEach(function (btn) {
        var label = btn.querySelector('span');
        var original = btn.getAttribute('data-copy-label') || (label ? label.textContent : '');

        btn.addEventListener('click', function () {
            copyText(btn.getAttribute('data-copy')).then(function (ok) {
                if (label) { label.textContent = ok ? 'Copied!' : 'Copy failed'; }
                btn.classList.toggle('is-copied', ok);
                window.setTimeout(function () {
                    if (label) { label.textContent = original; }
                    btn.classList.remove('is-copied');
                }, 2000);
            });
        });
    });
})();
