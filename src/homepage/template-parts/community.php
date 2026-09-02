<?php

defined( 'ABSPATH' ) || exit;

$telegram = $data['editorial']['telegram'] ?? [];
?>
<section class="hp-section hp-shell hp-community" aria-labelledby="community-title">
    <div class="hp-community__icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" width="30" height="30">
            <path d="M20.7 3.5 3.8 10c-1.15.46-1.14 1.1-.2 1.39l4.34 1.35 1.67 5.18c.2.57.1.8.7.8.46 0 .66-.21.92-.46l2.08-2.03 4.33 3.2c.8.44 1.37.21 1.57-.74L22 5.02c.29-1.15-.44-1.67-1.3-1.52Z" fill="currentColor"/>
        </svg>
    </div>

    <div class="hp-community__copy">
        <p class="hp-eyebrow">جامعه پانته</p>
        <h2 id="community-title">آموزش‌ها و گفت‌وگوها را در تلگرام دنبال کنید</h2>
        <p>برای خبرهای جدید کانال را دنبال کنید و برای گفت‌وگوی تخصصی به گروه بپیوندید.</p>
    </div>

    <div class="hp-community__actions">
        <a class="hp-btn hp-btn--primary" href="<?php echo esc_url( $telegram['channel_url'] ?? '#' ); ?>" target="_blank" rel="noopener noreferrer">کانال تلگرام</a>
        <a class="hp-btn hp-btn--secondary" href="<?php echo esc_url( $telegram['group_url'] ?? '#' ); ?>" target="_blank" rel="noopener noreferrer">گروه گفتگو</a>
    </div>
</section>
