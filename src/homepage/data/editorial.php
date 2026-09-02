<?php

defined( 'ABSPATH' ) || exit;

function gpante_home_get_editorial(): array {
    $config = gpante_home_config();

    $shop_page_id = function_exists( 'wc_get_page_id' ) ? (int) wc_get_page_id( 'shop' ) : 0;
    $shop_url     = $shop_page_id > 0 ? get_permalink( $shop_page_id ) : home_url( '/?post_type=product' );

    return [
        'hero'        => $config['hero'],
        'shop_url'    => $shop_url,
        'free_url'    => add_query_arg(
            [
                'post_type' => 'product',
                's'         => 'رایگان',
            ],
            home_url( '/' )
        ),
        'search_url'  => home_url( '/' ),
        'values'      => $config['value_propositions'],
        'support'     => $config['support'],
        'telegram'    => $config['telegram'],
        'contact'     => $config['contact'],
    ];
}

function gpante_home_get_testimonials(): array {
    $config = gpante_home_config();
    $items  = [];

    foreach ( array_map( 'absint', $config['testimonial_attachment_ids'] ?? [] ) as $attachment_id ) {
        if ( ! $attachment_id ) {
            continue;
        }

        $image = wp_get_attachment_image_src( $attachment_id, 'large' );
        if ( ! $image ) {
            continue;
        }

        $items[] = [
            'attachment_id' => $attachment_id,
            'url'           => $image[0],
            'width'         => (int) $image[1],
            'height'        => (int) $image[2],
            'alt'           => (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ),
        ];
    }

    return $items;
}
