<?php
/**
 * Title: Recreational Dance
 * Slug: onstage/recreational-dance
 * Categories: onstage
 * Block Types: core/post-content
 * Post Types: page
 */
$photo = onstage_img( 'recreational-dance.jpg' );
?>
<!-- wp:group {"align":"full","className":"page-header dance-title-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull page-header dance-title-section">
	<!-- wp:heading {"textAlign":"center","level":1,"className":"pink-text program-child-title"} -->
	<h1 class="wp-block-heading has-text-align-center pink-text program-child-title">RECREATIONAL DANCE</h1>
	<!-- /wp:heading -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"announcement-section bg-light-gray dance-intro-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull announcement-section bg-light-gray dance-intro-section">
	<!-- wp:columns {"verticalAlignment":"center","className":"announcement-content"} -->
	<div class="wp-block-columns announcement-content are-vertically-aligned-center">
		<!-- wp:column {"className":"announcement-img"} -->
		<div class="wp-block-column announcement-img">
			<!-- wp:image {"sizeSlug":"large"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $photo; ?>" alt="On Stage dance student performing"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"announcement-text"} -->
		<div class="wp-block-column announcement-text">
			<!-- wp:heading {"level":2} -->
			<h2 class="wp-block-heading">RECREATIONAL CLASSES</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"className":"mb-30"} -->
			<p class="mb-30">On Stage offers recreational dance classes for a variety of ages and experience levels. Students are introduced to movement, music, dance technique, and performance in a positive and welcoming environment.</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3,"className":"pink-text"} -->
			<h3 class="wp-block-heading pink-text">SING. DANCE. ACT. PERFORM.</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>From our youngest dancers through teens and adults, recreational classes give students opportunities to build technique, confidence, creativity, and a love of performing.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"acting-programs-section dance-offerings-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull acting-programs-section dance-offerings-section">
	<!-- wp:heading {"textAlign":"center","className":"pink-text"} -->
	<h2 class="wp-block-heading has-text-align-center pink-text">DANCE CLASS OFFERINGS</h2>
	<!-- /wp:heading -->
	<!-- wp:html -->
	<div class="programs-grid recreational-class-grid">
		<div class="program-card">
			<h3 class="pink-text"><i class="fa-solid fa-star" aria-hidden="true"></i> BABY STARS</h3>
			<p>An introductory movement class designed for On Stage’s youngest students, providing an early opportunity to explore music, movement, and dance.</p>
		</div>
		<div class="program-card">
			<h3 class="pink-text"><i class="fa-solid fa-star" aria-hidden="true"></i> TINY STARS</h3>
			<p>A beginning dance class that introduces young students to basic movement, rhythm, coordination, and classroom skills in an age-appropriate environment.</p>
		</div>
		<div class="program-card">
			<h3 class="pink-text"><i class="fa-solid fa-star" aria-hidden="true"></i> BRIGHT STARS</h3>
			<p>Young dancers continue developing movement, coordination, musicality, and foundational dance skills while building confidence in the classroom.</p>
		</div>
		<div class="program-card">
			<h3 class="pink-text"><i class="fa-solid fa-star" aria-hidden="true"></i> RISING STARS</h3>
			<p>A recreational class designed to help developing dancers strengthen their technique, musicality, coordination, and performance skills.</p>
		</div>
		<div class="program-card">
			<h3 class="pink-text"><i class="fa-solid fa-music" aria-hidden="true"></i> MY MINI</h3>
			<p>A recreational dance program for young dancers ready to continue developing their technique, confidence, and performance experience.</p>
		</div>
		<div class="program-card">
			<h3 class="pink-text"><i class="fa-solid fa-masks-theater" aria-hidden="true"></i> TEEN TRIPLE THREAT CLUB</h3>
			<p>A program for teens interested in strengthening their performance abilities while developing the skills and confidence needed on stage.</p>
		</div>
		<div class="program-card">
			<h3 class="pink-text"><i class="fa-solid fa-music" aria-hidden="true"></i> ADULT JAZZ</h3>
			<p>A welcoming jazz class for adult dancers focused on movement, technique, musicality, and the enjoyment of dance.</p>
		</div>
	</div>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->

<?php echo onstage_gkac_box_blocks(); ?>
