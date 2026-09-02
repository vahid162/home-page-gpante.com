<?php

defined( 'ABSPATH' ) || exit;

function gpante_home_get_recent_forum_activity( int $limit = 3 ): array {
    if ( ! function_exists( 'WPF' ) ) {
        return [];
    }

    $wpforo = WPF();

    if ( ! is_object( $wpforo ) || empty( $wpforo->post ) || ! method_exists( $wpforo->post, 'get_posts' ) ) {
        return [];
    }

    $posts = $wpforo->post->get_posts(
        [
            'orderby'   => 'created',
            'order'     => 'DESC',
            'row_count' => max( 8, $limit * 4 ),
            'status'    => 0,
            'private'   => 0,
        ]
    );

    if ( ! is_array( $posts ) ) {
        return [];
    }

    $items = [];

    foreach ( $posts as $post ) {
        if ( ! is_array( $post ) ) {
            continue;
        }

        $forum_id = isset( $post['forumid'] ) ? (int) $post['forumid'] : 0;

        if ( isset( $post['private'] ) && (int) $post['private'] !== 0 ) {
            continue;
        }

        if (
            $forum_id > 0 &&
            ! empty( $wpforo->perm ) &&
            method_exists( $wpforo->perm, 'forum_can' ) &&
            ! $wpforo->perm->forum_can( 'vf', $forum_id )
        ) {
            continue;
        }

        $topic = [];
        if ( ! empty( $wpforo->topic ) && method_exists( $wpforo->topic, 'get_topic' ) && ! empty( $post['topicid'] ) ) {
            $topic = $wpforo->topic->get_topic( (int) $post['topicid'] );
            $topic = is_array( $topic ) ? $topic : [];
        }

        $title = isset( $topic['title'] ) ? (string) $topic['title'] : '';
        if ( '' === $title && ! empty( $post['title'] ) ) {
            $title = (string) $post['title'];
        }
        if ( '' === $title && ! empty( $post['body'] ) ) {
            $title = wp_trim_words( wp_strip_all_tags( (string) $post['body'] ), 12, '…' );
        }

        $url = '';
        if ( ! empty( $post['postid'] ) && method_exists( $wpforo->post, 'get_post_url' ) ) {
            $url = (string) $wpforo->post->get_post_url( (int) $post['postid'] );
        }

        if ( '' === $title || '' === $url ) {
            continue;
        }

        $created = ! empty( $post['created'] ) ? strtotime( (string) $post['created'] ) : false;
        $relative = $created
            ? sprintf( '%s پیش', human_time_diff( $created, current_time( 'timestamp' ) ) )
            : '';

        $items[] = [
            'title'    => $title,
            'url'      => $url,
            'type'     => empty( $post['parentid'] ) ? 'پرسش' : 'پاسخ',
            'relative' => $relative,
        ];

        if ( count( $items ) >= $limit ) {
            break;
        }
    }

    return $items;
}

function gpante_home_get_forum_questions_url(): string {
    return home_url( '/community/questions/' );
}
