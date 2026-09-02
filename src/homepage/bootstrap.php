<?php
/**
 * GPante custom Homepage Main Content bootstrap.
 */

defined( 'ABSPATH' ) || exit;

$gpante_home_files = [
    '/config.php',
    '/data/editorial.php',
    '/data/categories.php',
    '/data/products.php',
    '/data/posts.php',
    '/data/wpforo.php',
    '/forms/callback-request.php',
    '/render.php',
];

foreach ( $gpante_home_files as $gpante_home_file ) {
    require_once __DIR__ . $gpante_home_file;
}

function gpante_home_enqueue_assets(): void {
    if ( ! gpante_home_is_enabled() ) {
        return;
    }

    $css_path = __DIR__ . '/assets/homepage.css';
    $js_path  = __DIR__ . '/assets/homepage.js';
    $base_uri = trailingslashit( get_stylesheet_directory_uri() ) . 'src/homepage/assets/';

    if ( is_readable( $css_path ) ) {
        wp_enqueue_style(
            'gpante-homepage',
            $base_uri . 'homepage.css',
            [],
            (string) filemtime( $css_path )
        );
    }

    if ( is_readable( $js_path ) ) {
        wp_enqueue_script(
            'gpante-homepage',
            $base_uri . 'homepage.js',
            [],
            (string) filemtime( $js_path ),
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'gpante_home_enqueue_assets', 30 );
