<?php
add_action('after_setup_theme', 'uncode_language_setup');
function uncode_language_setup()
{
	load_child_theme_textdomain('uncode', get_stylesheet_directory() . '/languages');
}

function theme_enqueue_styles()
{
	$production_mode = ot_get_option('_uncode_production');
	$resources_version = ($production_mode === 'on') ? null : rand();
	if ( function_exists('get_rocket_option') && ( get_rocket_option( 'remove_query_strings' ) || get_rocket_option( 'minify_css' ) || get_rocket_option( 'minify_js' ) ) ) {
		$resources_version = null;
	}
	$parent_style = 'uncode-style';
	$child_style = array('uncode-style');
	wp_enqueue_style($parent_style, get_template_directory_uri() . '/library/css/style.css', array(), $resources_version);
	wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', $child_style, $resources_version);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles', 100);

function my_gwolle_gb_button( $button ) {
        // $button is a string
        $button = '
                <div id="gwolle_gb_write_button">
                        <input type="button" class="button btn btn-default " value="Say thank you" />
                </div>';
        return $button;
}
add_filter( 'gwolle_gb_button', 'my_gwolle_gb_button', 10, 1 );

add_filter('uncode_before_body_title', function ($html) {
  // Temporary deploy test banner (remove after verifying staging deploy works)
  return $html . '<div class="deploy-test-banner">✅ DEPLOY TEST: If you can see this, the child theme was deployed.</div>';
});