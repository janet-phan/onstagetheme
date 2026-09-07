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
	<!-- wp:columns {"className":"gallery-grid-new show-gallery-grid"} -->
	<div class="wp-block-columns gallery-grid-new show-gallery-grid">
		<!-- wp:column {"className":"gallery-item-new"} -->
		<div class="wp-block-column gallery-item-new">
			<!-- wp:cover {"url":"<?php echo $dare; ?>","alt":"Dare to Dream","dimRatio":50,"overlayColor":"dark","isUserOverlayColor":true,"minHeight":280,"minHeightUnit":"px","className":"show-gallery-card"} -->
			<div class="wp-block-cover show-gallery-card" style="min-height:280px"><span aria-hidden="true" class="wp-block-cover__background has-dark-background-color has-background-dim"></span><img class="wp-block-cover__image-background" alt="Dare to Dream" src="<?php echo $dare; ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container">
				<!-- wp:heading {"textAlign":"center","level":3} -->
				<h3 class="wp-block-heading has-text-align-center">DARE TO DREAM</h3>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"align":"center","className":"view-gallery-link"} -->
				<p class="has-text-align-center view-gallery-link"><a href="/dare-to-dream-gallery/">VIEW GALLERY</a></p>
				<!-- /wp:paragraph -->
			</div></div>
			<!-- /wp:cover -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"gallery-item-new"} -->
		<div class="wp-block-column gallery-item-new">
			<!-- wp:cover {"url":"<?php echo $peter; ?>","alt":"Peter Pan","dimRatio":50,"overlayColor":"dark","isUserOverlayColor":true,"minHeight":280,"minHeightUnit":"px","className":"show-gallery-card"} -->
			<div class="wp-block-cover show-gallery-card" style="min-height:280px"><span aria-hidden="true" class="wp-block-cover__background has-dark-background-color has-background-dim"></span><img class="wp-block-cover__image-background" alt="Peter Pan" src="<?php echo $peter; ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container">
				<!-- wp:heading {"textAlign":"center","level":3} -->
				<h3 class="wp-block-heading has-text-align-center">PETER PAN</h3>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"align":"center","className":"view-gallery-link"} -->
				<p class="has-text-align-center view-gallery-link"><a href="/peter-pan-gallery/">VIEW GALLERY</a></p>
				<!-- /wp:paragraph -->
			</div></div>
			<!-- /wp:cover -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"gallery-item-new"} -->
		<div class="wp-block-column gallery-item-new">
			<!-- wp:cover {"url":"<?php echo $carol; ?>","alt":"A Christmas Carol","dimRatio":50,"overlayColor":"dark","isUserOverlayColor":true,"minHeight":280,"minHeightUnit":"px","className":"show-gallery-card"} -->
			<div class="wp-block-cover show-gallery-card" style="min-height:280px"><span aria-hidden="true" class="wp-block-cover__background has-dark-background-color has-background-dim"></span><img class="wp-block-cover__image-background" alt="A Christmas Carol" src="<?php echo $carol; ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container">
				<!-- wp:heading {"textAlign":"center","level":3} -->
				<h3 class="wp-block-heading has-text-align-center">A CHRISTMAS CAROL</h3>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"align":"center","className":"view-gallery-link"} -->
				<p class="has-text-align-center view-gallery-link"><a href="/christmas-carol-gallery/">VIEW GALLERY</a></p>
				<!-- /wp:paragraph -->
			</div></div>
			<!-- /wp:cover -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"gallery-item-new"} -->
		<div class="wp-block-column gallery-item-new">
			<!-- wp:cover {"url":"<?php echo $oliver; ?>","alt":"Oliver!","dimRatio":50,"overlayColor":"dark","isUserOverlayColor":true,"minHeight":280,"minHeightUnit":"px","className":"show-gallery-card"} -->
			<div class="wp-block-cover show-gallery-card" style="min-height:280px"><span aria-hidden="true" class="wp-block-cover__background has-dark-background-color has-background-dim"></span><img class="wp-block-cover__image-background" alt="Oliver!" src="<?php echo $oliver; ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container">
				<!-- wp:heading {"textAlign":"center","level":3} -->
				<h3 class="wp-block-heading has-text-align-center">OLIVER!</h3>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"align":"center","className":"view-gallery-link"} -->
				<p class="has-text-align-center view-gallery-link"><a href="/oliver-gallery/">VIEW GALLERY</a></p>
				<!-- /wp:paragraph -->
			</div></div>
			<!-- /wp:cover -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
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
	<!-- wp:columns {"className":"youtube-grid"} -->
	<div class="wp-block-columns youtube-grid">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"youtube-card"} -->
			<div class="wp-block-group youtube-card">
				<!-- wp:shortcode -->
				[onstage_youtube id="Zc7XV9ESEEc" title="On Stage featured video"]
				<!-- /wp:shortcode -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"youtube-card"} -->
			<div class="wp-block-group youtube-card">
				<!-- wp:shortcode -->
				[onstage_youtube id="o6OmG95CnyM" title="On Stage featured video"]
				<!-- /wp:shortcode -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
	<!-- wp:columns {"className":"youtube-grid"} -->
	<div class="wp-block-columns youtube-grid">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"youtube-card"} -->
			<div class="wp-block-group youtube-card">
				<!-- wp:shortcode -->
				[onstage_youtube id="IQyLCBmc0nY" title="On Stage featured video"]
				<!-- /wp:shortcode -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"youtube-card"} -->
			<div class="wp-block-group youtube-card">
				<!-- wp:shortcode -->
				[onstage_youtube id="yRWus1LGt6o" title="On Stage featured video"]
				<!-- /wp:shortcode -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
	<!-- wp:html -->
	<p class="program-child-actions youtube-channel-cta has-text-align-center"><a class="btn btn-pink rounded-pill" href="<?php echo esc_url( $youtube ); ?>" target="_blank" rel="noreferrer noopener">VIEW MORE ON YOUTUBE</a></p>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
