<?php
/**
 * Title: Home
 * Slug: onstage/home
 * Categories: onstage
 * Block Types: core/post-content
 * Post Types: page
 * Description: Front page: hero, programs, happening now, upcoming shows query, costume teaser, gallery, stats, partners, CTAs.
 */
$hero     = onstage_img( 'hero.jpg' );
$dance    = onstage_img( 'dance.jpg' );
$musical  = onstage_img( 'musical.jpg' );
$sing     = onstage_img( 'sing.jpg' );
$summer   = onstage_img( 'summer.jpg' );
$current  = onstage_img( 'current-show.jpg' );
$summer_p = onstage_img( 'summer-programs.jpg' );
$recital  = onstage_img( 'recital.jpg' );
$costume  = onstage_img( 'costume-banner.jpg' );
$bts      = array(
	onstage_img( 'bts-1.jpg' ),
	onstage_img( 'bts-2.jpg' ),
	onstage_img( 'bts-3.jpg' ),
	onstage_img( 'bts-4.jpg' ),
	onstage_img( 'bts-5.jpg' ),
	onstage_img( 'bts-6.jpg' ),
	onstage_img( 'bts-7.jpg' ),
	onstage_img( 'bts-8.jpg' ),
	onstage_img( 'bts-9.jpg' ),
);
$tickets = ONSTAGE_TICKETS_URL;
$studio  = ONSTAGE_STUDIO_URL;
?>
<!-- wp:cover {"url":"<?php echo $hero; ?>","alt":"","dimRatio":50,"overlayColor":"dark","isUserOverlayColor":true,"minHeight":85,"minHeightUnit":"vh","align":"full","className":"hero-cover","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull hero-cover" style="min-height:85vh"><span aria-hidden="true" class="wp-block-cover__background has-dark-background-color has-background-dim"></span><img class="wp-block-cover__image-background" alt="" src="<?php echo $hero; ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container">
	<!-- wp:columns {"verticalAlignment":"bottom","className":"hero-text-row"} -->
	<div class="wp-block-columns hero-text-row are-vertically-aligned-bottom">
		<!-- wp:column {"width":"50%","verticalAlignment":"bottom","className":"hero-left"} -->
		<div class="wp-block-column is-vertically-aligned-bottom hero-left" style="flex-basis:50%">
			<!-- wp:heading {"level":1,"className":"hero-title"} -->
			<h1 class="wp-block-heading hero-title">ON STAGE<br>THEATRICAL<br>PRODUCTIONS,<br>INC</h1>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"width":"50%","verticalAlignment":"bottom","className":"hero-right"} -->
		<div class="wp-block-column is-vertically-aligned-bottom hero-right" style="flex-basis:50%">
			<!-- wp:heading {"textAlign":"right","level":2,"className":"hero-subtitle"} -->
			<h2 class="wp-block-heading has-text-align-right hero-subtitle">Helping Students Build Confidence and Shine on Stage</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"align":"right","className":"hero-desc"} -->
			<p class="has-text-align-right hero-desc">Acting, Musical Theatre, Dance, and performance opportunities led by professional artists in a supportive, family-centered environment.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
	<!-- wp:html -->
	<div class="hero-buttons-row">
		<a class="btn btn-white-pink btn-hero-large" href="<?php echo esc_url( $tickets ); ?>" target="_blank" rel="noopener noreferrer">Buy Tickets</a>
		<a class="btn btn-white-pink btn-hero-large" href="<?php echo esc_url( $studio ); ?>" target="_blank" rel="noopener noreferrer">Join the Studio</a>
	</div>
	<!-- /wp:html -->
</div></div>
<!-- /wp:cover -->

<!-- wp:group {"align":"full","className":"programs bg-light-blue","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull programs bg-light-blue">
	<!-- wp:heading {"textAlign":"center"} -->
	<h2 class="wp-block-heading has-text-align-center">Explore Our Programs</h2>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"align":"center","className":"subtitle"} -->
	<p class="has-text-align-center subtitle">We offer programs for students of all ages and abilities.</p>
	<!-- /wp:paragraph -->
	<!-- wp:columns {"verticalAlignment":"stretch","className":"programs-grid"} -->
	<div class="wp-block-columns programs-grid are-vertically-aligned-stretch">
		<!-- wp:column {"className":"program-card"} -->
		<div class="wp-block-column program-card">
			<!-- wp:heading {"textAlign":"center","level":3,"className":"pink-text"} -->
			<h3 class="wp-block-heading has-text-align-center pink-text">DANCE</h3>
			<!-- /wp:heading -->
			<!-- wp:group {"className":"program-card-copy"} -->
			<div class="wp-block-group program-card-copy">
				<!-- wp:paragraph -->
				<p>On Stage offers a comprehensive dance program for ages 3 to 18. Our classes are led by trained professional teachers who are dedicated to nurturing each student's passion for dance.<br><br><strong>Our dance programs run for a full 12 months throughout the year.</strong></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
			<!-- wp:image {"sizeSlug":"large"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $dance; ?>" alt="Dance class"/></figure>
			<!-- /wp:image -->
			<!-- wp:group {"className":"program-card-action"} -->
			<div class="wp-block-group program-card-action">
				<!-- wp:html -->
				<p><a class="btn-blue-small" href="/recreational-dance/">Find Out More</a></p>
				<!-- /wp:html -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"program-card"} -->
		<div class="wp-block-column program-card">
			<!-- wp:heading {"textAlign":"center","level":3,"className":"pink-text"} -->
			<h3 class="wp-block-heading has-text-align-center pink-text">MUSICAL THEATER / ACTING</h3>
			<!-- /wp:heading -->
			<!-- wp:group {"className":"program-card-copy"} -->
			<div class="wp-block-group program-card-copy">
				<!-- wp:paragraph -->
				<p>Students learn how to sing, dance, act, and perform. Our instructors nurture talent and creativity in a fun, supportive environment.<br><br><strong>Our theater and acting programs run for a full 12 months throughout the year.</strong></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
			<!-- wp:image {"sizeSlug":"large"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $musical; ?>" alt="Musical theater and acting class"/></figure>
			<!-- /wp:image -->
			<!-- wp:group {"className":"program-card-action"} -->
			<div class="wp-block-group program-card-action">
				<!-- wp:html -->
				<p><a class="btn-blue-small" href="/musical-theater/">Find Out More</a></p>
				<!-- /wp:html -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"program-card"} -->
		<div class="wp-block-column program-card">
			<!-- wp:heading {"textAlign":"center","level":3,"className":"pink-text"} -->
			<h3 class="wp-block-heading has-text-align-center pink-text">VOICE AND PIANO</h3>
			<!-- /wp:heading -->
			<!-- wp:group {"className":"program-card-copy"} -->
			<div class="wp-block-group program-card-copy">
				<!-- wp:paragraph -->
				<p>Engaging voice and piano lessons designed for children who want to enhance their musical theater education.<br><br><strong>Voice lessons run September through June each year.</strong></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
			<!-- wp:image {"sizeSlug":"large"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $sing; ?>" alt="Voice and piano class"/></figure>
			<!-- /wp:image -->
			<!-- wp:group {"className":"program-card-action"} -->
			<div class="wp-block-group program-card-action">
				<!-- wp:html -->
				<p><a class="btn-blue-small" href="/voice-piano/">Find Out More</a></p>
				<!-- /wp:html -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"program-card"} -->
		<div class="wp-block-column program-card">
			<!-- wp:heading {"textAlign":"center","level":3,"className":"pink-text"} -->
			<h3 class="wp-block-heading has-text-align-center pink-text">GIVE KIDS A CHANCE</h3>
			<!-- /wp:heading -->
			<!-- wp:group {"className":"program-card-copy"} -->
			<div class="wp-block-group program-card-copy">
				<!-- wp:paragraph -->
				<p>Give Kids A Chance provides underserved youth in Fall River with access to quality performing arts education through On Stage Theatrical Productions.<br><br><strong>Our dance programs run for a full 12 months throughout the year.</strong></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
			<!-- wp:image {"sizeSlug":"large"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $summer; ?>" alt="Give Kids A Chance"/></figure>
			<!-- /wp:image -->
			<!-- wp:group {"className":"program-card-action"} -->
			<div class="wp-block-group program-card-action">
				<!-- wp:html -->
				<p><a class="btn-blue-small" href="/scholarships/">Find Out More</a></p>
				<!-- /wp:html -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"happening-now","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull happening-now">
	<!-- wp:heading {"textAlign":"center"} -->
	<h2 class="wp-block-heading has-text-align-center">WHAT'S HAPPENING NOW</h2>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"align":"center","className":"subtitle"} -->
	<p class="has-text-align-center subtitle">Explore current productions, classes, and upcoming events.</p>
	<!-- /wp:paragraph -->
	<!-- wp:columns {"className":"news-grid"} -->
	<div class="wp-block-columns news-grid">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":3,"className":"news-title"} -->
			<h3 class="wp-block-heading news-title">CURRENT PRODUCTION</h3>
			<!-- /wp:heading -->
			<!-- wp:group {"className":"news-card"} -->
			<div class="wp-block-group news-card">
				<!-- wp:image {"sizeSlug":"large","linkDestination":"custom"} -->
				<figure class="wp-block-image size-large"><a href="/shows/"><img src="<?php echo $current; ?>" alt="Current production"/></a></figure>
				<!-- /wp:image -->
				<!-- wp:paragraph {"className":"news-banner green-banner"} -->
				<p class="news-banner green-banner"><a href="/shows/">VIEW SHOWS</a></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":3,"className":"news-title"} -->
			<h3 class="wp-block-heading news-title">Summer Program Registration</h3>
			<!-- /wp:heading -->
			<!-- wp:group {"className":"news-card"} -->
			<div class="wp-block-group news-card">
				<!-- wp:image {"sizeSlug":"large","linkDestination":"custom"} -->
				<figure class="wp-block-image size-large"><a href="/programs/"><img src="<?php echo $summer_p; ?>" alt="Summer program registration"/></a></figure>
				<!-- /wp:image -->
				<!-- wp:paragraph {"className":"news-banner green-banner"} -->
				<p class="news-banner green-banner"><a href="/programs/">VIEW PROGRAMS</a></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":3,"className":"news-title"} -->
			<h3 class="wp-block-heading news-title">RECITAL DATES</h3>
			<!-- /wp:heading -->
			<!-- wp:group {"className":"news-card"} -->
			<div class="wp-block-group news-card">
				<!-- wp:image {"sizeSlug":"large","linkDestination":"custom"} -->
				<figure class="wp-block-image size-large"><a href="/shows/"><img src="<?php echo $recital; ?>" alt="Recital dates"/></a></figure>
				<!-- /wp:image -->
				<!-- wp:paragraph {"className":"news-banner green-banner"} -->
				<p class="news-banner green-banner"><a href="/shows/">VIEW SCHEDULE</a></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"shows home-upcoming-shows bg-light-gray","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull shows home-upcoming-shows bg-light-gray">
	<!-- wp:heading {"textAlign":"center","className":"home-upcoming-heading"} -->
	<h2 class="wp-block-heading has-text-align-center home-upcoming-heading">UPCOMING SHOWS AND EVENTS</h2>
	<!-- /wp:heading -->
	<!-- wp:query {"queryId":11,"query":{"perPage":6,"pages":0,"offset":0,"postType":"show","order":"asc","orderBy":"date","inherit":false},"className":"event-list home-upcoming-list"} -->
	<div class="wp-block-query event-list home-upcoming-list">
		<!-- wp:post-template {"layout":{"type":"default"}} -->
			<!-- wp:group {"className":"event-item home-show-card"} -->
			<div class="wp-block-group event-item home-show-card">
				<!-- wp:post-featured-image {"isLink":true,"sizeSlug":"large","className":"home-show-photo"} /-->
				<!-- wp:group {"className":"event-details home-show-body"} -->
				<div class="wp-block-group event-details home-show-body">
					<!-- wp:post-title {"level":3,"isLink":true,"className":"pink-text home-show-title"} /-->
					<!-- wp:onstage/show-listing-meta /-->
					<!-- wp:post-excerpt {"moreText":""} /-->
					<!-- wp:read-more {"content":"LEARN MORE","className":"home-show-learn-more"} /-->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		<!-- /wp:post-template -->
		<!-- wp:query-no-results -->
			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center">Show listings will appear here. Add a Show under <strong>Shows → Add Show</strong> in the dashboard.</p>
			<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->
</div>
<!-- /wp:group -->

<!-- wp:columns {"align":"full","className":"costume-rentals"} -->
<div class="wp-block-columns alignfull costume-rentals">
	<!-- wp:column {"className":"costume-left bg-light-blue"} -->
	<div class="wp-block-column costume-left bg-light-blue">
		<!-- wp:group {"className":"costume-content"} -->
		<div class="wp-block-group costume-content">
			<!-- wp:heading -->
			<h2 class="wp-block-heading">Costume Rentals for Schools &amp; Performing Arts Organizations</h2>
			<!-- /wp:heading -->
			<!-- wp:buttons -->
			<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-onstage-black"} -->
			<div class="wp-block-button is-style-onstage-black"><a class="wp-block-button__link wp-element-button" href="/costume-rentals/">Find Out More</a></div>
			<!-- /wp:button --></div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:column -->
	<!-- wp:column {"className":"costume-right"} -->
	<div class="wp-block-column costume-right">
		<!-- wp:image {"sizeSlug":"large"} -->
		<figure class="wp-block-image size-large"><img src="<?php echo $costume; ?>" alt="Costume rentals"/></figure>
		<!-- /wp:image -->
	</div>
	<!-- /wp:column -->
</div>
<!-- /wp:columns -->

<!-- wp:group {"align":"full","className":"behind-scenes","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull behind-scenes">
	<!-- wp:heading {"textAlign":"center","className":"section-badge bg-pink"} -->
	<h2 class="wp-block-heading has-text-align-center section-badge bg-pink">Behind the Scenes</h2>
	<!-- /wp:heading -->
	<!-- wp:gallery {"columns":3,"imageCrop":true,"linkTo":"none","sizeSlug":"medium","className":"gallery-grid"} -->
	<figure class="wp-block-gallery has-nested-images columns-3 is-cropped gallery-grid">
		<?php foreach ( $bts as $i => $src ) : ?>
		<!-- wp:image {"sizeSlug":"medium","linkDestination":"none"} -->
		<figure class="wp-block-image size-medium"><img src="<?php echo $src; ?>" alt="Behind the scenes <?php echo (int) $i + 1; ?>"/></figure>
		<!-- /wp:image -->
		<?php endforeach; ?>
	</figure>
	<!-- /wp:gallery -->
	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-onstage-pill"} -->
	<div class="wp-block-button is-style-onstage-pill"><a class="wp-block-button__link wp-element-button" href="/gallery/">View More</a></div>
	<!-- /wp:button --></div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<?php echo onstage_load_pattern_file( 'success-stats.php' ); ?>

<?php echo onstage_load_pattern_file( 'partners.php' ); ?>

<?php echo onstage_load_pattern_file( 'cta-join-tickets.php' ); ?>
