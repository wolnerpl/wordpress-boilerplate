<?php if (!defined('ABSPATH')) { exit; } ?>
<?php
function register_acf_blocks() {
    if (!function_exists('register_block_type')) {
        return;
    }

    $blocks_directory = get_template_directory() . '/parts/blocks';
    $block_directories = glob($blocks_directory . '/*', GLOB_ONLYDIR);

    foreach ($block_directories as $directory) {
        register_block_type($directory);
    }
}

add_action('acf/init', 'register_acf_blocks');

function new_blocks_category( $cats ) {
	$new = array(
		'category' => array(
			'slug'  => 'this',
			'title' => 'Wordpress Boilerplate Theme'
		)
	);
	$cats = array_slice( $cats, 0, 0, true ) + $new + array_slice( $cats, 0, null, true );
	$cats = array_values( $cats );
	return $cats;

}
add_filter( 'block_categories_all', 'new_blocks_category' );