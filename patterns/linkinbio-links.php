<?php
/**
 * Title: LinkInBio Links
 * Slug: linkinbio/links
 * Categories: linkinbio_patterns
 * Inserter: no
 *
 * The links open in a new tab, so each one carries screen reader text that
 * says so.
 *
 * @package linkinbio
 * @since 1.0.0
 */

$linkinbio_new_tab = '<span class="screen-reader-text">' . esc_html__( '(opens in a new tab)', 'linkinbio' ) . '</span>';
?>
<!-- wp:group {"className":"lib-card","ariaLabel":"<?php esc_attr_e( 'Links', 'linkinbio' ); ?>"} -->
<div class="wp-block-group lib-card" aria-label="<?php esc_attr_e( 'Links', 'linkinbio' ); ?>">
	<!-- wp:heading {"className":"lib-section-label"} -->
	<h2 class="wp-block-heading lib-section-label"><?php esc_html_e( 'Links', 'linkinbio' ); ?></h2>
	<!-- /wp:heading -->
	<!-- wp:buttons {"className":"lib-link-list","layout":{"type":"flex","orientation":"vertical","justifyContent":"left"}} -->
	<div class="wp-block-buttons lib-link-list">
		<!-- wp:button {"className":"lib-link-row lib-link-gh"} -->
		<div class="wp-block-button lib-link-row lib-link-gh"><a class="wp-block-button__link wp-element-button" href="#" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'GitHub', 'linkinbio' ); ?> <?php echo wp_kses_post( $linkinbio_new_tab ); ?></a></div>
		<!-- /wp:button -->
		<!-- wp:button {"className":"lib-link-row lib-link-x"} -->
		<div class="wp-block-button lib-link-row lib-link-x"><a class="wp-block-button__link wp-element-button" href="#" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'X (Twitter)', 'linkinbio' ); ?> <?php echo wp_kses_post( $linkinbio_new_tab ); ?></a></div>
		<!-- /wp:button -->
		<!-- wp:button {"className":"lib-link-row lib-link-ig"} -->
		<div class="wp-block-button lib-link-row lib-link-ig"><a class="wp-block-button__link wp-element-button" href="#" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Instagram', 'linkinbio' ); ?> <?php echo wp_kses_post( $linkinbio_new_tab ); ?></a></div>
		<!-- /wp:button -->
		<!-- wp:button {"className":"lib-link-row lib-link-li"} -->
		<div class="wp-block-button lib-link-row lib-link-li"><a class="wp-block-button__link wp-element-button" href="#" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'LinkedIn', 'linkinbio' ); ?> <?php echo wp_kses_post( $linkinbio_new_tab ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
