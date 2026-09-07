<?php
/**
 * Title: Musical Theater
 * Slug: onstage/musical-theater
 * Categories: onstage
 * Block Types: core/post-content
 * Post Types: page
 */
$intro  = onstage_img( 'musical.jpg' );
$circle = onstage_img( 'musical-theatre-program.jpg' );
$office = 'tel:' . ONSTAGE_PHONE_TEL;
$email  = 'mailto:' . ONSTAGE_EMAIL;
?>
<!-- wp:group {"align":"full","className":"page-header musical-title-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull page-header musical-title-section">
	<!-- wp:heading {"textAlign":"center","level":1,"className":"pink-text program-child-title"} -->
	<h1 class="wp-block-heading has-text-align-center pink-text program-child-title">MUSICAL THEATER</h1>
	<!-- /wp:heading -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"announcement-section bg-light-gray musical-intro-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull announcement-section bg-light-gray musical-intro-section">
	<!-- wp:columns {"verticalAlignment":"center","className":"announcement-content"} -->
	<div class="wp-block-columns announcement-content are-vertically-aligned-center">
		<!-- wp:column {"className":"announcement-img"} -->
		<div class="wp-block-column announcement-img">
			<!-- wp:image {"sizeSlug":"large"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $intro; ?>" alt="On Stage students performing in a musical theater production"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"announcement-text"} -->
		<div class="wp-block-column announcement-text">
			<!-- wp:heading {"level":2} -->
			<h2 class="wp-block-heading">TRIPLE-THREAT TRAINING</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"className":"mb-30"} -->
			<p class="mb-30">Musical Theater students receive training in acting, voice, and dance. Every class includes voice coaching, acting, theater skills, performance technique, stage movement, dance, and choreography.</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3,"className":"pink-text"} -->
			<h3 class="wp-block-heading pink-text">EXPERIENCED INSTRUCTION</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Classes are taught by experienced performing arts professionals Linda Mercer-Botelho, Roger Botelho, Karen White, and Christopher Mc Intyre.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"recital-section bg-light-blue musical-schedule-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull recital-section bg-light-blue musical-schedule-section">
	<!-- wp:columns {"verticalAlignment":"center","className":"recital-content"} -->
	<div class="wp-block-columns recital-content are-vertically-aligned-center">
		<!-- wp:column {"width":"38%","className":"recital-image"} -->
		<div class="wp-block-column recital-image" style="flex-basis:38%">
			<!-- wp:image {"sizeSlug":"large"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $circle; ?>" alt="On Stage student performing"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"recital-text"} -->
		<div class="wp-block-column recital-text">
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">MUSICAL THEATER SCHEDULE</h3>
			<!-- /wp:heading -->
			<!-- wp:html -->
			<p class="date-text"><i class="fa-regular fa-calendar-days" aria-hidden="true"></i> Musical Theater I — Ages 9–12</p>
			<p>Tuesdays, 4:30–5:30 p.m.</p>
			<hr class="musical-schedule-rule"/>
			<p class="date-text"><i class="fa-regular fa-calendar-days" aria-hidden="true"></i> Musical Theater II — Ages 6–9</p>
			<p>Tuesday, 5:30–7:00 p.m.</p>
			<hr class="musical-schedule-rule"/>
			<p class="date-text"><i class="fa-regular fa-calendar-days" aria-hidden="true"></i> Musical Theater III — Ages 10–13</p>
			<p>Tuesday, 5:30–7:30 p.m.</p>
			<hr class="musical-schedule-rule"/>
			<p class="date-text"><i class="fa-regular fa-calendar-days" aria-hidden="true"></i> Musical Theater IV — Ages 14–18</p>
			<p>Thursday, 7:00–8:00 p.m.</p>
			<hr class="musical-schedule-rule"/>
			<p class="date-text"><i class="fa-regular fa-calendar-days" aria-hidden="true"></i> Musical Theater V — Ages 14–18</p>
			<p>Thursday, 7:00–8:30 p.m.</p>
			<p class="btn-container program-child-actions"><a class="btn btn-pink" href="<?php echo esc_url( $office ); ?>">CALL THE FRONT OFFICE</a><a class="btn btn-black" href="<?php echo esc_url( $email ); ?>">EMAIL US</a></p>
			<!-- /wp:html -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"acting-programs-section musical-learn-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull acting-programs-section musical-learn-section">
	<!-- wp:heading {"textAlign":"center","className":"pink-text"} -->
	<h2 class="wp-block-heading has-text-align-center pink-text">WHAT STUDENTS WILL LEARN</h2>
	<!-- /wp:heading -->
	<!-- wp:html -->
	<div class="programs-grid musical-learn-grid">
		<div class="program-card">
			<h3 class="pink-text"><i class="fa-solid fa-comments" aria-hidden="true"></i> COMMUNICATION SKILLS</h3>
			<p>Theater helps students develop the confidence to speak clearly and thoughtfully while becoming more comfortable presenting in front of an audience.</p>
		</div>
		<div class="program-card">
			<h3 class="pink-text"><i class="fa-solid fa-bullseye" aria-hidden="true"></i> MOTIVATION &amp; COMMITMENT</h3>
			<p>Classes and productions teach students that preparation, responsibility, and commitment are essential parts of completing a successful performance.</p>
		</div>
		<div class="program-card">
			<h3 class="pink-text"><i class="fa-solid fa-eye" aria-hidden="true"></i> CONCENTRATION</h3>
			<p>Acting exercises strengthen focus and concentration—skills students can carry into school and other activities.</p>
		</div>
		<div class="program-card">
			<h3 class="pink-text"><i class="fa-solid fa-person-rays" aria-hidden="true"></i> SELF-CONFIDENCE</h3>
			<p>Students learn to trust their abilities and discover that they can manage new responsibilities, challenges, and performance pressure.</p>
		</div>
		<div class="program-card">
			<h3 class="pink-text"><i class="fa-solid fa-flag-checkered" aria-hidden="true"></i> GOAL ORIENTATION</h3>
			<p>Rehearsing and performing teaches students how to set specific goals, stay on task, and take practical steps toward completing them.</p>
		</div>
		<div class="program-card">
			<h3 class="pink-text"><i class="fa-solid fa-star" aria-hidden="true"></i> ENJOYMENT &amp; COLLABORATION</h3>
			<p>Students experience the joy of creating theater together, supporting fellow performers, and sharing completed work with an audience.</p>
		</div>
	</div>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->

<?php echo onstage_gkac_box_blocks(); ?>
