<?php
/**
 * Title: Fall 2026–2027 Class Schedule
 * Slug: onstage/fall-schedule
 * Categories: onstage
 * Description: Weekday grid from the Class CPT plus Good to Know, performance dates, and contact CTAs. No calendar plugin.
 */
$email = 'mailto:' . ONSTAGE_EMAIL . '?subject=' . rawurlencode( 'Fall 2026-2027 Class Information' );
$phone = 'tel:' . ONSTAGE_PHONE_TEL;
?>
<!-- wp:group {"align":"full","className":"fall-schedule-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull fall-schedule-section" id="fall-schedule">
	<!-- wp:group {"className":"schedule-heading"} -->
	<div class="wp-block-group schedule-heading">
		<!-- wp:paragraph {"align":"center","className":"schedule-season-label pink-text"} -->
		<p class="has-text-align-center schedule-season-label pink-text">FALL 2026-2027 SEASON</p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"textAlign":"center"} -->
		<h2 class="wp-block-heading has-text-align-center">FALL 2026-2027 SCHEDULE</h2>
		<!-- /wp:heading -->
		<!-- wp:html -->
		<p class="has-text-align-center schedule-tagline"><span class="tag-sing">Sing</span> <span>•</span> <span class="tag-dance">Dance</span> <span>•</span> <span class="tag-act">Act</span> <span>•</span> <span class="tag-perform">Perform</span></p>
		<!-- /wp:html -->
		<!-- wp:paragraph {"align":"center","className":"schedule-intro"} -->
		<p class="has-text-align-center schedule-intro">Classes are arranged by day and listed in start-time order. Class placement may depend on age, experience, readiness, and instructor recommendation.</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
	<!-- wp:html -->
	<div class="schedule-key" aria-label="Schedule category key">
		<span class="schedule-key-item"><span class="schedule-key-dot company-dot"></span> Company Teams</span>
		<span class="schedule-key-item"><span class="schedule-key-dot theater-dot"></span> Musical Theater</span>
		<span class="schedule-key-item"><span class="schedule-key-dot combo-dot"></span> Little Ones / Combo</span>
		<span class="schedule-key-item"><span class="schedule-key-dot teen-dot"></span> Teen &amp; Adult</span>
		<span class="schedule-key-item"><span class="schedule-key-dot rehearsal-dot"></span> Rehearsals &amp; Shows</span>
		<span class="schedule-key-item"><span class="schedule-key-dot hiphop-dot"></span> Hip Hop</span>
	</div>
	<!-- /wp:html -->
	<!-- wp:shortcode -->
	[onstage_class_schedule]
	<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"schedule-details-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull schedule-details-section">
	<!-- wp:group {"className":"schedule-details-heading"} -->
	<div class="wp-block-group schedule-details-heading">
		<!-- wp:paragraph {"align":"center","className":"schedule-season-label pink-text"} -->
		<p class="has-text-align-center schedule-season-label pink-text">AGE GROUPS, COMMITMENTS &amp; PERFORMANCES</p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"textAlign":"center"} -->
		<h2 class="wp-block-heading has-text-align-center">GOOD TO KNOW</h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->
	<!-- wp:columns {"className":"schedule-details-grid"} -->
	<div class="wp-block-columns schedule-details-grid">
		<!-- wp:column {"className":"schedule-detail-card"} -->
		<div class="wp-block-column schedule-detail-card">
			<!-- wp:paragraph {"className":"schedule-detail-age"} -->
			<p class="schedule-detail-age">Age 2½–3</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Baby Stars</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>45-minute class, one costume, and one dance in the recital on June 26, 2027.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"schedule-detail-card"} -->
		<div class="wp-block-column schedule-detail-card">
			<!-- wp:paragraph {"className":"schedule-detail-age"} -->
			<p class="schedule-detail-age">Ages 4–5</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Tiny Stars</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>45-minute class, one costume, and one dance in the recital on June 26, 2027.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"schedule-detail-card"} -->
		<div class="wp-block-column schedule-detail-card">
			<!-- wp:paragraph {"className":"schedule-detail-age"} -->
			<p class="schedule-detail-age">Ages 5–7</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Bright Stars</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>45-minute class, one costume, and two dances in the recital on June 26, 2027.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"schedule-detail-card"} -->
		<div class="wp-block-column schedule-detail-card">
			<!-- wp:paragraph {"className":"schedule-detail-age"} -->
			<p class="schedule-detail-age">Ages 7–10</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">My Mini's</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>A 1½-hour class with Saturday rehearsals as needed, one costume, performances in the Christmas Spectacular and Spring Musical, and one competition to be announced.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
	<!-- wp:columns {"className":"schedule-details-grid"} -->
	<div class="wp-block-columns schedule-details-grid">
		<!-- wp:column {"className":"schedule-detail-card"} -->
		<div class="wp-block-column schedule-detail-card">
			<!-- wp:paragraph {"className":"schedule-detail-age"} -->
			<p class="schedule-detail-age">Ages 7–10</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Beginner Ballet</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>One-hour class, one costume, and one dance in the recital on June 26, 2027.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"schedule-detail-card"} -->
		<div class="wp-block-column schedule-detail-card">
			<!-- wp:paragraph {"className":"schedule-detail-age"} -->
			<p class="schedule-detail-age">Ages 7–10</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Beginner Jazz and Tap</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>One-hour class, one costume, and two dances in the recital on June 26, 2027.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"schedule-detail-card"} -->
		<div class="wp-block-column schedule-detail-card">
			<!-- wp:paragraph {"className":"schedule-detail-age"} -->
			<p class="schedule-detail-age">Levels 1–4</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Musical Theater</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Students perform in the Christmas Spectacular on December 5–6, 2026, and the Spring Musical on May 14–15, 2027.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"schedule-detail-card"} -->
		<div class="wp-block-column schedule-detail-card">
			<!-- wp:paragraph {"className":"schedule-detail-age"} -->
			<p class="schedule-detail-age">Musical Theater Students</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Triple Threat Teens Club</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Additional dance and movement training for the stage, one costume, and two dances in the recital on June 26, 2027.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
	<!-- wp:columns {"className":"schedule-details-grid"} -->
	<div class="wp-block-columns schedule-details-grid">
		<!-- wp:column {"className":"schedule-detail-card"} -->
		<div class="wp-block-column schedule-detail-card">
			<!-- wp:paragraph {"className":"schedule-detail-age"} -->
			<p class="schedule-detail-age">Adult Program</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Adult Tap &amp; Jazz</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Runs September through November, takes a holiday break, resumes in January, and ends in May.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"schedule-detail-card"} -->
		<div class="wp-block-column schedule-detail-card">
			<!-- wp:paragraph {"className":"schedule-detail-age"} -->
			<p class="schedule-detail-age">Performance Team</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Junior Youth Company</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Three hours plus Saturday rehearsals, one costume plus rentals, and three dances in the recital.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"schedule-detail-card"} -->
		<div class="wp-block-column schedule-detail-card">
			<!-- wp:paragraph {"className":"schedule-detail-age"} -->
			<p class="schedule-detail-age">Performance Team</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Junior Company</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Five hours plus Saturday rehearsals, one costume plus rentals, and three dances in the recital.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"schedule-detail-card"} -->
		<div class="wp-block-column schedule-detail-card">
			<!-- wp:paragraph {"className":"schedule-detail-age"} -->
			<p class="schedule-detail-age">Performance Team</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Senior Apprentice</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Seven and one-half hours plus Saturday rehearsals, one costume, and costume rentals.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
	<!-- wp:columns {"className":"schedule-details-grid"} -->
	<div class="wp-block-columns schedule-details-grid">
		<!-- wp:column {"className":"schedule-detail-card"} -->
		<div class="wp-block-column schedule-detail-card">
			<!-- wp:paragraph {"className":"schedule-detail-age"} -->
			<p class="schedule-detail-age">Performance Team</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Senior Company</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Seven and one-half hours plus Saturday rehearsals, one costume, and costume rentals.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"schedule-detail-card schedule-detail-featured"} -->
		<div class="wp-block-column schedule-detail-card schedule-detail-featured">
			<!-- wp:paragraph {"className":"schedule-detail-age"} -->
			<p class="schedule-detail-age">All Company Levels</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">All Performance Teams</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Every performance-team member appears in the Christmas Spectacular and the Spring Musical.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column -->
		<div class="wp-block-column"></div>
		<!-- /wp:column -->
		<!-- wp:column -->
		<div class="wp-block-column"></div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:html -->
	<div class="schedule-dates-banner">
		<div class="schedule-dates-heading">
			<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
			<div>
				<p>MARK THE CALENDAR</p>
				<h3>2026–2027 Performance Dates</h3>
			</div>
		</div>
		<div class="schedule-date-list">
			<div class="schedule-date-item">
				<strong>Christmas Spectacular</strong>
				<span>December 5–6, 2026</span>
			</div>
			<div class="schedule-date-item">
				<strong>Spring Musical</strong>
				<span>May 14–15, 2027</span>
			</div>
			<div class="schedule-date-item">
				<strong>Recital</strong>
				<span>June 26, 2027</span>
			</div>
		</div>
	</div>
	<!-- /wp:html -->

	<!-- wp:group {"className":"schedule-contact"} -->
	<div class="wp-block-group schedule-contact">
		<!-- wp:heading {"textAlign":"center"} -->
		<h2 class="wp-block-heading has-text-align-center">NEED HELP CHOOSING A CLASS?</h2>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"align":"center"} -->
		<p class="has-text-align-center">Contact the front office for help with placement, availability, registration, and performance-team requirements.</p>
		<!-- /wp:paragraph -->
		<!-- wp:html -->
		<p class="cta-buttons program-child-actions"><a class="btn btn-pink rounded-pill" href="<?php echo esc_url( $phone ); ?>">CALL THE FRONT OFFICE</a><a class="btn btn-black" href="<?php echo esc_url( $email ); ?>">EMAIL ON STAGE</a></p>
		<!-- /wp:html -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
