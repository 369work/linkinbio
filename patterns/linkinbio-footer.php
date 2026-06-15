<?php
/**
 * Title: LinkInBio Footer
 * Slug: linkinbio/footer
 * Categories: linkinbio_patterns
 * Inserter: no
 *
 * @package linkinbio
 * @since 1.0.0
 */
?>
<!-- wp:group {"tagName":"footer","className":"lib-footer","layout":{"type":"default"}} -->
<footer class="wp-block-group lib-footer">
	<!-- wp:paragraph {"className":"lib-copyright"} -->
	<p class="lib-copyright">&copy; <?php echo esc_html(gmdate('Y')); ?> <?php esc_html_e('Your Name. All rights reserved.', 'linkinbio'); ?></p>
	<!-- /wp:paragraph -->
</footer>
<!-- /wp:group -->
