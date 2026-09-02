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
            <label class="screen-reader-text" for="gpante-home-search">جست‌وجوی محصولات</label>
            <input id="gpante-home-search" name="s" type="search" placeholder="جست‌وجوی محصولات" autocomplete="off">
            <input type="hidden" name="post_type" value="product">
            <button class="hp-btn hp-btn--primary" type="submit">جست‌وجو</button>
        </form>

        <div class="hp-hero__actions">
            <a class="hp-btn hp-btn--primary" href="<?php echo esc_url( $editorial['shop_url'] ?? '#' ); ?>">مشاهده همه طرح‌ها</a>
            <a class="hp-btn hp-btn--outline" href="<?php echo esc_url( $editorial['free_url'] ?? '#' ); ?>">فایل‌های رایگان</a>
        </div>

        <?php if ( ! empty( $hero['micro'] ) ) : ?>
            <ul class="hp-hero__micro" aria-label="مزیت‌ها">
                <?php foreach ( $hero['micro'] as $item ) : ?>
                    <li><span aria-hidden="true">✓</span><?php echo esc_html( $item ); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
