<?php
/**
 * Show custom post type — productions the client updates often.
 *
 * Fields: title, start date (for chronological sorting), dates / times text,
 * repeatable performance dates & times builder, venue, ticket URL, show poster image, body copy.
 *
 * @package Onstage
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Show CPT.
 */
function onstage_register_show_cpt() {
	$labels = array(
		'name'               => __( 'Shows', 'onstage' ),
		'singular_name'      => __( 'Show', 'onstage' ),
		'add_new'            => __( 'Add Show', 'onstage' ),
		'add_new_item'       => __( 'Add New Show', 'onstage' ),
		'edit_item'          => __( 'Edit Show', 'onstage' ),
		'new_item'           => __( 'New Show', 'onstage' ),
		'view_item'          => __( 'View Show', 'onstage' ),
		'search_items'       => __( 'Search Shows', 'onstage' ),
		'not_found'          => __( 'No shows found', 'onstage' ),
		'not_found_in_trash' => __( 'No shows found in trash', 'onstage' ),
		'menu_name'          => __( 'Shows', 'onstage' ),
		'all_items'          => __( 'All Shows', 'onstage' ),
	);

	register_post_type(
		'show',
		array(
			'labels'              => $labels,
			'public'              => true,
			'show_in_rest'        => false,
			'has_archive'         => false,
			'menu_icon'           => 'dashicons-tickets-alt',
			'menu_position'       => 5,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'custom-fields' ),
			'rewrite'             => array( 'slug' => 'show' ),
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
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

	register_post_meta( 'show', 'onstage_show_start_date', array_merge( $meta_args, array(
		'description' => __( 'Opening / First Performance Date in YYYY-MM-DD for chronological sorting (soonest first)', 'onstage' ),
	) ) );

	register_post_meta( 'show', 'onstage_show_performances', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'auth_callback'     => function () {
			return current_user_can( 'edit_posts' );
		},
		'description'       => __( 'JSON array of performance dates and times', 'onstage' ),
	) );

	register_post_meta( 'show', 'onstage_show_dates', array_merge( $meta_args, array(
		'description'       => __( 'Performance dates as shown on the site, e.g. December 5, 2026 - 6:00 PM', 'onstage' ),
		'sanitize_callback' => 'sanitize_textarea_field',
	) ) );

	register_post_meta( 'show', 'onstage_show_venue', array_merge( $meta_args, array(
		'description' => __( 'Venue or location', 'onstage' ),
	) ) );

	register_post_meta( 'show', 'onstage_show_ticket_url', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'auth_callback'     => function () {
			return current_user_can( 'edit_posts' );
		},
		'sanitize_callback' => 'esc_url_raw',
		'description'       => __( 'External ticketing URL (Small Venue Ticketing, etc.)', 'onstage' ),
	) );
}
add_action( 'init', 'onstage_register_show_cpt' );

/**
 * Centered Meta Box so title, dates, venue, ticket URL, and poster image
 * are all in ONE unified main area directly under the title.
 */
function onstage_show_meta_box() {
	add_meta_box(
		'onstage_show_details',
		__( '🎭 Show Production Details & Poster', 'onstage' ),
		'onstage_show_meta_box_html',
		'show',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'onstage_show_meta_box' );

/**
 * Helper to auto-extract opening date from performance dates string.
 *
 * @param string $dates_text Text string like "December 5, 2026 - 6:00 PM".
 * @return string YYYY-MM-DD or empty.
 */
function onstage_extract_show_date( $dates_text ) {
	if ( empty( $dates_text ) ) {
		return '';
	}

	$clean = trim( $dates_text );

	// Match Month DD, YYYY
	if ( preg_match( '/(January|February|March|April|May|June|July|August|September|October|November|December)\s+(\d{1,2})(?:[–\-]\d{1,2})?,?\s+(\d{4})/i', $clean, $matches ) ) {
		$month = $matches[1];
		$day   = $matches[2];
		$year  = $matches[3];
		$ts    = strtotime( "$month $day, $year" );
		if ( $ts ) {
			return date( 'Y-m-d', $ts );
		}
	}

	// Try generic strtotime on first line
	$lines = explode( "\n", $clean );
	$first = trim( $lines[0] );
	$first_no_time = preg_replace( '/\s*[-–]\s*\d{1,2}:\d{2}.*$/i', '', $first );
	$ts = strtotime( $first_no_time );
	if ( $ts && $ts > 0 ) {
		return date( 'Y-m-d', $ts );
	}

	return '';
}

/**
 * Parse existing show dates text into structured array of date/time rows.
 *
 * @param string $text Dates text string.
 * @return array<int, array{date: string, time: string}>
 */
function onstage_parse_existing_show_dates_text( $text ) {
	$rows = array();
	if ( empty( $text ) ) {
		return $rows;
	}

	$lines = preg_split( '/\r\n|\n|\r/', trim( $text ) );

	// If single line contains multiple Month Year occurrences (e.g. December 5, 2026 ... December 6, 2026 ...)
	if ( 1 === count( $lines ) && preg_match_all( '/(January|February|March|April|May|June|July|August|September|October|November|December)\s+\d{1,2}(?:[–\-]\d{1,2})?,?\s+\d{4}/i', $text, $matches, PREG_OFFSET_CAPTURE ) ) {
		$positions = $matches[0];
		if ( count( $positions ) > 1 ) {
			$extracted_lines = array();
			for ( $i = 0; $i < count( $positions ); $i++ ) {
				$start_idx = $positions[$i][1];
				$end_idx   = ( $i + 1 < count( $positions ) ) ? $positions[$i+1][1] : strlen( $text );
				$extracted_lines[] = trim( substr( $text, $start_idx, $end_idx - $start_idx ) );
			}
			$lines = $extracted_lines;
		}
	}

	foreach ( $lines as $line ) {
		$line = trim( $line );
		if ( empty( $line ) ) {
			continue;
		}
		$date_val = onstage_extract_show_date( $line );
		$time_val = '';
		if ( preg_match( '/(?:at|[-–])\s*(\d{1,2}(?::\d{2})?\s*(?:[ap]\.?m\.?|AM|PM).*)$/i', $line, $t_match ) ) {
			$time_val = trim( $t_match[1] );
		} elseif ( preg_match( '/(\d{1,2}(?::\d{2})?\s*(?:[ap]\.?m\.?|AM|PM).*)/i', $line, $t_match ) ) {
			$time_val = trim( $t_match[1] );
		}

		if ( $date_val || $time_val ) {
			$rows[] = array(
				'date' => $date_val ? $date_val : '',
				'time' => $time_val ? $time_val : '',
			);
		}
	}

	return $rows;
}

/**
 * Retrieve performance date/time rows for a show.
 *
 * @param int $post_id Post ID.
 * @return array<int, array{date: string, time: string}>
 */
function onstage_get_show_performances( $post_id ) {
	$json = get_post_meta( $post_id, 'onstage_show_performances', true );
	if ( ! empty( $json ) ) {
		$decoded = json_decode( $json, true );
		if ( is_array( $decoded ) && ! empty( $decoded ) ) {
			return $decoded;
		}
	}

	$dates_text = get_post_meta( $post_id, 'onstage_show_dates', true );
	if ( ! empty( $dates_text ) ) {
		return onstage_parse_existing_show_dates_text( $dates_text );
	}

	return array();
}

/**
 * Meta box markup — all-in-one centered panel with Date/Add Date/Time builder.
 *
 * @param WP_Post $post Current post.
 */
function onstage_show_meta_box_html( $post ) {
	wp_nonce_field( 'onstage_show_meta', 'onstage_show_meta_nonce' );

	$start_date   = get_post_meta( $post->ID, 'onstage_show_start_date', true );
	$dates        = get_post_meta( $post->ID, 'onstage_show_dates', true );
	$venue        = get_post_meta( $post->ID, 'onstage_show_venue', true );
	$ticket       = get_post_meta( $post->ID, 'onstage_show_ticket_url', true );
	$thumb_id     = get_post_thumbnail_id( $post->ID );
	$performances = onstage_get_show_performances( $post->ID );

	if ( empty( $start_date ) || '9999-12-31' === $start_date ) {
		$detected_date = onstage_extract_show_date( $dates );
		if ( $detected_date ) {
			$start_date = $detected_date;
		}
	}

	if ( $thumb_id ) {
		$poster_preview = wp_get_attachment_image_url( $thumb_id, 'medium' );
	} else {
		$poster_preview = onstage_img( 'placeholder_show.png' );
	}
	?>
	<div style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif; padding:10px 0;">
		
		<!-- Poster Image & Quick Help Row -->
		<div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:8px; padding:18px; margin-bottom:20px; display:flex; gap:24px; align-items:center; flex-wrap:wrap;">
			<div style="text-align:center;">
				<img id="onstage_show_poster_preview" src="<?php echo esc_url( $poster_preview ); ?>" alt="Show Poster" style="width:130px; height:170px; object-fit:cover; border-radius:8px; border:2px solid #0284c7; box-shadow:0 4px 12px rgba(0,0,0,0.12); display:block; background:#0f172a;" />
			</div>
			<div style="flex:1; min-width:260px;">
				<h4 style="margin:0 0 6px 0; font-size:16px; color:#0f172a;"><?php esc_html_e( 'Show Poster / Promotional Artwork', 'onstage' ); ?></h4>
				<p class="description" style="margin:0 0 12px 0; font-size:13px; color:#64748b; line-height:1.5;">
					<?php esc_html_e( 'Upload the poster image here. It displays on the show page, the ticket card, and the home page banner.', 'onstage' ); ?>
				</p>
				<input type="hidden" name="onstage_show_thumbnail_id" id="onstage_show_thumbnail_id" value="<?php echo esc_attr( $thumb_id ); ?>" />
				<button type="button" class="button button-primary button-large" id="onstage_upload_show_poster_btn" style="background:#0284c7; border-color:#0284c7; font-weight:600;">
					<span class="dashicons dashicons-format-image" style="vertical-align:middle; margin-top:-2px;"></span> <?php esc_html_e( 'Choose / Upload Poster', 'onstage' ); ?>
				</button>
				<button type="button" class="button button-secondary" id="onstage_remove_show_poster_btn" style="margin-left:8px;">
					<?php esc_html_e( 'Remove Poster', 'onstage' ); ?>
				</button>
			</div>
		</div>

		<!-- Repeatable Performance Dates & Times Builder -->
		<div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:18px; margin-bottom:20px;">
			<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:10px;">
				<div>
					<label style="display:block; font-weight:700; font-size:15px; color:#166534;">
						📅 <?php esc_html_e( 'Performance Dates & Showtimes Builder', 'onstage' ); ?>
					</label>
					<span class="description" style="font-size:12px; color:#15803d;">
						<?php esc_html_e( 'Set performance dates and times. Click "+ Add Another Performance Date" for multiple shows. Dates are automatically sorted soonest first!', 'onstage' ); ?>
					</span>
				</div>
				<button type="button" class="button button-secondary" id="onstage_add_perf_date_btn" style="background:#fff; border-color:#86efac; color:#166534; font-weight:600;">
					<span class="dashicons dashicons-plus-alt2" style="vertical-align:middle; margin-top:-2px;"></span> <?php esc_html_e( '+ Add Another Performance Date', 'onstage' ); ?>
				</button>
			</div>

			<input type="hidden" name="onstage_show_performances" id="onstage_show_performances" value="<?php echo esc_attr( wp_json_encode( $performances ) ); ?>" />

			<!-- Dynamic List of Date + Time Rows -->
			<div id="onstage_perf_rows_list" style="display:flex; flex-direction:column; gap:8px; margin-bottom:12px;"></div>

			<!-- Linked Auto-Calculated Controls -->
			<div style="display:flex; gap:20px; flex-wrap:wrap; align-items:flex-start; margin-top:14px; padding-top:14px; border-top:1px dashed #86efac;">
				<div style="flex:0 0 220px;">
					<label for="onstage_show_start_date" style="display:block; font-weight:700; font-size:12px; margin-bottom:4px; color:#166534;">
						<?php esc_html_e( 'Opening Date (Soonest first sort):', 'onstage' ); ?>
					</label>
					<input type="date" id="onstage_show_start_date" name="onstage_show_start_date" value="<?php echo esc_attr( ( '9999-12-31' === $start_date ) ? '' : $start_date ); ?>" style="padding:6px 10px; font-size:13px; width:100%; border-radius:4px; border:1px solid #86efac; background:#fff;" />
				</div>
				<div style="flex:1; min-width:260px;">
					<label for="onstage_show_dates" style="display:block; font-weight:700; font-size:12px; margin-bottom:4px; color:#166534;">
						<?php esc_html_e( 'Website Display Text (Auto-formats from dates above):', 'onstage' ); ?>
					</label>
					<textarea id="onstage_show_dates" name="onstage_show_dates" rows="2" class="widefat" placeholder="<?php esc_attr_e( 'e.g. December 5, 2026 - 6:00 PM&#10;December 6, 2026 - 2:00 PM', 'onstage' ); ?>" style="padding:6px 10px; font-size:13px; border-radius:4px; border:1px solid #86efac; background:#fff;"><?php echo esc_textarea( $dates ); ?></textarea>
					<span class="description" style="display:block; margin-top:3px; font-size:11px; color:#15803d;">
						<?php esc_html_e( 'Shown directly on the show card and event listings.', 'onstage' ); ?>
					</span>
				</div>
			</div>
		</div>

		<!-- Venue & Ticketing -->
		<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:20px; margin-bottom:15px;">
			<div style="background:#fff; border:1px solid #cbd5e1; border-radius:8px; padding:16px;">
				<label for="onstage_show_venue" style="display:block; font-weight:700; font-size:14px; margin-bottom:6px; color:#0f172a;">
					📍 <?php esc_html_e( 'Venue Location:', 'onstage' ); ?>
				</label>
				<input type="text" id="onstage_show_venue" name="onstage_show_venue" class="widefat" value="<?php echo esc_attr( $venue ); ?>" placeholder="<?php esc_attr_e( 'e.g. Bristol Community College, Fall River, MA', 'onstage' ); ?>" style="padding:8px 10px; font-size:14px; border-radius:4px;" />
				<span class="description" style="display:block; margin-top:4px; font-size:12px; color:#64748b;">
					<?php esc_html_e( 'Theater, auditorium, or campus name.', 'onstage' ); ?>
				</span>
			</div>

			<div style="background:#fff; border:1px solid #cbd5e1; border-radius:8px; padding:16px;">
				<label for="onstage_show_ticket_url" style="display:block; font-weight:700; font-size:14px; margin-bottom:6px; color:#0f172a;">
					🎟️ <?php esc_html_e( 'Ticket Purchase URL (External):', 'onstage' ); ?>
				</label>
				<input type="url" id="onstage_show_ticket_url" name="onstage_show_ticket_url" class="widefat" value="<?php echo esc_attr( $ticket ); ?>" placeholder="https://30865.smallvenueticketing.com/..." style="padding:8px 10px; font-size:14px; border-radius:4px;" />
				<span class="description" style="display:block; margin-top:4px; font-size:12px; color:#64748b;">
					<?php esc_html_e( 'Leave blank to use the default Small Venue Ticketing link.', 'onstage' ); ?>
				</span>
			</div>
		</div>

	</div>

	<script>
	jQuery(document).ready(function($) {
		// Poster Media Uploader
		var showMediaFrame;
		$('#onstage_upload_show_poster_btn').on('click', function(e) {
			e.preventDefault();
			if (showMediaFrame) {
				showMediaFrame.open();
				return;
			}
			showMediaFrame = wp.media({
				title: '<?php echo esc_js( __( 'Select or Upload Show Poster Artwork', 'onstage' ) ); ?>',
				button: { text: '<?php echo esc_js( __( 'Set as Show Poster', 'onstage' ) ); ?>' },
				multiple: false
			});
			showMediaFrame.on('select', function() {
				var attachment = showMediaFrame.state().get('selection').first().toJSON();
				$('#onstage_show_thumbnail_id').val(attachment.id);
				$('#onstage_show_poster_preview').attr('src', attachment.url);
			});
			showMediaFrame.open();
		});

		$('#onstage_remove_show_poster_btn').on('click', function(e) {
			e.preventDefault();
			$('#onstage_show_thumbnail_id').val('');
			$('#onstage_show_poster_preview').attr('src', '<?php echo esc_js( onstage_img( 'placeholder_show.png' ) ); ?>');
		});

		// Performance Dates & Times Builder
		var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		var perfRows = <?php echo wp_json_encode( $performances ); ?>;
		if (!Array.isArray(perfRows) || perfRows.length === 0) {
			var initDate = $('#onstage_show_start_date').val() || '';
			perfRows = [{ date: initDate, time: '' }];
		}

		function formatDateString(ymd) {
			if (!ymd) return '';
			var parts = ymd.split('-');
			if (parts.length !== 3) return ymd;
			var y = parseInt(parts[0], 10);
			var m = parseInt(parts[1], 10) - 1;
			var d = parseInt(parts[2], 10);
			return monthNames[m] + ' ' + d + ', ' + y;
		}

		function syncAllRows() {
			var lines = [];
			var earliest = '';
			var validRows = [];

			$('#onstage_perf_rows_list .onstage-perf-row').each(function(idx) {
				var d = $(this).find('.onstage-perf-date-input').val();
				var t = $(this).find('.onstage-perf-time-input').val();
				validRows.push({ date: d, time: t });

				if (d) {
					if (!earliest || d < earliest) {
						earliest = d;
					}
					var formattedDate = formatDateString(d);
					if (t) {
						lines.push(formattedDate + ' - ' + t);
					} else {
						lines.push(formattedDate);
					}
				} else if (t) {
					lines.push(t);
				}
			});

			if (earliest) {
				$('#onstage_show_start_date').val(earliest);
			}
			if (lines.length > 0) {
				$('#onstage_show_dates').val(lines.join("\n"));
			}
			$('#onstage_show_performances').val(JSON.stringify(validRows));
		}

		function renderRows() {
			var $container = $('#onstage_perf_rows_list');
			$container.empty();

			perfRows.forEach(function(item, idx) {
				var $row = $(
					'<div class="onstage-perf-row" data-idx="' + idx + '" style="display:flex; gap:12px; align-items:center; background:#fff; border:1px solid #cbd5e1; border-radius:6px; padding:8px 12px; box-shadow:0 1px 3px rgba(0,0,0,0.03);">' +
						'<span style="font-weight:700; color:#0284c7; font-size:12px; min-width:24px;">#' + (idx + 1) + '</span>' +
						'<div>' +
							'<label style="display:block; font-size:11px; font-weight:600; color:#475569; margin-bottom:2px;"><?php echo esc_js( __( 'Date:', 'onstage' ) ); ?></label>' +
							'<input type="date" class="onstage-perf-date-input" value="' + (item.date || '') + '" style="padding:6px 10px; font-size:13px; border-radius:4px; border:1px solid #cbd5e1;" />' +
						'</div>' +
						'<div style="flex:1;">' +
							'<label style="display:block; font-size:11px; font-weight:600; color:#475569; margin-bottom:2px;"><?php echo esc_js( __( 'Performance Time (e.g. 6:00 PM or 2:00 p.m.):', 'onstage' ) ); ?></label>' +
							'<input type="text" class="onstage-perf-time-input" value="' + (item.time || '') + '" placeholder="e.g. 6:00 PM" style="width:100%; padding:6px 10px; font-size:13px; border-radius:4px; border:1px solid #cbd5e1;" />' +
						'</div>' +
						'<button type="button" class="button button-link-delete onstage-remove-row-btn" style="color:#ef4444; font-size:18px; margin-top:14px; text-decoration:none;" title="<?php echo esc_js( __( 'Remove date', 'onstage' ) ); ?>">&times;</button>' +
					'</div>'
				);
				$container.append($row);
			});
		}

		renderRows();

		$('#onstage_add_perf_date_btn').on('click', function(e) {
			e.preventDefault();
			perfRows.push({ date: '', time: '' });
			renderRows();
			syncAllRows();
		});

		$('#onstage_perf_rows_list').on('click', '.onstage-remove-row-btn', function(e) {
			e.preventDefault();
			var idx = $(this).closest('.onstage-perf-row').data('idx');
			perfRows.splice(idx, 1);
			if (perfRows.length === 0) {
				perfRows = [{ date: '', time: '' }];
			}
			renderRows();
			syncAllRows();
		});

		$('#onstage_perf_rows_list').on('input change', '.onstage-perf-date-input, .onstage-perf-time-input', function() {
			syncAllRows();
		});
	});
	</script>
	<?php
}

/**
 * Save show meta.
 *
 * @param int $post_id Post ID.
 */
function onstage_save_show_meta( $post_id ) {
	if ( ! isset( $_POST['onstage_show_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['onstage_show_meta_nonce'] ) ), 'onstage_show_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$dates = isset( $_POST['onstage_show_dates'] ) ? sanitize_textarea_field( wp_unslash( $_POST['onstage_show_dates'] ) ) : '';
	update_post_meta( $post_id, 'onstage_show_dates', $dates );

	if ( isset( $_POST['onstage_show_performances'] ) ) {
		update_post_meta( $post_id, 'onstage_show_performances', wp_unslash( $_POST['onstage_show_performances'] ) );
	}

	// Start date for chronological sorting (soonest first)
	$start_date = isset( $_POST['onstage_show_start_date'] ) ? sanitize_text_field( wp_unslash( $_POST['onstage_show_start_date'] ) ) : '';
	if ( empty( $start_date ) ) {
		$extracted = onstage_extract_show_date( $dates );
		$start_date = $extracted ? $extracted : '9999-12-31';
	}
	update_post_meta( $post_id, 'onstage_show_start_date', $start_date );

	if ( isset( $_POST['onstage_show_venue'] ) ) {
		update_post_meta( $post_id, 'onstage_show_venue', sanitize_text_field( wp_unslash( $_POST['onstage_show_venue'] ) ) );
	}
	if ( isset( $_POST['onstage_show_ticket_url'] ) ) {
		update_post_meta( $post_id, 'onstage_show_ticket_url', esc_url_raw( wp_unslash( $_POST['onstage_show_ticket_url'] ) ) );
	}

	// Sync Featured Image from the center poster uploader
	if ( isset( $_POST['onstage_show_thumbnail_id'] ) ) {
		$thumb_id = (int) $_POST['onstage_show_thumbnail_id'];
		if ( $thumb_id > 0 ) {
			set_post_thumbnail( $post_id, $thumb_id );
		} else {
			delete_post_thumbnail( $post_id );
		}
	}
}
add_action( 'save_post_show', 'onstage_save_show_meta' );

/**
 * Auto-populate start dates for existing shows if missing.
 */
function onstage_backfill_show_start_dates() {
	if ( ! is_admin() ) {
		return;
	}

	$shows = get_posts( array(
		'post_type'      => 'show',
		'post_status'    => array( 'publish', 'draft', 'future' ),
		'posts_per_page' => -1,
	) );

	foreach ( $shows as $s ) {
		$existing_date = get_post_meta( $s->ID, 'onstage_show_start_date', true );
		if ( empty( $existing_date ) ) {
			$dates = get_post_meta( $s->ID, 'onstage_show_dates', true );
			$extracted = onstage_extract_show_date( $dates );
			if ( $extracted ) {
				update_post_meta( $s->ID, 'onstage_show_start_date', $extracted );
			} else {
				update_post_meta( $s->ID, 'onstage_show_start_date', '9999-12-31' );
			}
		}
	}
}
add_action( 'admin_init', 'onstage_backfill_show_start_dates' );

/**
 * Never let a Show hide because post_date is the performance datetime.
 * Drafts/trash stay as-is. Dates/times meta is untouched.
 *
 * @param array $data    Sanitized post data.
 * @param array $postarr Raw post data.
 * @return array
 */
function onstage_show_insert_publish_now( $data, $postarr ) {
	if ( 'show' !== $data['post_type'] ) {
		return $data;
	}
	if ( in_array( $data['post_status'], array( 'draft', 'auto-draft', 'trash', 'pending', 'private', 'inherit' ), true ) ) {
		return $data;
	}

	$date_ts = ! empty( $data['post_date'] ) ? strtotime( $data['post_date'] ) : 0;
	$now_ts  = current_time( 'timestamp' );
	if ( 'future' === $data['post_status'] || ( $date_ts && $date_ts > $now_ts ) ) {
		$now                   = current_time( 'mysql' );
		$data['post_status']   = 'publish';
		$data['post_date']     = $now;
		$data['post_date_gmt'] = get_gmt_from_date( $now );
	}

	return $data;
}
add_filter( 'wp_insert_post_data', 'onstage_show_insert_publish_now', 20, 2 );

/**
 * Admin columns for the Shows list.
 *
 * @param array $columns Columns.
 * @return array
 */
function onstage_show_columns( $columns ) {
	$new_columns = array();
	$new_columns['cb']                  = $columns['cb'];
	$new_columns['onstage_poster']      = __( 'Poster', 'onstage' );
	$new_columns['title']               = __( 'Show Title', 'onstage' );
	$new_columns['onstage_start_date']  = __( 'Opening Date', 'onstage' );
	$new_columns['onstage_dates']       = __( 'Showtimes Display', 'onstage' );
	$new_columns['onstage_venue']       = __( 'Venue', 'onstage' );
	$new_columns['onstage_ticket']      = __( 'Tickets', 'onstage' );
	return $new_columns;
}
add_filter( 'manage_show_posts_columns', 'onstage_show_columns' );

/**
 * Admin column values.
 *
 * @param string $column  Column id.
 * @param int    $post_id Post ID.
 */
function onstage_show_column_content( $column, $post_id ) {
	if ( 'onstage_poster' === $column ) {
		$thumb_id = get_post_thumbnail_id( $post_id );
		if ( $thumb_id ) {
			echo wp_get_attachment_image( $thumb_id, array( 45, 60 ), false, array( 'style' => 'border-radius:4px; object-fit:cover;' ) );
		} else {
			echo '<span class="dashicons dashicons-format-image" style="font-size:30px; color:#cbd5e1;"></span>';
		}
	}
	if ( 'onstage_start_date' === $column ) {
		$date = get_post_meta( $post_id, 'onstage_show_start_date', true );
		if ( $date && '9999-12-31' !== $date ) {
			echo esc_html( date( 'M j, Y', strtotime( $date ) ) );
		} else {
			echo '<span style="color:#d97706; font-weight:600;">' . esc_html__( 'TBA', 'onstage' ) . '</span>';
		}
	}
	if ( 'onstage_dates' === $column ) {
		$dates = get_post_meta( $post_id, 'onstage_show_dates', true );
		echo $dates ? nl2br( esc_html( $dates ) ) : esc_html__( 'TBA', 'onstage' );
	}
	if ( 'onstage_venue' === $column ) {
		echo esc_html( get_post_meta( $post_id, 'onstage_show_venue', true ) );
	}
	if ( 'onstage_ticket' === $column ) {
		$url = get_post_meta( $post_id, 'onstage_show_ticket_url', true );
		echo $url ? esc_html__( 'Yes', 'onstage' ) : esc_html__( 'Default link', 'onstage' );
	}
}
add_action( 'manage_show_posts_custom_column', 'onstage_show_column_content', 10, 2 );

/**
 * Make Show Date sortable in WP Admin.
 *
 * @param array $columns Sortable columns.
 * @return array
 */
function onstage_show_sortable_columns( $columns ) {
	$columns['onstage_start_date'] = 'onstage_start_date';
	return $columns;
}
add_filter( 'manage_edit-show_sortable_columns', 'onstage_show_sortable_columns' );

/**
 * Custom sorting for Show Date column in WP Admin.
 *
 * @param WP_Query $query Query.
 */
function onstage_show_admin_sorting( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( 'show' === $query->get( 'post_type' ) && 'onstage_start_date' === $query->get( 'orderby' ) ) {
		$query->set( 'meta_key', 'onstage_show_start_date' );
		$query->set( 'orderby', 'meta_value' );
	}
}
add_action( 'pre_get_posts', 'onstage_show_admin_sorting' );
