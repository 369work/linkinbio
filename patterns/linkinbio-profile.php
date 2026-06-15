<?php
/**
 * Title: LinkInBio Profile
 * Slug: linkinbio/profile
 * Categories: linkinbio_patterns
 * Inserter: no
 *
 * @package linkinbio
 * @since 1.0.0
 */
?>
<!-- wp:group {"className":"lib-card lib-profile","ariaLabel":"<?php esc_attr_e('Profile', 'linkinbio'); ?>"} -->
<div class="wp-block-group lib-card lib-profile" aria-label="<?php esc_attr_e('Profile', 'linkinbio'); ?>">
	<!-- wp:group {"className":"lib-avatar"} -->
	<div class="wp-block-group lib-avatar">
		<!-- wp:paragraph {"className":"lib-avatar-initials"} -->
		<p class="lib-avatar-initials"><?php esc_html_e('YN', 'linkinbio'); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
	<!-- wp:heading {"level":1,"className":"lib-name"} -->
	<h1 class="lib-name"><?php esc_html_e('Your Name', 'linkinbio'); ?></h1>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"className":"lib-role"} -->
	<p class="lib-role"><?php esc_html_e('Web Designer / Developer', 'linkinbio'); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:paragraph {"className":"lib-bio"} -->
	<p class="lib-bio"><?php esc_html_e('A short introduction about yourself. Edit this text in the Site Editor to make it your own.', 'linkinbio'); ?></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
