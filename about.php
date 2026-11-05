<?php
$page = [
    'key' => 'about',
    'file' => 'about.php',
    'title' => 'About Us',
    'description' => 'Learn about Samdani Emergency Medical Centre (SEMC) in Gulzar-e-Hijri, Karachi - our purpose, patient-focused approach and commitment to compassionate care.',
    'keywords' => 'about Samdani Emergency Medical Centre, medical centre Gulzar-e-Hijri Karachi, patient-focused healthcare Karachi',
    'css' => 'about',
];
include __DIR__ . '/includes/header.php';
?>

<section class="page-hero" aria-labelledby="page-title">
    <div class="container">
        <nav class="breadcrumb-semc" aria-label="Breadcrumb"><a href="<?= e(page_url('index.php')) ?>">Home</a><span aria-hidden="true">/</span>About Us</nav>
        <h1 id="page-title" class="anim-fade-up">About Samdani Emergency Medical Centre</h1>
        <p class="anim-fade-up anim-delay-1">Accessible, compassionate medical care for patients and families in Karachi, open around the clock.</p>
    </div>
</section>

<!-- Sub navigation (in-page) -->
<div class="about-subnav" id="aboutSubnav">
    <div class="container">
        <ul class="list-unstyled d-flex gap-2 mb-0 overflow-auto">
            <li><a href="#introduction" class="subnav-link">Introduction</a></li>
            <li><a href="#mission-vision" class="subnav-link">Mission &amp; Vision</a></li>
            <li><a href="#approach" class="subnav-link">Our Approach</a></li>
            <li><a href="#commitments" class="subnav-link">Commitments</a></li>
            <li><a href="#gallery" class="subnav-link">Gallery</a></li>
        </ul>
    </div>
</div>

<section class="section" id="introduction" aria-labelledby="intro-title">
    <div class="container">
        <div class="row align-items-center gy-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="eyebrow">Introduction</span>
                <h2 id="intro-title" class="mb-3">Who we are</h2>
                <p>Samdani Emergency Medical Centre (SEMC) is an emergency care service and medical centre located at Safoora Chowk on Main University Road, in K.D.A Sector 34 A, Gulzar-e-Hijri, Karachi.</p>
                <p>We are open 24 hours so that patients and their families have somewhere to turn when they need medical attention, whatever the time of day.</p>
                <p class="mb-0"><strong class="text-navy">Our purpose</strong> is simple: to make medical care and support accessible to the people of Karachi, delivered with professionalism and compassion.</p>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="img-reveal shadow-semc">
                    <img src="<?= e(img_src('about.jpg')) ?>" alt="<?= has_img('about.jpg') ? 'Samdani Emergency Medical Centre' : 'Photo placeholder - official SEMC image to be added' ?>" width="800" height="600" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-light" id="mission-vision" aria-labelledby="mv-title">
    <div class="container">
        <div class="section-head" data-aos="fade-up">
            <span class="eyebrow">Mission &amp; Vision</span>
            <h2 id="mv-title">What guides us</h2>
        </div>
        <!-- TODO(CLIENT): Mission/Vision wording is a draft based on the supplied description. Confirm or replace. -->
        <div class="row g-4">
            <div class="col-md-6" data-aos="fade-up">
                <article class="card-semc mv-card">
                    <span class="icon-box"><i class="bi bi-bullseye" aria-hidden="true"></i></span>
                    <h3>Our Mission</h3>
                    <p>To provide accessible medical care and support to patients in Karachi, with compassion, respect and professionalism, at any hour of the day.</p>
                </article>
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                <article class="card-semc mv-card">
                    <span class="icon-box green"><i class="bi bi-eye" aria-hidden="true"></i></span>
                    <h3>Our Vision</h3>
                    <p>To be a trusted place of care in our community, where every patient and family feels heard, respected and well looked after.</p>
                </article>
            </div>
        </div>
    </div>
</section>

<section class="section" id="approach" aria-labelledby="approach-title">
    <div class="container">
        <div class="section-head" data-aos="fade-up">
            <span class="eyebrow">Patient-focused approach</span>
            <h2 id="approach-title">Professional and compassionate care</h2>
            <p>Our approach reflects what patients tell us matters most.</p>
        </div>
        <div class="row g-4">
            <?php
            $pillars = [
                ['bi-person-hearts', 'Patients come first', 'Care is centred on the patient and their family, with courtesy and patience at every step.', ''],
                ['bi-chat-dots', 'Clear explanations', 'We aim to explain conditions and next steps in plain language so patients understand their care.', 'green'],
                ['bi-hand-thumbs-up', 'Respectful treatment', 'Every patient is treated politely and with dignity, regardless of the situation that brings them in.', ''],
            ];
            foreach ($pillars as $i => $p): ?>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                    <article class="card-semc text-center">
                        <span class="icon-box <?= $p[3] ?>"><i class="bi <?= $p[0] ?>" aria-hidden="true"></i></span>
                        <h3><?= e($p[1]) ?></h3>
                        <p class="text-muted-semc"><?= e($p[2]) ?></p>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section-light" id="commitments" aria-labelledby="commit-title">
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-lg-5" data-aos="fade-right">
                <span class="eyebrow">Healthcare standards</span>
                <h2 id="commit-title" class="mb-3">Our commitments</h2>
                <p class="mb-0">These are the principles we hold ourselves to. They are commitments of conduct and care, not claims of formal accreditation.</p>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <div class="commit-list">
                    <div class="commit-item"><i class="bi bi-check-circle-fill" aria-hidden="true"></i><div><strong>Cleanliness</strong> - maintaining a neat, clean environment for patients and visitors.</div></div>
                    <div class="commit-item"><i class="bi bi-check-circle-fill" aria-hidden="true"></i><div><strong>Courtesy</strong> - treating patients and families politely and respectfully.</div></div>
                    <div class="commit-item"><i class="bi bi-check-circle-fill" aria-hidden="true"></i><div><strong>Communication</strong> - taking the time to explain things clearly.</div></div>
                    <div class="commit-item"><i class="bi bi-check-circle-fill" aria-hidden="true"></i><div><strong>Availability</strong> - being open 24 hours for patients who need us.</div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section" id="gallery" aria-labelledby="gallery-title">
    <div class="container">
        <div class="section-head" data-aos="fade-up">
            <span class="eyebrow">Gallery</span>
            <h2 id="gallery-title">Our medical centre</h2>
            <p>Photographs of the centre will appear here.</p>
        </div>
        <!-- TODO(CLIENT): add gallery-1.jpg ... gallery-6.jpg to assets/images/ -->
        <div class="row g-3 gallery-grid">
            <?php for ($i = 1; $i <= 6; $i++): $f = "gallery-$i.jpg"; ?>
                <div class="col-6 col-md-4" data-aos="fade-up" data-aos-delay="<?= ($i - 1) % 3 * 80 ?>">
                    <figure class="gallery-item img-reveal mb-0">
                        <img src="<?= e(img_src($f)) ?>" width="800" height="600" loading="lazy"
                             alt="<?= has_img($f) ? 'Samdani Emergency Medical Centre photo ' . $i : 'Photo placeholder ' . $i . ' - official SEMC image to be added' ?>">
                    </figure>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<section class="section pt-0">
    <div class="container">
        <div class="cta-band" data-aos="fade-up">
            <h2>Need medical attention?</h2>
            <p>We are open 24 hours. Call us or visit the centre at Safoora Chowk, Main University Road.</p>
            <div class="cta-actions d-flex flex-wrap justify-content-center gap-3">
                <a class="btn btn-semc btn-semc-emergency btn-lg" href="<?= e(phone_tel()) ?>"><i class="bi bi-telephone-fill" aria-hidden="true"></i> Call Emergency</a>
                <a class="btn btn-semc btn-semc-ghost-light btn-lg" href="<?= e(page_url('contact.php')) ?>">Contact Us</a>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
