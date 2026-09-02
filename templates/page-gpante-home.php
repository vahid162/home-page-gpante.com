<?php
/**
 * Template Name: GPante Custom Homepage
 * Template Post Type: page
 *
 * Safe switch-over template for the Homepage Main Content.
 */

defined( 'ABSPATH' ) || exit;

require_once get_stylesheet_directory() . '/src/homepage/bootstrap.php';

get_header();

gpante_home_render_main();

get_footer();
