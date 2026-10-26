<?php
/**
 * Title: LinkInBio Footer
 * Slug: linkinbio/footer
 * Categories: linkinbio_patterns
 * Inserter: no
 *
 * The template part already renders the <footer> element, so the wrapper
 * here is a plain div. The copyright paragraph is bound to
 * linkinbio/copyright, which resolves the year on every request; the text
 * printed here is only the sample shown in the Site Editor.
 *
 * @package linkinbio
 * @since 1.0.0
 */

?>
<!-- wp:group {"className":"lib-footer","layout":{"type":"default"}} -->
<div class="wp-block-group lib-footer">
	<!-- wp:paragraph {"className":"lib-copyright","metadata":{"bindings":{"content":{"source":"linkinbio/copyright"}}}} -->
	<p class="lib-copyright"><?php echo esc_html( linkinbio_get_copyright_text() ); ?></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
