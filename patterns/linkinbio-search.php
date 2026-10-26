<?php
/**
 * Title: LinkInBio Search
 * Slug: linkinbio/search
 * Categories: linkinbio_patterns
 * Inserter: no
 *
 * @package linkinbio
 * @since 1.2.0
 */

?>
<!-- wp:group {"className":"linkinbio-archive-intro","layout":{"type":"default"}} -->
<div class="wp-block-group linkinbio-archive-intro">
	<!-- wp:query-title {"type":"search","className":"lib-page-title"} /-->
	<!-- wp:search {"label":<?php echo wp_json_encode( __( 'Search', 'linkinbio' ) ); ?>,"showLabel":false,"placeholder":<?php echo wp_json_encode( __( 'Search this site…', 'linkinbio' ) ); ?>,"buttonText":<?php echo wp_json_encode( __( 'Search', 'linkinbio' ) ); ?>,"className":"lib-search-form"} /-->
</div>
<!-- /wp:group -->

<!-- wp:query {"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"relevance","inherit":true},"className":"linkinbio-query","layout":{"type":"default"}} -->
<div class="wp-block-query linkinbio-query">
	<!-- wp:post-template -->
	<!-- wp:group {"className":"lib-card linkinbio-archive","layout":{"type":"default"}} -->
	<div class="wp-block-group lib-card linkinbio-archive">
		<!-- wp:post-title {"isLink":true,"className":"linkinbio-title"} /-->
		<!-- wp:post-date {"className":"linkinbio-date"} /-->
		<!-- wp:post-excerpt {"excerptLength":40,"className":"linkinbio-excerpt"} /-->
	</div>
	<!-- /wp:group -->
	<!-- /wp:post-template -->

	<!-- wp:query-no-results -->
	<!-- wp:paragraph {"className":"lib-no-results"} -->
	<p class="lib-no-results"><?php esc_html_e( 'No results found. Please try a different search term.', 'linkinbio' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- /wp:query-no-results -->

	<!-- wp:query-pagination {"paginationArrow":"arrow","layout":{"type":"flex","justifyContent":"center"},"className":"linkinbio-pagination"} -->
	<!-- wp:query-pagination-previous /-->
	<!-- wp:query-pagination-numbers /-->
	<!-- wp:query-pagination-next /-->
	<!-- /wp:query-pagination -->
</div>
<!-- /wp:query -->
