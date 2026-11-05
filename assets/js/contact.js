/**
 * SEMC - contact.js (contact.php only)
 *  - Client-side validation (mirrors the PHP rules in contact.php)
 *  - Submits with fetch() for a smoother experience and shows the REAL result
 *    returned by the server. A success message is shown only when the server
 *    answers with success === true.
 *  - If fetch fails entirely, shows an error with the phone number. Without
 *    JS the form still posts normally and PHP validates and responds.
 */
(function () {
    'use strict';

    var form = document.getElementById('contactForm');
    if (!form) { return; }

    var statusBox = document.getElementById('formStatus');
    var submitBtn = document.getElementById('submitBtn');
    var counter = document.getElementById('msgCount');
    var message = document.getElementById('message');
    var PHONE = '+92 300 0267362';

    var rules = {
        name: function (v) {
            if (!v) { return 'Please enter your full name.'; }
            if (v.length < 2 || v.length > 80) { return 'Name must be between 2 and 80 characters.'; }
        },
        email: function (v) {
            if (!v) { return 'Please enter your email address.'; }
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v) || v.length > 120) { return 'Please enter a valid email address.'; }
        },
        phone: function (v) {
            if (!v) { return 'Please enter your phone number.'; }
            if (!/^\+?[0-9][0-9\s\-()]{6,18}$/.test(v)) { return 'Please enter a valid phone number (digits, spaces, + or - only).'; }
        },
        subject: function (v) {
            if (!v) { return 'Please enter a subject.'; }
            if (v.length < 3 || v.length > 120) { return 'Subject must be between 3 and 120 characters.'; }
        },
        message: function (v) {
            if (!v) { return 'Please write your message.'; }
            if (v.length < 10) { return 'Your message is too short (at least 10 characters).'; }
            if (v.length > 2000) { return 'Your message is too long (maximum 2000 characters).'; }
        }
    };

    function field(name) { return form.elements[name]; }
    function errorBox(name) { return form.querySelector('[data-error-for="' + name + '"]'); }

    function setError(name, msg) {
        var input = field(name), box = errorBox(name);
        if (!input || !box) { return; }
        if (msg) {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            input.setAttribute('aria-invalid', 'true');
            box.textContent = msg;
        } else {
            input.classList.remove('is-invalid');
            input.removeAttribute('aria-invalid');
            box.textContent = '';
        }
    }

    function validateField(name) {
        var input = field(name);
        var msg = rules[name](input.value.trim());
        setError(name, msg);
        if (!msg) { input.classList.add('is-valid'); }
        return !msg;
    }

    function validateAll() {
        var firstBad = null;
        Object.keys(rules).forEach(function (name) {
            if (!validateField(name) && !firstBad) { firstBad = field(name); }
        });
        return firstBad;
    }

    function showStatus(type, text) {
        var icon = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill';
        statusBox.innerHTML = '';
        var div = document.createElement('div');
        div.className = 'notice notice-' + (type === 'success' ? 'success' : 'danger') + ' mb-3';
        var i = document.createElement('i');
        i.className = 'bi ' + icon;
        i.setAttribute('aria-hidden', 'true');
        div.appendChild(i);
        div.appendChild(document.createTextNode(' ' + text));
        statusBox.appendChild(div);
        statusBox.focus();
        statusBox.scrollIntoView({ behavior: window.SEMC && window.SEMC.reduceMotion ? 'auto' : 'smooth', block: 'center' });
    }

    function setLoading(on) {
        submitBtn.disabled = on;
        submitBtn.querySelector('.btn-label').hidden = on;
        submitBtn.querySelector('.btn-loading').hidden = !on;
    }

    // Live validation after the user leaves a field, and re-check while fixing an error.
    Object.keys(rules).forEach(function (name) {
        var input = field(name);
        input.addEventListener('blur', function () { validateField(name); });
        input.addEventListener('input', function () {
            if (input.classList.contains('is-invalid')) { validateField(name); }
        });
    });

    if (message && counter) {
        message.addEventListener('input', function () { counter.textContent = String(message.value.length); });
    }

    form.addEventListener('submit', function (e) {
        var firstBad = validateAll();
        if (firstBad) {
            e.preventDefault();
            showStatus('error', 'Please correct the highlighted fields and try again.');
            firstBad.focus();
            return;
        }

        if (!window.fetch || !window.FormData) { return; } // fall back to a normal POST

        e.preventDefault();
        setLoading(true);

        fetch(form.getAttribute('action').split('#')[0], {
            method: 'POST',
            body: new FormData(form),
            headers: { 'X-Requested-With': 'fetch', 'Accept': 'application/json' },
            credentials: 'same-origin'
        })
        .then(function (res) {
            return res.json().then(function (data) { return { ok: res.ok, data: data }; });
        })
        .then(function (r) {
            if (r.ok && r.data && r.data.success === true) {
                form.reset();
                Object.keys(rules).forEach(function (n) { field(n).classList.remove('is-valid', 'is-invalid'); });
                if (counter) { counter.textContent = '0'; }
                if (r.data.csrf) { document.getElementById('csrfToken').value = r.data.csrf; }
                showStatus('success', r.data.message);
            } else {
                var errs = (r.data && r.data.errors) || {};
                Object.keys(rules).forEach(function (n) { setError(n, errs[n] || ''); });
                showStatus('error', (r.data && r.data.message) || 'Your message could not be sent. Please call ' + PHONE + '.');
            }
        })
        .catch(function () {
            showStatus('error', 'We could not send your message (connection problem). Please try again or call ' + PHONE + '.');
        })
        .then(function () { setLoading(false); });
    });
})();
