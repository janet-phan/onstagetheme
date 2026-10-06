<?php
/**
 * Title: About
 * Slug: onstage/about
 * Categories: onstage
 * Block Types: core/post-content
 * Post Types: page
 */
$mission = onstage_img( 'missionstatement.jpg' );
?>
<!-- wp:group {"align":"full","className":"mission-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull mission-section">
	<!-- wp:heading {"textAlign":"center","className":"pink-text"} -->
	<h2 class="wp-block-heading has-text-align-center pink-text">MISSION STATEMENT</h2>
	<!-- /wp:heading -->
	<!-- wp:columns {"className":"mission-content"} -->
	<div class="wp-block-columns mission-content">
		<!-- wp:column {"className":"mission-text"} -->
		<div class="wp-block-column mission-text">
			<!-- wp:paragraph -->
			<p>At On Stage Theatrical Productions, our mission is to inspire, educate, and empower children and young adults through high-quality performing arts education and live theatrical experiences.</p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph -->
			<p>We are dedicated to providing a safe, supportive, and inclusive environment where students can develop their talents in theater, dance, voice, and performance while building confidence, creativity, discipline, teamwork, and leadership skills that will benefit them throughout their lives.</p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph -->
			<p>Through professional instruction, productions, and community programs, we strive to make the performing arts accessible to children and families throughout Fall River and the surrounding South Coast community, including those who may not otherwise have access to arts education opportunities. We believe every child deserves the opportunity to experience the joy, confidence, and personal growth that the performing arts can provide.</p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph -->
			<p>On Stage Theatrical Productions is committed to enriching the community through the arts while encouraging self-expression, cultural appreciation, educational achievement, and a lifelong love of performance and creativity.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"mission-image"} -->
		<div class="wp-block-column mission-image">
			<!-- wp:image {"sizeSlug":"large"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $mission; ?>" alt="Students in costume"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"vision-section bg-light-blue","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull vision-section bg-light-blue">
	<!-- wp:heading {"textAlign":"center","className":"white-text"} -->
	<h2 class="wp-block-heading has-text-align-center white-text">VISION STATEMENT</h2>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"align":"center","className":"vision-body"} -->
	<p class="has-text-align-center vision-body">The vision of On Stage Theatrical Productions is to create a thriving and inclusive performing arts community where every child has the opportunity to discover their talents, build confidence, and achieve their fullest potential through the arts.</p>
	<!-- /wp:paragraph -->
	<!-- wp:paragraph {"align":"center","className":"vision-body"} -->
	<p class="has-text-align-center vision-body">We envision a future where children and families throughout Fall River and the South Coast region have access to exceptional performing arts education, live theater experiences, and creative opportunities regardless of financial or social barriers.</p>
	<!-- /wp:paragraph -->
	<!-- wp:paragraph {"align":"center","className":"vision-body"} -->
	<p class="has-text-align-center vision-body">Through theater, dance, voice, and performance, On Stage strives to inspire the next generation of artists, educators, leaders, and community members while fostering creativity, discipline, compassion, collaboration, and lifelong appreciation for the arts.</p>
	<!-- /wp:paragraph -->
	<!-- wp:paragraph {"align":"center","className":"vision-body"} -->
	<p class="has-text-align-center vision-body">Our goal is to continue building a respected community arts organization that transforms lives, strengthens families, enriches the cultural landscape of the region, and empowers young people to shine both on stage and beyond.</p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"leadership-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull leadership-section">
	<!-- wp:heading {"textAlign":"center","className":"pink-text"} -->
	<h2 class="wp-block-heading has-text-align-center pink-text">LEADERSHIP / INSTRUCTORS</h2>
	<!-- /wp:heading -->
<?php echo onstage_render_staff_profiles(); ?>
</div>
<!-- /wp:group -->

<?php echo onstage_load_pattern_file( 'success-stats.php' ); ?>

<?php echo onstage_load_pattern_file( 'partners.php' ); ?>

<?php echo onstage_load_pattern_file( 'cta-join-tickets.php' ); ?>
