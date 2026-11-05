<?php
$page = [
    'key' => 'doctors',
    'file' => 'doctors.php',
    'title' => 'Doctors & Medical Team',
    'description' => 'Meet the medical team at Samdani Emergency Medical Centre, Karachi. Doctor profiles, qualifications and specialisations will be published here.',
    'keywords' => 'doctors Karachi, medical team Gulzar-e-Hijri, emergency doctors Karachi, Samdani Emergency Medical Centre doctors',
    'css' => 'doctors',
];
include __DIR__ . '/includes/header.php';
global $DOCTORS;
$hasDoctors = !empty($DOCTORS);
?>

<section class="page-hero" aria-labelledby="page-title">
    <div class="container">
        <nav class="breadcrumb-semc" aria-label="Breadcrumb"><a href="<?= e(page_url('index.php')) ?>">Home</a><span aria-hidden="true">/</span>Doctors</nav>
        <h1 id="page-title" class="anim-fade-up">Doctors &amp; Medical Team</h1>
        <p class="anim-fade-up anim-delay-1">The doctors and nursing staff who care for patients at SEMC.</p>
    </div>
</section>

<section class="section" aria-labelledby="team-title">
    <div class="container">
        <div class="section-head" data-aos="fade-up">
            <span class="eyebrow">Our team</span>
            <h2 id="team-title">Meet the medical team</h2>
            <p>Patients describe our doctors as knowledgeable and kind, and our nursing staff as caring.</p>
        </div>

<?php if ($hasDoctors): ?>
        <?php
        $specs = array_values(array_unique(array_filter(array_map(static fn($d) => $d['specialization'] ?? '', $DOCTORS))));
        if (count($specs) > 1): ?>
            <div class="doctor-filters" role="group" aria-label="Filter doctors by specialisation">
                <button type="button" class="filter-btn is-active" data-filter="all">All</button>
                <?php foreach ($specs as $sp): ?>
                    <button type="button" class="filter-btn" data-filter="<?= e(strtolower($sp)) ?>"><?= e($sp) ?></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="row g-4" id="doctorGrid">
            <?php foreach ($DOCTORS as $i => $d): $photo = $d['photo'] ?? ''; ?>
                <div class="col-12 col-md-6 col-lg-4 doctor-col" data-spec="<?= e(strtolower($d['specialization'] ?? '')) ?>" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 90 ?>">
                    <article class="card-semc doctor-card">
                        <div class="doctor-photo">
                            <img src="<?= e($photo && has_img($photo) ? asset('images/' . $photo) : asset('images/placeholder-doctor.svg')) ?>" alt="<?= e(($d['name'] ?? 'Doctor') . ' profile photo') ?>" width="400" height="400" loading="lazy">
                        </div>
                        <h3><?= e($d['name'] ?? '') ?></h3>
                        <p class="doctor-role"><?= e($d['role'] ?? '') ?></p>
                        <dl class="doctor-meta">
                            <dt>Qualifications</dt><dd><?= e($d['qualifications'] ?? 'To be confirmed') ?></dd>
                            <dt>Specialisation</dt><dd><?= e($d['specialization'] ?? 'To be confirmed') ?></dd>
                            <dt>Experience</dt><dd><?= e($d['experience'] ?? 'To be confirmed') ?></dd>
                        </dl>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
<?php else: ?>
        <!-- No verified profiles supplied yet: show clearly-labelled template cards only. -->
        <div class="notice mb-4" data-aos="fade-up" role="note">
            <strong>Profiles coming soon.</strong> Verified doctor profiles (names, qualifications, specialisations and experience) will be published here once supplied by SEMC. The cards below are layout placeholders only.
        </div>
        <div class="row g-4">
            <?php for ($i = 1; $i <= 3; $i++): ?>
                <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= ($i - 1) * 90 ?>">
                    <article class="card-semc doctor-card doctor-card-placeholder" aria-label="Doctor profile placeholder <?= $i ?>">
                        <div class="doctor-photo">
                            <img src="<?= e(asset('images/placeholder-doctor.svg')) ?>" alt="Placeholder - doctor photograph to be added" width="400" height="400" loading="lazy">
                        </div>
                        <span class="badge-pending">Awaiting confirmation</span>
                        <h3 class="mt-3">Doctor name</h3>
                        <p class="doctor-role">Role / designation</p>
                        <dl class="doctor-meta">
                            <dt>Qualifications</dt><dd>To be confirmed</dd>
                            <dt>Specialisation</dt><dd>To be confirmed</dd>
                            <dt>Experience</dt><dd>To be confirmed</dd>
                        </dl>
                    </article>
                </div>
            <?php endfor; ?>
        </div>
<?php endif; ?>

        <div class="notice notice-info mt-5" data-aos="fade-up">
            <i class="bi bi-telephone" aria-hidden="true"></i>
            To ask about doctor availability, please call <a href="<?= e(phone_tel()) ?>"><?= e(SITE_PHONE_DISPLAY) ?></a> or use the <a href="<?= e(page_url('contact.php')) ?>">contact form</a>.
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
