<?php
/**
 * Reusable navigation: top info bar + sticky navbar.
 * Uses $NAV_ITEMS (config.php) and $pageKey (header.php) for the active state.
 */
global $NAV_ITEMS;
?>
<div class="topbar d-none d-md-block" role="complementary" aria-label="Quick contact">
    <div class="container d-flex justify-content-between align-items-center">
        <span><i class="bi bi-clock" aria-hidden="true"></i> <?= e(SITE_HOURS) ?></span>
        <span class="topbar-address"><i class="bi bi-geo-alt" aria-hidden="true"></i> <?= e(SITE_ADDRESS_SHORT) ?></span>
        <a href="<?= e(phone_tel()) ?>"><i class="bi bi-telephone" aria-hidden="true"></i> <?= e(SITE_PHONE_DISPLAY) ?></a>
    </div>
</div>

<header class="site-header sticky-top">
    <nav class="navbar navbar-expand-lg semc-navbar" aria-label="Main navigation">
        <div class="container">
            <a class="navbar-brand" href="<?= e(page_url('index.php')) ?>" aria-label="<?= e(SITE_NAME) ?> - Home">
                <img src="<?= e(asset('images/logo-semc.svg')) ?>" width="44" height="44" alt="<?= e(SITE_SHORT) ?> logo<?= LOGO_IS_PLACEHOLDER ? ' (placeholder)' : '' ?>">
                <span class="brand-text">
                    <strong><?= e(SITE_SHORT) ?></strong>
                    <small>Samdani Emergency<br class="d-none d-sm-inline"> Medical Centre</small>
                </span>
            </a>

            <div class="d-flex align-items-center gap-2 order-lg-3">
                <a class="btn btn-semc btn-semc-emergency btn-sm nav-call" href="<?= e(phone_tel()) ?>">
                    <i class="bi bi-telephone-fill" aria-hidden="true"></i>
                    <span class="d-none d-sm-inline">Call Emergency</span><span class="d-sm-none">Call</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                        aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse order-lg-2" id="mainNav">
                <ul class="navbar-nav mx-lg-auto mb-2 mb-lg-0">
                    <?php foreach ($NAV_ITEMS as $key => $item): $active = ($key === $pageKey); ?>
                        <li class="nav-item">
                            <a class="nav-link<?= $active ? ' active' : '' ?><?= $key === 'emergency' ? ' nav-link-emergency' : '' ?>"
                               href="<?= e(page_url($item['file'])) ?>"<?= $active ? ' aria-current="page"' : '' ?>>
                                <?= e($item['label']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
