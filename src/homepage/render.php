<?php

defined( 'ABSPATH' ) || exit;

function gpante_home_is_enabled(): bool {
    if ( defined( 'GPANTE_HOME_FORCE_ENABLE' ) && GPANTE_HOME_FORCE_ENABLE ) {
        return true;
    }

    return is_page_template( 'templates/page-gpante-home.php' );
}

function gpante_home_render_part( string $name, array $data = [] ): void {
    $file = __DIR__ . '/template-parts/' . sanitize_file_name( $name ) . '.php';

    if ( ! is_readable( $file ) ) {
        return;
    }

    require $file;
}

function gpante_home_build_context(): array {
    return [
        'editorial'    => gpante_home_get_editorial(),
        'categories'   => gpante_home_get_categories(),
        'sale_products'=> gpante_home_get_sale_products( 4 ),
        'new_products' => gpante_home_get_new_products( 4 ),
        'forum_items'  => gpante_home_get_recent_forum_activity( 3 ),
        'articles'     => gpante_home_get_latest_articles( 3 ),
        'testimonials' => gpante_home_get_testimonials(),
    ];
}

function gpante_home_render_main(): void {
    $context = gpante_home_build_context();

    echo '<main class="hp" id="main-content" dir="rtl">';

    gpante_home_render_part( 'hero', $context );
    gpante_home_render_part( 'categories', $context );
    gpante_home_render_part( 'special-offers', $context );
    gpante_home_render_part( 'products', $context );
    gpante_home_render_part( 'value-props', $context );
    gpante_home_render_part( 'knowledge', $context );
    gpante_home_render_part( 'support', $context );
    gpante_home_render_part( 'testimonials', $context );
    gpante_home_render_part( 'contact', $context );
    gpante_home_render_part( 'community', $context );

    echo '</main>';
}
