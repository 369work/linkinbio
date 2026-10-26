<?php
/**
 * LinkInBio Theme Functions
 *
 * @package linkinbio
 */

declare(strict_types=1);

defined( 'ABSPATH' ) || exit;

// =============================================================================
// Constants
// =============================================================================

/*
 * Read the version from the parent theme. wp_get_theme() with no argument
 * returns the active (child) theme, whose version has nothing to do with the
 * assets loaded from here.
 */
define( 'LINKINBIO_VERSION', (string) wp_get_theme( get_template() )->get( 'Version' ) );

// =============================================================================
// Theme setup
// =============================================================================

/**
 * Declare theme supports and register the editor stylesheets.
 *
 * @return void
 */
function linkinbio_setup(): void {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support(
		'html5',
		array(
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_editor_style( 'assets/css/linkinbio-style.css' );
	add_editor_style( 'assets/css/linkinbio-editor-style.css' );
}
add_action( 'after_setup_theme', 'linkinbio_setup' );

// =============================================================================
// Assets
// =============================================================================

/**
 * Enqueue the front-end stylesheets and the dark mode toggle.
 *
 * @return void
 */
function linkinbio_enqueue_assets(): void {
	wp_enqueue_style(
		'linkinbio-theme',
		get_template_directory_uri() . '/style.css',
		array(),
		LINKINBIO_VERSION
	);

	wp_enqueue_style(
		'linkinbio-style',
		get_template_directory_uri() . '/assets/css/linkinbio-style.css',
		array( 'linkinbio-theme' ),
		LINKINBIO_VERSION
	);

	/*
	 * Printed in the head, not the footer: the saved choice has to be on
	 * <html> before the first paint, or dark mode flashes light on load.
	 * The file is tiny and binds the button on DOMContentLoaded.
	 */
	wp_enqueue_script(
		'linkinbio-dark-toggle',
		get_template_directory_uri() . '/assets/js/linkinbio-dark-toggle.js',
		array(),
		LINKINBIO_VERSION,
		array( 'in_footer' => false )
	);
}
add_action( 'wp_enqueue_scripts', 'linkinbio_enqueue_assets' );

// =============================================================================
// Block pattern category
// =============================================================================

/**
 * Register the block pattern category.
 *
 * The patterns themselves are registered by core from the headers of
 * /patterns/*.php. Core does that on init at priority 10, so the category
 * is registered at 9 to exist before the patterns that use it.
 *
 * @return void
 */
function linkinbio_register_pattern_category(): void {
	register_block_pattern_category(
		'linkinbio_patterns',
		array(
			'label'       => __( 'LinkInBio Patterns', 'linkinbio' ),
			'description' => __( 'Patterns provided by LinkInBio.', 'linkinbio' ),
			'icon'        => 'admin-links',
		)
	);
}
add_action( 'init', 'linkinbio_register_pattern_category', 9 );

// =============================================================================
// Values resolved on every request
// =============================================================================

require_once get_template_directory() . '/inc/dynamic-values.php';

// =============================================================================
// Automatic updates
// =============================================================================

/*
 * inc/class-theme-updater.php is generated from the shared template by
 * premium/build-updater.php. Do not edit it here.
 */
require_once get_template_directory() . '/inc/class-theme-updater.php';

new LinkInBio_Theme_Updater(
	array(
		'slug'       => 'linkinbio',
		'remote_url' => 'https://369theme.com/releases/linkinbio.json',
	)
);

/*
 * Only on local / development environments, skip SSL verification for
 * requests to 369theme.com. Production keeps verification on.
 */
if ( in_array( wp_get_environment_type(), array( 'local', 'development' ), true ) ) {
	add_filter(
		'http_request_args',
		/**
		 * Disable SSL verification for 369theme.com on local environments.
		 *
		 * @param array<string, mixed> $args Request arguments.
		 * @param string               $url  Request URL.
		 * @return array<string, mixed>
		 */
		function ( array $args, string $url ): array {
			if ( false !== strpos( $url, '369theme.com' ) ) {
				$args['sslverify'] = false;
			}
			return $args;
		},
		10,
		2
	);
}
