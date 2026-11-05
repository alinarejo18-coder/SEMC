# Samdani Emergency Medical Centre (SEMC) - Website

Official project documentation and development handover.

- **Project folder:** `C:\xampp\htdocs\SEMC`
- **Local URL:** `http://localhost/SEMC/`
- **Last updated:** 2026-11-05 (session 1)
- **Overall status:** All 7 pages built. Server-side behaviour tested with a local PHP server. **Real-browser testing (Chrome / Firefox / Edge, mobile layouts, console, animations) has NOT been done yet.**

---

## 1. Project Overview

A multipage PHP website for a 24-hour emergency medical centre in Karachi. It uses reusable PHP includes, a separate stylesheet and script per page, Bootstrap 5, AOS scroll animations and a contact form with client- and server-side validation.

Guiding rules followed: no invented services, doctors, certifications or history; anything unverified is a clearly marked placeholder or is hidden.

## 2. Business Information (supplied by client)

| Item | Value |
|---|---|
| Name | Samdani Emergency Medical Centre (SEMC) |
| Category | Emergency Care Service / Medical Centre |
| Address | Safoora Chowk, Main University Road, K.D.A Sector 34 A, Lawyers' Colony, Gulzar-e-Hijri, Karachi, Pakistan |
| Plus Code | W5R4+3F, Sector 34 A, Gulzar-e-Hijri Scheme 33, Karachi, Pakistan |
| Phone | +92 300 0267362 (`tel:+923000267362`) |
| Hours | Open 24 Hours |
| Google rating | 4.6/5 from 20 reviews |

All of these live in `includes/config.php` (single source of truth).

## 3. Technology Stack

HTML5, CSS3, vanilla JavaScript, PHP 8+ (no framework), Bootstrap 5.3.3, Bootstrap Icons 1.11.3, AOS 2.3.4, Google Fonts (Inter, Plus Jakarta Sans). Vendor libraries load from jsDelivr / Google CDNs, so an internet connection is needed to view the site as designed. MySQL is **not used** (not required; messages are stored in a file, see section 9).

## 4. Folder Structure

```
SEMC/
├── index.php  about.php  services.php  doctors.php
├── reviews.php  contact.php  emergency.php
├── includes/
│   ├── config.php     business data, services, reviews, helpers
│   ├── header.php     <head>, SEO, Open Graph, JSON-LD, opens <main>
│   ├── navbar.php     top bar + sticky navbar
│   └── footer.php     footer + scripts (closes </main>)
├── assets/
│   ├── css/   style, home, about, services, doctors, reviews, contact, emergency, responsive, animations
│   ├── js/    main, home, about, services, doctors, reviews, contact, emergency
│   ├── images/  logo-semc.svg + placeholder SVGs + README.txt (image drop-in guide)
│   └── fonts/   (empty; fonts come from Google Fonts)
├── storage/    contact-form messages (web access denied via .htaccess; git-ignored)
├── README.md
└── .gitignore
```

## 5. Pages

| Page | File | Notes |
|---|---|---|
| Home | `index.php` | Hero, 24/7 strip, intro, services overview, why choose, patient-focused panel + rating, 3 testimonials, location + map |
| About | `about.php` | Intro, mission/vision, approach, commitments, 6-tile gallery (placeholders) |
| Services | `services.php` | Cards for verified services only; expandable "How to access" |
| Doctors | `doctors.php` | No profiles supplied, so shows clearly labelled placeholder cards |
| Reviews | `reviews.php` | 4.6/5, 20 reviews, 3 supplied excerpts (no reviewer names), themes, Google button |
| Contact | `contact.php` | Details, form, embedded map |
| Emergency | `emergency.php` | Big click-to-call, address, copy buttons, directions, map, no ambulance claims |

## 6. Shared Components

`header.php` (SEO + head), `navbar.php` (top bar, sticky navbar, hamburger menu, active-page indicator, logo left, "Call Emergency" right), `footer.php` (links, services, contact, medical disclaimer, back-to-top, scripts).

## 7. CSS Files

| File | Responsibility |
|---|---|
| `style.css` | Design tokens (palette), typography, buttons, navbar, cards, forms, footer, utilities |
| `home.css` `about.css` `services.css` `doctors.css` `reviews.css` `contact.css` `emergency.css` | Styles for that page only |
| `responsive.css` | Shared mobile-first breakpoints (576/768/992/1400), mobile menu, print |
| `animations.css` | Keyframes, hero fade-in, image reveal, pulse, reduced-motion rules, no-AOS safety net |

Every page loads: `style.css` -> its own CSS -> `responsive.css` -> `animations.css`.

## 8. JavaScript Files

| File | Responsibility |
|---|---|
| `main.js` | Header shadow on scroll, close mobile menu on link click, AOS init, image-reveal observer, back-to-top, `SEMC.countUp` helper |
| `home.js` / `reviews.js` | Rating count-up (final value already in HTML) |
| `about.js` | Highlights in-page sub-nav link for the visible section |
| `services.js` | Accessible expand/collapse per service card |
| `doctors.js` | Specialisation filter (only active once real profiles exist) |
| `contact.js` | Client-side validation, fetch submission, shows the server's real result |
| `emergency.js` | Copy phone number / address buttons |

Each page loads only `main.js` plus its own script.

## 9. PHP Architecture

- Each page sets a `$page` array (key, title, description, keywords, css, schema) then includes `header.php` ... `footer.php`.
- `config.php` exposes constants and helpers: `e()`, `page_url()`, `asset()` (cache-busting), `img_src()` (uses a real photo if present, else a placeholder), `phone_tel()`, `maps_directions_url()`, `maps_embed_url()`, `reviews_url()`, `active_services()`.
- Works in any folder; `BASE_URL` is detected automatically.
- **Contact form** (`contact.php`): session CSRF token, hidden honeypot field, 20-second resend limit, server-side validation, control-character stripping, output escaping. A message is saved to `storage/messages/messages.jsonl`. **"Success" is returned only if that write succeeded**; otherwise an error with the phone number is shown. If `CONTACT_MAIL_TO` is set, an email copy is also attempted (best effort; success never depends on it, because XAMPP's `mail()` is not configured by default).

## 10. Implemented Features

Navigation (sticky, hamburger, active state) - click-to-call links - Google Maps directions and embed (no API key needed) - contact form with validation - copy-to-clipboard - rating count-up - service toggles - image-drop-in system - LocalBusiness JSON-LD (home page) - Open Graph tags - unique titles/descriptions - skip link, ARIA labels, focus styles.

## 11. Animations

Hero fade-in (CSS), AOS scroll reveal, card/button hover, image clip reveal, navbar shadow transition, pulse indicator, smooth scrolling. All disabled under `prefers-reduced-motion`. If AOS fails to load, `animations.css` keeps all content visible.

## 12. Responsive Design

Mobile-first with Bootstrap grid plus `responsive.css`. Written for 320px to 1400px+ with 44px touch targets and no fixed widths. **Not yet visually verified on real devices/browsers.**

## 13. SEO

Unique `<title>` and meta description per page, semantic HTML5 landmarks, single H1 per page, alt text on images, Open Graph, Karachi/Gulzar-e-Hijri keywords, `LocalBusiness` (`MedicalBusiness`) JSON-LD on the home page with verified data only, lazy-loaded images and iframes.

## 14. Status Checklist

Legend: `[x]` completed and tested - `[~]` implemented, not fully tested - `[ ]` not started - `[!]` needs attention

- [x] Project structure, includes, config
- [x] All 7 PHP files lint clean and return HTTP 200 (tested with PHP 8.3 built-in server)
- [x] Every local link / CSS / JS / image URL resolves (29 URLs checked, 0 broken)
- [x] Each page loads its own CSS, and `tel:+923000267362` is present on every page
- [x] Contact form server logic: invalid input -> 422 with field errors; bad CSRF -> 400; honeypot -> 400; valid -> 200 and stored; resend within 20 s -> 429; unwritable storage -> 500 with NO success message
- [~] Visual design on all pages
- [~] Mobile navigation / hamburger
- [~] Contact form client-side validation + fetch UX
- [~] Animations, AOS, image reveal, reduced-motion
- [~] Responsive layouts (all breakpoints)
- [~] Embedded Google Maps / directions links
- [~] Copy buttons, service toggles, about sub-nav highlighting
- [~] Structured data (not yet run through Google's Rich Results test)
- [ ] Real photography (hero, about, gallery, doctors)
- [ ] Official logo
- [ ] Open Graph image
- [ ] Self-hosted/optimised assets (optional)
- [!] Browser testing in Chrome, Firefox, Edge
- [!] Console-error check

## 15. Pending Tasks

1. Open the site in Chrome, Firefox and Edge; check console, mobile emulation (320 / 375 / 768 / 1024 / 1440), hamburger menu, animations.
2. Replace placeholders (section 18).
3. Run Lighthouse; compress any photos you add.
4. Test that email delivery works if `CONTACT_MAIL_TO` is configured.

## 16. Known Issues

- No real browser has been used yet, so visual or JS issues may exist that server-side tests cannot catch.
- Photos are SVG placeholders, so the site looks less "premium" until real images are added.
- `mail()` does nothing on a default XAMPP; messages are kept in `storage/messages/messages.jsonl` instead and must be checked manually (there is no admin screen yet).
- The embedded map and "Get Directions" use the written address; the Plus Code is shown as text. Verify the pin lands on the correct building.
- An alert red (`#D32F3F`) is used only for emergency call buttons; it is outside the six-colour palette you specified, by design for urgency. Easy to change in `style.css` (`--semc-alert`).

## 17. Testing Status

| Area | Status |
|---|---|
| PHP syntax | Passed (`php -l` on all files) |
| HTTP 200 on all pages, no PHP warnings | Passed (curl) |
| Links and assets | Passed (29/29) |
| Contact form back-end | Passed (see checklist) |
| Chrome / Firefox / Edge | **Not tested** |
| Mobile responsiveness | **Not tested visually** |
| Console errors | **Not checked** |
| Animations | **Not checked visually** |

## 18. Information Awaiting Confirmation

| Item | Where | Current handling |
|---|---|---|
| Google reviews link | `GOOGLE_REVIEWS_URL` in `config.php` | Empty -> button opens SEMC on Google Maps. Paste the real link when available. |
| Diagnostic Testing, X-Ray, Nursing Support | `$SERVICES` in `config.php` | Shown as active because the supplied patient review mentions them. **Confirm with SEMC**; set `'verified' => false` to hide. |
| General Medical Consultation, Patient Assessment | `$SERVICES` | **Hidden** (unconfirmed). Set `'verified' => true` once confirmed. |
| Doctor profiles (names, qualifications, specialisation, experience, photos) | `$DOCTORS` in `config.php` | Empty -> labelled placeholder cards. Add real entries to replace. |
| Mission & Vision wording | `about.php` | Draft derived from the supplied description. Confirm or edit. |
| "Our commitments" wording | `about.php` | Values only; no certifications claimed. Confirm. |
| Official logo | `assets/images/logo-semc.svg` | Placeholder. Replace, then set `LOGO_IS_PLACEHOLDER` to `false`. |
| Photos | `assets/images/` (see its README.txt) | SVG placeholders. |
| Ambulance, pharmacy, ICU, labs, insurance, etc. | - | **Not mentioned anywhere**, because none are confirmed. |
| Public domain URL | `SITE_PUBLIC_URL` | Empty -> no canonical / `og:url`. Set before launch. |
| Contact inbox for emails | `CONTACT_MAIL_TO` | Empty -> messages stored only. |
| Open Graph image | `header.php` | Needs a 1200x630 PNG/JPG. |
| Google rating in structured data | `header.php` | Uses the supplied 4.6 / 20. Update if it changes. |

## 19. Installation

1. Install XAMPP (PHP 8.0+).
2. Extract this project so the files are in `C:\xampp\htdocs\SEMC` (e.g. `C:\xampp\htdocs\SEMC\index.php`).

## 20. XAMPP Setup

1. Open XAMPP Control Panel and **Start Apache** (MySQL is not required).
2. Make sure the `storage` folder is writable (default on Windows).
3. Optional email: configure `sendmail` in `php.ini`, then set `CONTACT_MAIL_TO`.

## 21. Run Locally

Visit **http://localhost/SEMC/**. Test the form on `/contact.php`, then read saved messages in `C:\xampp\htdocs\SEMC\storage\messages\messages.jsonl`.

Quick alternative without Apache: `php -S localhost:8000` inside the project folder, then open `http://localhost:8000/`.

## 22. How to Continue Development

1. Do the browser QA in section 15 and update the `[~]` items to `[x]` only after testing.
2. Add confirmed content in `includes/config.php` (services, doctors, URLs) - pages update automatically.
3. Drop real photos into `assets/images/` using the filenames in its `README.txt`.
4. Optional next features: simple admin page to read messages (behind a login), email delivery via SMTP (PHPMailer), self-hosted fonts/libraries, a sitemap.xml and robots.txt.

### Files created in session 1

All files listed in section 4. No files have been modified since creation except `README.md` (rewritten at the end of the session).
