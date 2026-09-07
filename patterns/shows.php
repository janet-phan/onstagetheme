<?php
/**
 * Title: Shows &amp; Tickets
 * Slug: onstage/shows
 * Categories: onstage
 * Block Types: core/post-content
 * Post Types: page
 */
$hero = onstage_img( 'costume-christmas-carol.jpg' );
$g1   = onstage_img( 'gallery-christmas-carol.jpg' );
$g2   = onstage_img( 'gallery-oliver.jpg' );
$g3   = onstage_img( 'gallery-peter-pan.jpg' );
$g4   = onstage_img( 'gallery-dare-to-dream.jpg' );
$g5   = onstage_img( 'musical-theatre-program.jpg' );
$g6   = onstage_img( 'bts-2.jpg' );
$g7   = onstage_img( 'bts-4.jpg' );
$g8   = onstage_img( 'current-show.jpg' );
?>
<!-- wp:group {"align":"full","className":"page-header","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull page-header">
	<!-- wp:heading {"textAlign":"center","level":1,"className":"pink-text shows-page-title"} -->
	<h1 class="wp-block-heading has-text-align-center pink-text shows-page-title">SHOWS &amp; TICKETS</h1>
	<!-- /wp:heading -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"shows-hero-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull shows-hero-section">
	<!-- wp:columns {"verticalAlignment":"center","className":"shows-hero-row"} -->
	<div class="wp-block-columns shows-hero-row are-vertically-aligned-center">
		<!-- wp:column {"className":"shows-hero-photo"} -->
		<div class="wp-block-column shows-hero-photo">
			<!-- wp:image {"sizeSlug":"large"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $hero; ?>" alt="On Stage theatrical production"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"shows-hero-copy"} -->
		<div class="wp-block-column shows-hero-copy">
			<!-- wp:heading {"textAlign":"center","level":2,"className":"shows-section-heading"} -->
			<h2 class="wp-block-heading has-text-align-center shows-section-heading">UPCOMING SHOWS</h2>
			<!-- /wp:heading -->
			<!-- wp:html -->
			<p class="program-child-actions shows-hero-actions has-text-align-center"><a class="btn btn-pink rounded-pill" href="/gallery/">VIEW PAST PRODUCTIONS</a></p>
			<!-- /wp:html -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"buy-tickets-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull buy-tickets-section">
	<!-- wp:heading {"level":2,"className":"green-text buy-tickets-heading"} -->
	<h2 class="wp-block-heading green-text buy-tickets-heading">BUY TICKETS</h2>
	<!-- /wp:heading -->
	<!-- wp:query {"queryId":21,"query":{"perPage":12,"pages":0,"offset":0,"postType":"show","order":"asc","orderBy":"date","inherit":false},"className":"event-list buy-tickets-list"} -->
	<div class="wp-block-query event-list buy-tickets-list">
		<!-- wp:post-template {"layout":{"type":"default"}} -->
			<!-- wp:group {"className":"event-item buy-tickets-row"} -->
			<div class="wp-block-group event-item buy-tickets-row">
				<!-- wp:group {"className":"event-details buy-tickets-text"} -->
				<div class="wp-block-group event-details buy-tickets-text">
					<!-- wp:post-title {"level":3,"isLink":true} /-->
					<!-- wp:shortcode -->
					[onstage_show_details tickets="0"]
					<!-- /wp:shortcode -->
					<!-- wp:post-excerpt /-->
					<!-- wp:read-more {"content":"FIND OUT MORE"} /-->
				</div>
				<!-- /wp:group -->
				<!-- wp:post-featured-image {"isLink":true,"sizeSlug":"large","className":"buy-tickets-poster"} /-->
			</div>
			<!-- /wp:group -->
		<!-- /wp:post-template -->
		<!-- wp:query-no-results -->
			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center">No shows are listed yet. Go to <strong>Shows → Add Show</strong> and click <strong>Publish</strong> now. Leave Dates/times blank to display TBA. Upcoming dates appear immediately — do not schedule the post for the performance day.</p>
			<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"past-productions-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull past-productions-section">
	<!-- wp:heading {"textAlign":"center","level":2,"className":"pink-text shows-section-heading"} -->
	<h2 class="wp-block-heading has-text-align-center pink-text shows-section-heading">PAST PRODUCTIONS &amp; HIGHLIGHTS</h2>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"align":"center"} -->
	<p class="has-text-align-center">Take a look back at memorable performances, talented casts, and special moments from previous On Stage productions.</p>
	<!-- /wp:paragraph -->
	<!-- wp:html -->
	<div class="past-productions-grid past-productions-gallery">
		<a class="past-production-thumb" href="/christmas-carol-gallery/"><img src="<?php echo $g1; ?>" alt="A Christmas Carol"/></a>
		<a class="past-production-thumb" href="/oliver-gallery/"><img src="<?php echo $g2; ?>" alt="Oliver!"/></a>
		<a class="past-production-thumb" href="/peter-pan-gallery/"><img src="<?php echo $g3; ?>" alt="Peter Pan"/></a>
		<a class="past-production-thumb" href="/dare-to-dream-gallery/"><img src="<?php echo $g4; ?>" alt="Dare to Dream"/></a>
		<a class="past-production-thumb" href="/gallery/"><img src="<?php echo $g5; ?>" alt="Musical theater performance"/></a>
		<a class="past-production-thumb" href="/gallery/"><img src="<?php echo $g6; ?>" alt="On Stage rehearsal"/></a>
		<a class="past-production-thumb" href="/gallery/"><img src="<?php echo $g7; ?>" alt="On Stage production still"/></a>
		<a class="past-production-thumb" href="/gallery/"><img src="<?php echo $g8; ?>" alt="Current On Stage production"/></a>
	</div>
	<p class="program-child-actions shows-hero-actions has-text-align-center"><a class="btn btn-pink rounded-pill" href="/gallery/">VIEW MORE</a></p>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
