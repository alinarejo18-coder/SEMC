<?php
$page = [
    'key' => 'services',
    'file' => 'services.php',
    'title' => 'Medical Services',
    'description' => 'Medical services at Samdani Emergency Medical Centre, Karachi: emergency medical care, diagnostic testing, X-ray services and nursing support. Open 24 hours.',
    'keywords' => 'emergency medical care Karachi, X-ray Karachi, diagnostic tests Gulzar-e-Hijri, nursing support, 24 hour medical centre Karachi',
    'css' => 'services',
];
include __DIR__ . '/includes/header.php';
$services = active_services();
?>

<section class="page-hero" aria-labelledby="page-title">
    <div class="container">
        <nav class="breadcrumb-semc" aria-label="Breadcrumb"><a href="<?= e(page_url('index.php')) ?>">Home</a><span aria-hidden="true">/</span>Services</nav>
        <h1 id="page-title" class="anim-fade-up">Our Medical Services</h1>
        <p class="anim-fade-up anim-delay-1">Care and support for patients at Samdani Emergency Medical Centre, available around the clock.</p>
    </div>
</section>

<section class="section" aria-labelledby="svc-title">
    <div class="container">
        <div class="section-head" data-aos="fade-up">
            <span class="eyebrow">What we offer</span>
            <h2 id="svc-title">Services at SEMC</h2>
            <p>Please call <a href="<?= e(phone_tel()) ?>"><?= e(SITE_PHONE_DISPLAY) ?></a> to confirm that a particular service is available before you travel.</p>
        </div>

        <?php /* Unverified services (verified => false in config.php) are intentionally NOT rendered. */ ?>
        <div class="row g-4">
            <?php foreach ($services as $i => $s): $id = 'svc-detail-' . $i; ?>
                <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 90 ?>">
                    <article class="card-semc service-card">
                        <span class="icon-box <?= $i % 2 ? 'green' : '' ?>"><i class="bi <?= e($s['icon']) ?>" aria-hidden="true"></i></span>
                        <h3><?= e($s['title']) ?></h3>
                        <p><?= e($s['desc']) ?></p>
                        <button class="service-toggle" type="button" aria-expanded="false" aria-controls="<?= $id ?>">
                            <span class="toggle-label">How to access</span> <i class="bi bi-chevron-down" aria-hidden="true"></i>
                        </button>
                        <div class="service-detail" id="<?= $id ?>" hidden>
                            <p>Call <a href="<?= e(phone_tel()) ?>"><?= e(SITE_PHONE_DISPLAY) ?></a> or visit us at Safoora Chowk, Main University Road. The medical team will advise on what is appropriate for your situation.</p>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="notice notice-info mt-5" data-aos="fade-up">
            <i class="bi bi-info-circle" aria-hidden="true"></i>
            Services, availability and timings may change. For the latest information, please contact the centre directly. This page is general information and not medical advice.
        </div>
    </div>
</section>

<section class="section section-light" aria-labelledby="visit-title">
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-lg-7" data-aos="fade-right">
                <span class="eyebrow">Before you visit</span>
                <h2 id="visit-title" class="mb-3">What to bring</h2>
                <ul class="list-check mb-0">
                    <li>Any previous medical reports, prescriptions or X-rays related to the current problem</li>
                    <li>A list of medicines the patient is currently taking</li>
                    <li>A family member or friend who can help with information about the patient</li>
                </ul>
            </div>
            <div class="col-lg-5" data-aos="fade-left">
                <div class="cta-band text-start">
                    <h2 class="h3">Need urgent help?</h2>
                    <p class="mx-0 mb-3">Call us now. We are open 24 hours.</p>
                    <a class="btn btn-semc btn-semc-emergency" href="<?= e(phone_tel()) ?>"><i class="bi bi-telephone-fill" aria-hidden="true"></i> Call Emergency</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
