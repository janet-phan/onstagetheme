<?php
/**
 * Title: Performance &amp; Competition Programs
 * Slug: onstage/performance-competition
 * Categories: onstage
 * Block Types: core/post-content
 * Post Types: page
 */
$photo  = onstage_img( 'performance-competition.jpg' );
$office = 'tel:' . ONSTAGE_PHONE_TEL;
$email  = 'mailto:' . ONSTAGE_EMAIL;
?>
<!-- wp:group {"align":"full","className":"page-header company-title-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull page-header company-title-section">
	<!-- wp:heading {"textAlign":"center","level":1,"className":"pink-text program-child-title"} -->
	<h1 class="wp-block-heading has-text-align-center pink-text program-child-title">PERFORMANCE &amp; COMPETITION</h1>
	<!-- /wp:heading -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"announcement-section bg-light-gray company-intro-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull announcement-section bg-light-gray company-intro-section">
	<!-- wp:columns {"verticalAlignment":"center","className":"announcement-content"} -->
	<div class="wp-block-columns announcement-content are-vertically-aligned-center">
		<!-- wp:column {"className":"announcement-img"} -->
		<div class="wp-block-column announcement-img">
			<!-- wp:image {"sizeSlug":"large"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $photo; ?>" alt="On Stage performance and competition dancer"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"announcement-text"} -->
		<div class="wp-block-column announcement-text">
			<!-- wp:heading {"level":2} -->
			<h2 class="wp-block-heading">COMPANY &amp; PERFORMANCE TEAMS</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"className":"mb-30"} -->
			<p class="mb-30">On Stage performance and competition programs give dedicated dancers a pathway into youth, junior, and senior company teams. Placement is based on age, experience, readiness, and instructor recommendation.</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3,"className":"pink-text"} -->
			<h3 class="wp-block-heading pink-text">MORE INFORMATION COMING SOON</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Full team descriptions, audition details, and competition calendars will be published here. Contact the front office for current placement and rehearsal expectations.</p>
			<!-- /wp:paragraph -->
			<!-- wp:html -->
			<p class="btn-container program-child-actions"><a class="btn btn-pink rounded-pill" href="<?php echo esc_url( $office ); ?>">CALL THE FRONT OFFICE</a><a class="btn btn-black" href="<?php echo esc_url( $email ); ?>">EMAIL US</a></p>
			<!-- /wp:html -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"acting-programs-section company-teams-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull acting-programs-section company-teams-section">
	<!-- wp:heading {"textAlign":"center","className":"pink-text"} -->
	<h2 class="wp-block-heading has-text-align-center pink-text">PERFORMANCE TEAM PATHWAYS</h2>
	<!-- /wp:heading -->
	<!-- wp:html -->
	<div class="programs-grid company-team-grid">
		<div class="program-card">
			<h3 class="pink-text"><i class="fa-solid fa-children" aria-hidden="true"></i> JUNIOR YOUTH COMPANY</h3>
			<p><strong>Ages 9–11</strong> · Three hours plus Saturday rehearsals, one costume plus rentals, and three dances in the recital.</p>
		</div>
		<div class="program-card">
			<h3 class="pink-text"><i class="fa-solid fa-star" aria-hidden="true"></i> JUNIOR COMPANY</h3>
			<p><strong>Ages 10–13</strong> · Five hours plus Saturday rehearsals, one costume plus rentals, and three dances in the recital.</p>
		</div>
		<div class="program-card">
			<h3 class="pink-text"><i class="fa-solid fa-arrow-trend-up" aria-hidden="true"></i> SENIOR APPRENTICE</h3>
			<p><strong>Ages 14–18</strong> · Seven and one-half hours plus Saturday rehearsals, one costume, and costume rentals.</p>
		</div>
		<div class="program-card">
			<h3 class="pink-text"><i class="fa-solid fa-trophy" aria-hidden="true"></i> SENIOR COMPANY</h3>
			<p><strong>Ages 15–18</strong> · Seven and one-half hours plus Saturday rehearsals, one costume, and costume rentals.</p>
		</div>
		<div class="program-card">
			<h3 class="pink-text"><i class="fa-solid fa-masks-theater" aria-hidden="true"></i> ALL PERFORMANCE TEAMS</h3>
			<p>Every performance-team member appears in the Christmas Spectacular and the Spring Musical.</p>
		</div>
	</div>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->

<?php echo onstage_gkac_box_blocks(); ?>
