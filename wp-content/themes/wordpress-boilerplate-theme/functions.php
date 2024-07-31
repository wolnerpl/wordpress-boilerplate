<?php if (!defined('ABSPATH')) { exit; } ?>
<?php
 require_once('inc/base/base.php');

 function theme_setup() {
    add_theme_support( 'title-tag' );
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'wordpress-boilerplate-theme'),
    ));

    add_theme_support('custom-logo', [
        'width'       => 400,
        'height'      => 100
    ]);

    add_image_size('slider', 1000);
}
add_action('after_setup_theme', 'theme_setup');

function theme_scripts() {
    wp_enqueue_style('theme-style', get_template_directory_uri() . '/dist/css/app.min.css', [], wp_get_theme()->get('Version'));
    wp_enqueue_script('theme-scripts', get_template_directory_uri() . '/dist/js/app.min.js', [], wp_get_theme()->get('Version'), ['in_footer' => true]);

    $php_array = [
        'admin_ajax' => admin_url('admin-ajax.php')
    ];
    wp_localize_script('theme-scripts', 'php_array', $php_array);
}
add_action('wp_enqueue_scripts', 'theme_scripts');

function common_scripts() {
    wp_register_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], wp_get_theme()->get('Version'));
    wp_register_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], wp_get_theme()->get('Version'), ['strategy' => 'defer', 'in_footer' => true]);
}
add_action('init', 'common_scripts');