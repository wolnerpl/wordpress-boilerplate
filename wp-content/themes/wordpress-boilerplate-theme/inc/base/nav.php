<?php if (!defined('ABSPATH')) { exit; } ?>
<?php
function wp_nav_menu_custom_args($args) {
    if (empty($args['container_aria_label'])) {
        $args['container_aria_label'] = wp_get_nav_menu_name($args['theme_location']);
    }
	if (empty($args['walker'])) {
        require_once(get_template_directory() .'/inc/nav/default-nav-walker.php');
		$args['fallback_cb'] = false;
		$args['walker'] = new Default_Nav_Walker();
    }
    if (!empty($args['container_class'])) {
		$args['menu_class'] = $args['container_class'] .'-menu';
    }
    if (!empty($args['menu_class'])) {
		$args['menu_class'] = $args['container_class'] .'-menu';
    }
    if (empty($args['menu_item_class'])) {
        $args['menu_item_class'] = $args['container_class'] .'-item';
    }
    if (empty($args['submenu_class'])) {
        $args['submenu_class'] = $args['container_class'] .'-sub-menu';
    }
    if (empty($args['link_class'])) {
        $args['link_class'] = $args['container_class'] .'-link';
    }
	return $args;
}
add_filter( 'wp_nav_menu_args', 'wp_nav_menu_custom_args' );

function change_menu_item_class($classes, $item, $args, $depth) {
    if(isset($args->menu_item_class)) {
        $classes[] = $args->menu_item_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'change_menu_item_class', 10, 4);

function change_submenu_class($classes, $args, $depth) {
    if(isset($args->submenu_class)) {
        $classes[] = $args->submenu_class;
    }
    return $classes;
}
add_filter('nav_menu_submenu_css_class', 'my_nav_menu_submenu_css_class', 10, 3);


function change_link_class($atts, $menu_item, $args, $depth) {
    if(isset($args->link_class)) {
        $atts['class'] = $args->link_class;
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'change_link_class', 10, 4);