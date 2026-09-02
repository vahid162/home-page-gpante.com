<?php

defined( 'ABSPATH' ) || exit;

$support = $data['editorial']['support'] ?? [];

if ( ! $support ) {
    return;
}
?>
<section class="hp-section hp-shell hp-support" aria-labelledby="support-title">
    <div class="hp-support__media">
        <?php if ( ! empty( $support['image_url'] ) ) : ?>
            <img src="<?php echo esc_url( $support['image_url'] ); ?>" alt="<?php echo esc_attr( $support['title'] ?? '' ); ?>" loading="lazy" decoding="async">
        <?php endif; ?>
    </div>

    <div class="hp-support__content">
        <h2 id="support-title"><?php echo esc_html( $support['title'] ?? '' ); ?></h2>
        <p><?php echo esc_html( $support['body'] ?? '' ); ?></p>
        <strong><?php echo esc_html( $support['title'] ?? '' ); ?></strong>
    </div>
</section>
