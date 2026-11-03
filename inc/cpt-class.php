<?php
/**
 * Class custom post type — weekly studio schedule cards.
 *
 * Automatically displays classes in chronological order by time slot.
 * Supports standard AM/PM time pickers, 2400 military time, and custom ranges.
 *
 * @package Onstage
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Class CPT (admin: Classes).
 */
function onstage_register_class_cpt() {
	$labels = array(
		'name'               => __( 'Classes', 'onstage' ),
		'singular_name'      => __( 'Class', 'onstage' ),
		'add_new'            => __( 'Add Class', 'onstage' ),
		'add_new_item'       => __( 'Add New Class', 'onstage' ),
		'edit_item'          => __( 'Edit Class', 'onstage' ),
		'new_item'           => __( 'New Class', 'onstage' ),
		'view_item'          => __( 'View Class', 'onstage' ),
		'search_items'       => __( 'Search Classes', 'onstage' ),
		'not_found'          => __( 'No classes found', 'onstage' ),
		'not_found_in_trash' => __( 'No classes found in trash', 'onstage' ),
		'menu_name'          => __( 'Classes', 'onstage' ),
		'all_items'          => __( 'All Classes', 'onstage' ),
	);

	register_post_type(
		'studio_class',
		array(
			'labels'              => $labels,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => true,
			'has_archive'         => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'menu_icon'           => 'dashicons-welcome-learn-more',
			'menu_position'       => 6,
			'supports'            => array( 'title', 'custom-fields', 'page-attributes' ),
			'rewrite'             => false,
		)
	);

	$meta_args = array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'auth_callback'     => function () {
			return current_user_can( 'edit_posts' );
		},
		'sanitize_callback' => 'sanitize_text_field',
	);

	register_post_meta( 'studio_class', 'onstage_class_weekday', array_merge( $meta_args, array(
		'description' => __( 'Weekday key: monday, tuesday, wednesday, thursday, saturday', 'onstage' ),
	) ) );
	register_post_meta( 'studio_class', 'onstage_class_start_time', array_merge( $meta_args, array(
		'description' => __( 'Start time in 24-hr format (HH:MM)', 'onstage' ),
	) ) );
	register_post_meta( 'studio_class', 'onstage_class_end_time', array_merge( $meta_args, array(
		'description' => __( 'End time in 24-hr format (HH:MM)', 'onstage' ),
	) ) );
	register_post_meta( 'studio_class', 'onstage_class_time', array_merge( $meta_args, array(
		'description' => __( 'Formatted time range text, e.g. 3:30–4:30 p.m.', 'onstage' ),
	) ) );
	register_post_meta( 'studio_class', 'onstage_class_time_minutes', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'integer',
		'auth_callback'     => function () {
			return current_user_can( 'edit_posts' );
		},
		'description'       => __( 'Start time in minutes from midnight for chronological sorting', 'onstage' ),
	) );
	register_post_meta( 'studio_class', 'onstage_class_ages', array_merge( $meta_args, array(
		'description' => __( 'Age range or extra note', 'onstage' ),
	) ) );
	register_post_meta( 'studio_class', 'onstage_class_instructor', array_merge( $meta_args, array(
		'description' => __( 'Instructor name(s)', 'onstage' ),
	) ) );
	register_post_meta( 'studio_class', 'onstage_class_category', array_merge( $meta_args, array(
		'description' => __( 'company, theater, combo, teen, rehearsal, or hiphop', 'onstage' ),
	) ) );
	register_post_meta( 'studio_class', 'onstage_class_is_new', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'boolean',
		'auth_callback'     => function () {
			return current_user_can( 'edit_posts' );
		},
		'description'       => __( 'Show a NEW badge on the card', 'onstage' ),
	) );
}
add_action( 'init', 'onstage_register_class_cpt' );

/**
 * Weekday labels and header color (pink Mon/Tue, purple Wed/Thu/Sat).
 *
 * @return array<string, array{label: string, header: string}>
 */
function onstage_class_weekdays() {
	return array(
		'monday'    => array(
			'label'  => __( 'Monday', 'onstage' ),
			'header' => 'blue',
		),
		'tuesday'   => array(
			'label'  => __( 'Tuesday', 'onstage' ),
			'header' => 'pink',
		),
		'wednesday' => array(
			'label'  => __( 'Wednesday', 'onstage' ),
			'header' => 'blue',
		),
		'thursday'  => array(
			'label'  => __( 'Thursday', 'onstage' ),
			'header' => 'purple',
		),
		'saturday'  => array(
			'label'  => __( 'Saturday', 'onstage' ),
			'header' => 'purple',
		),
	);
}

/**
 * Category CSS class map.
 *
 * @return array<string, string>
 */
function onstage_class_categories() {
	return array(
		'company'   => 'schedule-company',
		'theater'   => 'schedule-theater',
		'combo'     => 'schedule-combo',
		'teen'      => 'schedule-teen',
		'rehearsal' => 'schedule-rehearsal',
		'hiphop'    => 'schedule-hiphop',
	);
}

/**
 * Convert class time string to minutes from midnight for chronological sorting.
 * Supports AM/PM, standard 12-hr, and 2400 military time.
 *
 * @param string $time_str Time range or time string.
 * @return int Minutes from midnight (0-1439).
 */
function onstage_parse_class_time( $time_str ) {
	if ( empty( $time_str ) ) {
		return 9999;
	}

	$str = strtolower( trim( $time_str ) );
	$str = str_replace( array( '&ndash;', '—', '–', '-' ), '-', $str );

	$parts = explode( '-', $str );
	$start = trim( $parts[0] );

	// Support pure 2400 military time without colon (e.g. 1530 or 0900)
	if ( preg_match( '/^([01]\d|2[0-3])([0-5]\d)$/', $start, $m_mil ) ) {
		return ( (int) $m_mil[1] * 60 ) + (int) $m_mil[2];
	}

	$start_has_pm = ( false !== strpos( $start, 'pm' ) || false !== strpos( $start, 'p.m.' ) );
	$start_has_am = ( false !== strpos( $start, 'am' ) || false !== strpos( $start, 'a.m.' ) );

	if ( preg_match( '/(\d{1,2})(?::(\d{2}))?/', $start, $matches ) ) {
		$hour = (int) $matches[1];
		$min  = isset( $matches[2] ) ? (int) $matches[2] : 0;

		// If hour is already 24-hr military time (13-23)
		if ( $hour >= 13 && $hour <= 23 ) {
			return ( $hour * 60 ) + $min;
		}

		if ( $start_has_pm ) {
			if ( $hour < 12 ) {
				$hour += 12;
			}
		} elseif ( $start_has_am ) {
			if ( 12 === $hour ) {
				$hour = 0;
			}
		} else {
			// Infer from studio schedule hours (typical afternoon/evening classes: 1:00-7:59 are PM):
			if ( $hour >= 1 && $hour <= 7 ) {
				$hour += 12;
			}
		}

		return ( $hour * 60 ) + $min;
	}

	return 9999;
}

/**
 * Extract 24-hour start and end times (HH:MM) from existing time range string.
 *
 * @param string $time_str Formatted string, e.g. "3:30–4:30 p.m.".
 * @return array{start: string, end: string}
 */
function onstage_extract_time_range_24h( $time_str ) {
	if ( empty( $time_str ) ) {
		return array( 'start' => '', 'end' => '' );
	}

	$clean = strtolower( trim( $time_str ) );
	$clean = str_replace( array( '&ndash;', '—', '–', '-' ), '-', $clean );
	$parts = explode( '-', $clean );

	if ( count( $parts ) < 2 ) {
		$min = onstage_parse_class_time( $clean );
		if ( 9999 !== $min ) {
			return array(
				'start' => sprintf( '%02d:%02d', floor( $min / 60 ), $min % 60 ),
				'end'   => '',
			);
		}
		return array( 'start' => '', 'end' => '' );
	}

	$start_part = trim( $parts[0] );
	$end_part   = trim( $parts[1] );

	$has_pm = ( false !== strpos( $clean, 'pm' ) || false !== strpos( $clean, 'p.m.' ) );

	if ( $has_pm && false === strpos( $start_part, 'am' ) && false === strpos( $start_part, 'a.m.' ) ) {
		$start_part .= ' pm';
	}

	$start_min = onstage_parse_class_time( $start_part );
	$end_min   = onstage_parse_class_time( $end_part );

	return array(
		'start' => ( 9999 !== $start_min ) ? sprintf( '%02d:%02d', floor( $start_min / 60 ), $start_min % 60 ) : '',
		'end'   => ( 9999 !== $end_min ) ? sprintf( '%02d:%02d', floor( $end_min / 60 ), $end_min % 60 ) : '',
	);
}

/**
 * Centered Meta Box for Class details so all editing is in one area.
 */
function onstage_class_meta_box() {
	add_meta_box(
		'onstage_class_details',
		__( '🩰 Studio Class Schedule Details', 'onstage' ),
		'onstage_class_meta_box_html',
		'studio_class',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'onstage_class_meta_box' );

/**
 * Meta box markup with AM/PM and 24-hr time selection.
 *
 * @param WP_Post $post Current post.
 */
function onstage_class_meta_box_html( $post ) {
	wp_nonce_field( 'onstage_class_meta', 'onstage_class_meta_nonce' );
	$weekday    = get_post_meta( $post->ID, 'onstage_class_weekday', true );
	$start_time = get_post_meta( $post->ID, 'onstage_class_start_time', true );
	$end_time   = get_post_meta( $post->ID, 'onstage_class_end_time', true );
	$time       = get_post_meta( $post->ID, 'onstage_class_time', true );
	$ages       = get_post_meta( $post->ID, 'onstage_class_ages', true );
	$instructor = get_post_meta( $post->ID, 'onstage_class_instructor', true );
	$category   = get_post_meta( $post->ID, 'onstage_class_category', true );
	$is_new     = (bool) get_post_meta( $post->ID, 'onstage_class_is_new', true );

	// Pre-populate time pickers from existing time string if empty
	if ( empty( $start_time ) && ! empty( $time ) ) {
		$extracted = onstage_extract_time_range_24h( $time );
		$start_time = $extracted['start'];
		$end_time   = $extracted['end'];
	}
	?>
	<div style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif; padding:10px 0;">
		
		<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:20px; margin-bottom:20px;">
			<!-- Weekday -->
			<div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:8px; padding:16px;">
				<label for="onstage_class_weekday" style="display:block; font-weight:700; font-size:14px; margin-bottom:6px; color:#0f172a;">
					📅 <?php esc_html_e( 'Day of the Week:', 'onstage' ); ?>
				</label>
				<select id="onstage_class_weekday" name="onstage_class_weekday" class="widefat" style="padding:8px 10px; font-size:14px; border-radius:4px;">
					<?php foreach ( onstage_class_weekdays() as $key => $day ) : ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $weekday, $key ); ?>><?php echo esc_html( $day['label'] ); ?></option>
					<?php endforeach; ?>
				</select>
				<span class="description" style="display:block; margin-top:4px; font-size:12px; color:#64748b;"><?php esc_html_e( 'Which day column this class appears under on the weekly schedule.', 'onstage' ); ?></span>
			</div>

			<!-- Time Selection (AM/PM & 24hr Military) -->
			<div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:16px;">
				<label style="display:block; font-weight:700; font-size:14px; margin-bottom:8px; color:#166534;">
					⏰ <?php esc_html_e( 'Class Time Slot (Automatic Chronological Order):', 'onstage' ); ?>
				</label>
				
				<div style="display:flex; gap:12px; align-items:center; flex-wrap:wrap; margin-bottom:10px;">
					<div>
						<label for="onstage_class_start_time" style="display:block; font-size:12px; font-weight:600; color:#166534; margin-bottom:2px;">
							<?php esc_html_e( 'Start Time (AM/PM / 24hr):', 'onstage' ); ?>
						</label>
						<input type="time" id="onstage_class_start_time" name="onstage_class_start_time" value="<?php echo esc_attr( $start_time ); ?>" style="padding:6px 10px; font-size:14px; border-radius:4px; border:1px solid #86efac; background:#fff;" />
					</div>
					<span style="font-weight:700; color:#166534; margin-top:16px;">—</span>
					<div>
						<label for="onstage_class_end_time" style="display:block; font-size:12px; font-weight:600; color:#166534; margin-bottom:2px;">
							<?php esc_html_e( 'End Time (AM/PM / 24hr):', 'onstage' ); ?>
						</label>
						<input type="time" id="onstage_class_end_time" name="onstage_class_end_time" value="<?php echo esc_attr( $end_time ); ?>" style="padding:6px 10px; font-size:14px; border-radius:4px; border:1px solid #86efac; background:#fff;" />
					</div>
				</div>

				<div>
					<label for="onstage_class_time" style="display:block; font-size:12px; font-weight:600; color:#166534; margin-bottom:2px;">
						<?php esc_html_e( 'Schedule Display Text (Auto-formats or type custom):', 'onstage' ); ?>
					</label>
					<input type="text" id="onstage_class_time" name="onstage_class_time" class="widefat" value="<?php echo esc_attr( $time ); ?>" placeholder="3:30–4:30 p.m." style="padding:7px 10px; font-size:14px; border-radius:4px; border:1px solid #86efac; background:#fff;" />
					<span class="description" style="display:block; margin-top:4px; font-size:12px; color:#15803d;">
						<?php esc_html_e( 'Selecting times above auto-formats this text and automatically sorts classes chronologically on the website!', 'onstage' ); ?>
					</span>
				</div>
			</div>
		</div>

		<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:20px; margin-bottom:20px;">
			<!-- Age Group -->
			<div style="background:#fff; border:1px solid #cbd5e1; border-radius:8px; padding:16px;">
				<label for="onstage_class_ages" style="display:block; font-weight:700; font-size:14px; margin-bottom:6px; color:#0f172a;">
					👶 <?php esc_html_e( 'Age Group / Level Note:', 'onstage' ); ?>
				</label>
				<input type="text" id="onstage_class_ages" name="onstage_class_ages" class="widefat" value="<?php echo esc_attr( $ages ); ?>" placeholder="Ages 4–6 or Teen/Adult" style="padding:8px 10px; font-size:14px; border-radius:4px;" />
				<span class="description" style="display:block; margin-top:4px; font-size:12px; color:#64748b;"><?php esc_html_e( 'Student age range or level note.', 'onstage' ); ?></span>
			</div>

			<!-- Instructor -->
			<div style="background:#fff; border:1px solid #cbd5e1; border-radius:8px; padding:16px;">
				<label for="onstage_class_instructor" style="display:block; font-weight:700; font-size:14px; margin-bottom:6px; color:#0f172a;">
					🧑‍🏫 <?php esc_html_e( 'Instructor Name(s):', 'onstage' ); ?>
				</label>
				<input type="text" id="onstage_class_instructor" name="onstage_class_instructor" class="widefat" value="<?php echo esc_attr( $instructor ); ?>" placeholder="Miss Linda / Miss Sarah" style="padding:8px 10px; font-size:14px; border-radius:4px;" />
				<span class="description" style="display:block; margin-top:4px; font-size:12px; color:#64748b;"><?php esc_html_e( 'Name of teacher(s) for this class.', 'onstage' ); ?></span>
			</div>
		</div>

		<!-- Category & Style -->
		<div style="background:#fff; border:1px solid #cbd5e1; border-radius:8px; padding:16px; margin-bottom:20px;">
			<label for="onstage_class_category" style="display:block; font-weight:700; font-size:14px; margin-bottom:6px; color:#0f172a;">
				🎨 <?php esc_html_e( 'Category & Schedule Card Color Style:', 'onstage' ); ?>
			</label>
			<select id="onstage_class_category" name="onstage_class_category" class="widefat" style="padding:8px 10px; font-size:14px; border-radius:4px;">
				<option value="company" <?php selected( $category, 'company' ); ?>><?php esc_html_e( 'Company Teams (Blue)', 'onstage' ); ?></option>
				<option value="theater" <?php selected( $category, 'theater' ); ?>><?php esc_html_e( 'Musical Theater (Pink)', 'onstage' ); ?></option>
				<option value="combo" <?php selected( $category, 'combo' ); ?>><?php esc_html_e( 'Little Ones / Combo (Green)', 'onstage' ); ?></option>
				<option value="teen" <?php selected( $category, 'teen' ); ?>><?php esc_html_e( 'Teen & Adult (Purple)', 'onstage' ); ?></option>
				<option value="rehearsal" <?php selected( $category, 'rehearsal' ); ?>><?php esc_html_e( 'Rehearsals & Shows (Orange)', 'onstage' ); ?></option>
				<option value="hiphop" <?php selected( $category, 'hiphop' ); ?>><?php esc_html_e( 'Hip Hop (Teal)', 'onstage' ); ?></option>
			</select>
		</div>

		<!-- NEW Badge Highlight -->
		<div style="background:#fef3c7; border:1px solid #fde047; padding:14px; border-radius:8px;">
			<label style="font-weight:700; color:#854d0e; font-size:14px; display:flex; align-items:center; gap:8px; cursor:pointer;">
				<input type="checkbox" name="onstage_class_is_new" value="1" <?php checked( $is_new ); ?> />
				<?php esc_html_e( '⭐ Highlight as NEW Class (Displays bright "NEW" badge on card)', 'onstage' ); ?>
			</label>
		</div>
	</div>

	<script>
	jQuery(document).ready(function($) {
		function formatSingleTime(time24) {
			if (!time24) return '';
			var parts = time24.split(':');
			var hour = parseInt(parts[0], 10);
			var min = parseInt(parts[1], 10);
			var ampm = hour >= 12 ? 'p.m.' : 'a.m.';
			var h12 = hour % 12;
			if (h12 === 0) h12 = 12;
			var minStr = min > 0 ? (min < 10 ? ':0' + min : ':' + min) : ':00';
			return { h12: h12, minStr: minStr, ampm: ampm, totalMin: (hour * 60) + min };
		}

		function updateFormattedDisplay() {
			var start = $('#onstage_class_start_time').val();
			var end = $('#onstage_class_end_time').val();
			if (!start) return;

			var s = formatSingleTime(start);
			if (end) {
				var e = formatSingleTime(end);
				if (s.ampm === e.ampm) {
					// e.g. 3:30–4:30 p.m.
					$('#onstage_class_time').val(s.h12 + s.minStr + '–' + e.h12 + e.minStr + ' ' + e.ampm);
				} else {
					// e.g. 11:15 a.m.–12:15 p.m.
					$('#onstage_class_time').val(s.h12 + s.minStr + ' ' + s.ampm + '–' + e.h12 + e.minStr + ' ' + e.ampm);
				}
			} else {
				$('#onstage_class_time').val(s.h12 + s.minStr + ' ' + s.ampm);
			}
		}

		$('#onstage_class_start_time, #onstage_class_end_time').on('change input', function() {
			updateFormattedDisplay();
		});
	});
	</script>
	<?php
}

/**
 * Save class meta.
 *
 * @param int $post_id Post ID.
 */
function onstage_save_class_meta( $post_id ) {
	if ( ! isset( $_POST['onstage_class_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['onstage_class_meta_nonce'] ) ), 'onstage_class_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$weekdays = array_keys( onstage_class_weekdays() );
	$weekday  = isset( $_POST['onstage_class_weekday'] ) ? sanitize_text_field( wp_unslash( $_POST['onstage_class_weekday'] ) ) : 'monday';
	if ( ! in_array( $weekday, $weekdays, true ) ) {
		$weekday = 'monday';
	}
	update_post_meta( $post_id, 'onstage_class_weekday', $weekday );

	$start_time = isset( $_POST['onstage_class_start_time'] ) ? sanitize_text_field( wp_unslash( $_POST['onstage_class_start_time'] ) ) : '';
	$end_time   = isset( $_POST['onstage_class_end_time'] ) ? sanitize_text_field( wp_unslash( $_POST['onstage_class_end_time'] ) ) : '';
	update_post_meta( $post_id, 'onstage_class_start_time', $start_time );
	update_post_meta( $post_id, 'onstage_class_end_time', $end_time );

	$time = isset( $_POST['onstage_class_time'] ) ? sanitize_text_field( wp_unslash( $_POST['onstage_class_time'] ) ) : '';
	update_post_meta( $post_id, 'onstage_class_time', $time );

	// Calculate chronological minutes: check start_time first (exact 24hr), fallback to parse string
	if ( ! empty( $start_time ) && false !== strpos( $start_time, ':' ) ) {
		$t_parts = explode( ':', $start_time );
		$minutes = ( (int) $t_parts[0] * 60 ) + (int) $t_parts[1];
	} else {
		$minutes = onstage_parse_class_time( $time );
	}
	update_post_meta( $post_id, 'onstage_class_time_minutes', $minutes );

	foreach ( array( 'onstage_class_ages', 'onstage_class_instructor' ) as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
		}
	}

	$cats     = array_keys( onstage_class_categories() );
	$category = isset( $_POST['onstage_class_category'] ) ? sanitize_text_field( wp_unslash( $_POST['onstage_class_category'] ) ) : 'company';
	if ( ! in_array( $category, $cats, true ) ) {
		$category = 'company';
	}
	update_post_meta( $post_id, 'onstage_class_category', $category );
	update_post_meta( $post_id, 'onstage_class_is_new', ! empty( $_POST['onstage_class_is_new'] ) ? 1 : 0 );
}
add_action( 'save_post_studio_class', 'onstage_save_class_meta' );

/**
 * Auto-populate class time minutes for existing classes if missing.
 */
function onstage_backfill_class_time_minutes() {
	if ( ! is_admin() ) {
		return;
	}

	$classes = get_posts( array(
		'post_type'      => 'studio_class',
		'post_status'    => array( 'publish', 'draft' ),
		'posts_per_page' => -1,
	) );

	foreach ( $classes as $c ) {
		$min = get_post_meta( $c->ID, 'onstage_class_time_minutes', true );
		if ( '' === (string) $min ) {
			$time = get_post_meta( $c->ID, 'onstage_class_time', true );
			update_post_meta( $c->ID, 'onstage_class_time_minutes', onstage_parse_class_time( $time ) );
		}
	}
}
add_action( 'admin_init', 'onstage_backfill_class_time_minutes' );

/**
 * Admin columns.
 *
 * @param array $columns Columns.
 * @return array
 */
function onstage_class_columns( $columns ) {
	$new_columns = array();
	$new_columns['cb']                 = $columns['cb'];
	$new_columns['title']              = __( 'Class Name', 'onstage' );
	$new_columns['onstage_weekday']    = __( 'Day', 'onstage' );
	$new_columns['onstage_time']       = __( 'Time (Sorted Chronologically)', 'onstage' );
	$new_columns['onstage_instructor'] = __( 'Instructor', 'onstage' );
	$new_columns['onstage_category']   = __( 'Category', 'onstage' );
	return $new_columns;
}
add_filter( 'manage_studio_class_posts_columns', 'onstage_class_columns' );

/**
 * Admin column values.
 *
 * @param string $column  Column id.
 * @param int    $post_id Post ID.
 */
function onstage_class_column_content( $column, $post_id ) {
	if ( 'onstage_weekday' === $column ) {
		$key  = get_post_meta( $post_id, 'onstage_class_weekday', true );
		$days = onstage_class_weekdays();
		echo esc_html( isset( $days[ $key ] ) ? $days[ $key ]['label'] : $key );
	}
	if ( 'onstage_time' === $column ) {
		$time = get_post_meta( $post_id, 'onstage_class_time', true );
		echo esc_html( $time ? $time : '—' );
	}
	if ( 'onstage_instructor' === $column ) {
		echo esc_html( get_post_meta( $post_id, 'onstage_class_instructor', true ) );
	}
	if ( 'onstage_category' === $column ) {
		echo esc_html( get_post_meta( $post_id, 'onstage_class_category', true ) );
	}
}
add_action( 'manage_studio_class_posts_custom_column', 'onstage_class_column_content', 10, 2 );

/**
 * Render the weekday schedule grid from Class posts.
 * Automatically sorts classes chronologically by start time!
 *
 * Usage: [onstage_class_schedule]
 *
 * @return string
 */
function onstage_class_schedule_shortcode() {
	$days  = onstage_class_weekdays();
	$cats  = onstage_class_categories();
	$query = new WP_Query(
		array(
			'post_type'      => 'studio_class',
			'post_status'    => 'publish',
			'posts_per_page' => 200,
			'no_found_rows'  => true,
		)
	);

	$grouped = array();
	foreach ( array_keys( $days ) as $key ) {
		$grouped[ $key ] = array();
	}

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$weekday = get_post_meta( get_the_ID(), 'onstage_class_weekday', true );
			if ( ! isset( $grouped[ $weekday ] ) ) {
				$weekday = 'monday';
			}

			$time_str = get_post_meta( get_the_ID(), 'onstage_class_time', true );
			$minutes  = get_post_meta( get_the_ID(), 'onstage_class_time_minutes', true );
			if ( '' === (string) $minutes ) {
				$minutes = onstage_parse_class_time( $time_str );
			}

			$grouped[ $weekday ][] = array(
				'title'        => get_the_title(),
				'time'         => $time_str,
				'time_minutes' => (int) $minutes,
				'menu_order'   => (int) get_post_field( 'menu_order', get_the_ID() ),
				'ages'         => get_post_meta( get_the_ID(), 'onstage_class_ages', true ),
				'instructor'   => get_post_meta( get_the_ID(), 'onstage_class_instructor', true ),
				'category'     => get_post_meta( get_the_ID(), 'onstage_class_category', true ),
				'is_new'       => (bool) get_post_meta( get_the_ID(), 'onstage_class_is_new', true ),
			);
		}
		wp_reset_postdata();
	}

	// Sort each weekday's classes chronologically by time!
	foreach ( array_keys( $days ) as $day_key ) {
		usort( $grouped[ $day_key ], function( $a, $b ) {
			if ( $a['time_minutes'] !== $b['time_minutes'] ) {
				return $a['time_minutes'] <=> $b['time_minutes'];
			}
			if ( $a['menu_order'] !== $b['menu_order'] ) {
				return $a['menu_order'] <=> $b['menu_order'];
			}
			return strcmp( $a['title'], $b['title'] );
		} );
	}

	ob_start();
	echo '<div class="weekly-schedule-grid">';
	foreach ( $days as $key => $day ) {
		$classes = $grouped[ $key ];
		$count   = count( $classes );
		$header  = 'schedule-day-header--' . sanitize_html_class( $day['header'] );
		$noun    = ( 1 === $count ) ? __( 'class', 'onstage' ) : ( 'saturday' === $key ? __( 'items', 'onstage' ) : __( 'classes', 'onstage' ) );

		echo '<section class="schedule-day">';
		echo '<header class="schedule-day-header ' . esc_attr( $header ) . '">';
		echo '<div><h3>' . esc_html( $day['label'] ) . '</h3>';
		echo '<p>' . esc_html( sprintf( '%d %s', $count, $noun ) ) . '</p></div>';
		echo '<i class="fa-regular fa-calendar-days" aria-hidden="true"></i>';
		echo '</header>';
		echo '<div class="schedule-class-list">';

		if ( ! $classes ) {
			echo '<article class="schedule-class"><p class="schedule-time">' . esc_html__( 'No classes listed', 'onstage' ) . '</p></article>';
		}

		foreach ( $classes as $class ) {
			$cat_class = isset( $cats[ $class['category'] ] ) ? $cats[ $class['category'] ] : 'schedule-company';
			echo '<article class="schedule-class ' . esc_attr( $cat_class ) . '">';
			if ( $class['is_new'] ) {
				echo '<p class="schedule-new-badge">' . esc_html__( 'NEW', 'onstage' ) . '</p>';
			}
			if ( $class['time'] ) {
				echo '<p class="schedule-time">' . esc_html( $class['time'] ) . '</p>';
			}
			echo '<h4>' . esc_html( $class['title'] ) . '</h4>';
			if ( $class['ages'] ) {
				echo '<p>' . esc_html( $class['ages'] ) . '</p>';
			}
			if ( $class['instructor'] ) {
				echo '<p class="schedule-teacher">' . esc_html( $class['instructor'] ) . '</p>';
			}
			echo '</article>';
		}

		echo '</div></section>';
	}
	echo '</div>';

	return ob_get_clean();
}
add_shortcode( 'onstage_class_schedule', 'onstage_class_schedule_shortcode' );

/**
 * Fall 2026–2027 seed rows (from the client preview programs page).
 * Strictly omits former instructors.
 *
 * @return array<int, array<string, mixed>>
 */
function onstage_class_seed_data() {
	return array(
		array( 'Beginner Jazz and Tap', 'monday', '3:30–4:30 p.m.', 'Ages 7–10', 'Linda Mercer-Botelho', 'combo', 0, 10 ),
		array( 'Junior Youth Co. — Ballet & Jazz', 'monday', '4:30–5:30 p.m.', 'Ages 9–10', 'Linda Mercer-Botelho', 'company', 0, 20 ),
		array( 'Junior Dance Co. — Jazz', 'monday', '4:30–5:30 p.m.', '', 'Stacy Wong', 'company', 0, 30 ),
		array( 'Junior Youth Co. — Tap', 'monday', '5:30–6:00 p.m.', 'Ages 9–10', 'Linda Mercer-Botelho', 'company', 0, 40 ),
		array( 'Junior Company — Tap', 'monday', '5:30–6:00 p.m.', '', 'Stacy Wong', 'company', 0, 50 ),
		array( 'Senior & Senior App — Tap and Jazz', 'monday', '6:00–7:30 p.m.', '', 'Lisa Mailloux', 'company', 0, 60 ),
		array( 'Junior Company — Hip Hop', 'monday', '6:00–6:30 p.m.', '', 'Stacy Wong', 'hiphop', 0, 70 ),
		array( 'Senior App — Theater Tap / Theater Jazz', 'monday', '7:00–8:30 p.m.', '', 'Staff Instructor', 'company', 0, 80 ),
		array( 'Senior Company — Contemporary', 'monday', '7:30–8:30 p.m.', '', 'Stacy Wong', 'company', 0, 90 ),

		array( 'Hip Hop', 'tuesday', '4:30–5:15 p.m.', 'Ages 8–10', 'Stacy Wong', 'hiphop', 0, 10 ),
		array( 'Musical Theater — Level I', 'tuesday', '4:30–5:30 p.m.', 'Ages 6–8', 'Roger Botelho and Linda Mercer-Botelho', 'theater', 0, 20 ),
		array( 'Ballet & Jazz Combo', 'tuesday', '5:15–6:15 p.m.', 'Ages 8–10', 'Stacy Wong', 'combo', 0, 30 ),
		array( 'Musical Theater — Level II', 'tuesday', '5:30–6:45 p.m.', 'Ages 9–11', 'Roger Botelho and Linda Mercer-Botelho', 'theater', 0, 40 ),
		array( 'Teen Hip Hop', 'tuesday', '6:15–7:00 p.m.', 'Ages 11+', 'Stacy Wong', 'hiphop', 0, 50 ),
		array( 'Musical Theater — Level III', 'tuesday', '6:45–8:00 p.m.', 'Ages 12+', 'Roger Botelho and Linda Mercer-Botelho', 'theater', 0, 60 ),
		array( 'Company Rehearsal Block', 'tuesday', '8:00–8:45 p.m.', '', 'Linda Mercer-Botelho and Roger Botelho', 'rehearsal', 0, 70 ),

		array( 'KinderDance Combo', 'wednesday', '3:30–4:30 p.m.', 'Ages 4–6', 'Linda Mercer-Botelho', 'combo', 0, 10 ),
		array( 'Petite Youth Co. — Ballet & Jazz', 'wednesday', '4:30–5:30 p.m.', 'Ages 6–8', 'Linda Mercer-Botelho', 'company', 0, 20 ),
		array( 'Petite Youth Co. — Tap', 'wednesday', '5:30–6:00 p.m.', 'Ages 6–8', 'Linda Mercer-Botelho', 'company', 0, 30 ),
		array( 'Mini Youth Co. — Tap & Jazz', 'wednesday', '5:30–6:30 p.m.', '', 'Stacy Wong', 'company', 0, 40 ),
		array( 'Adult Tap and Jazz', 'wednesday', '6:00–7:30 p.m.', 'Jazz: 6:00–7:00 p.m. Tap: 7:00–7:30 p.m.', 'Staff Instructor', 'teen', 0, 50 ),
		array( 'Voice and Piano Lessons', 'wednesday', 'By Appointment', 'All Ages', 'Roger Botelho Jr. and Hannah Miller', 'theater', 0, 60 ),

		array( 'Mini Youth Co. — Ballet', 'thursday', '4:30–5:15 p.m.', '', 'Azusa Okamoto', 'company', 0, 10 ),
		array( 'Junior Youth Co. — Ballet Technique', 'thursday', '5:15–6:15 p.m.', '', 'Azusa Okamoto', 'company', 0, 20 ),
		array( 'Junior Dance Co. — Ballet Technique', 'thursday', '6:15–7:15 p.m.', '', 'Azusa Okamoto', 'company', 0, 30 ),
		array( 'Senior & Senior App — Ballet Technique', 'thursday', '7:15–8:45 p.m.', '', 'Azusa Okamoto', 'company', 0, 40 ),

		array( 'Tiny Tots Dance', 'saturday', '9:00–9:45 a.m.', 'Ages 2.5–3.5', 'Linda Mercer-Botelho', 'combo', 0, 10 ),
		array( 'KinderDance — Ballet & Tap', 'saturday', '9:45–10:45 a.m.', 'Ages 4–5', 'Linda Mercer-Botelho', 'combo', 0, 20 ),
		array( 'Primary Dance Combo', 'saturday', '10:45–11:45 a.m.', 'Ages 6–7', 'Linda Mercer-Botelho', 'combo', 0, 30 ),
		array( 'Junior Apprentice Rehearsal', 'saturday', '11:45 a.m.–1:15 p.m.', '', 'Linda Mercer-Botelho and Stacy Wong', 'rehearsal', 0, 40 ),
		array( 'Senior Company Rehearsal', 'saturday', '1:15–3:30 p.m.', '', 'Linda Mercer-Botelho and Stacy Wong', 'rehearsal', 0, 50 ),
	);
}
