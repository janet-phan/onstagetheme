<?php
/**
 * Title: Programs &amp; Classes
 * Slug: onstage/programs
 * Categories: onstage
 * Block Types: core/post-content
 * Post Types: page
 * Description: Program catalog plus the Fall 2026–2027 Class CPT schedule.
 */
$form = ONSTAGE_SCHOLARSHIP_FORM;
$c1   = onstage_img( 'children-program.jpg' );
$c2   = onstage_img( 'recreational-dance.jpg' );
$c3   = onstage_img( 'musical-theatre-program.jpg' );
$c4   = onstage_img( 'performance-competition.jpg' );
$c5   = onstage_img( 'voice-lessons.jpg' );
$c6   = onstage_img( 'voice.jpg' );
?>
<!-- wp:group {"align":"full","className":"page-header","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull page-header">
	<!-- wp:heading {"textAlign":"center","level":1,"className":"pink-text programs-page-title"} -->
	<h1 class="wp-block-heading has-text-align-center pink-text programs-page-title">PROGRAMS AND CLASSES</h1>
	<!-- /wp:heading -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"acting-programs-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull acting-programs-section">
	<!-- wp:heading {"textAlign":"center","level":2,"className":"pink-text programs-section-label"} -->
	<h2 class="wp-block-heading has-text-align-center pink-text programs-section-label">PROGRAMS</h2>
	<!-- /wp:heading -->
	<!-- wp:group {"className":"programs-intro"} -->
	<div class="wp-block-group programs-intro">
		<!-- wp:heading {"textAlign":"center","level":3} -->
		<h3 class="wp-block-heading has-text-align-center">There's Something for Everyone in the Family at On Stage</h3>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"align":"center"} -->
		<p class="has-text-align-center">On Stage Academy of Performing Arts has created opportunities for every kind of performer in a family-friendly atmosphere. Learn more about our different programs below.</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
	<!-- wp:columns {"className":"programs-grid program-catalog-grid"} -->
	<div class="wp-block-columns programs-grid program-catalog-grid">
		<!-- wp:column {"className":"program-card program-catalog-card"} -->
		<div class="wp-block-column program-card program-catalog-card">
			<!-- wp:image {"sizeSlug":"large","className":"program-catalog-image"} -->
			<figure class="wp-block-image size-large program-catalog-image"><img src="<?php echo $c1; ?>" alt="Children's Programs"/></figure>
			<!-- /wp:image -->
			<!-- wp:group {"className":"program-catalog-body"} -->
			<div class="wp-block-group program-catalog-body">
				<!-- wp:heading {"textAlign":"center","level":3,"className":"green-text"} -->
				<h3 class="wp-block-heading has-text-align-center green-text">Children's Programs</h3>
				<!-- /wp:heading -->
				<!-- wp:html -->
				<p class="program-catalog-action"><a class="btn btn-pink rounded-pill program-catalog-button" href="/children-program/">LEARN MORE</a></p>
				<!-- /wp:html -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"program-card program-catalog-card"} -->
		<div class="wp-block-column program-card program-catalog-card">
			<!-- wp:image {"sizeSlug":"large","className":"program-catalog-image"} -->
			<figure class="wp-block-image size-large program-catalog-image"><img src="<?php echo $c2; ?>" alt="Recreational Dance Program"/></figure>
			<!-- /wp:image -->
			<!-- wp:group {"className":"program-catalog-body"} -->
			<div class="wp-block-group program-catalog-body">
				<!-- wp:heading {"textAlign":"center","level":3,"className":"green-text"} -->
				<h3 class="wp-block-heading has-text-align-center green-text">Recreational Dance Program</h3>
				<!-- /wp:heading -->
				<!-- wp:html -->
				<p class="program-catalog-action"><a class="btn btn-pink rounded-pill program-catalog-button" href="/recreational-dance/">LEARN MORE</a></p>
				<!-- /wp:html -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"program-card program-catalog-card"} -->
		<div class="wp-block-column program-card program-catalog-card">
			<!-- wp:image {"sizeSlug":"large","className":"program-catalog-image"} -->
			<figure class="wp-block-image size-large program-catalog-image"><img src="<?php echo $c3; ?>" alt="Musical Theater Program"/></figure>
			<!-- /wp:image -->
			<!-- wp:group {"className":"program-catalog-body"} -->
			<div class="wp-block-group program-catalog-body">
				<!-- wp:heading {"textAlign":"center","level":3,"className":"green-text"} -->
				<h3 class="wp-block-heading has-text-align-center green-text">Musical Theater Program</h3>
				<!-- /wp:heading -->
				<!-- wp:html -->
				<p class="program-catalog-action"><a class="btn btn-pink rounded-pill program-catalog-button" href="/musical-theater/">LEARN MORE</a></p>
				<!-- /wp:html -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
	<!-- wp:columns {"className":"programs-grid program-catalog-grid"} -->
	<div class="wp-block-columns programs-grid program-catalog-grid">
		<!-- wp:column {"className":"program-card program-catalog-card"} -->
		<div class="wp-block-column program-card program-catalog-card" id="coming-soon">
			<!-- wp:image {"sizeSlug":"large","className":"program-catalog-image"} -->
			<figure class="wp-block-image size-large program-catalog-image"><img src="<?php echo $c4; ?>" alt="Performance and Competition Programs"/></figure>
			<!-- /wp:image -->
			<!-- wp:group {"className":"program-catalog-body"} -->
			<div class="wp-block-group program-catalog-body">
				<!-- wp:heading {"textAlign":"center","level":3,"className":"green-text"} -->
				<h3 class="wp-block-heading has-text-align-center green-text">Performance &amp; Competition Programs</h3>
				<!-- /wp:heading -->
				<!-- wp:html -->
				<p class="program-catalog-action"><a class="btn btn-pink rounded-pill program-catalog-button catalog-coming-soon" href="/performance-competition/">MORE INFO COMING SOON</a></p>
				<!-- /wp:html -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"program-card program-catalog-card"} -->
		<div class="wp-block-column program-card program-catalog-card">
			<!-- wp:image {"sizeSlug":"large","className":"program-catalog-image"} -->
			<figure class="wp-block-image size-large program-catalog-image"><img src="<?php echo $c5; ?>" alt="Voice Lessons"/></figure>
			<!-- /wp:image -->
			<!-- wp:group {"className":"program-catalog-body"} -->
			<div class="wp-block-group program-catalog-body">
				<!-- wp:heading {"textAlign":"center","level":3,"className":"green-text"} -->
				<h3 class="wp-block-heading has-text-align-center green-text">Voice Lessons</h3>
				<!-- /wp:heading -->
				<!-- wp:html -->
				<p class="program-catalog-action"><a class="btn btn-pink rounded-pill program-catalog-button" href="/voice-piano/">LEARN MORE</a></p>
				<!-- /wp:html -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"program-card program-catalog-card"} -->
		<div class="wp-block-column program-card program-catalog-card">
			<!-- wp:image {"sizeSlug":"large","className":"program-catalog-image"} -->
			<figure class="wp-block-image size-large program-catalog-image"><img src="<?php echo $c6; ?>" alt="Piano Lessons"/></figure>
			<!-- /wp:image -->
			<!-- wp:group {"className":"program-catalog-body"} -->
			<div class="wp-block-group program-catalog-body">
				<!-- wp:heading {"textAlign":"center","level":3,"className":"green-text"} -->
				<h3 class="wp-block-heading has-text-align-center green-text">Piano Lessons</h3>
				<!-- /wp:heading -->
				<!-- wp:html -->
				<p class="program-catalog-action"><a class="btn btn-pink rounded-pill program-catalog-button" href="/voice-piano/">LEARN MORE</a></p>
				<!-- /wp:html -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"gkac-application-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull gkac-application-section">
	<!-- wp:group {"className":"gkac-application-box"} -->
	<div class="wp-block-group gkac-application-box">
		<!-- wp:paragraph {"className":"gkac-application-icon"} -->
		<p class="gkac-application-icon"><i class="fa-solid fa-graduation-cap" aria-hidden="true"></i></p>
		<!-- /wp:paragraph -->
		<!-- wp:group {"className":"gkac-application-content"} -->
		<div class="wp-block-group gkac-application-content">
			<!-- wp:heading {"level":2} -->
			<h2 class="wp-block-heading">Give Kids A Chance</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Financial assistance may be available for eligible families through the Give Kids A Chance Program. Complete the online application to be considered for participation.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<!-- wp:html -->
		<p class="gkac-application-action"><a class="btn gkac-application-button" href="<?php echo esc_url( $form ); ?>" target="_blank" rel="noreferrer noopener">Apply for the Give Kids A Chance Program</a></p>
		<!-- /wp:html -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->

<?php echo onstage_load_pattern_file( 'fall-schedule.php' ); ?>
