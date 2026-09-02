<?php

defined( 'ABSPATH' ) || exit;

$items = $data['editorial']['promo_banners'] ?? [];

if ( ! $items ) {
    return;
}
?>
<section class="hp-section hp-shell hp-promo-grid" aria-label="خدمات و منابع کاربردی">
    <?php foreach ( $items as $item ) : ?>
        <a class="hp-promo hp-promo--<?php echo esc_attr( $item['tone'] ?? 'default' ); ?>" href="<?php echo esc_url( $item['url'] ?? '#' ); ?>">
            <span class="hp-promo__kicker"><?php echo esc_html( $item['kicker'] ?? '' ); ?></span>
            <strong><?php echo esc_html( $item['title'] ?? '' ); ?></strong>
            <span class="hp-promo__body"><?php echo esc_html( $item['body'] ?? '' ); ?></span>
            <span class="hp-promo__link">مشاهده صفحه ←</span>
        </a>
    <?php endforeach; ?>
</section>
