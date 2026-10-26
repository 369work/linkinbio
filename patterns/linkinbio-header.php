<?php
/**
 * Title: LinkInBio Header
 * Slug: linkinbio/header
 * Categories: linkinbio_patterns
 * Inserter: no
 *
 * The template part already renders the <header> element, so the wrapper
 * here is a plain div. The site title replaces the hard-coded theme name,
 * and the dark mode toggle is a wp:html button because aria-pressed cannot
 * be set from a block comment.
 *
 * @package linkinbio
 * @since 1.0.0
 */

?>
<!-- wp:group {"className":"lib-header","layout":{"type":"default"}} -->
<div class="wp-block-group lib-header">
	<!-- wp:site-title {"level":0,"className":"lib-site-name"} /-->
	<!-- wp:html -->
	<button type="button" class="lib-dark-toggle" aria-pressed="false" aria-label="<?php esc_attr_e( 'Switch to dark mode', 'linkinbio' ); ?>" data-label-dark="<?php esc_attr_e( 'Switch to dark mode', 'linkinbio' ); ?>" data-label-light="<?php esc_attr_e( 'Switch to light mode', 'linkinbio' ); ?>">
		<span class="lib-dark-toggle__icon lib-dark-toggle__icon--light" aria-hidden="true">
			<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" focusable="false">
				<circle cx="12" cy="12" r="5" />
				<line x1="12" y1="1" x2="12" y2="3" />
				<line x1="12" y1="21" x2="12" y2="23" />
				<line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
				<line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
				<line x1="1" y1="12" x2="3" y2="12" />
				<line x1="21" y1="12" x2="23" y2="12" />
				<line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
				<line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
			</svg>
		</span>
		<span class="lib-dark-toggle__icon lib-dark-toggle__icon--dark" aria-hidden="true">
			<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" focusable="false">
				<path d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79z" />
			</svg>
		</span>
	</button>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
