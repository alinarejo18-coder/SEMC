<?php
/**
 * Contact page + form handler.
 *
 * A message counts as "sent" ONLY when it was actually stored on the server
 * (storage/messages/messages.jsonl) - and, when CONTACT_MAIL_TO is configured,
 * we additionally try to email it. A success message is shown only after the
 * write succeeds.
 */
declare(strict_types=1);
session_start();

require_once __DIR__ . '/includes/config.php';

const MSG_DIR = ROOT_PATH . '/storage/messages';

/** Remove control characters and trim. */
function clean_text(string $v, bool $multiline = false): string
{
    $v = trim($v);
    $pattern = $multiline ? '/[^\P{C}\n\r\t]+/u' : '/\p{C}+/u';
    $out = preg_replace($pattern, ' ', $v);
    return $out === null ? '' : trim($out);
}

/** @return array{0: array<string,string>, 1: array<string,string>} [clean values, errors] */
function validate_contact(array $in): array
{
    $v = [
        'name'    => clean_text((string)($in['name'] ?? '')),
        'email'   => clean_text((string)($in['email'] ?? '')),
        'phone'   => clean_text((string)($in['phone'] ?? '')),
        'subject' => clean_text((string)($in['subject'] ?? '')),
        'message' => clean_text((string)($in['message'] ?? ''), true),
    ];
    $err = [];

    $len = static fn(string $s): int => function_exists('mb_strlen') ? mb_strlen($s) : strlen($s);

    if ($v['name'] === '') { $err['name'] = 'Please enter your full name.'; }
    elseif ($len($v['name']) < 2 || $len($v['name']) > 80) { $err['name'] = 'Name must be between 2 and 80 characters.'; }

    if ($v['email'] === '') { $err['email'] = 'Please enter your email address.'; }
    elseif (!filter_var($v['email'], FILTER_VALIDATE_EMAIL) || $len($v['email']) > 120) { $err['email'] = 'Please enter a valid email address.'; }

    if ($v['phone'] === '') { $err['phone'] = 'Please enter your phone number.'; }
    elseif (!preg_match('/^\+?[0-9][0-9\s\-()]{6,18}$/', $v['phone'])) { $err['phone'] = 'Please enter a valid phone number (digits, spaces, + or - only).'; }

    if ($v['subject'] === '') { $err['subject'] = 'Please enter a subject.'; }
    elseif ($len($v['subject']) < 3 || $len($v['subject']) > 120) { $err['subject'] = 'Subject must be between 3 and 120 characters.'; }

    if ($v['message'] === '') { $err['message'] = 'Please write your message.'; }
    elseif ($len($v['message']) < 10) { $err['message'] = 'Your message is too short (at least 10 characters).'; }
    elseif ($len($v['message']) > 2000) { $err['message'] = 'Your message is too long (maximum 2000 characters).'; }

    return [$v, $err];
}

/** Persist a message. Returns true only if the write succeeded. */
function store_message(array $v): bool
{
    if (!is_dir(MSG_DIR) && !@mkdir(MSG_DIR, 0775, true) && !is_dir(MSG_DIR)) {
        return false;
    }
    // Defence in depth: deny web access even if /storage/.htaccess is ignored.
    $ht = MSG_DIR . '/.htaccess';
    if (!is_file($ht)) {
        @file_put_contents($ht, "Require all denied\n");
    }
    $record = $v + [
        'received_at' => date('c'),
        'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
    ];
    $line = json_encode($record, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($line === false) {
        return false;
    }
    $bytes = @file_put_contents(MSG_DIR . '/messages.jsonl', $line . PHP_EOL, FILE_APPEND | LOCK_EX);
    return $bytes !== false && $bytes > 0;
}

/** Optional email copy. Never required for success. */
function mail_copy(array $v): void
{
    if (CONTACT_MAIL_TO === '' || !function_exists('mail')) { return; }
    $subject = '[SEMC website] ' . str_replace(["\r", "\n"], ' ', $v['subject']);
    $body = "Name: {$v['name']}\nEmail: {$v['email']}\nPhone: {$v['phone']}\n\n{$v['message']}\n";
    $headers = 'Content-Type: text/plain; charset=UTF-8';
    @mail(CONTACT_MAIL_TO, $subject, $body, $headers);
}

/* ---------- CSRF token ---------- */
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

$old = ['name' => '', 'email' => '', 'phone' => '', 'subject' => '', 'message' => ''];
$errors = [];
$status = null; // null | 'success' | 'error'
$statusMsg = '';

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $isAjax = (($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'fetch');

    $respond = static function (int $code, array $payload) use ($isAjax): void {
        if ($isAjax) {
            http_response_code($code);
            header('Content-Type: application/json; charset=UTF-8');
            header('Cache-Control: no-store');
            echo json_encode($payload, JSON_UNESCAPED_UNICODE);
            exit;
        }
    };

    $token = (string)($_POST['csrf'] ?? '');
    $now = time();

    if (!hash_equals($_SESSION['csrf'], $token)) {
        $status = 'error';
        $statusMsg = 'Your session has expired. Please reload the page and try again.';
        $respond(400, ['success' => false, 'message' => $statusMsg, 'errors' => new stdClass()]);
    } elseif (!empty($_POST['website'])) {
        // Honeypot filled in: pretend nothing happened, store nothing, show NO success.
        $status = 'error';
        $statusMsg = 'We could not process your message. Please call us instead.';
        $respond(400, ['success' => false, 'message' => $statusMsg, 'errors' => new stdClass()]);
    } elseif (isset($_SESSION['last_submit']) && ($now - (int)$_SESSION['last_submit']) < 20) {
        $status = 'error';
        $statusMsg = 'Please wait a few seconds before sending another message.';
        $respond(429, ['success' => false, 'message' => $statusMsg, 'errors' => new stdClass()]);
    } else {
        [$clean, $errors] = validate_contact($_POST);
        $old = $clean;

        if ($errors) {
            $status = 'error';
            $statusMsg = 'Please correct the highlighted fields and try again.';
            $respond(422, ['success' => false, 'message' => $statusMsg, 'errors' => $errors]);
        } elseif (!store_message($clean)) {
            $status = 'error';
            $statusMsg = 'Sorry, we could not save your message right now. Please call ' . SITE_PHONE_DISPLAY . ' instead.';
            error_log('SEMC contact form: could not write to ' . MSG_DIR);
            $respond(500, ['success' => false, 'message' => $statusMsg, 'errors' => new stdClass()]);
        } else {
            mail_copy($clean);
            $_SESSION['last_submit'] = $now;
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
            $status = 'success';
            $statusMsg = 'Thank you. Your message has been received by our team.';
            $old = ['name' => '', 'email' => '', 'phone' => '', 'subject' => '', 'message' => ''];
            $respond(200, ['success' => true, 'message' => $statusMsg, 'csrf' => $_SESSION['csrf']]);
        }
    }
}

$page = [
    'key' => 'contact',
    'file' => 'contact.php',
    'title' => 'Contact Us',
    'description' => 'Contact Samdani Emergency Medical Centre in Gulzar-e-Hijri, Karachi. Call +92 300 0267362 (open 24 hours), find directions on the map or send us a message.',
    'keywords' => 'contact Samdani Emergency Medical Centre, medical centre phone Karachi, directions Safoora Chowk University Road Karachi',
    'css' => 'contact',
];
include __DIR__ . '/includes/header.php';

$f = static fn(string $k): string => e($old[$k] ?? '');
$bad = static fn(string $k): string => isset($errors[$k]) ? ' is-invalid' : '';
?>

<section class="page-hero" aria-labelledby="page-title">
    <div class="container">
        <nav class="breadcrumb-semc" aria-label="Breadcrumb"><a href="<?= e(page_url('index.php')) ?>">Home</a><span aria-hidden="true">/</span>Contact Us</nav>
        <h1 id="page-title" class="anim-fade-up">Contact Us</h1>
        <p class="anim-fade-up anim-delay-1">Call us any time, day or night, or send a message and our team will review it.</p>
    </div>
</section>

<section class="section" aria-labelledby="contact-title">
    <div class="container">
        <div class="row g-4 g-lg-5">

            <!-- Contact details -->
            <div class="col-lg-5" data-aos="fade-right">
                <span class="eyebrow">Get in touch</span>
                <h2 id="contact-title" class="mb-4">Contact information</h2>

                <ul class="contact-list list-unstyled">
                    <li>
                        <span class="icon-box"><i class="bi bi-telephone-fill" aria-hidden="true"></i></span>
                        <div><strong>Phone</strong><a href="<?= e(phone_tel()) ?>"><?= e(SITE_PHONE_DISPLAY) ?></a></div>
                    </li>
                    <li>
                        <span class="icon-box green"><i class="bi bi-clock-fill" aria-hidden="true"></i></span>
                        <div><strong>Hours</strong><?= e(SITE_HOURS) ?></div>
                    </li>
                    <li>
                        <span class="icon-box"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i></span>
                        <div><strong>Address</strong><?= e(SITE_ADDRESS) ?></div>
                    </li>
                    <li>
                        <span class="icon-box green"><i class="bi bi-qr-code" aria-hidden="true"></i></span>
                        <div><strong>Plus Code</strong><?= e(SITE_PLUS_CODE) ?></div>
                    </li>
                </ul>

                <div class="d-flex flex-column flex-sm-row gap-3 mt-4">
                    <a class="btn btn-semc btn-semc-emergency" href="<?= e(phone_tel()) ?>"><i class="bi bi-telephone-fill" aria-hidden="true"></i> Call Now</a>
                    <a class="btn btn-semc btn-semc-outline" href="<?= e(maps_directions_url()) ?>" target="_blank" rel="noopener"><i class="bi bi-signpost-split" aria-hidden="true"></i> Get Directions</a>
                </div>
            </div>

            <!-- Form -->
            <div class="col-lg-7" data-aos="fade-left">
                <div class="form-card">
                    <h2 class="h3 mb-1">Send us a message</h2>
                    <p class="text-muted-semc mb-3">For general enquiries only.</p>

                    <div class="notice notice-danger mb-4" role="note">
                        <strong>Emergency?</strong> Do not use this form. Call <a href="<?= e(phone_tel()) ?>"><strong><?= e(SITE_PHONE_DISPLAY) ?></strong></a> or go to the nearest emergency facility immediately.
                    </div>

                    <div id="formStatus" role="status" aria-live="polite" tabindex="-1">
                        <?php if ($status === 'success'): ?>
                            <div class="notice notice-success mb-3"><i class="bi bi-check-circle-fill" aria-hidden="true"></i> <?= e($statusMsg) ?></div>
                        <?php elseif ($status === 'error'): ?>
                            <div class="notice notice-danger mb-3"><i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i> <?= e($statusMsg) ?></div>
                        <?php endif; ?>
                    </div>

                    <form id="contactForm" method="post" action="<?= e(page_url('contact.php')) ?>#contactForm" novalidate>
                        <input type="hidden" name="csrf" id="csrfToken" value="<?= e($_SESSION['csrf']) ?>">
                        <!-- Honeypot: real visitors never see or fill this -->
                        <div class="hp-field" aria-hidden="true">
                            <label for="website">Leave this field empty</label>
                            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="name">Full Name <span class="text-danger">*</span></label>
                                <input class="form-control<?= $bad('name') ?>" type="text" id="name" name="name" value="<?= $f('name') ?>" maxlength="80" autocomplete="name" required>
                                <div class="invalid-feedback" data-error-for="name"><?= e($errors['name'] ?? '') ?></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="email">Email Address <span class="text-danger">*</span></label>
                                <input class="form-control<?= $bad('email') ?>" type="email" id="email" name="email" value="<?= $f('email') ?>" maxlength="120" autocomplete="email" required>
                                <div class="invalid-feedback" data-error-for="email"><?= e($errors['email'] ?? '') ?></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="phone">Phone Number <span class="text-danger">*</span></label>
                                <input class="form-control<?= $bad('phone') ?>" type="tel" id="phone" name="phone" value="<?= $f('phone') ?>" maxlength="20" autocomplete="tel" inputmode="tel" required>
                                <div class="invalid-feedback" data-error-for="phone"><?= e($errors['phone'] ?? '') ?></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="subject">Subject <span class="text-danger">*</span></label>
                                <input class="form-control<?= $bad('subject') ?>" type="text" id="subject" name="subject" value="<?= $f('subject') ?>" maxlength="120" required>
                                <div class="invalid-feedback" data-error-for="subject"><?= e($errors['subject'] ?? '') ?></div>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="message">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control<?= $bad('message') ?>" id="message" name="message" rows="5" maxlength="2000" required><?= $f('message') ?></textarea>
                                <div class="d-flex justify-content-between">
                                    <div class="invalid-feedback d-block" data-error-for="message"><?= e($errors['message'] ?? '') ?></div>
                                    <small class="text-muted-semc ms-auto"><span id="msgCount"><?= strlen($old['message']) ?></span>/2000</small>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-semc btn-lg w-100 w-sm-auto" type="submit" id="submitBtn">
                                    <span class="btn-label"><i class="bi bi-send" aria-hidden="true"></i> Send Message</span>
                                    <span class="btn-loading" hidden><span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Sending...</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-light pt-5" aria-labelledby="map-title">
    <div class="container">
        <div class="section-head" data-aos="fade-up">
            <span class="eyebrow">Find us</span>
            <h2 id="map-title">Our location</h2>
        </div>
        <div class="map-frame" data-aos="fade-up">
            <iframe title="Map showing Samdani Emergency Medical Centre, Karachi" src="<?= e(maps_embed_url()) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
        </div>
        <div class="text-center mt-4">
            <a class="btn btn-semc" href="<?= e(maps_directions_url()) ?>" target="_blank" rel="noopener"><i class="bi bi-signpost-split" aria-hidden="true"></i> Get Directions in Google Maps</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
