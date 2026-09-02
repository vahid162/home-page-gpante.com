<?php

defined( 'ABSPATH' ) || exit;

$telegram = $data['editorial']['telegram'] ?? [];
?>
<section class="hp-section hp-shell hp-community" aria-labelledby="community-title">
    <div class="hp-community__copy">
        <p class="hp-community__eyebrow"><?php echo esc_html( $telegram['eyebrow'] ?? '' ); ?></p>
        <h2 id="community-title"><?php echo esc_html( $telegram['title'] ?? '' ); ?></h2>
        <p><?php echo esc_html( $telegram['body'] ?? '' ); ?></p>
    </div>

    <div class="hp-community__actions">
        <a class="hp-btn hp-btn--light" href="<?php echo esc_url( $telegram['channel_url'] ?? '#' ); ?>" target="_blank" rel="noopener noreferrer">عضویت در کانال پانته</a>
        <a class="hp-btn hp-btn--ghost-light" href="<?php echo esc_url( $telegram['group_url'] ?? '#' ); ?>" target="_blank" rel="noopener noreferrer">ورود به گروه گفت‌وگو</a>
    </div>
</section>
