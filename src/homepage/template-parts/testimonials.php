<?php

defined( 'ABSPATH' ) || exit;

$items = $data['testimonials'] ?? [];

if ( ! $items ) {
    return;
}
?>
<section class="hp-section hp-shell" aria-labelledby="testimonials-title">
    <header class="hp-heading hp-heading--compact">
        <h2 id="testimonials-title">نظرات و رضایت برخی از همکاران</h2>
    </header>

    <div class="hp-testimonial-grid" aria-label="تصاویر رضایت مشتریان">
        <?php foreach ( $items as $index => $item ) : ?>
            <figure class="hp-testimonial">
                <img src="<?php echo esc_url( $item['url'] ); ?>" alt="<?php echo esc_attr( $item['alt'] . ' ' . ( $index + 1 ) ); ?>" loading="lazy" decoding="async">
            </figure>
        <?php endforeach; ?>
    </div>
</section>
