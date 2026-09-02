<?php

defined( 'ABSPATH' ) || exit;

$support = $data['editorial']['support'] ?? [];

if ( ! $support ) {
    return;
}
?>
<section class="hp-section hp-shell hp-support" aria-labelledby="support-title">
    <div class="hp-support__content">
        <p class="hp-eyebrow"><?php echo esc_html( $support['eyebrow'] ?? '' ); ?></p>
        <h2 id="support-title"><?php echo esc_html( $support['title'] ?? '' ); ?></h2>
        <p><?php echo esc_html( $support['body'] ?? '' ); ?></p>
    </div>

    <?php if ( ! empty( $support['points'] ) ) : ?>
        <div class="hp-support__points">
            <?php foreach ( $support['points'] as $point ) : ?>
                <div>
                    <span aria-hidden="true"><?php echo esc_html( $point['number'] ?? '' ); ?></span>
                    <strong><?php echo esc_html( $point['title'] ?? '' ); ?></strong>
                    <small><?php echo esc_html( $point['body'] ?? '' ); ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
