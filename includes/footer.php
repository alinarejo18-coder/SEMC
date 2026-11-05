<?php
/**
 * Shared footer + script loading.
 * Expects $page['js'] (optional) = name of the page-specific script (without .js).
 */
global $NAV_ITEMS;
$pageJs = $page['js'] ?? ($page['key'] ?? 'home');
?>
</main>

<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="row gy-4">
            <div class="col-12 col-lg-4">
                <a class="footer-brand" href="<?= e(page_url('index.php')) ?>">
                    <img src="<?= e(asset('images/logo-semc.svg')) ?>" width="48" height="48" alt="" loading="lazy">
                    <span><strong><?= e(SITE_SHORT) ?></strong><br><small><?= e(SITE_NAME) ?></small></span>
                </a>
                <p class="mt-3 mb-0 footer-muted"><?= e(SITE_TAGLINE) ?></p>
            </div>

            <div class="col-6 col-lg-2">
                <h2 class="footer-title">Quick Links</h2>
                <ul class="list-unstyled footer-links">
                    <?php foreach ($NAV_ITEMS as $item): ?>
                        <li><a href="<?= e(page_url($item['file'])) ?>"><?= e($item['label']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="col-6 col-lg-2">
                <h2 class="footer-title">Services</h2>
                <ul class="list-unstyled footer-links">
                    <?php foreach (active_services() as $s): ?>
                        <li><a href="<?= e(page_url('services.php')) ?>"><?= e($s['title']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="col-12 col-lg-4">
                <h2 class="footer-title">Contact</h2>
                <ul class="list-unstyled footer-contact">
                    <li><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> <span><?= e(SITE_ADDRESS) ?></span></li>
                    <li><i class="bi bi-telephone-fill" aria-hidden="true"></i> <a href="<?= e(phone_tel()) ?>"><?= e(SITE_PHONE_DISPLAY) ?></a></li>
                    <li><i class="bi bi-clock-fill" aria-hidden="true"></i> <span><?= e(SITE_HOURS) ?></span></li>
                </ul>
                <a class="btn btn-semc btn-semc-light btn-sm" href="<?= e(maps_directions_url()) ?>" target="_blank" rel="noopener">
                    <i class="bi bi-signpost-split" aria-hidden="true"></i> Get Directions
                </a>
            </div>
        </div>

        <hr class="footer-rule">
        <p class="footer-disclaimer">
            The information on this website is for general guidance only and is not a substitute for professional medical advice, diagnosis or treatment.
            In a medical emergency, call us or go to the nearest emergency facility immediately.
        </p>
        <p class="footer-copy mb-0">&copy; <?= date('Y') ?> <?= e(SITE_NAME) ?>. All rights reserved.</p>
    </div>
</footer>

<a href="#main" class="back-to-top" id="backToTop" aria-label="Back to top" hidden><i class="bi bi-arrow-up" aria-hidden="true"></i></a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="<?= e(asset('js/main.js')) ?>"></script>
<?php if ($pageJs && is_file(ROOT_PATH . '/assets/js/' . $pageJs . '.js')): ?>
<script src="<?= e(asset('js/' . $pageJs . '.js')) ?>"></script>
<?php endif; ?>
</body>
</html>
