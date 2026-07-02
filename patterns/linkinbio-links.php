<?php
/**
 * Title: LinkInBio Links
 * Slug: linkinbio/links
 * Categories: linkinbio_patterns
 * Inserter: no
 *
 * @package linkinbio
 * @since 1.0.0
 */

?>
<!-- wp:group {"className":"lib-card","ariaLabel":"<?php esc_attr_e( 'Links', 'linkinbio' ); ?>"} -->
<div class="wp-block-group lib-card" aria-label="<?php esc_attr_e( 'Links', 'linkinbio' ); ?>">
	<!-- wp:heading {"level":2,"className":"lib-section-label"} -->
	<h2 class="lib-section-label"><?php esc_html_e( 'Links', 'linkinbio' ); ?></h2>
	<!-- /wp:heading -->
	<!-- wp:buttons {"className":"lib-link-list","layout":{"type":"flex","orientation":"vertical","justifyContent":"left"}} -->
	<div class="wp-block-buttons lib-link-list">
		<!-- wp:button {"url":"#","linkTarget":"_blank","rel":"noreferrer noopener","className":"lib-link-row lib-link-gh"} -->
		<div class="wp-block-button lib-link-row lib-link-gh"><a class="wp-block-button__link wp-element-button"
				href="#" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'GitHub', 'linkinbio' ); ?></a></div>
		<!-- /wp:button -->
		<!-- wp:button {"url":"#","linkTarget":"_blank","rel":"noreferrer noopener","className":"lib-link-row lib-link-x"} -->
		<div class="wp-block-button lib-link-row lib-link-x"><a class="wp-block-button__link wp-element-button" href="#"
				target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'X (Twitter)', 'linkinbio' ); ?></a></div>
		<!-- /wp:button -->
		<!-- wp:button {"url":"#","linkTarget":"_blank","rel":"noreferrer noopener","className":"lib-link-row lib-link-ig"} -->
		<div class="wp-block-button lib-link-row lib-link-ig"><a class="wp-block-button__link wp-element-button"
				href="#" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Instagram', 'linkinbio' ); ?></a>
		</div>
		<!-- /wp:button -->
		<!-- wp:button {"url":"#","linkTarget":"_blank","rel":"noreferrer noopener","className":"lib-link-row lib-link-li"} -->
		<div class="wp-block-button lib-link-row lib-link-li"><a class="wp-block-button__link wp-element-button"
				href="#" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'LinkedIn', 'linkinbio' ); ?></a>
		</div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->