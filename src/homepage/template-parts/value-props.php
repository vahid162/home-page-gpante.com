<?php

defined( 'ABSPATH' ) || exit;

$items = $data['editorial']['values'] ?? [];

if ( ! $items ) {
    return;
}
?>
<section class="hp-section hp-shell" aria-label="مزیت‌های خدمات">
    <div class="hp-value-grid">
        <?php foreach ( $items as $item ) : ?>
            <article class="hp-value-card">
                <span class="hp-value-card__icon" aria-hidden="true"><?php echo esc_html( $item['icon'] ?? '' ); ?></span>
                <div>
                    <h2><?php echo esc_html( $item['title'] ?? '' ); ?></h2>
                    <p><?php echo esc_html( $item['body'] ?? '' ); ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
