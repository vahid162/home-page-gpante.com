<?php

defined( 'ABSPATH' ) || exit;

$categories = $data['categories'] ?? [];

if ( ! $categories ) {
    return;
}
?>
<section class="hp-section hp-shell" id="categories" aria-labelledby="categories-title">
    <header class="hp-heading">
        <h2 id="categories-title">دسته بندی‌ طرح‌‌های برش لیزر</h2>
        <p>مجموعه طرح و فایل های لیزر را به صورت دسته بندی مشاهده کنید</p>
    </header>

    <div class="hp-category-grid" data-category-grid>
        <?php foreach ( $categories as $index => $category ) : ?>
            <a class="hp-category-card<?php echo $index >= 6 ? ' hp-category-card--extra' : ''; ?>" href="<?php echo esc_url( $category['url'] ); ?>">
                <span class="hp-category-card__media">
                    <?php if ( ! empty( $category['thumbnail_id'] ) ) : ?>
                        <?php
                        echo wp_get_attachment_image(
                            (int) $category['thumbnail_id'],
                            'woocommerce_thumbnail',
                            false,
                            [
                                'alt'      => $category['name'],
                                'loading'  => 'lazy',
                                'decoding' => 'async',
                            ]
                        ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        ?>
                    <?php else : ?>
                        <span class="hp-category-card__placeholder" aria-hidden="true"></span>
                    <?php endif; ?>
                </span>
                <span class="hp-category-card__body">
                    <strong><?php echo esc_html( $category['name'] ); ?></strong>
                    <small><?php echo esc_html( number_format_i18n( (int) $category['count'] ) ); ?> محصول</small>
                </span>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if ( count( $categories ) > 6 ) : ?>
        <button class="hp-btn hp-btn--outline hp-mobile-only hp-category-toggle" type="button" aria-expanded="false" data-category-toggle>
            نمایش دسته‌های بیشتر
        </button>
    <?php endif; ?>
</section>
