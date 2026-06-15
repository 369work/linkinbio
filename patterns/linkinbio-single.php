<?php

/**
 * Title: LinkInBio Single
 * Slug: linkinbio/single
 * Categories: linkinbio_patterns
 * Inserter: no
 *
 * @package linkinbio
 * @since 1.0.0
 */
?>

<!-- wp:group {"tagName":"article","className":"linkinbio-single-article","layout":{"type":"constrained"},"align":"full"} -->
<article class="wp-block-group linkinbio-single-article alignfull">
    <!-- wp:group {"className":"linkinbio-single-header","layout":{"type":"constrained"}} -->
    <div class="wp-block-group linkinbio-single-header">

        <!-- wp:group {"className":"linkinbio-single-meta","layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
        <div class="wp-block-group linkinbio-single-meta">
            <!-- wp:post-terms {"term":"category","className":"linkinbio-single-term"} /-->
            <!-- wp:post-date {"className":"linkinbio-single-date"} /-->
        </div>
        <!-- /wp:group -->

        <!-- wp:post-title {"level":1,"className":"linkinbio-single-title"} /-->

        <!-- wp:group {"className":"linkinbio-single-author","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
        <div class="wp-block-group linkinbio-single-author">
            <!-- wp:avatar {"size":48,"className":"linkinbio-single-avatar"} /-->
            <!-- wp:group {"layout":{"type":"default"}} -->
            <div class="wp-block-group">
                <!-- wp:paragraph {"className":"linkinbio-single-author-label","fontSize":"sm"} -->
                <p class="linkinbio-single-author-label has-sm-font-size"><?php esc_html_e('Written by', 'linkinbio'); ?></p>
                <!-- /wp:paragraph -->
                <!-- wp:post-author-name {"isLink":true,"className":"linkinbio-single-author-name"} /-->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:group -->

    </div>
    <!-- /wp:group -->

    <!-- wp:separator {"className":"linkinbio-single-divider"} -->
    <hr class="wp-block-separator has-alpha-channel-opacity linkinbio-single-divider"/>
    <!-- /wp:separator -->

    <!-- wp:post-featured-image {"className":"linkinbio-single-featured"} /-->

    <!-- wp:group {"className":"linkinbio-single-content-wrap","layout":{"type":"constrained"}} -->
    <div class="wp-block-group linkinbio-single-content-wrap">
        <!-- wp:post-content {"className":"linkinbio-single-content","layout":{"type":"constrained"}} /-->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"linkinbio-single-nav-wrap","layout":{"type":"constrained"}} -->
    <div class="wp-block-group linkinbio-single-nav-wrap">
        <!-- wp:group {"className":"linkinbio-single-nav","layout":{"type":"flex","justifyContent":"space-between","verticalAlignment":"center","flexWrap":"wrap"}} -->
        <div class="wp-block-group linkinbio-single-nav">
            <!-- wp:post-navigation-link {"type":"previous","label":"Previous Article","showTitle":true,"className":"linkinbio-single-nav-prev"} /-->
            <!-- wp:post-navigation-link {"type":"next","label":"Next Article","showTitle":true,"className":"linkinbio-single-nav-next","textAlign":"right"} /-->
        </div>
        <!-- /wp:group -->
    </div>
    <!-- /wp:group -->

</article>
<!-- /wp:group -->
