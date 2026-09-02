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

        $thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );

        $items[] = [
            'id'           => (int) $term->term_id,
            'slug'         => (string) $term->slug,
            'name'         => (string) $term->name,
            'count'        => (int) $term->count,
            'url'          => (string) $url,
            'thumbnail_id' => $thumbnail_id,
        ];
    }

    return $items;
}
