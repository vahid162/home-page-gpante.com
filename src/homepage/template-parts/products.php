<?php

defined( 'ABSPATH' ) || exit;

$products = $data['new_products'] ?? [];

if ( ! $products ) {
    return;
}

$best_url     = gpante_home_get_bestseller_store_api_url( 4 );
$shop_url     = $data['editorial']['shop_url'] ?? home_url( '/' );
$fallback_url = add_query_arg( 'orderby', 'popularity', $shop_url );
?>
<section class="hp-section hp-shell" id="products" aria-labelledby="products-title" data-products-section data-best-sellers-url="<?php echo esc_url( $best_url ); ?>" data-best-sellers-fallback-url="<?php echo esc_url( $fallback_url ); ?>">
    <div class="hp-section__head hp-section__head--products">
        <div>
            <p class="hp-eyebrow">پیشنهادهای پانته</p>
            <h2 id="products-title">جدیدترین و محبوب‌ترین فایل‌ها</h2>
            <p>تازه‌ترین فایل‌ها را ببینید یا بین طرح‌های محبوب‌تر جست‌وجو کنید.</p>
        </div>

        <div class="hp-tabs" role="tablist" aria-label="نوع فهرست محصولات">
            <button class="hp-tab is-active" type="button" role="tab" aria-selected="true" aria-controls="new-products" id="tab-new" data-tab="new-products">جدیدترین‌ها</button>
            <button class="hp-tab" type="button" role="tab" aria-selected="false" aria-controls="best-products" id="tab-best" data-tab="best-products">پرفروش‌ترین‌ها</button>
        </div>
    </div>

    <div class="hp-tab-panel is-active" id="new-products" role="tabpanel" aria-labelledby="tab-new">
        <div class="hp-product-grid">
            <?php foreach ( $products as $product ) : ?>
                <?php gpante_home_render_part( 'product-card', [ 'product' => $product, 'context' => 'new' ] ); ?>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="hp-tab-panel" id="best-products" role="tabpanel" aria-labelledby="tab-best" hidden>
        <div class="hp-product-grid" data-best-products-grid>
            <p class="hp-products-loading" data-best-products-status>در حال دریافت پرفروش‌ترین‌ها…</p>
        </div>
    </div>

    <div class="hp-center-action">
        <a class="hp-btn hp-btn--secondary" href="<?php echo esc_url( $shop_url ); ?>">مشاهده همه فایل‌ها</a>
    </div>

    <noscript>
        <p class="hp-noscript-link">
            <a href="<?php echo esc_url( $fallback_url ); ?>">مشاهده پرفروش‌ترین‌ها در فروشگاه</a>
        </p>
    </noscript>
</section>
