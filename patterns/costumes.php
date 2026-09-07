<?php
/**
 * Title: Costume Rentals
 * Slug: onstage/costumes
 * Categories: onstage
 * Block Types: core/post-content
 * Post Types: page
 */
$email  = 'mailto:' . ONSTAGE_EMAIL . '?subject=' . rawurlencode( 'Costume Rental Inquiry' );
$overview = onstage_img( 'costume-christmas-carol.jpg' );
$schools  = onstage_img( 'costume-oliver.jpg' );
$oliver   = onstage_img( 'costume-oliver.jpg' );
$peter    = onstage_img( 'costume-peter-pan.jpg' );
$carol    = onstage_img( 'costume-christmas-carol.jpg' );
?>
<!-- wp:group {"align":"full","className":"costume-overview-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull costume-overview-section">
	<!-- wp:heading {"textAlign":"center","level":1,"className":"pink-text"} -->
	<h1 class="wp-block-heading has-text-align-center pink-text">COSTUME RENTALS</h1>
	<!-- /wp:heading -->
	<!-- wp:columns {"verticalAlignment":"center","className":"overview-row"} -->
	<div class="wp-block-columns overview-row are-vertically-aligned-center">
		<!-- wp:column {"className":"overview-image"} -->
		<div class="wp-block-column overview-image">
			<!-- wp:image {"sizeSlug":"large"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $overview; ?>" alt="Actors in period costumes from an On Stage production"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"overview-text"} -->
		<div class="wp-block-column overview-text">
			<!-- wp:heading {"className":"green-text"} -->
			<h2 class="wp-block-heading green-text">RENTAL OVERVIEW</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>On Stage offers costume rentals for schools, nonprofits, and community performing arts organizations looking to bring their productions to life.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
	<!-- wp:columns {"verticalAlignment":"center","className":"overview-row overview-row-flip"} -->
	<div class="wp-block-columns overview-row overview-row-flip are-vertically-aligned-center">
		<!-- wp:column {"className":"overview-text"} -->
		<div class="wp-block-column overview-text">
			<!-- wp:heading {"className":"green-text"} -->
			<h2 class="wp-block-heading green-text">FOR SCHOOLS &amp; THEATERS</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>We proudly support educational and nonprofit arts organizations with high-quality costume rental options for performances and productions.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"overview-image"} -->
		<div class="wp-block-column overview-image">
			<!-- wp:image {"sizeSlug":"large"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $schools; ?>" alt="Outdoor period costumes available for schools and theaters"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"costume-categories-section bg-light-blue","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull costume-categories-section bg-light-blue">
	<!-- wp:heading {"textAlign":"center","className":"white-text"} -->
	<h2 class="wp-block-heading has-text-align-center white-text">FEATURED COSTUME COLLECTIONS</h2>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"align":"center","className":"white-text"} -->
	<p class="has-text-align-center white-text">Select a production to view examples from its costume collection.</p>
	<!-- /wp:paragraph -->
	<!-- wp:html -->
	<div class="costume-categories-grid">
		<a class="category-card costume-gallery-trigger" href="/oliver-costumes/">
			<div class="category-title">OLIVER</div>
			<img src="<?php echo $oliver; ?>" alt="Oliver costume collection"/>
			<div class="costume-gallery-label"><i class="fa-solid fa-images" aria-hidden="true"></i> VIEW COLLECTION</div>
		</a>
		<a class="category-card costume-gallery-trigger" href="/peter-pan-costumes/">
			<div class="category-title">PETER PAN</div>
			<img src="<?php echo $peter; ?>" alt="Peter Pan costume collection"/>
			<div class="costume-gallery-label"><i class="fa-solid fa-images" aria-hidden="true"></i> VIEW COLLECTION</div>
		</a>
		<a class="category-card costume-gallery-trigger" href="/christmas-carol-costumes/">
			<div class="category-title">A CHRISTMAS CAROL</div>
			<img src="<?php echo $carol; ?>" alt="A Christmas Carol costume collection"/>
			<div class="costume-gallery-label"><i class="fa-solid fa-images" aria-hidden="true"></i> VIEW COLLECTION</div>
		</a>
	</div>
	<!-- /wp:html -->
	<!-- wp:group {"className":"other-costume-shows"} -->
	<div class="wp-block-group other-costume-shows">
		<!-- wp:heading {"textAlign":"center","level":3} -->
		<h3 class="wp-block-heading has-text-align-center">OTHER AVAILABLE SHOWS</h3>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"align":"center"} -->
		<p class="has-text-align-center">Additional costume collections may be available for:</p>
		<!-- /wp:paragraph -->
		<!-- wp:list {"className":"other-costume-shows-list"} -->
		<ul class="wp-block-list other-costume-shows-list">
			<!-- wp:list-item -->
			<li>Annie</li>
			<!-- /wp:list-item -->
			<!-- wp:list-item -->
			<li>Geppetto and Son</li>
			<!-- /wp:list-item -->
			<!-- wp:list-item -->
			<li>Mulan</li>
			<!-- /wp:list-item -->
			<!-- wp:list-item -->
			<li>The Little Mermaid</li>
			<!-- /wp:list-item -->
			<!-- wp:list-item -->
			<li>Madeline and the Gypsies</li>
			<!-- /wp:list-item -->
		</ul>
		<!-- /wp:list -->
		<!-- wp:paragraph {"align":"center"} -->
		<p class="has-text-align-center">Please contact Linda for current availability, sizing, pricing, and production-specific rental information.</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"rental-form-cta-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull rental-form-cta-section">
	<!-- wp:heading {"textAlign":"center","className":"pink-text"} -->
	<h2 class="wp-block-heading has-text-align-center pink-text">INTERESTED IN RENTING COSTUMES?</h2>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"align":"center"} -->
	<p class="has-text-align-center">Please email Linda for information about costume availability, rental pricing, sizing, and the rental process.</p>
	<!-- /wp:paragraph -->
	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-onstage-green"} -->
	<div class="wp-block-button is-style-onstage-green"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $email ); ?>">EMAIL LINDA ABOUT COSTUME RENTALS</a></div>
	<!-- /wp:button --></div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
