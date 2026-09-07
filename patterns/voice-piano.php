<?php
/**
 * Title: Voice &amp; Piano Lessons
 * Slug: onstage/voice-piano
 * Categories: onstage
 * Block Types: core/post-content
 * Post Types: page
 */
$private = onstage_img( 'voice-lessons.jpg' );
$recital = onstage_img( 'voice.jpg' );
$office  = 'tel:' . ONSTAGE_PHONE_TEL;
$email   = 'mailto:' . ONSTAGE_EMAIL;
$phone   = ONSTAGE_PHONE;
?>
<!-- wp:group {"align":"full","className":"voice-piano-page voice-title-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull voice-piano-page voice-title-section">
	<!-- wp:heading {"textAlign":"center","level":1,"className":"pink-text voice-page-title"} -->
	<h1 class="wp-block-heading has-text-align-center pink-text voice-page-title">VOICE AND PIANO LESSONS</h1>
	<!-- /wp:heading -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"voice-private-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull voice-private-section">
	<!-- wp:columns {"verticalAlignment":"center","className":"voice-private-row"} -->
	<div class="wp-block-columns voice-private-row are-vertically-aligned-center">
		<!-- wp:column {"className":"voice-private-photo"} -->
		<div class="wp-block-column voice-private-photo">
			<!-- wp:image {"sizeSlug":"large"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $private; ?>" alt="Student singing during a voice lesson"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"voice-private-copy"} -->
		<div class="wp-block-column voice-private-copy">
			<!-- wp:heading {"level":2,"className":"voice-private-heading"} -->
			<h2 class="wp-block-heading voice-private-heading">PRIVATE LESSONS</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Voice and piano lessons are offered on a private basis. All lessons are scheduled through the On Stage front office.</p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"className":"voice-price pink-text"} -->
			<p class="voice-price pink-text">$30 FOR A 30-MINUTE LESSON</p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph -->
			<p>To ask about availability or schedule a lesson, contact the front office at <strong><?php echo esc_html( $phone ); ?></strong>.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"voice-info-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull voice-info-section">
	<!-- wp:heading {"textAlign":"center","className":"pink-text"} -->
	<h2 class="wp-block-heading has-text-align-center pink-text">LESSON INFORMATION</h2>
	<!-- /wp:heading -->
	<!-- wp:columns {"className":"voice-info-grid"} -->
	<div class="wp-block-columns voice-info-grid">
		<!-- wp:column {"className":"voice-info-card"} -->
		<div class="wp-block-column voice-info-card">
			<!-- wp:paragraph {"className":"voice-info-icon"} -->
			<p class="voice-info-icon"><i class="fa-solid fa-calendar-days" aria-hidden="true"></i></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"textAlign":"center","level":3,"className":"green-text"} -->
			<h3 class="wp-block-heading has-text-align-center green-text">SCHEDULING</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center">All voice and piano lessons must be booked through the front office. Please contact the office directly to discuss lesson availability.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"voice-info-card"} -->
		<div class="wp-block-column voice-info-card">
			<!-- wp:paragraph {"className":"voice-info-icon"} -->
			<p class="voice-info-icon"><i class="fa-solid fa-phone" aria-hidden="true"></i></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"textAlign":"center","level":3,"className":"green-text"} -->
			<h3 class="wp-block-heading has-text-align-center green-text">ILLNESS</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center">When a student is sick and cannot attend a scheduled lesson, a parent or guardian must call the office that morning.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"voice-info-card"} -->
		<div class="wp-block-column voice-info-card">
			<!-- wp:paragraph {"className":"voice-info-icon"} -->
			<p class="voice-info-icon"><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"textAlign":"center","level":3,"className":"green-text"} -->
			<h3 class="wp-block-heading has-text-align-center green-text">MISSED LESSONS</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center">Families will be charged for a scheduled lesson when the student does not attend and the office is not notified.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"voice-recital-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull voice-recital-section">
	<!-- wp:columns {"verticalAlignment":"center","className":"voice-recital-row"} -->
	<div class="wp-block-columns voice-recital-row are-vertically-aligned-center">
		<!-- wp:column {"width":"38%","className":"voice-recital-photo"} -->
		<div class="wp-block-column voice-recital-photo" style="flex-basis:38%">
			<!-- wp:image {"sizeSlug":"large","className":"voice-recital-img"} -->
			<figure class="wp-block-image size-large voice-recital-img"><img src="<?php echo $recital; ?>" alt="Students performing at the voice and piano recital"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"voice-recital-copy"} -->
		<div class="wp-block-column voice-recital-copy">
			<!-- wp:heading {"level":2,"className":"pink-text"} -->
			<h2 class="wp-block-heading pink-text">END-OF-YEAR VOICE AND PIANO RECITAL</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Saturday, June 26, 2027</p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph -->
			<p>2:00 PM</p>
			<!-- /wp:paragraph -->
			<!-- wp:html -->
			<p class="voice-recital-actions"><a class="btn btn-pink" href="<?php echo esc_url( $office ); ?>">CALL THE FRONT OFFICE</a><a class="btn btn-black" href="<?php echo esc_url( $email ); ?>">EMAIL US</a></p>
			<!-- /wp:html -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
