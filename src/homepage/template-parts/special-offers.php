<?php

defined( 'ABSPATH' ) || exit;

$products = $data['sale_products'] ?? [];

if ( ! $products ) {
    return;
}
?>
<section class="hp-section hp-shell" aria-labelledby="offers-title">
    <div class="hp-section__head">
        <div>
            <p class="hp-eyebrow">فرصت‌های محدود</p>
            <h2 id="offers-title">تخفیف‌های ویژه</h2>
            <p>فایل‌های منتخب با تخفیف را سریع و بدون شلوغی مقایسه کنید.</p>
        </div>
    </div>

    <div class="hp-product-strip" aria-label="محصولات تخفیف‌دار">
        <?php foreach ( $products as $product ) : ?>
            <?php gpante_home_render_part( 'product-card', [ 'product' => $product, 'context' => 'sale' ] ); ?>
        <?php endforeach; ?>
    </div>
</section>
