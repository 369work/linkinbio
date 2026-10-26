<?php
/**
 * Title: LinkInBio Index
 * Slug: linkinbio/index
 * Categories: linkinbio_patterns
 * Inserter: no
 *
 * @package linkinbio
 * @since 1.0.0
 */

?>
<!-- wp:query {"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","inherit":true},"className":"linkinbio-query","layout":{"type":"default"}} -->
<div class="wp-block-query linkinbio-query">
	<!-- wp:post-template -->
	<!-- wp:group {"className":"lib-card linkinbio-archive","layout":{"type":"default"}} -->
	<div class="wp-block-group lib-card linkinbio-archive">
		<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/5","className":"linkinbio-image"} /-->
		<!-- wp:group {"className":"linkinbio-meta","layout":{"type":"flex","justifyContent":"space-between","verticalAlignment":"center","flexWrap":"nowrap"}} -->
		<div class="wp-block-group linkinbio-meta">
			<!-- wp:post-terms {"term":"category","className":"linkinbio-term"} /-->
			<!-- wp:post-date {"className":"linkinbio-date"} /-->
		</div>
		<!-- /wp:group -->
		<!-- wp:post-title {"isLink":true,"className":"linkinbio-title"} /-->
		<!-- wp:post-excerpt {"excerptLength":64,"className":"linkinbio-excerpt"} /-->
		<!-- wp:read-more {"content":<?php echo wp_json_encode( __( 'Read Essay →', 'linkinbio' ) ); ?>,"className":"linkinbio-readmore"} /-->
	</div>
	<!-- /wp:group -->
	<!-- /wp:post-template -->

	<!-- wp:query-no-results -->
	<!-- wp:paragraph {"className":"lib-no-results"} -->
	<p class="lib-no-results"><?php esc_html_e( 'No posts found.', 'linkinbio' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- /wp:query-no-results -->

	<!-- wp:query-pagination {"paginationArrow":"arrow","layout":{"type":"flex","justifyContent":"center"},"className":"linkinbio-pagination"} -->
	<!-- wp:query-pagination-previous /-->
	<!-- wp:query-pagination-numbers /-->
	<!-- wp:query-pagination-next /-->
	<!-- /wp:query-pagination -->
</div>
<!-- /wp:query -->
