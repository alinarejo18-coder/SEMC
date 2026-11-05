<?php
/**
 * SEMC - Global configuration, data and helper functions.
 *
 * Every page includes this file first. Nothing here prints output.
 * All business facts live in this file so they can be corrected in one place.
 */
declare(strict_types=1);

date_default_timezone_set('Asia/Karachi');

/* ------------------------------------------------------------------
 * Base URL (works at http://localhost/SEMC/ or in any sub-folder)
 * ------------------------------------------------------------------ */
$__dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
define('BASE_URL', ($__dir === '/' || $__dir === '.') ? '' : rtrim($__dir, '/'));
define('ROOT_PATH', dirname(__DIR__));

/* ------------------------------------------------------------------
 * Verified business information (supplied by the client)
 * ------------------------------------------------------------------ */
define('SITE_NAME', 'Samdani Emergency Medical Centre');
define('SITE_SHORT', 'SEMC');
define('SITE_TAGLINE', 'Your Health, Our Priority. Care When You Need It Most.');
define('SITE_CATEGORY', 'Emergency Care Service / Medical Centre');
define('SITE_ADDRESS', "Safoora Chowk, Main University Road, K.D.A Sector 34 A, Lawyers' Colony, Gulzar-e-Hijri, Karachi, Pakistan");
define('SITE_ADDRESS_SHORT', 'Safoora Chowk, Main University Road, Gulzar-e-Hijri, Karachi');
define('SITE_PLUS_CODE', 'W5R4+3F, Sector 34 A, Gulzar-e-Hijri Scheme 33, Karachi, Pakistan');
define('SITE_PHONE_DISPLAY', '+92 300 0267362');
define('SITE_PHONE_TEL', '+923000267362');
define('SITE_HOURS', 'Open 24 Hours');
define('SITE_RATING', '4.6');
define('SITE_REVIEW_COUNT', 20);

/* ------------------------------------------------------------------
 * Items awaiting client confirmation (see README section 18)
 * ------------------------------------------------------------------ */
// TODO(CLIENT): replace with the real Google reviews link when available.
// While empty, the button falls back to a Google Maps search for the centre.
define('GOOGLE_REVIEWS_URL', '');

// TODO(CLIENT): inbox that should also receive contact-form emails.
// Leave empty to only store messages in /storage/messages/ (default).
define('CONTACT_MAIL_TO', '');

// TODO(CLIENT): public site URL (used for canonical/Open Graph). e.g. https://www.example.com
define('SITE_PUBLIC_URL', '');

// Set false once the SEMC logo file is placed at assets/images/logo-semc.svg (or .png)
define('LOGO_IS_PLACEHOLDER', true);

/* ------------------------------------------------------------------
 * Navigation
 * ------------------------------------------------------------------ */
$NAV_ITEMS = [
    'home'      => ['label' => 'Home',      'file' => 'index.php'],
    'about'     => ['label' => 'About Us',  'file' => 'about.php'],
    'services'  => ['label' => 'Services',  'file' => 'services.php'],
    'doctors'   => ['label' => 'Doctors',   'file' => 'doctors.php'],
    'reviews'   => ['label' => 'Reviews',   'file' => 'reviews.php'],
    'emergency' => ['label' => 'Emergency', 'file' => 'emergency.php'],
    'contact'   => ['label' => 'Contact Us','file' => 'contact.php'],
];

/* ------------------------------------------------------------------
 * Services. Only entries with 'verified' => true are shown publicly.
 * Flip a flag to true once SEMC confirms the service.
 * ------------------------------------------------------------------ */
$SERVICES = [
    [
        'icon' => 'bi-heart-pulse', 'title' => 'Emergency Medical Care',
        'desc' => 'Medical assistance for patients who need urgent attention, available around the clock.',
        'verified' => true, 'basis' => 'Business category + 24-hour opening hours',
    ],
    [
        'icon' => 'bi-clipboard2-pulse', 'title' => 'Diagnostic Testing',
        'desc' => 'Test services that help guide diagnosis and treatment decisions.',
        'verified' => true, 'basis' => 'Mentioned in supplied patient review',
    ],
    [
        'icon' => 'bi-file-earmark-medical', 'title' => 'X-Ray Services',
        'desc' => 'X-ray imaging to support patient assessment and care.',
        'verified' => true, 'basis' => 'Mentioned in supplied patient review',
    ],
    [
        'icon' => 'bi-person-heart', 'title' => 'Nursing Support',
        'desc' => 'Caring nursing staff supporting patients throughout their visit.',
        'verified' => true, 'basis' => 'Mentioned in supplied patient review',
    ],
    [
        'icon' => 'bi-stethoscope', 'title' => 'General Medical Consultation',
        'desc' => 'Consultation with a doctor for general health concerns.',
        'verified' => false, 'basis' => 'AWAITING CONFIRMATION',
    ],
    [
        'icon' => 'bi-clipboard2-check', 'title' => 'Patient Assessment',
        'desc' => 'Initial evaluation of a patient\'s condition.',
        'verified' => false, 'basis' => 'AWAITING CONFIRMATION',
    ],
];

/* ------------------------------------------------------------------
 * Doctors. Leave empty until real, approved profiles are supplied.
 * Each: ['name','role','qualifications','specialization','experience','photo']
 * ------------------------------------------------------------------ */
$DOCTORS = [];

/* ------------------------------------------------------------------
 * Supplied patient review excerpts (no reviewer identities supplied)
 * ------------------------------------------------------------------ */
$REVIEWS = [
    ['text' => 'The hospital is very neat and clean, providing test services and X-rays etc. Nursing staff is much caring and helping.', 'theme' => 'Cleanliness & nursing care', 'icon' => 'bi-stars'],
    ['text' => 'Dr Samdani such a humble person. He treated my Dad so politely.', 'theme' => 'Respectful treatment', 'icon' => 'bi-emoji-smile'],
    ['text' => 'The doctors were knowledgeable, kind, and took the time to explain everything clearly.', 'theme' => 'Clear communication', 'icon' => 'bi-chat-heart'],
];

/* ------------------------------------------------------------------
 * Helpers
 * ------------------------------------------------------------------ */

/** HTML-escape. */
function e(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** URL of an internal page, e.g. page_url('about.php'). */
function page_url(string $file = 'index.php'): string
{
    return BASE_URL . '/' . ltrim($file, '/');
}

/** URL of an asset with a cache-busting timestamp. */
function asset(string $path): string
{
    $path = ltrim($path, '/');
    $full = ROOT_PATH . '/assets/' . $path;
    $v = is_file($full) ? '?v=' . filemtime($full) : '';
    return BASE_URL . '/assets/' . $path . $v;
}

/**
 * Use a real photo if one has been dropped into assets/images/,
 * otherwise fall back to a placeholder illustration.
 */
function img_src(string $realFile, string $fallback = 'placeholder-photo.svg'): string
{
    return is_file(ROOT_PATH . '/assets/images/' . $realFile)
        ? asset('images/' . $realFile)
        : asset('images/' . $fallback);
}

function has_img(string $realFile): bool
{
    return is_file(ROOT_PATH . '/assets/images/' . $realFile);
}

function phone_tel(): string
{
    return 'tel:' . SITE_PHONE_TEL;
}

function maps_directions_url(): string
{
    return 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode(SITE_ADDRESS);
}

function maps_embed_url(): string
{
    return 'https://www.google.com/maps?q=' . rawurlencode(SITE_ADDRESS) . '&output=embed';
}

function maps_view_url(): string
{
    return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode(SITE_NAME . ', ' . SITE_ADDRESS);
}

function reviews_url(): string
{
    return GOOGLE_REVIEWS_URL !== '' ? GOOGLE_REVIEWS_URL : maps_view_url();
}

/** Services to display publicly. */
function active_services(): array
{
    global $SERVICES;
    return array_values(array_filter($SERVICES, static fn($s) => !empty($s['verified'])));
}

/** Absolute canonical URL, only if SITE_PUBLIC_URL is configured. */
function canonical_url(string $file): string
{
    if (SITE_PUBLIC_URL === '') {
        return '';
    }
    return rtrim(SITE_PUBLIC_URL, '/') . ($file === 'index.php' ? '/' : '/' . $file);
}
