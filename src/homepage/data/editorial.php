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
        'search_url'   => home_url( '/' ),
        'promo_banners'=> $config['promo_banners'] ?? [],
        'support'      => $config['support'] ?? [],
        'testimonials' => $config['testimonial_urls'] ?? [],
        'telegram'     => $config['telegram'],
        'contact'      => $config['contact'],
    ];
}

function gpante_home_get_testimonials(): array {
    $config = gpante_home_config();
    $items  = [];

    foreach ( $config['testimonial_urls'] ?? [] as $url ) {
        $url = esc_url_raw( (string) $url );
        if ( '' === $url ) {
            continue;
        }

        $items[] = [
            'url' => $url,
            'alt' => 'رضایت مشتری از گروه پانته',
        ];
    }

    return $items;
}
