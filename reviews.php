<?php
$page = [
    'key' => 'reviews',
    'file' => 'reviews.php',
    'title' => 'Patient Reviews',
    'description' => 'Read what patients say about Samdani Emergency Medical Centre in Karachi: Google rating 4.6/5 from 20 reviews, with feedback on cleanliness, caring staff and clear communication.',
    'keywords' => 'Samdani Emergency Medical Centre reviews, patient reviews Karachi, medical centre Karachi rating, Gulzar-e-Hijri hospital reviews',
    'css' => 'reviews',
];
include __DIR__ . '/includes/header.php';
global $REVIEWS;
$googleUrl = reviews_url();
?>

<section class="page-hero" aria-labelledby="page-title">
    <div class="container">
        <nav class="breadcrumb-semc" aria-label="Breadcrumb"><a href="<?= e(page_url('index.php')) ?>">Home</a><span aria-hidden="true">/</span>Reviews</nav>
        <h1 id="page-title" class="anim-fade-up">Patient Reviews</h1>
        <p class="anim-fade-up anim-delay-1">What patients and families have shared about their experience at SEMC.</p>
    </div>
</section>

<section class="section" aria-labelledby="rating-title">
    <div class="container">
        <div class="rating-summary" data-aos="fade-up">
            <div class="row align-items-center gy-4">
                <div class="col-md-5 text-center">
                    <h2 id="rating-title" class="visually-hidden">Google rating</h2>
                    <div class="rating-big"><span id="ratingNumber" data-value="<?= e(SITE_RATING) ?>"><?= e(SITE_RATING) ?></span><small>/5</small></div>
                    <div class="stars fs-4" aria-hidden="true"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i></div>
                    <p class="mb-0 mt-2"><strong><?= (int)SITE_REVIEW_COUNT ?></strong> Google reviews</p>
                </div>
                <div class="col-md-7">
                    <h3 class="h4 mb-3">Patient experience highlights</h3>
                    <ul class="list-check mb-4">
                        <li>A <strong>clean, well-kept</strong> environment</li>
                        <li><strong>Caring and helpful</strong> nursing staff</li>
                        <li>Doctors who are <strong>kind, polite and clear</strong> in their explanations</li>
                    </ul>
                    <a class="btn btn-semc" href="<?= e($googleUrl) ?>" target="_blank" rel="noopener" data-google-reviews>
                        <i class="bi bi-google" aria-hidden="true"></i> View &amp; write Google reviews
                    </a>
                    <?php if (GOOGLE_REVIEWS_URL === ''): ?>
                        <!-- TODO(CLIENT): set GOOGLE_REVIEWS_URL in includes/config.php. Until then the button opens SEMC on Google Maps. -->
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-light pt-5" aria-labelledby="feedback-title">
    <div class="container">
        <div class="section-head" data-aos="fade-up">
            <span class="eyebrow">Patient feedback</span>
            <h2 id="feedback-title">Selected excerpts</h2>
            <p>Short excerpts from Google reviews. Reviewer names are not shown.</p>
        </div>
        <div class="row g-4">
            <?php foreach ($REVIEWS as $i => $r): ?>
                <div class="col-12 col-lg-4" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                    <figure class="card-semc review-card mb-0">
                        <span class="theme-tag"><i class="bi <?= e($r['icon']) ?>" aria-hidden="true"></i> <?= e($r['theme']) ?></span>
                        <blockquote>&ldquo;<?= e($r['text']) ?>&rdquo;</blockquote>
                        <figcaption><i class="bi bi-google" aria-hidden="true"></i> Google review excerpt</figcaption>
                    </figure>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section" aria-labelledby="themes-title">
    <div class="container">
        <div class="section-head" data-aos="fade-up">
            <span class="eyebrow">What patients mention</span>
            <h2 id="themes-title">Cleanliness &amp; staff feedback</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-6" data-aos="fade-up">
                <article class="card-semc">
                    <span class="icon-box"><i class="bi bi-stars" aria-hidden="true"></i></span>
                    <h3>Cleanliness</h3>
                    <p class="mb-0">One reviewer describes the centre as very neat and clean, and notes that test services and X-rays are provided.</p>
                </article>
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                <article class="card-semc">
                    <span class="icon-box green"><i class="bi bi-person-heart" aria-hidden="true"></i></span>
                    <h3>Staff &amp; doctors</h3>
                    <p class="mb-0">Reviewers describe the nursing staff as caring and helpful, and the doctors as humble, polite, knowledgeable and clear communicators.</p>
                </article>
            </div>
        </div>

        <div class="cta-band mt-5" data-aos="fade-up">
            <h2>Share your experience</h2>
            <p>Have you visited SEMC? Your feedback helps other patients and helps us improve.</p>
            <a class="btn btn-semc btn-semc-light btn-lg" href="<?= e($googleUrl) ?>" target="_blank" rel="noopener"><i class="bi bi-google" aria-hidden="true"></i> Open Google reviews</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
