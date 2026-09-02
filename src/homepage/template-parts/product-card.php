<?php

defined( 'ABSPATH' ) || exit;

$product_card = $data['product'] ?? [];
$card_context = $data['context'] ?? 'default';

if ( empty( $product_card['id'] ) || empty( $product_card['url'] ) ) {
    return;
}

$meta_label = 'new' === $card_context ? 'جدید' : 'فایل آماده';
if ( 'sale' === $card_context ) {
    $meta_label = 'تخفیف ویژه';
}
?>
<article class="hp-product-card<?php echo 'sale' === $card_context ? ' hp-product-card--sale' : ''; ?>">
    <a class="hp-product-card__media" href="<?php echo esc_url( $product_card['url'] ); ?>" aria-label="<?php echo esc_attr( $product_card['name'] ); ?>">
        <?php echo gpante_home_product_image_html( $product_card ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php if ( 'sale' === $card_context && ! empty( $product_card['sale_percent'] ) ) : ?>
            <span class="hp-sale-badge"><?php echo esc_html( sprintf( '٪%d-', (int) $product_card['sale_percent'] ) ); ?></span>
        <?php endif; ?>
    </a>

    <div class="hp-product-card__body">
        <p class="hp-product-card__meta"><?php echo esc_html( $meta_label ); ?></p>
        <h3><a href="<?php echo esc_url( $product_card['url'] ); ?>"><?php echo esc_html( $product_card['name'] ); ?></a></h3>

        <div class="hp-price">
            <?php if ( 'sale' === $card_context && ! empty( $product_card['regular_price_html'] ) && ! empty( $product_card['sale_price_html'] ) ) : ?>
                <del><?php echo wp_kses_post( $product_card['regular_price_html'] ); ?></del>
                <strong><?php echo wp_kses_post( $product_card['sale_price_html'] ); ?></strong>
            <?php else : ?>
                <strong><?php echo wp_kses_post( $product_card['price_html'] ); ?></strong>
            <?php endif; ?>
        </div>
    </div>
</article>
