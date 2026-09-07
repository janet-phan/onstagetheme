<?php
/**
 * Title: Scholarships
 * Slug: onstage/scholarships
 * Categories: onstage
 * Block Types: core/post-content
 * Post Types: page
 */
$photo = onstage_img( 'scholarship.jpg' );
$form  = ONSTAGE_SCHOLARSHIP_FORM;
?>
<!-- wp:group {"align":"full","className":"page-header scholarship-header","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull page-header scholarship-header">
	<!-- wp:heading {"textAlign":"center","level":1,"className":"pink-text"} -->
	<h1 class="wp-block-heading has-text-align-center pink-text">SCHOLARSHIP PROGRAM</h1>
	<!-- /wp:heading -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"scholarship-intro bg-light-gray","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull scholarship-intro bg-light-gray">
	<!-- wp:columns {"className":"scholarship-grid"} -->
	<div class="wp-block-columns scholarship-grid">
		<!-- wp:column {"className":"scholarship-text"} -->
		<div class="wp-block-column scholarship-text">
			<!-- wp:heading {"className":"pink-text"} -->
			<h2 class="wp-block-heading pink-text">GIVE KIDS A CHANCE</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"className":"subtitle purple-text"} -->
			<p class="subtitle purple-text">Sponsored by On Stage Theatrical Productions, Inc.</p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph -->
			<p><strong>Give Kids A Chance</strong> is a scholarship program created to provide underserved youth of the City of Fall River with the opportunity to participate in quality performing arts education through On Stage Theatrical Productions, Inc.</p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph -->
			<p>The program is designed to introduce children to the arts in a positive, structured, and educational environment where they can grow in confidence, creativity, teamwork, discipline, and self-expression through dance and performance opportunities.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"scholarship-image"} -->
		<div class="wp-block-column scholarship-image">
			<!-- wp:image {"sizeSlug":"large"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $photo; ?>" alt="Students performing on stage in the Give Kids A Chance program"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"policies-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull policies-section">
	<!-- wp:group {"className":"policy-card"} -->
	<div class="wp-block-group policy-card">
		<!-- wp:heading -->
		<h2 class="wp-block-heading">TRIAL PERIOD &amp; POLICIES</h2>
		<!-- /wp:heading -->
		<!-- wp:paragraph -->
		<p>Students accepted into the scholarship program will begin with a <strong>six-week trial period</strong>. During this time, students and families are expected to follow all studio policies and procedures, including:</p>
		<!-- /wp:paragraph -->
		<!-- wp:list {"className":"policy-list"} -->
		<ul class="wp-block-list policy-list">
			<!-- wp:list-item -->
			<li>Arriving for class and pick-up on time</li>
			<!-- /wp:list-item -->
			<!-- wp:list-item -->
			<li>No horseplay or disruptive behavior</li>
			<!-- /wp:list-item -->
			<!-- wp:list-item -->
			<li>Hair neatly secured in a ballet bun for class</li>
			<!-- /wp:list-item -->
			<!-- wp:list-item -->
			<li>Showing respect toward teachers, staff, fellow students, and studio property</li>
			<!-- /wp:list-item -->
			<!-- wp:list-item -->
			<li>Respectful behavior in the studio and lobby areas</li>
			<!-- /wp:list-item -->
			<!-- wp:list-item -->
			<li>Proper dress code and clean uniform each week</li>
			<!-- /wp:list-item -->
			<!-- wp:list-item -->
			<li>Practicing at home and arriving prepared each week</li>
			<!-- /wp:list-item -->
		</ul>
		<!-- /wp:list -->
		<!-- wp:paragraph -->
		<p>At the conclusion of each six-week session, the Board of Directors will review student participation, attendance, effort, behavior, and family cooperation to determine continued scholarship eligibility for the following session.</p>
		<!-- /wp:paragraph -->
		<!-- wp:paragraph {"className":"pink-text scholarship-footnote"} -->
		<p class="pink-text scholarship-footnote">* Scholarship assistance is based on financial need and program availability.</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"eligibility-section bg-light-blue","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull eligibility-section bg-light-blue">
	<!-- wp:group {"className":"eligibility-card"} -->
	<div class="wp-block-group eligibility-card">
		<!-- wp:heading -->
		<h2 class="wp-block-heading">ELIGIBILITY INDICATORS</h2>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"className":"eligibility-subhead"} -->
		<p class="eligibility-subhead">Please review the indicators below. Households that meet one or more of these criteria may apply:</p>
		<!-- /wp:paragraph -->
		<!-- wp:html -->
		<form id="eligibilityForm" class="eligibility-form">
			<label class="checkbox-label"><input type="checkbox" name="eligibility" value="free-lunch"/> Free/Reduced Lunch</label>
			<label class="checkbox-label"><input type="checkbox" name="eligibility" value="snap-ebt"/> SNAP/EBT Assistance</label>
			<label class="checkbox-label"><input type="checkbox" name="eligibility" value="medicaid"/> MassHealth/Medicaid</label>
			<label class="checkbox-label"><input type="checkbox" name="eligibility" value="single-parent"/> Single Parent Household</label>
			<label class="checkbox-label"><input type="checkbox" name="eligibility" value="hardship"/> Financial Hardship</label>
			<label class="checkbox-label"><input type="checkbox" name="eligibility" value="foster"/> Foster Care / Guardianship / Adopted</label>
			<label class="checkbox-label"><input type="checkbox" name="eligibility" value="referred"/> Referred by School or Community Program</label>
		</form>
		<!-- /wp:html -->
		<!-- wp:group {"className":"app-cta-box"} -->
		<div class="wp-block-group app-cta-box">
			<!-- wp:heading {"textAlign":"center","level":3} -->
			<h3 class="wp-block-heading has-text-align-center">Apply for the Give Kids A Chance Scholarship</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center">Complete the online application to be considered. Please review the eligibility information above before applying.</p>
			<!-- /wp:paragraph -->
			<!-- wp:html -->
			<p class="program-child-actions has-text-align-center"><a class="btn btn-pink rounded-pill" href="<?php echo esc_url( $form ); ?>" target="_blank" rel="noreferrer noopener">START APPLICATION</a></p>
			<!-- /wp:html -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
