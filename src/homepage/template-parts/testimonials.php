<?php

defined( 'ABSPATH' ) || exit;

$items = $data['testimonials'] ?? [];

if ( ! $items ) {
    return;
}
?>
<section class="hp-section hp-shell" aria-labelledby="testimonials-title">
    <div class="hp-section__head">
        <div>
            <p class="hp-eyebrow">تجربه مشتریان</p>
            <h2 id="testimonials-title">بازخوردهای واقعی مشتریان</h2>
            <p>در این بخش فقط تصاویر واقعی و تأییدشده موجود در Media Library نمایش داده می‌شوند.</p>
        </div>
    </div>

    <div class="hp-testimonial-grid hp-testimonial-grid--images">
        <?php foreach ( $items as $item ) : ?>
            <figure class="hp-testimonial hp-testimonial--image">
                <?php
                echo wp_get_attachment_image(
                    (int) $item['attachment_id'],
                    'large',
                    false,
                    [
                        'alt'      => $item['alt'],
                        'loading'  => 'lazy',
                        'decoding' => 'async',
                    ]
                ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                ?>
            </figure>
        <?php endforeach; ?>
    </div>
</section>
