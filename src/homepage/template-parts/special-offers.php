<?php

defined( 'ABSPATH' ) || exit;

$products = $data['sale_products'] ?? [];

if ( ! $products ) {
    return;
}
?>
<section class="hp-section hp-shell hp-sale-section" aria-labelledby="offers-title">
    <header class="hp-heading hp-heading--compact">
        <h2 id="offers-title">تخفیف های تکرار نشدنی</h2>
    </header>

    <div class="hp-sale-grid" aria-label="محصولات تخفیف‌دار">
        <?php foreach ( $products as $product ) : ?>
            <?php gpante_home_render_part( 'product-card', [ 'product' => $product, 'context' => 'sale' ] ); ?>
        <?php endforeach; ?>
    </div>
</section>
