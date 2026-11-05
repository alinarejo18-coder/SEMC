<?php
/**
 * Shared <head> + opening <body> + navbar.
 *
 * Expects $page (array) defined by the including page:
 *   key, title, description, keywords, css (page stylesheet name), schema (bool)
 */
require_once __DIR__ . '/config.php';

$page = $page ?? [];
$pageKey   = $page['key'] ?? 'home';
$pageTitle = $page['title'] ?? SITE_NAME;
$pageDesc  = $page['description'] ?? SITE_TAGLINE;
$pageKeys  = $page['keywords'] ?? 'emergency medical centre Karachi, 24 hour medical centre Karachi';
$pageCss   = $page['css'] ?? $pageKey;
$pageFile  = $page['file'] ?? 'index.php';
$canonical = canonical_url($pageFile);
$fullTitle = $pageKey === 'home' ? $pageTitle : $pageTitle . ' | ' . SITE_SHORT;
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($fullTitle) ?></title>
    <meta name="description" content="<?= e($pageDesc) ?>">
    <meta name="keywords" content="<?= e($pageKeys) ?>">
    <meta name="theme-color" content="#0878B9">
<?php if ($canonical): ?>
    <link rel="canonical" href="<?= e($canonical) ?>">
<?php endif; ?>

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= e(SITE_NAME) ?>">
    <meta property="og:title" content="<?= e($fullTitle) ?>">
    <meta property="og:description" content="<?= e($pageDesc) ?>">
    <meta property="og:locale" content="en_PK">
<?php if ($canonical): ?>
    <meta property="og:url" content="<?= e($canonical) ?>">
<?php endif; ?>
    <?php /* TODO(CLIENT): add og:image once an official PNG/JPG (1200x630) is available. */ ?>
    <meta name="twitter:card" content="summary">

    <link rel="icon" type="image/svg+xml" href="<?= e(asset('images/logo-semc.svg')) ?>">

    <!-- Fonts & vendor CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Site CSS: global -> page -> responsive -> animations -->
    <link href="<?= e(asset('css/style.css')) ?>" rel="stylesheet">
    <link href="<?= e(asset('css/' . $pageCss . '.css')) ?>" rel="stylesheet">
    <link href="<?= e(asset('css/responsive.css')) ?>" rel="stylesheet">
    <link href="<?= e(asset('css/animations.css')) ?>" rel="stylesheet">

    <script>document.documentElement.className = 'js';</script>

<?php if (!empty($page['schema'])): ?>
    <!-- LocalBusiness structured data (verified information only) -->
    <script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'MedicalBusiness',
    'name' => SITE_NAME,
    'alternateName' => SITE_SHORT,
    'description' => 'Emergency care service and medical centre in Karachi, Pakistan.',
    'telephone' => SITE_PHONE_TEL,
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => "Safoora Chowk, Main University Road, K.D.A Sector 34 A, Lawyers' Colony, Gulzar-e-Hijri",
        'addressLocality' => 'Karachi',
        'addressCountry' => 'PK',
    ],
    'openingHoursSpecification' => [[
        '@type' => 'OpeningHoursSpecification',
        'dayOfWeek' => ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'],
        'opens' => '00:00',
        'closes' => '23:59',
    ]],
    'aggregateRating' => [
        '@type' => 'AggregateRating',
        'ratingValue' => SITE_RATING,
        'bestRating' => '5',
        'reviewCount' => SITE_REVIEW_COUNT,
    ],
    'hasMap' => maps_view_url(),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>

    </script>
<?php endif; ?>
</head>
<body class="page-<?= e($pageKey) ?>">
<a class="skip-link" href="#main">Skip to main content</a>
<?php include __DIR__ . '/navbar.php'; ?>
<main id="main">
