<?php

defined( 'ABSPATH' ) || exit;

function gpante_home_get_latest_articles( int $limit = 3 ): array {
    $query = new WP_Query(
        [
            'post_type'              => 'post',
            'post_status'            => 'publish',
            'posts_per_page'         => max( 1, $limit ),
            'orderby'                => 'date',
            'order'                  => 'DESC',
            'ignore_sticky_posts'    => true,
            'no_found_rows'          => true,
            'update_post_meta_cache' => true,
            'update_post_term_cache' => false,
        ]
    );

    $items = [];

    foreach ( $query->posts as $post ) {
        $image_id = (int) get_post_thumbnail_id( $post );

        $items[] = [
            'id'       => (int) $post->ID,
            'title'    => (string) get_the_title( $post ),
            'url'      => (string) get_permalink( $post ),
            'excerpt'  => wp_trim_words( wp_strip_all_tags( get_the_excerpt( $post ) ), 18, '…' ),
            'date'     => (string) get_the_date( '', $post ),
            'image_id' => $image_id,
            'image_alt'=> $image_id ? (string) get_post_meta( $image_id, '_wp_attachment_image_alt', true ) : '',
        ];
    }

    wp_reset_postdata();

    return $items;
}

function gpante_home_get_posts_index_url(): string {
    $page_for_posts = (int) get_option( 'page_for_posts' );

    return $page_for_posts > 0 ? (string) get_permalink( $page_for_posts ) : '';
}
