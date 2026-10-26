<?php
/**
 * Values that have to be resolved on every request.
 *
 * Saving a template in the Site Editor stores whatever the pattern printed at
 * that moment, and the pattern's PHP never runs again. The footer copyright
 * used gmdate() and would freeze on the day the template was saved. It is a
 * block binding now, so the value is resolved at render time.
 *
 * The footer pattern still prints the same text; that output is the sample
 * the Site Editor shows while editing.
 *
 * @package linkinbio
 * @since 1.2.0
 */

declare(strict_types=1);

defined( 'ABSPATH' ) || exit;

/**
 * Footer copyright line: the current year and the site title.
 *
 * Uses wp_date() rather than gmdate(), so the year follows the site's
 * timezone instead of UTC around New Year.
 *
 * @return string
 */
function linkinbio_get_copyright_text(): string {
	return sprintf(
		/* translators: 1: current year, 2: site title */
		__( '© %1$s %2$s', 'linkinbio' ),
		wp_date( 'Y' ),
		get_bloginfo( 'name' )
	);
}

/**
 * Register the block bindings source used by the footer.
 *
 * @return void
 */
function linkinbio_register_block_bindings(): void {
	register_block_bindings_source(
		'linkinbio/copyright',
		array(
			'label'              => __( 'Copyright', 'linkinbio' ),
			'get_value_callback' => static function (): string {
				return esc_html( linkinbio_get_copyright_text() );
			},
		)
	);
}
add_action( 'init', 'linkinbio_register_block_bindings' );
