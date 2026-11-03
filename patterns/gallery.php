<?php
/**
 * Title: Photo Gallery
 * Slug: onstage/gallery
 * Categories: onstage
 * Block Types: core/post-content
 * Post Types: page
 */
$dare      = onstage_img( 'gallery-dare-to-dream.jpg' );
$peter     = onstage_img( 'gallery-peter-pan.jpg' );
$carol     = onstage_img( 'gallery-christmas-carol.jpg' );
$oliver    = onstage_img( 'gallery-oliver.jpg' );
$youtube   = 'https://www.youtube.com/channel/UCYURAEfRUgjAipibRgcIiOg';
?>
<!-- wp:group {"align":"full","className":"page-header gallery-page-header","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull page-header gallery-page-header">
	<!-- wp:heading {"textAlign":"center","level":1,"className":"gallery-page-title"} -->
	<h1 class="wp-block-heading has-text-align-center gallery-page-title">PHOTO &amp; VIDEO GALLERY</h1>
	<!-- /wp:heading -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"photo-gallery-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull photo-gallery-section">
	<!-- wp:heading {"textAlign":"center","className":"pink-text"} -->
	<h2 class="wp-block-heading has-text-align-center pink-text">PREVIOUS SHOW GALLERIES</h2>
	<!-- /wp:heading -->
	<!-- wp:shortcode -->
	[onstage_gallery_grid type="photo"]
	<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"video-gallery-section bg-light-blue","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull video-gallery-section bg-light-blue">
	<!-- wp:heading {"textAlign":"center"} -->
	<h2 class="wp-block-heading has-text-align-center">FEATURED VIDEOS</h2>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"align":"center"} -->
	<p class="has-text-align-center">Enjoy highlights from On Stage performances and productions.</p>
	<!-- /wp:paragraph -->
	<!-- wp:shortcode -->
	[onstage_featured_videos]
	<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->
