<?php

defined( 'ABSPATH' ) || exit;

$product_card = $data['product'] ?? [];
$card_context = $data['context'] ?? 'default';

if ( empty( $product_card['id'] ) || empty( $product_card['url'] ) ) {
    return;
}
?>
<article class="hp-product-card hp-product-card--<?php echo esc_attr( $card_context ); ?>">
    <a class="hp-product-card__media" href="<?php echo esc_url( $product_card['url'] ); ?>">
        <?php echo gpante_home_product_image_html( $product_card ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

        <?php if ( ! empty( $product_card['is_on_sale'] ) && ! empty( $product_card['sale_percent'] ) ) : ?>
            <span class="hp-sale-badge">-<?php echo esc_html( (string) $product_card['sale_percent'] ); ?>%</span>
        <?php endif; ?>
    </a>

    <div class="hp-product-card__body">
        <div class="hp-product-card__brand">پانته</div>
        <h3><a href="<?php echo esc_url( $product_card['url'] ); ?>"><?php echo esc_html( $product_card['name'] ); ?></a></h3>

        <?php if ( 'sale' === $card_context && ! empty( $product_card['short_description'] ) ) : ?>
            <p class="hp-product-card__excerpt"><?php echo esc_html( $product_card['short_description'] ); ?></p>
        <?php endif; ?>

        <div class="hp-price"><?php echo wp_kses_post( $product_card['price_html'] ); ?></div>

        <?php if ( 'sale' === $card_context ) : ?>
            <a class="hp-product-card__buy" href="<?php echo esc_url( $product_card['url'] ); ?>">خرید</a>
        <?php endif; ?>
    </div>
</article>
