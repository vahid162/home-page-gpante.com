<?php

defined( 'ABSPATH' ) || exit;

$categories = $data['categories'] ?? [];

if ( ! $categories ) {
    return;
}
?>
<section class="hp-section hp-shell" id="categories" aria-labelledby="categories-title">
    <div class="hp-section__head">
        <div>
            <p class="hp-eyebrow">مرور سریع</p>
            <h2 id="categories-title">دسته‌بندی طرح‌های برش لیزر</h2>
            <p>طرح‌ها را بر اساس کاربرد و نوع محصول مرور کنید و سریع‌تر به فایل مناسب برسید.</p>
        </div>
    </div>

    <div class="hp-category-grid" data-category-grid>
        <?php foreach ( $categories as $index => $category ) : ?>
            <a class="hp-category-card<?php echo $index >= 6 ? ' hp-category-card--extra' : ''; ?>" href="<?php echo esc_url( $category['url'] ); ?>">
                <span class="hp-category-card__icon" aria-hidden="true"><?php echo esc_html( $category['icon_key'] ); ?></span>
                <span>
                    <strong><?php echo esc_html( $category['name'] ); ?></strong>
                    <small><?php echo esc_html( number_format_i18n( (int) $category['count'] ) ); ?> محصول</small>
                </span>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if ( count( $categories ) > 6 ) : ?>
        <button class="hp-btn hp-btn--secondary hp-mobile-only hp-category-toggle" type="button" aria-expanded="false" data-category-toggle>
            نمایش دسته‌های بیشتر
        </button>
    <?php endif; ?>
</section>
