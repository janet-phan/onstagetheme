<?php
/**
 * First-run content: pages, menu, demo shows, custom logo, static front page.
 *
 * First activation seeds missing pages. Later theme updates refresh seeded
 * page markup when ONSTAGE_CONTENT_VERSION changes (overwrites those pages).
 *
 * @package Onstage
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Flag setup for the next `init` (patterns are registered after `after_setup_theme`).
 */
function onstage_flag_setup() {
	update_option( 'onstage_needs_setup', '1' );
}
add_action( 'after_switch_theme', 'onstage_flag_setup' );

/**
 * Seed demo content on first activation; refresh page markup on version bumps.
 */
function onstage_maybe_seed() {
	if ( '1' === get_option( 'onstage_needs_setup' ) ) {
		if ( ! get_option( 'onstage_setup_complete' ) ) {
			onstage_seed_logo();
			onstage_seed_shows();
			onstage_publish_scheduled_shows();
			onstage_seed_classes();
			$ids = onstage_seed_pages();
			onstage_seed_menu( $ids );
			onstage_configure_reading( $ids );

			if ( '' === get_option( 'permalink_structure' ) ) {
				update_option( 'permalink_structure', '/%postname%/' );
				flush_rewrite_rules();
			}

			update_option( 'onstage_setup_complete', '1' );
			update_option( 'onstage_content_version', ONSTAGE_CONTENT_VERSION );
		}
		delete_option( 'onstage_needs_setup' );
	}
}
add_action( 'init', 'onstage_maybe_seed', 30 );

/**
 * Overwrite seeded page post_content when the theme content version changes.
 *
 * Runs in WP Admin only (so KSES does not strip block comments). Copy the
 * updated theme folder, then open WP Admin once as an editor. Does not require
 * switching themes. This overwrites Home/About/etc. if those pages were edited.
 */
function onstage_maybe_refresh_seeded_content() {
	try {
		if ( ! get_option( 'onstage_setup_complete' ) ) {
			return;
		}
		if ( (string) get_option( 'onstage_content_version' ) === (string) ONSTAGE_CONTENT_VERSION ) {
			return;
		}
		if ( ! current_user_can( 'edit_pages' ) ) {
			return;
		}

		onstage_reset_customized_templates();
		onstage_seed_logo( true );
		onstage_seed_classes();
		onstage_write_seeded_pages();
		onstage_publish_scheduled_shows();

		update_option( 'onstage_content_version', ONSTAGE_CONTENT_VERSION );
	} catch ( Throwable $e ) {
		onstage_log_setup_error( 'Content refresh failed: ' . $e->getMessage() );
	}
}
add_action( 'admin_init', 'onstage_maybe_refresh_seeded_content' );

/**
 * Temporarily drop KSES so seeded block comments / iframes / inputs survive.
 * WordPress has kses_remove_filters() and kses_init() — not kses_restore_filters().
 */
function onstage_kses_pause() {
	if ( function_exists( 'kses_remove_filters' ) ) {
		kses_remove_filters();
	}
}

/**
 * Restore KSES to the capability-correct state for the current user.
 */
function onstage_kses_resume() {
	if ( function_exists( 'kses_init' ) ) {
		kses_init();
		return;
	}
	if ( function_exists( 'kses_init_filters' ) ) {
		kses_init_filters();
	}
}

/**
 * Insert or overwrite seeded pages. Failures are logged; admin is not white-screened.
 */
function onstage_write_seeded_pages() {
	onstage_kses_pause();
	try {
		foreach ( onstage_seeded_pages_map() as $slug => $page ) {
			try {
				$content  = onstage_load_pattern_file( $page['pattern'] );
				$existing = get_page_by_path( $slug );
				if ( $existing ) {
					wp_update_post(
						array(
							'ID'           => $existing->ID,
							'post_content' => $content,
						)
					);
					continue;
				}
				wp_insert_post(
					array(
						'post_type'    => 'page',
						'post_status'  => 'publish',
						'post_title'   => $page['title'],
						'post_name'    => $slug,
						'post_content' => $content,
					)
				);
			} catch ( Throwable $e ) {
				onstage_log_setup_error( 'Failed seeding /' . $slug . '/: ' . $e->getMessage() );
			}
		}
	} catch ( Throwable $e ) {
		onstage_log_setup_error( 'Seeded page write failed: ' . $e->getMessage() );
	} finally {
		onstage_kses_resume();
	}
}

/**
 * @param string $message Error text.
 */
function onstage_log_setup_error( $message ) {
	if ( function_exists( 'error_log' ) ) {
		error_log( 'On Stage theme: ' . $message );
	}
}

/**
 * Drop database copies of this theme’s templates and parts so files in
 * /templates and /parts win (fixes a missing footer / tiny logo when the
 * Site Editor saved an older copy).
 */
function onstage_reset_customized_templates() {
	if ( ! taxonomy_exists( 'wp_theme' ) ) {
		return;
	}

	$theme_slugs = array_unique( array_filter( array( get_stylesheet(), get_template() ) ) );
	$ids         = get_posts(
		array(
			'post_type'              => array( 'wp_template', 'wp_template_part' ),
			'post_status'            => 'any',
			'posts_per_page'         => -1,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'tax_query'              => array(
				array(
					'taxonomy' => 'wp_theme',
					'field'    => 'name',
					'terms'    => $theme_slugs,
				),
			),
		)
	);

	foreach ( $ids as $id ) {
		wp_delete_post( (int) $id, true );
	}
}

/**
 * Upload the theme logo into Media Library and assign it as the custom logo.
 */
function onstage_seed_logo( $force = false ) {
	if ( ! $force && get_theme_mod( 'custom_logo' ) ) {
		return;
	}
	if ( $force ) {
		remove_theme_mod( 'custom_logo' );
	}
	$attachment_id = onstage_sideload_theme_image( 'onstage_logo_transparent.png', __( 'On Stage Logo', 'onstage' ) );
	if ( $attachment_id ) {
		set_theme_mod( 'custom_logo', $attachment_id );
	}
}

/**
 * Copy a theme asset into the Media Library.
 *
 * @param string $filename File in assets/images/.
 * @param string $title    Attachment title.
 * @return int Attachment ID or 0.
 */
function onstage_sideload_theme_image( $filename, $title ) {
	$path = get_template_directory() . '/assets/images/' . $filename;
	if ( ! file_exists( $path ) ) {
		return 0;
	}

	$existing = get_posts(
		array(
			'post_type'      => 'attachment',
			'title'          => $title,
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'post_status'    => 'inherit',
		)
	);
	if ( $existing ) {
		return (int) $existing[0];
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$tmp = wp_tempnam( $filename );
	if ( ! copy( $path, $tmp ) ) {
		return 0;
	}

	$file_array = array(
		'name'     => $filename,
		'tmp_name' => $tmp,
	);

	$attachment_id = media_handle_sideload( $file_array, 0, $title );
	if ( is_wp_error( $attachment_id ) ) {
		@unlink( $tmp ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		return 0;
	}
	return (int) $attachment_id;
}

/**
 * Convert Shows that are Scheduled only because post_date is the performance
 * datetime. Performance text stays in Dates/times meta — this never wipes meta.
 *
 * @return int Number of shows repaired.
 */
function onstage_publish_scheduled_shows() {
	$ids = get_posts(
		array(
			'post_type'      => 'show',
			'post_status'    => array( 'future', 'publish' ),
			'posts_per_page' => -1,
			'orderby'        => 'date',
			'order'          => 'ASC',
			'fields'         => 'ids',
		)
	);

	if ( empty( $ids ) ) {
		return 0;
	}

	$now_ts = current_time( 'timestamp' );
	$fixed  = 0;
	foreach ( $ids as $post_id ) {
		$post = get_post( $post_id );
		if ( ! $post ) {
			continue;
		}
		$date_ts        = strtotime( $post->post_date );
		$needs_unhide   = ( 'future' === $post->post_status ) || ( $date_ts && $date_ts > $now_ts );
		if ( ! $needs_unhide ) {
			continue;
		}

		$local = date( 'Y-m-d H:i:s', $now_ts + $fixed );
		wp_update_post(
			array(
				'ID'            => (int) $post_id,
				'post_status'   => 'publish',
				'post_date'     => $local,
				'post_date_gmt' => get_gmt_from_date( $local ),
				'edit_date'     => true,
			)
		);
		++$fixed;
	}

	if ( $fixed && is_admin() ) {
		set_transient( 'onstage_repaired_shows', $fixed, MINUTE_IN_SECONDS );
	}

	return $fixed;
}

/**
 * Repair scheduled Shows on every WP Admin load (not only a version bump).
 */
function onstage_maybe_repair_scheduled_shows() {
	if ( ! current_user_can( 'edit_posts' ) ) {
		return;
	}
	onstage_publish_scheduled_shows();
}
add_action( 'admin_init', 'onstage_maybe_repair_scheduled_shows', 20 );

/**
 * Tell Janet how many Shows were un-scheduled.
 */
function onstage_repaired_shows_notice() {
	$count = get_transient( 'onstage_repaired_shows' );
	if ( ! $count ) {
		return;
	}
	delete_transient( 'onstage_repaired_shows' );
	echo '<div class="notice notice-success is-dismissible"><p>';
	echo esc_html(
		sprintf(
			/* translators: %d: number of shows */
			_n(
				'On Stage published %d scheduled show so it appears on the site before the performance date. Dates/times meta was not changed.',
				'On Stage published %d scheduled shows so they appear on the site before the performance date. Dates/times meta was not changed.',
				(int) $count,
				'onstage'
			),
			(int) $count
		)
	);
	echo '</p></div>';
}
add_action( 'admin_notices', 'onstage_repaired_shows_notice' );

/**
 * Create three demo productions from the mockup.
 *
 * Publish immediately. Performance dates live in Dates/times meta — a future
 * post_date would make WordPress schedule the show and hide it from listings.
 */
function onstage_seed_shows() {
	$counts = wp_count_posts( 'show' );
	if ( $counts && ( (int) $counts->publish + (int) $counts->future ) > 0 ) {
		return;
	}

	$shows = array(
		array(
			'title'   => 'Christmas Spectacular 30th Anniversary Celebration',
			'slug'    => 'christmas-spectacular',
			'dates'   => "December 5, 2026 - 6:00 PM\nDecember 6, 2026 - 2:00 PM",
			'venue'   => 'Bristol Community College, Fall River, MA',
			'excerpt' => 'A magical tradition for the whole family.',
			'content' => "<!-- wp:paragraph --><p>Join On Stage Theatrical Productions for the 30th Anniversary Christmas Spectacular — a heartwarming holiday tradition for the whole family.</p><!-- /wp:paragraph -->\n<!-- wp:paragraph --><p>Performances at Bristol Community College on Saturday, December 5, 2026 at 6:00 p.m. and Sunday, December 6, 2026 at 2:00 p.m.</p><!-- /wp:paragraph -->",
			'image'   => 'christmas-spectacular.jpg',
			'ticket'  => ONSTAGE_TICKETS_URL,
		),
		array(
			'title'   => 'Spring Musical',
			'slug'    => 'spring-musical',
			'dates'   => '',
			'venue'   => 'Bristol Community College, Fall River, MA',
			'excerpt' => 'Join us for our spring musical production, with details to be announced.',
			'content' => "<!-- wp:paragraph --><p>Join us for our spring musical production. Title, dates, and casting details will be announced as they are confirmed.</p><!-- /wp:paragraph -->\n<!-- wp:paragraph --><p>Venue: Bristol Community College. Performance dates TBA.</p><!-- /wp:paragraph -->",
			'image'   => 'curtains.jpg',
			'ticket'  => ONSTAGE_TICKETS_URL,
		),
		array(
			'title'   => 'Student Showcase',
			'slug'    => 'student-showcase',
			'dates'   => "June 26, 2027\n2:00 p.m. Voice and Piano Recital\n6:00 p.m. Dance Recital",
			'venue'   => 'Bristol Community College, Fall River, MA',
			'excerpt' => 'Celebrate the hard work and achievements of our students.',
			'content' => "<!-- wp:paragraph --><p>Celebrate the hard work and achievements of our students.</p><!-- /wp:paragraph -->\n<!-- wp:paragraph --><p>2:00 p.m. Voice and Piano Recital<br>6:00 p.m. Dance Recital<br>Bristol Community College — June 26, 2027.</p><!-- /wp:paragraph -->",
			'image'   => 'student-showcase.jpg',
			'ticket'  => ONSTAGE_TICKETS_URL,
		),
	);

	$now = current_time( 'mysql' );
	foreach ( $shows as $index => $show ) {
		$local = date( 'Y-m-d H:i:s', strtotime( $now ) + (int) $index );
		$id    = wp_insert_post(
			array(
				'post_type'     => 'show',
				'post_status'   => 'publish',
				'post_title'    => $show['title'],
				'post_name'     => $show['slug'],
				'post_content'  => $show['content'],
				'post_excerpt'  => $show['excerpt'],
				'post_date'     => $local,
				'post_date_gmt' => get_gmt_from_date( $local ),
			)
		);
		if ( is_wp_error( $id ) || ! $id ) {
			continue;
		}
		update_post_meta( $id, 'onstage_show_dates', $show['dates'] );
		update_post_meta( $id, 'onstage_show_venue', $show['venue'] );
		update_post_meta( $id, 'onstage_show_ticket_url', $show['ticket'] );
		$image_id = onstage_sideload_theme_image( $show['image'], $show['title'] . ' artwork' );
		if ( $image_id ) {
			set_post_thumbnail( $id, $image_id );
		}
	}
}

/**
 * Seed Fall 2026–2027 Class CPT rows (once). Does not overwrite edits.
 */
function onstage_seed_classes() {
	$counts = wp_count_posts( 'studio_class' );
	if ( $counts && (int) $counts->publish > 0 ) {
		return;
	}

	foreach ( onstage_class_seed_data() as $row ) {
		$id = wp_insert_post(
			array(
				'post_type'    => 'studio_class',
				'post_status'  => 'publish',
				'post_title'   => $row[0],
				'menu_order'   => (int) $row[7],
			)
		);
		if ( is_wp_error( $id ) || ! $id ) {
			continue;
		}
		update_post_meta( $id, 'onstage_class_weekday', $row[1] );
		update_post_meta( $id, 'onstage_class_time', $row[2] );
		update_post_meta( $id, 'onstage_class_ages', $row[3] );
		update_post_meta( $id, 'onstage_class_instructor', $row[4] );
		update_post_meta( $id, 'onstage_class_category', $row[5] );
		update_post_meta( $id, 'onstage_class_is_new', $row[6] ? 1 : 0 );
	}
}

/**
 * Slug → title/pattern map for first-run seed and later content refreshes.
 *
 * @return array<string, array{title: string, pattern: string}>
 */
function onstage_seeded_pages_map() {
	return array(
		'home'                       => array(
			'title'   => 'Home',
			'pattern' => 'home.php',
		),
		'about'                      => array(
			'title'   => 'About',
			'pattern' => 'about.php',
		),
		'programs'                   => array(
			'title'   => 'Programs & Classes',
			'pattern' => 'programs.php',
		),
		'shows'                      => array(
			'title'   => 'Shows & Tickets',
			'pattern' => 'shows.php',
		),
		'scholarships'               => array(
			'title'   => 'Scholarship Program',
			'pattern' => 'scholarships.php',
		),
		'costume-rentals'            => array(
			'title'   => 'Costume Rentals',
			'pattern' => 'costumes.php',
		),
		'gallery'                    => array(
			'title'   => 'Photo & Video Gallery',
			'pattern' => 'gallery.php',
		),
		'christmas-carol-costumes'   => array(
			'title'   => 'A Christmas Carol Costumes',
			'pattern' => 'christmas-carol-costumes.php',
		),
		'oliver-costumes'            => array(
			'title'   => 'Oliver Costumes',
			'pattern' => 'oliver-costumes.php',
		),
		'peter-pan-costumes'         => array(
			'title'   => 'Peter Pan Costumes',
			'pattern' => 'peter-pan-costumes.php',
		),
		'children-program'           => array(
			'title'   => "Children's Programs",
			'pattern' => 'children-program.php',
		),
		'recreational-dance'         => array(
			'title'   => 'Recreational Dance',
			'pattern' => 'recreational-dance.php',
		),
		'musical-theater'            => array(
			'title'   => 'Musical Theater',
			'pattern' => 'musical-theater.php',
		),
		'voice-piano'                => array(
			'title'   => 'Voice & Piano Lessons',
			'pattern' => 'voice-piano.php',
		),
		'performance-competition'    => array(
			'title'   => 'Performance & Competition Programs',
			'pattern' => 'performance-competition.php',
		),
		'dare-to-dream-gallery'      => array(
			'title'   => 'Dare to Dream Gallery',
			'pattern' => 'dare-to-dream-gallery.php',
		),
		'peter-pan-gallery'          => array(
			'title'   => 'Peter Pan Gallery',
			'pattern' => 'peter-pan-gallery.php',
		),
		'christmas-carol-gallery'    => array(
			'title'   => 'A Christmas Carol Gallery',
			'pattern' => 'christmas-carol-gallery.php',
		),
		'oliver-gallery'             => array(
			'title'   => 'Oliver! Gallery',
			'pattern' => 'oliver-gallery.php',
		),
		'privacy-policy'             => array(
			'title'   => 'Privacy Policy',
			'pattern' => 'privacy.php',
		),
		'terms-of-use'               => array(
			'title'   => 'Terms of Use',
			'pattern' => 'terms.php',
		),
	);
}

/**
 * Create the mockup pages with pattern content.
 *
 * @return array Map of slug => page ID.
 */
function onstage_seed_pages() {
	$map = onstage_seeded_pages_map();

	$ids = array();
	foreach ( $map as $slug => $page ) {
		$existing = get_page_by_path( $slug );
		if ( $existing ) {
			$ids[ $slug ] = $existing->ID;
			continue;
		}
		$content = onstage_load_pattern_file( $page['pattern'] );
		$new_id  = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $page['title'],
				'post_name'    => $slug,
				'post_content' => $content,
			)
		);
		if ( ! is_wp_error( $new_id ) ) {
			$ids[ $slug ] = $new_id;
		}
	}
	return $ids;
}

/**
 * Build a Primary menu matching the mockup.
 *
 * @param array $ids Slug => page ID.
 */
function onstage_seed_menu( $ids ) {
	$menu_name = 'Primary';
	$menu      = wp_get_nav_menu_object( $menu_name );
	if ( $menu ) {
		$menu_id = (int) $menu->term_id;
	} else {
		$menu_id = wp_create_nav_menu( $menu_name );
	}

	$order = array(
		'home'            => 'HOME',
		'about'           => 'ABOUT',
		'programs'        => 'PROGRAMS & CLASSES',
		'shows'           => 'SHOWS & TICKETS',
		'scholarships'    => 'SCHOLARSHIPS',
		'costume-rentals' => 'COSTUME RENTALS',
		'gallery'         => 'PHOTO GALLERY',
	);

	$existing_items = wp_get_nav_menu_items( $menu_id );
	if ( empty( $existing_items ) ) {
		$position = 1;
		foreach ( $order as $slug => $label ) {
			if ( empty( $ids[ $slug ] ) ) {
				continue;
			}
			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title'     => $label,
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $ids[ $slug ],
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
					'menu-item-position'  => $position,
				)
			);
			++$position;
		}
	}

	$locations            = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary'] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );

	onstage_seed_navigation_block( $ids, $order );
}

/**
 * Publish a wp_navigation post so the Site Editor header has real links.
 *
 * @param array $ids   Slug => page ID.
 * @param array $order Slug => label.
 */
function onstage_seed_navigation_block( $ids, $order ) {
	$existing = get_posts(
		array(
			'post_type'      => 'wp_navigation',
			'title'          => 'Primary',
			'posts_per_page' => 1,
			'post_status'    => 'publish',
		)
	);
	if ( $existing ) {
		return;
	}

	$blocks = '';
	foreach ( $order as $slug => $label ) {
		if ( empty( $ids[ $slug ] ) ) {
			continue;
		}
		$url     = get_permalink( $ids[ $slug ] );
		$blocks .= '<!-- wp:navigation-link {"label":' . wp_json_encode( $label ) . ',"type":"page","id":' . (int) $ids[ $slug ] . ',"url":' . wp_json_encode( $url ) . ',"kind":"post-type"} /-->' . "\n";
	}

	wp_insert_post(
		array(
			'post_type'    => 'wp_navigation',
			'post_status'  => 'publish',
			'post_title'   => 'Primary',
			'post_name'    => 'primary',
			'post_content' => $blocks,
		)
	);
}

/**
 * Point the front page at Home.
 *
 * @param array $ids Slug => page ID.
 */
function onstage_configure_reading( $ids ) {
	if ( empty( $ids['home'] ) ) {
		return;
	}
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', (int) $ids['home'] );
}
