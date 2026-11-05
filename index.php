<?php
$page = [
    'key' => 'home',
    'file' => 'index.php',
    'title' => 'Samdani Emergency Medical Centre (SEMC) - 24-Hour Medical Care in Karachi',
    'description' => 'Samdani Emergency Medical Centre in Gulzar-e-Hijri, Karachi is open 24 hours. Call +92 300 0267362 for emergency medical assistance and patient care.',
    'keywords' => 'emergency medical centre Karachi, 24 hour hospital Karachi, medical centre Gulzar-e-Hijri, emergency care University Road Karachi, SEMC Karachi',
    'css' => 'home',
    'schema' => true,
];
include __DIR__ . '/includes/header.php';
global $REVIEWS;
$services = active_services();
?>

<!-- HERO -->
<section class="hero" aria-labelledby="hero-title">
    <div class="container">
        <div class="row align-items-center gy-5">
            <div class="col-lg-6">
                <span class="hero-badge anim-fade-up"><span class="pulse-dot green" aria-hidden="true"></span> <?= e(SITE_HOURS) ?> &middot; Karachi</span>
                <h1 id="hero-title" class="anim-fade-up anim-delay-1">Compassionate Healthcare. Emergency Care Around the Clock.</h1>
                <p class="hero-lead anim-fade-up anim-delay-2">Samdani Emergency Medical Centre is committed to providing accessible medical care and support to patients in Karachi.</p>
                <div class="d-flex flex-column flex-sm-row gap-3 anim-fade-up anim-delay-3">
                    <a class="btn btn-semc btn-semc-emergency btn-lg" href="<?= e(phone_tel()) ?>"><i class="bi bi-telephone-fill" aria-hidden="true"></i> Call Emergency</a>
                    <a class="btn btn-semc btn-semc-outline btn-lg" href="<?= e(maps_directions_url()) ?>" target="_blank" rel="noopener"><i class="bi bi-signpost-split" aria-hidden="true"></i> Get Directions</a>
                </div>
                <p class="hero-note anim-fade-up anim-delay-4"><a href="<?= e(page_url('contact.php')) ?>"><i class="bi bi-envelope" aria-hidden="true"></i> Send us a message</a> &nbsp;&middot;&nbsp; <?= e(SITE_PHONE_DISPLAY) ?></p>
            </div>
            <div class="col-lg-6">
                <div class="hero-media anim-fade-in anim-delay-2">
                    <img class="float-soft" src="<?= e(img_src('hero.jpg', 'placeholder-hero.svg')) ?>"
                         alt="<?= has_img('hero.jpg') ? 'Samdani Emergency Medical Centre' : 'Healthcare illustration (placeholder for official SEMC photo)' ?>"
                         width="640" height="560" fetchpriority="high">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 24/7 STRIP -->
<section class="availability" aria-label="Availability">
    <div class="container">
        <div class="availability-card" data-aos="fade-up">
            <div class="avail-item"><i class="bi bi-clock-history" aria-hidden="true"></i><div><strong>Open 24 Hours</strong><span>Care is available day and night</span></div></div>
            <div class="avail-item"><i class="bi bi-telephone-inbound" aria-hidden="true"></i><div><strong><a href="<?= e(phone_tel()) ?>"><?= e(SITE_PHONE_DISPLAY) ?></a></strong><span>Tap to call from your phone</span></div></div>
            <div class="avail-item"><i class="bi bi-geo-alt" aria-hidden="true"></i><div><strong>Main University Road</strong><span>Safoora Chowk, Gulzar-e-Hijri</span></div></div>
        </div>
    </div>
</section>

<!-- INTRO -->
<section class="section" aria-labelledby="intro-title">
    <div class="container">
        <div class="row align-items-center gy-5">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="img-reveal shadow-semc">
                    <img src="<?= e(img_src('about.jpg')) ?>" alt="<?= has_img('about.jpg') ? 'Samdani Emergency Medical Centre' : 'Photo placeholder - official SEMC image to be added' ?>" width="800" height="600" loading="lazy">
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <span class="eyebrow">About the centre</span>
                <h2 id="intro-title" class="mb-3">A medical centre you can reach at any hour</h2>
                <p>Samdani Emergency Medical Centre (SEMC) is an emergency care service and medical centre serving patients in Karachi from Safoora Chowk on Main University Road, in the Gulzar-e-Hijri area.</p>
                <p>Our centre is open around the clock, so patients and families have a place to turn to when care cannot wait. We aim to combine prompt attention with respectful, clear communication.</p>
                <a class="btn btn-semc btn-semc-outline mt-2" href="<?= e(page_url('about.php')) ?>">Learn more about SEMC <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES OVERVIEW -->
<section class="section section-light" aria-labelledby="services-title">
    <div class="container">
        <div class="section-head" data-aos="fade-up">
            <span class="eyebrow">Our services</span>
            <h2 id="services-title">Medical services overview</h2>
            <p>An overview of the care available at SEMC. Please call us if you need to confirm a specific service before you visit.</p>
        </div>
        <div class="row g-4">
            <?php foreach ($services as $i => $s): ?>
                <div class="col-12 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?= $i * 80 ?>">
                    <article class="card-semc">
                        <span class="icon-box"><i class="bi <?= e($s['icon']) ?>" aria-hidden="true"></i></span>
                        <h3><?= e($s['title']) ?></h3>
                        <p><?= e($s['desc']) ?></p>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4" data-aos="fade-up">
            <a class="btn btn-semc" href="<?= e(page_url('services.php')) ?>">View all services</a>
        </div>
    </div>
</section>

<!-- WHY CHOOSE -->
<section class="section" aria-labelledby="why-title">
    <div class="container">
        <div class="section-head" data-aos="fade-up">
            <span class="eyebrow">Why choose SEMC</span>
            <h2 id="why-title">What patients can expect</h2>
        </div>
        <div class="row g-4">
            <?php
            $why = [
                ['bi-clock', 'Open around the clock', 'The centre is open 24 hours, every day, for patients who need care at any time.', ''],
                ['bi-heart', 'Caring staff', 'Patients have described the nursing staff as caring and helpful in their Google reviews.', 'green'],
                ['bi-stars', 'Clean environment', 'Cleanliness is one of the things patients mention most positively in their feedback.', ''],
                ['bi-chat-heart', 'Clear communication', 'Reviewers say the doctors take time to explain things clearly and treat families politely.', 'green'],
            ];
            foreach ($why as $i => $w): ?>
                <div class="col-12 col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?= $i * 80 ?>">
                    <div class="why-item">
                        <span class="icon-box <?= $w[3] ?>"><i class="bi <?= $w[0] ?>" aria-hidden="true"></i></span>
                        <h3><?= e($w[1]) ?></h3>
                        <p><?= e($w[2]) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- PATIENT FOCUSED -->
<section class="section section-light" aria-labelledby="patient-title">
    <div class="container">
        <div class="patient-panel" data-aos="fade-up">
            <div class="row align-items-center gy-4">
                <div class="col-lg-7">
                    <span class="eyebrow">Patient-focused healthcare</span>
                    <h2 id="patient-title" class="mb-3">Care that starts with listening</h2>
                    <p>Every patient arrives with their own worries. We aim to treat patients and their families with courtesy, explain what is happening in plain language, and keep the focus on the person in front of us.</p>
                    <ul class="list-check mb-0">
                        <li>Respectful, polite treatment of patients and families</li>
                        <li>Clear explanations from the medical team</li>
                        <li>A clean, well-kept environment</li>
                    </ul>
                </div>
                <div class="col-lg-5 text-center">
                    <div class="rating-card">
                        <div class="rating-big"><span id="ratingNumber" data-value="<?= e(SITE_RATING) ?>"><?= e(SITE_RATING) ?></span><small>/5</small></div>
                        <div class="stars" aria-hidden="true"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i></div>
                        <p class="mb-3">Google rating from <?= (int)SITE_REVIEW_COUNT ?> reviews</p>
                        <a class="btn btn-semc btn-semc-green btn-sm" href="<?= e(page_url('reviews.php')) ?>">Read patient feedback</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIALS -->
<section class="section" aria-labelledby="testi-title">
    <div class="container">
        <div class="section-head" data-aos="fade-up">
            <span class="eyebrow">Patient testimonials</span>
            <h2 id="testi-title">In patients' own words</h2>
            <p>Selected excerpts from Google reviews.</p>
        </div>
        <div class="row g-4">
            <?php foreach ($REVIEWS as $i => $r): ?>
                <div class="col-12 col-lg-4" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                    <figure class="card-semc review-card mb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="quote-mark" aria-hidden="true"><i class="bi bi-quote"></i></span>
                            <span class="stars" aria-hidden="true"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></span>
                        </div>
                        <blockquote>&ldquo;<?= e($r['text']) ?>&rdquo;</blockquote>
                        <figcaption><i class="bi bi-google" aria-hidden="true"></i> Google review excerpt</figcaption>
                    </figure>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4" data-aos="fade-up">
            <a class="btn btn-semc btn-semc-outline" href="<?= e(page_url('reviews.php')) ?>">See all feedback</a>
        </div>
    </div>
</section>

<!-- LOCATION -->
<section class="section section-light" aria-labelledby="loc-title">
    <div class="container">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-5" data-aos="fade-right">
                <span class="eyebrow">Location &amp; directions</span>
                <h2 id="loc-title" class="mb-3">Find us on Main University Road</h2>
                <ul class="list-unstyled location-list">
                    <li><i class="bi bi-geo-alt-fill" aria-hidden="true"></i><span><?= e(SITE_ADDRESS) ?></span></li>
                    <li><i class="bi bi-qr-code" aria-hidden="true"></i><span>Plus Code: <?= e(SITE_PLUS_CODE) ?></span></li>
                    <li><i class="bi bi-telephone-fill" aria-hidden="true"></i><a href="<?= e(phone_tel()) ?>"><?= e(SITE_PHONE_DISPLAY) ?></a></li>
                    <li><i class="bi bi-clock-fill" aria-hidden="true"></i><span><?= e(SITE_HOURS) ?></span></li>
                </ul>
                <div class="d-flex flex-column flex-sm-row gap-3">
                    <a class="btn btn-semc" href="<?= e(maps_directions_url()) ?>" target="_blank" rel="noopener"><i class="bi bi-signpost-split" aria-hidden="true"></i> Get Directions</a>
                    <a class="btn btn-semc btn-semc-emergency" href="<?= e(phone_tel()) ?>"><i class="bi bi-telephone-fill" aria-hidden="true"></i> Call Emergency</a>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <div class="map-frame">
                    <iframe title="Map showing Samdani Emergency Medical Centre, Karachi" src="<?= e(maps_embed_url()) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
