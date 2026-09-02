<?php

defined( 'ABSPATH' ) || exit;

function gpante_home_get_categories(): array {
    if ( ! taxonomy_exists( 'product_cat' ) ) {
        return [];
    }

    $config = gpante_home_config();
    $items  = [];

    foreach ( $config['category_selection'] ?? [] as $selected ) {
        $slug = isset( $selected['slug'] ) ? (string) $selected['slug'] : '';
        if ( '' === $slug ) {
            continue;
        }

        $term = get_term_by( 'slug', $slug, 'product_cat' );
        if ( ! $term || is_wp_error( $term ) ) {
            continue;
        }

        $url = get_term_link( $term );
        if ( is_wp_error( $url ) ) {
            continue;
        }

        $items[] = [
            'id'       => (int) $term->term_id,
            'slug'     => (string) $term->slug,
            'name'     => (string) $term->name,
            'count'    => (int) $term->count,
            'url'      => (string) $url,
            'icon_key' => isset( $selected['icon'] ) ? (string) $selected['icon'] : '◇',
        ];
    }

    return $items;
}
