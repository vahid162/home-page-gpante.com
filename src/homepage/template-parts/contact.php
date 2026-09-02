<?php

defined( 'ABSPATH' ) || exit;

$contact = $data['editorial']['contact'] ?? [];
$status  = gpante_home_callback_status_message();
?>
<section class="hp-section hp-shell hp-contact" id="contact-request" aria-labelledby="contact-title">
    <div class="hp-contact__media">
        <?php if ( ! empty( $contact['image_url'] ) ) : ?>
            <img src="<?php echo esc_url( $contact['image_url'] ); ?>" alt="اگر به طراحی نیاز دارید" loading="lazy" decoding="async">
        <?php endif; ?>
    </div>

    <div class="hp-contact__content">
        <p class="hp-contact__eyebrow"><?php echo esc_html( $contact['eyebrow'] ?? '' ); ?></p>
        <h2 id="contact-title"><?php echo esc_html( $contact['title'] ?? '' ); ?></h2>

        <form class="hp-contact__form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" data-contact-form>
            <input type="hidden" name="action" value="gpante_home_callback_request">
            <?php wp_nonce_field( 'gpante_home_callback_request', '_gpante_nonce' ); ?>

            <div class="hp-honeypot" aria-hidden="true">
                <label for="gpante-website">وب‌سایت</label>
                <input id="gpante-website" type="text" name="website" value="" tabindex="-1" autocomplete="off">
            </div>

            <label for="gpante-mobile">شماره موبایل</label>
            <div class="hp-contact__row">
                <input id="gpante-mobile" name="mobile" type="tel" inputmode="numeric" autocomplete="tel" placeholder="09" required aria-describedby="mobile-status">
                <button class="hp-btn hp-btn--primary" type="submit">با من تماس بگیرید</button>
            </div>

            <p class="hp-form-status<?php echo $status ? ' is-' . esc_attr( $status[0] ) : ''; ?>" id="mobile-status" role="status" aria-live="polite">
                <?php echo $status ? esc_html( $status[1] ) : ''; ?>
            </p>
        </form>
    </div>
</section>
