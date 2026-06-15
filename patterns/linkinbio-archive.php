<?php

/**
 * Title: LinkInBio Archive
 * Slug: linkinbio/archive
 * Categories: linkinbio_patterns
 * Inserter: no
 *
 * @package linkinbio
 * @since 1.0.0
 */
?>

<!-- wp:query {"query":{"perPage":9,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","inherit":true},"className":"linkinbio-query","layout":{"type":"default"},"align":"full"} -->
<div class="wp-block-query linkinbio-query alignfull">
    <!-- wp:post-template {"layout":{"type":"grid","columnCount":1}} -->
    <!-- wp:group {"className":"lib-card linkinbio-archive","layout":{"type":"default"}} -->
    <div class="wp-block-group lib-card linkinbio-archive">
        <!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/5","className":"linkinbio-image"} /-->
        <!-- wp:group {"className":"linkinbio-meta","layout":{"type":"flex","justifyContent":"space-between","verticalAlignment":"center","flexWrap":"nowrap"}} -->
        <div class="wp-block-group linkinbio-meta">
            <!-- wp:post-terms {"term":"category","className":"linkinbio-term","fontSize":"sm","textColor":"accent"} /-->
            <!-- wp:post-date {"className":"linkinbio-date","fontSize":"sm","textColor":"muted"} /-->
        </div>
        <!-- /wp:group -->
        <!-- wp:post-title {"isLink":true,"className":"linkinbio-title"} /-->
        <!-- wp:post-excerpt {"excerptLength":64,"className":"linkinbio-excerpt"} /-->
    </div>
    <!-- /wp:group -->
    <!-- /wp:post-template -->

    <!-- wp:query-no-results -->
    <!-- wp:paragraph -->
    <p><?php esc_html_e('No posts found.', 'linkinbio'); ?></p>
    <!-- /wp:paragraph -->
    <!-- /wp:query-no-results -->

    <!-- wp:query-pagination {"paginationArrow":"arrow","layout":{"type":"flex","justifyContent":"center"},"className":"linkinbio-pagination"} -->
    <!-- wp:query-pagination-previous {"label":"Previous"} /-->
    <!-- wp:query-pagination-numbers /-->
    <!-- wp:query-pagination-next {"label":"Next"} /-->
    <!-- /wp:query-pagination -->
</div>
<!-- /wp:query -->
