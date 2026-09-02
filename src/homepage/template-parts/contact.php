<?php

defined( 'ABSPATH' ) || exit;

$contact = $data['editorial']['contact'] ?? [];
$status  = gpante_home_callback_status_message();
?>
<section class="hp-section hp-shell hp-contact" id="contact-request" aria-labelledby="contact-title">
    <div class="hp-contact__copy">
        <p class="hp-eyebrow">طراحی اختصاصی</p>
        <h2 id="contact-title"><?php echo esc_html( $contact['title'] ?? '' ); ?></h2>
        <p><?php echo esc_html( $contact['body'] ?? '' ); ?></p>
    </div>

    <form class="hp-contact__form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" data-contact-form>
        <input type="hidden" name="action" value="gpante_home_callback_request">
        <?php wp_nonce_field( 'gpante_home_callback_request', '_gpante_nonce' ); ?>

        <div class="hp-honeypot" aria-hidden="true">
            <label for="gpante-website">وب‌سایت</label>
            <input id="gpante-website" type="text" name="website" value="" tabindex="-1" autocomplete="off">
        </div>

        <label for="gpante-mobile">شماره موبایل</label>
        <div class="hp-contact__row">
            <input id="gpante-mobile" name="mobile" type="tel" inputmode="numeric" autocomplete="tel" placeholder="09xxxxxxxxx" required aria-describedby="mobile-help mobile-status">
            <button class="hp-btn hp-btn--primary" type="submit">با من تماس بگیرید</button>
        </div>

        <small id="mobile-help">شماره فقط برای پیگیری همین درخواست استفاده می‌شود.</small>
        <p class="hp-form-status<?php echo $status ? ' is-' . esc_attr( $status[0] ) : ''; ?>" id="mobile-status" role="status" aria-live="polite">
            <?php echo $status ? esc_html( $status[1] ) : ''; ?>
        </p>
    </form>
</section>
