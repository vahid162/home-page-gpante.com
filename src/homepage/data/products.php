<?php

defined( 'ABSPATH' ) || exit;

function gpante_home_normalize_product( $product ): ?array {
    if ( ! $product instanceof WC_Product || $product->is_type( 'variation' ) ) {
        return null;
    }

    $image_id = (int) $product->get_image_id();
    $regular  = $product->get_regular_price();
    $sale     = $product->get_sale_price();
    $percent  = null;

    if ( is_numeric( $regular ) && is_numeric( $sale ) && (float) $regular > 0 && (float) $sale >= 0 && (float) $sale < (float) $regular ) {
        $percent = (int) round( ( ( (float) $regular - (float) $sale ) / (float) $regular ) * 100 );
    }

    return [
        'id'                 => (int) $product->get_id(),
        'name'               => (string) $product->get_name(),
        'url'                => (string) $product->get_permalink(),
        'image_id'           => $image_id,
        'image_alt'          => $image_id ? (string) get_post_meta( $image_id, '_wp_attachment_image_alt', true ) : '',
        'price_html'         => (string) $product->get_price_html(),
        'short_description'  => wp_trim_words( wp_strip_all_tags( (string) $product->get_short_description() ), 24, '…' ),
        'regular_price_html' => is_numeric( $regular ) && '' !== $regular ? wc_price( (float) $regular ) : '',
        'sale_price_html'    => is_numeric( $sale ) && '' !== $sale ? wc_price( (float) $sale ) : '',
        'is_on_sale'         => (bool) $product->is_on_sale(),
        'sale_percent'       => $percent,
        'is_purchasable'     => (bool) $product->is_purchasable(),
        'is_in_stock'        => (bool) $product->is_in_stock(),
    ];
}

function gpante_home_normalize_products( array $products, int $limit ): array {
    $items = [];

    foreach ( $products as $product ) {
        $normalized = gpante_home_normalize_product( $product );
        if ( null === $normalized ) {
            continue;
        }

        $items[] = $normalized;
        if ( count( $items ) >= $limit ) {
            break;
        }
    }

    return $items;
}

function gpante_home_get_new_products( int $limit = 4 ): array {
    if ( ! function_exists( 'wc_get_products' ) ) {
        return [];
    }

    $products = wc_get_products(
        [
            'status'     => 'publish',
            'visibility' => 'visible',
            'limit'      => max( 1, $limit ),
            'orderby'    => 'date',
            'order'      => 'DESC',
            'return'     => 'objects',
        ]
    );

    return gpante_home_normalize_products( is_array( $products ) ? $products : [], $limit );
}

function gpante_home_get_sale_products( int $limit = 4 ): array {
    if ( ! function_exists( 'wc_get_products' ) || ! class_exists( 'WC_Data_Store' ) ) {
        return [];
    }

    $data_store = WC_Data_Store::load( 'product' );

    if ( ! is_object( $data_store ) || ! method_exists( $data_store, 'get_on_sale_products' ) ) {
        return [];
    }

    $on_sale_rows = $data_store->get_on_sale_products();
    if ( ! is_array( $on_sale_rows ) ) {
        return [];
    }

    $sale_ids = [];

    foreach ( $on_sale_rows as $row ) {
        $id        = isset( $row->id ) ? absint( $row->id ) : 0;
        $parent_id = isset( $row->parent_id ) ? absint( $row->parent_id ) : 0;
        $target_id = $parent_id ?: $id;

        if ( $target_id ) {
            $sale_ids[] = $target_id;
        }
    }

    $sale_ids = array_values( array_unique( $sale_ids ) );

    if ( ! $sale_ids ) {
        return [];
    }

    $products = wc_get_products(
        [
            'status'     => 'publish',
            'visibility' => 'visible',
            'include'    => $sale_ids,
            'limit'      => max( 12, $limit * 3 ),
            'orderby'    => 'date',
            'order'      => 'DESC',
            'return'     => 'objects',
        ]
    );

    return gpante_home_normalize_products( is_array( $products ) ? $products : [], $limit );
}

function gpante_home_get_bestseller_store_api_url( int $limit = 4 ): string {
    return add_query_arg(
        [
            'orderby'            => 'popularity',
            'order'              => 'desc',
            'per_page'           => max( 1, min( 100, $limit ) ),
            'catalog_visibility' => 'visible',
        ],
        rest_url( 'wc/store/v1/products' )
    );
}

function gpante_home_product_image_html( array $product, string $size = 'woocommerce_thumbnail', string $loading = 'lazy' ): string {
    $image_id = isset( $product['image_id'] ) ? absint( $product['image_id'] ) : 0;

    if ( ! $image_id ) {
        return '<span class="hp-product-card__placeholder" aria-hidden="true"></span>';
    }

    $alt = '' !== ( $product['image_alt'] ?? '' ) ? (string) $product['image_alt'] : (string) ( $product['name'] ?? '' );

    return wp_get_attachment_image(
        $image_id,
        $size,
        false,
        [
            'alt'      => $alt,
            'loading'  => $loading,
            'decoding' => 'async',
        ]
    );
}
