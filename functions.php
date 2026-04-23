<?php
/**
 * Theme bootstrap for the school demo.
 *
 * @package Demo_Keiyo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/school-demo.php';

/**
 * Enqueue base styles.
 */
function demo_keiyo_enqueue_assets() {
	if ( ! is_singular( 'school_demo' ) && ! is_post_type_archive( 'school_demo' ) ) {
		return;
	}

	wp_enqueue_style(
		'demo-keiyo-school-demo',
		get_template_directory_uri() . '/assets/css/school-demo.css',
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'demo_keiyo_enqueue_assets' );
