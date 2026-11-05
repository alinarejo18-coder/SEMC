<?php
$page = [
    'key' => 'emergency',
    'file' => 'emergency.php',
    'title' => 'Emergency Care - Call 24 Hours',
    'description' => 'Emergency medical assistance in Karachi. Samdani Emergency Medical Centre is open 24 hours. Call +92 300 0267362 or get directions to Safoora Chowk, Main University Road.',
    'keywords' => 'emergency Karachi, 24 hour emergency medical centre, emergency care Gulzar-e-Hijri, emergency University Road Karachi, emergency phone number',
    'css' => 'emergency',
];
include __DIR__ . '/includes/header.php';
?>

<section class="emergency-hero" aria-labelledby="page-title">
    <div class="container">
        <nav class="breadcrumb-semc" aria-label="Breadcrumb"><a href="<?= e(page_url('index.php')) ?>">Home</a><span aria-hidden="true">/</span>Emergency</nav>
        <div class="row align-items-center gy-4">
            <div class="col-lg-7">
                <span class="open-badge anim-fade-up"><span class="pulse-dot green" aria-hidden="true"></span> <?= e(SITE_HOURS) ?></span>
                <h1 id="page-title" class="anim-fade-up anim-delay-1">Need medical help now?</h1>
                <p class="lead anim-fade-up anim-delay-2">Call Samdani Emergency Medical Centre. We are open 24 hours, every day.</p>
                <a class="call-big anim-fade-up anim-delay-3" href="<?= e(phone_tel()) ?>" id="callBig" aria-label="Call <?= e(SITE_PHONE_DISPLAY) ?> now">
                    <span class="call-icon"><i class="bi bi-telephone-fill" aria-hidden="true"></i></span>
                    <span class="call-text"><small>Tap to call</small><strong><?= e(SITE_PHONE_DISPLAY) ?></strong></span>
                </a>
            </div>
            <div class="col-lg-5">
                <div class="warn-card anim-fade-in anim-delay-2" role="note">
                    <h2 class="h5"><i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i> In a life-threatening emergency</h2>
                    <p class="mb-0">Call immediately. Do not wait to fill in a form or send a message. If you cannot reach us, contact your local emergency services or go to the nearest emergency facility.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section" aria-labelledby="info-title">
    <div class="container">
        <div class="section-head" data-aos="fade-up">
            <span class="eyebrow">Emergency contact information</span>
            <h2 id="info-title">How to reach us</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up">
                <article class="card-semc text-center">
                    <span class="icon-box"><i class="bi bi-telephone-fill" aria-hidden="true"></i></span>
                    <h3>Phone</h3>
                    <p><a class="fw-semibold fs-5" href="<?= e(phone_tel()) ?>"><?= e(SITE_PHONE_DISPLAY) ?></a></p>
                    <button type="button" class="btn btn-semc btn-semc-outline btn-sm" data-copy="<?= e(SITE_PHONE_DISPLAY) ?>" data-copy-label="Copy number">
                        <i class="bi bi-clipboard" aria-hidden="true"></i> <span>Copy number</span>
                    </button>
                </article>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <article class="card-semc text-center">
                    <span class="icon-box green"><i class="bi bi-clock-fill" aria-hidden="true"></i></span>
                    <h3>Availability</h3>
                    <p class="mb-1"><strong><?= e(SITE_HOURS) ?></strong></p>
                    <p class="text-muted-semc mb-0">Every day of the week</p>
                </article>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <article class="card-semc text-center">
                    <span class="icon-box"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i></span>
                    <h3>Address</h3>
                    <p class="small"><?= e(SITE_ADDRESS) ?></p>
                    <button type="button" class="btn btn-semc btn-semc-outline btn-sm" data-copy="<?= e(SITE_ADDRESS) ?>" data-copy-label="Copy address">
                        <i class="bi bi-clipboard" aria-hidden="true"></i> <span>Copy address</span>
                    </button>
                </article>
            </div>
        </div>
    </div>
</section>

<section class="section section-light pt-5" aria-labelledby="dir-title">
    <div class="container">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-5" data-aos="fade-right">
                <span class="eyebrow">Directions</span>
                <h2 id="dir-title" class="mb-3">Getting to SEMC</h2>
                <p>We are at Safoora Chowk on Main University Road, in K.D.A Sector 34 A, Gulzar-e-Hijri, Karachi.</p>
                <p class="small text-muted-semc">Plus Code: <?= e(SITE_PLUS_CODE) ?></p>
                <div class="d-flex flex-column gap-3 mt-3">
                    <a class="btn btn-semc btn-lg" href="<?= e(maps_directions_url()) ?>" target="_blank" rel="noopener"><i class="bi bi-signpost-split" aria-hidden="true"></i> Get Directions in Google Maps</a>
                    <a class="btn btn-semc btn-semc-emergency btn-lg" href="<?= e(phone_tel()) ?>"><i class="bi bi-telephone-fill" aria-hidden="true"></i> Call Emergency</a>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <div class="map-frame">
                    <iframe title="Map showing Samdani Emergency Medical Centre, Karachi" src="<?= e(maps_embed_url()) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                </div>
            </div>
        </div>

        <div class="notice notice-info mt-4" data-aos="fade-up">
            <i class="bi bi-info-circle" aria-hidden="true"></i>
            Please call ahead if you need to confirm a specific service or facility. For non-urgent questions, use the <a href="<?= e(page_url('contact.php')) ?>">contact form</a>.
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
