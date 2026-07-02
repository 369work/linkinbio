<?php
/**
 * Title: LinkInBio CTA
 * Slug: linkinbio/cta
 * Categories: linkinbio_patterns
 * Inserter: no
 *
 * @package linkinbio
 * @since 1.0.0
 */

?>
<!-- wp:group {"className":"lib-card lib-cta","ariaLabel":"<?php esc_attr_e( 'Contact', 'linkinbio' ); ?>"} -->
<div class="wp-block-group lib-card lib-cta" aria-label="<?php esc_attr_e( 'Contact', 'linkinbio' ); ?>">
	<!-- wp:heading {"level":2,"className":"lib-section-label"} -->
	<h2 class="lib-section-label"><?php esc_html_e( 'Contact', 'linkinbio' ); ?></h2>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"className":"lib-cta-text"} -->
	<p class="lib-cta-text"><?php esc_html_e( 'Interested in working together? Feel free to reach out.', 'linkinbio' ); ?>
	</p>
	<!-- /wp:paragraph -->
	<!-- wp:buttons {"className":"lib-cta-btn-wrap"} -->
	<div class="wp-block-buttons lib-cta-btn-wrap">
		<!-- wp:button {"url":"mailto:hello@example.com","className":"lib-cta-button"} -->
		<div class="wp-block-button lib-cta-button"><a class="wp-block-button__link wp-element-button"
				href="mailto:hello@example.com"><?php esc_html_e( 'hello@example.com', 'linkinbio' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->