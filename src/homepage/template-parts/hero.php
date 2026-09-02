<?php

defined( 'ABSPATH' ) || exit;

$editorial = $data['editorial'] ?? [];
$hero      = $editorial['hero'] ?? [];
?>
<section class="hp-hero hp-shell" aria-labelledby="hero-title">
    <div class="hp-hero__content">
        <p class="hp-eyebrow"><?php echo esc_html( $hero['eyebrow'] ?? '' ); ?></p>
        <h1 id="hero-title"><?php echo esc_html( $hero['title'] ?? '' ); ?></h1>
        <p class="hp-hero__lead"><?php echo esc_html( $hero['lead'] ?? '' ); ?></p>

        <form class="hp-search" action="<?php echo esc_url( $editorial['search_url'] ?? home_url( '/' ) ); ?>" method="get" role="search">
            <label class="sr-only" for="gpante-home-search">جست‌وجوی فایل و طرح</label>
            <span class="hp-search__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="22" height="22">
                    <path d="m21 21-4.6-4.6m2.1-5.1a7.2 7.2 0 1 1-14.4 0 7.2 7.2 0 0 1 14.4 0Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </span>
            <input id="gpante-home-search" name="s" type="search" placeholder="مثلاً باکس هدیه، استند، وکتور، فایل رایگان..." autocomplete="off">
            <input type="hidden" name="post_type" value="product">
            <button class="hp-btn hp-btn--primary hp-search__submit" type="submit">جست‌وجو</button>
        </form>

        <div class="hp-hero__actions">
            <a class="hp-btn hp-btn--primary" href="<?php echo esc_url( $editorial['shop_url'] ?? '#' ); ?>">مشاهده همه طرح‌ها</a>
            <a class="hp-btn hp-btn--secondary" href="<?php echo esc_url( $editorial['free_url'] ?? '#' ); ?>">فایل‌های رایگان</a>
        </div>

        <?php if ( ! empty( $hero['micro'] ) ) : ?>
            <ul class="hp-hero__micro" aria-label="مزیت‌ها">
                <?php foreach ( $hero['micro'] as $item ) : ?>
                    <li><span aria-hidden="true">✓</span> <?php echo esc_html( $item ); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <div class="hp-hero__visual" aria-hidden="true">
        <div class="hp-machine">
            <div class="hp-machine__rail"></div>
            <div class="hp-machine__head"><span></span><span></span><span></span></div>
            <div class="hp-machine__beam"></div>
            <div class="hp-machine__work"><i></i><i></i><i></i><i></i></div>
            <div class="hp-machine__spark hp-machine__spark--1"></div>
            <div class="hp-machine__spark hp-machine__spark--2"></div>
            <div class="hp-machine__spark hp-machine__spark--3"></div>
        </div>
        <div class="hp-hero__visual-label">
            <strong>Laser / CNC</strong>
            <span>Ready-to-make files</span>
        </div>
    </div>
</section>
