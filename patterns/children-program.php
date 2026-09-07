<?php
/**
 * Title: Children's Programs
 * Slug: onstage/children-program
 * Categories: onstage
 * Block Types: core/post-content
 * Post Types: page
 */
$intro   = onstage_img( 'recital.jpg' );
$tiny    = onstage_img( 'children-program.jpg' );
$bright  = onstage_img( 'dance.jpg' );
$minis   = onstage_img( 'musical.jpg' );
$grow    = onstage_img( 'dance.jpg' );
$studio  = ONSTAGE_STUDIO_URL;
$office  = 'tel:' . ONSTAGE_PHONE_TEL;
$email   = 'mailto:' . ONSTAGE_EMAIL . '?subject=' . rawurlencode( "Children's Program Information" );
?>
<!-- wp:group {"align":"full","className":"page-header children-title-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull page-header children-title-section">
	<!-- wp:heading {"textAlign":"center","level":1,"className":"pink-text program-child-title"} -->
	<h1 class="wp-block-heading has-text-align-center pink-text program-child-title">CHILDREN'S PROGRAMS</h1>
	<!-- /wp:heading -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"announcement-section bg-light-gray children-intro-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull announcement-section bg-light-gray children-intro-section">
	<!-- wp:columns {"verticalAlignment":"center","className":"announcement-content"} -->
	<div class="wp-block-columns announcement-content are-vertically-aligned-center">
		<!-- wp:column {"className":"announcement-img"} -->
		<div class="wp-block-column announcement-img">
			<!-- wp:image {"sizeSlug":"large"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $intro; ?>" alt="Young On Stage dancers performing together"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"announcement-text"} -->
		<div class="wp-block-column announcement-text">
			<!-- wp:heading {"level":2} -->
			<h2 class="wp-block-heading">A POSITIVE FIRST STEP INTO THE PERFORMING ARTS</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"className":"mb-30"} -->
			<p class="mb-30">On Stage offers small class sizes so each child receives personal attention while building a strong foundation in dance, movement, music, and performance.</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3,"className":"pink-text"} -->
			<h3 class="wp-block-heading pink-text">LEARN, GROW, AND HAVE FUN</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Classes are designed to help young students develop coordination, musical awareness, listening skills, creativity, self-esteem, and confidence in a welcoming and age-appropriate environment.</p>
			<!-- /wp:paragraph -->
			<!-- wp:html -->
			<p class="btn-container program-child-actions"><a class="btn btn-pink" href="<?php echo esc_url( $studio ); ?>" target="_blank" rel="noreferrer noopener">REGISTER NOW</a><a class="btn btn-black" href="<?php echo esc_url( $office ); ?>">CALL THE FRONT OFFICE</a></p>
			<!-- /wp:html -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"acting-programs-section children-pathways-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull acting-programs-section children-pathways-section">
	<!-- wp:heading {"textAlign":"center","className":"pink-text"} -->
	<h2 class="wp-block-heading has-text-align-center pink-text">CHILDREN'S CLASS PATHWAYS</h2>
	<!-- /wp:heading -->
	<!-- wp:html -->
	<div class="programs-grid children-pathway-grid">
		<article class="program-card">
			<img src="<?php echo $tiny; ?>" alt="Young children performing ballet"/>
			<h3 class="pink-text"><i class="fa-solid fa-star" aria-hidden="true"></i> BABY STARS &amp; TINY STARS</h3>
			<p><strong>Baby Stars:</strong> Ages 3–4<br><strong>Tiny Stars:</strong> Ages 4–5</p>
			<p>These creative movement, pre-ballet, and pre-tap classes are designed especially for On Stage’s youngest students.</p>
			<p>Children begin developing coordination, rhythm, musical awareness, classroom listening skills, and confidence while using their natural creativity.</p>
		</article>
		<article class="program-card">
			<img src="<?php echo $bright; ?>" alt="Children performing a jazz dance together"/>
			<h3 class="pink-text"><i class="fa-solid fa-music" aria-hidden="true"></i> BRIGHT STARS &amp; RISING STARS</h3>
			<p><strong>Bright Stars:</strong> Ages 5–6<br><strong>Rising Stars:</strong> Approximately ages 5–7</p>
			<p>These combination classes introduce the fundamentals of ballet, tap, and jazz in one weekly class.</p>
			<p>Students expand their dance vocabulary, technique, musicality, confidence, and performance skills as class length and expectations grow with their age and experience.</p>
		</article>
		<article class="program-card">
			<img src="<?php echo $minis; ?>" alt="Children performing together in a musical theater production"/>
			<h3 class="pink-text"><i class="fa-solid fa-masks-theater" aria-hidden="true"></i> MY MINI'S</h3>
			<p><strong>Recommended ages:</strong> Approximately 7–9</p>
			<p>My Mini’s students continue their ballet, tap, and jazz development while adding more focused jazz technique.</p>
			<p>Students may also begin adding musical theater to their studies, combining training in music, dance, and drama in a supportive performance environment.</p>
		</article>
	</div>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->

<?php echo onstage_gkac_box_blocks(); ?>

<!-- wp:group {"align":"full","className":"recital-section bg-light-blue children-grow-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull recital-section bg-light-blue children-grow-section">
	<!-- wp:columns {"verticalAlignment":"center","className":"recital-content"} -->
	<div class="wp-block-columns recital-content are-vertically-aligned-center">
		<!-- wp:column {"width":"38%","className":"recital-image"} -->
		<div class="wp-block-column recital-image" style="flex-basis:38%">
			<!-- wp:image {"sizeSlug":"large"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $grow; ?>" alt="On Stage dancers performing on stage"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"recital-text"} -->
		<div class="wp-block-column recital-text">
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">GROWING WITH ON STAGE</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>As students gain confidence and experience, On Stage offers a pathway into age- and ability-appropriate youth, company, and teen programs.</p>
			<!-- /wp:paragraph -->
			<!-- wp:html -->
			<p class="date-text"><i class="fa-solid fa-children" aria-hidden="true"></i> Junior Youth Group — Ages 9–11</p>
			<p class="date-text"><i class="fa-solid fa-star" aria-hidden="true"></i> Junior Company — Ages 10–13</p>
			<p class="date-text"><i class="fa-solid fa-arrow-trend-up" aria-hidden="true"></i> Senior Apprentice Company — Ages 14–18</p>
			<p class="date-text"><i class="fa-solid fa-trophy" aria-hidden="true"></i> Senior Company — Ages 15–18</p>
			<p class="date-text"><i class="fa-solid fa-masks-theater" aria-hidden="true"></i> Teen Recreational Dance &amp; Musical Theater</p>
			<!-- /wp:html -->
			<!-- wp:paragraph -->
			<p>Final class placement may be based on the student’s age, experience, readiness, and instructor recommendation.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"registration-section children-register-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull registration-section children-register-section">
	<!-- wp:heading {"textAlign":"center","className":"pink-text"} -->
	<h2 class="wp-block-heading has-text-align-center pink-text">FIND THE RIGHT CLASS FOR YOUR CHILD</h2>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"align":"center","className":"mb-30"} -->
	<p class="has-text-align-center mb-30">Contact the front office for help choosing the appropriate program, age group, and class level.</p>
	<!-- /wp:paragraph -->
	<!-- wp:html -->
	<p class="cta-buttons program-child-actions"><a class="btn btn-pink-large" href="<?php echo esc_url( $studio ); ?>" target="_blank" rel="noreferrer noopener">REGISTER FOR CLASSES</a><a class="btn btn-black" href="<?php echo esc_url( $email ); ?>">EMAIL ON STAGE</a></p>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
