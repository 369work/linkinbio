<?php
/**
 * Title: LinkInBio 404
 * Slug: linkinbio/404
 * Categories: linkinbio_patterns
 * Inserter: no
 *
 * @package linkinbio
 * @since 1.2.0
 */

?>
<!-- wp:group {"className":"lib-card","layout":{"type":"default"}} -->
<div class="wp-block-group lib-card">
	<!-- wp:heading {"level":1,"className":"lib-page-title"} -->
	<h1 class="wp-block-heading lib-page-title"><?php esc_html_e( 'Page not found', 'linkinbio' ); ?></h1>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"className":"lib-404-message"} -->
	<p class="lib-404-message"><?php esc_html_e( 'The page you are looking for could not be found. Try searching instead.', 'linkinbio' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:search {"label":<?php echo wp_json_encode( __( 'Search', 'linkinbio' ) ); ?>,"showLabel":false,"placeholder":<?php echo wp_json_encode( __( 'Search this site…', 'linkinbio' ) ); ?>,"buttonText":<?php echo wp_json_encode( __( 'Search', 'linkinbio' ) ); ?>,"className":"lib-search-form"} /-->
</div>
<!-- /wp:group -->
