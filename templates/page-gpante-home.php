<?php
/**
 * Template Name: GPante Custom Homepage
 * Template Post Type: page
 *
 * Safe switch-over template for the Homepage Main Content.
 *
 * Keep Woodmart's page-layout wrappers intact so the custom Main Content
 * participates in the same content/sidebar grid as the parent page.php.
 */

defined( 'ABSPATH' ) || exit;

require_once get_stylesheet_directory() . '/src/homepage/bootstrap.php';

$classes = '';
$style   = '';

get_header();

if ( function_exists( 'woodmart_has_sidebar_in_page' ) && woodmart_has_sidebar_in_page() ) {
    $classes .= ' wd-grid-col';

    if ( function_exists( 'woodmart_get_content_inline_style' ) ) {
        $style .= ' style="' . woodmart_get_content_inline_style() . '"';
    }
}

if ( function_exists( 'woodmart_get_page_layout' ) && 'sidebar-left' === woodmart_get_page_layout() ) {
    get_sidebar();
}
?>

<div class="wd-content-area site-content<?php echo esc_attr( $classes ); ?>"<?php echo wp_kses( $style, true ); ?>>
    <?php while ( have_posts() ) : ?>
        <?php the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-content gpante-homepage-entry' ); ?>>
            <?php gpante_home_render_main(); ?>
        </article>
    <?php endwhile; ?>
</div>

<?php
if ( ! function_exists( 'woodmart_get_page_layout' ) || 'sidebar-left' !== woodmart_get_page_layout() ) {
    get_sidebar();
}

get_footer();
