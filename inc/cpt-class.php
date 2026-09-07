<?php
/**
 * Class custom post type — weekly studio schedule cards.
 *
 * Not a calendar plugin. One post per class; the Programs page renders
 * a weekday grid via [onstage_class_schedule].
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
	register_post_meta( 'studio_class', 'onstage_class_time', array_merge( $meta_args, array(
		'description' => __( 'Time range, e.g. 3:30–4:30 p.m.', 'onstage' ),
	) ) );
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
 * Meta box for weekday / time / ages / instructor / category / NEW.
 */
function onstage_class_meta_box() {
	add_meta_box(
		'onstage_class_details',
		__( 'Class details', 'onstage' ),
		'onstage_class_meta_box_html',
		'studio_class',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'onstage_class_meta_box' );

/**
 * Meta box markup.
 *
 * @param WP_Post $post Current post.
 */
function onstage_class_meta_box_html( $post ) {
	wp_nonce_field( 'onstage_class_meta', 'onstage_class_meta_nonce' );
	$weekday    = get_post_meta( $post->ID, 'onstage_class_weekday', true );
	$time       = get_post_meta( $post->ID, 'onstage_class_time', true );
	$ages       = get_post_meta( $post->ID, 'onstage_class_ages', true );
	$instructor = get_post_meta( $post->ID, 'onstage_class_instructor', true );
	$category   = get_post_meta( $post->ID, 'onstage_class_category', true );
	$is_new     = (bool) get_post_meta( $post->ID, 'onstage_class_is_new', true );
	?>
	<p>
		<label for="onstage_class_weekday"><strong><?php esc_html_e( 'Weekday', 'onstage' ); ?></strong></label><br />
		<select id="onstage_class_weekday" name="onstage_class_weekday" class="widefat">
			<?php foreach ( onstage_class_weekdays() as $key => $day ) : ?>
				<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $weekday, $key ); ?>><?php echo esc_html( $day['label'] ); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label for="onstage_class_time"><strong><?php esc_html_e( 'Time', 'onstage' ); ?></strong></label><br />
		<input type="text" id="onstage_class_time" name="onstage_class_time" class="widefat" value="<?php echo esc_attr( $time ); ?>" placeholder="3:30–4:30 p.m." />
	</p>
	<p>
		<label for="onstage_class_ages"><strong><?php esc_html_e( 'Ages / note', 'onstage' ); ?></strong></label><br />
		<input type="text" id="onstage_class_ages" name="onstage_class_ages" class="widefat" value="<?php echo esc_attr( $ages ); ?>" />
	</p>
	<p>
		<label for="onstage_class_instructor"><strong><?php esc_html_e( 'Instructor', 'onstage' ); ?></strong></label><br />
		<input type="text" id="onstage_class_instructor" name="onstage_class_instructor" class="widefat" value="<?php echo esc_attr( $instructor ); ?>" />
	</p>
	<p>
		<label for="onstage_class_category"><strong><?php esc_html_e( 'Category color', 'onstage' ); ?></strong></label><br />
		<select id="onstage_class_category" name="onstage_class_category" class="widefat">
			<option value="company" <?php selected( $category, 'company' ); ?>><?php esc_html_e( 'Company Teams', 'onstage' ); ?></option>
			<option value="theater" <?php selected( $category, 'theater' ); ?>><?php esc_html_e( 'Musical Theater', 'onstage' ); ?></option>
			<option value="combo" <?php selected( $category, 'combo' ); ?>><?php esc_html_e( 'Little Ones / Combo', 'onstage' ); ?></option>
			<option value="teen" <?php selected( $category, 'teen' ); ?>><?php esc_html_e( 'Teen & Adult', 'onstage' ); ?></option>
			<option value="rehearsal" <?php selected( $category, 'rehearsal' ); ?>><?php esc_html_e( 'Rehearsals & Shows', 'onstage' ); ?></option>
			<option value="hiphop" <?php selected( $category, 'hiphop' ); ?>><?php esc_html_e( 'Hip Hop', 'onstage' ); ?></option>
		</select>
	</p>
	<p>
		<label>
			<input type="checkbox" name="onstage_class_is_new" value="1" <?php checked( $is_new ); ?> />
			<?php esc_html_e( 'Show NEW badge', 'onstage' ); ?>
		</label>
	</p>
	<p class="description"><?php esc_html_e( 'Menu order controls sort within a day (lower = earlier). The Programs page grid updates automatically.', 'onstage' ); ?></p>
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

	foreach ( array( 'onstage_class_time', 'onstage_class_ages', 'onstage_class_instructor' ) as $key ) {
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
 * Admin columns.
 *
 * @param array $columns Columns.
 * @return array
 */
function onstage_class_columns( $columns ) {
	$columns['onstage_weekday']    = __( 'Day', 'onstage' );
	$columns['onstage_time']       = __( 'Time', 'onstage' );
	$columns['onstage_instructor'] = __( 'Instructor', 'onstage' );
	$columns['onstage_category']   = __( 'Category', 'onstage' );
	return $columns;
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
		echo esc_html( get_post_meta( $post_id, 'onstage_class_time', true ) );
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
			'posts_per_page' => 100,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
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
			$grouped[ $weekday ][] = array(
				'title'      => get_the_title(),
				'time'       => get_post_meta( get_the_ID(), 'onstage_class_time', true ),
				'ages'       => get_post_meta( get_the_ID(), 'onstage_class_ages', true ),
				'instructor' => get_post_meta( get_the_ID(), 'onstage_class_instructor', true ),
				'category'   => get_post_meta( get_the_ID(), 'onstage_class_category', true ),
				'is_new'     => (bool) get_post_meta( get_the_ID(), 'onstage_class_is_new', true ),
			);
		}
		wp_reset_postdata();
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
		array( 'Senior App — Theater Tap / Theater Jazz', 'monday', '7:00–8:30 p.m.', '', 'Elle Gendreau', 'company', 0, 80 ),
		array( 'Senior Company — Contemporary', 'monday', '7:30–8:30 p.m.', '', 'Stacy Wong', 'company', 0, 90 ),

		array( 'Hip Hop', 'tuesday', '4:30–5:15 p.m.', 'Ages 8–10', 'Stacy Wong', 'hiphop', 0, 10 ),
		array( 'Musical Theater — Level I', 'tuesday', '4:30–5:30 p.m.', 'Ages 6–8', 'Roger Botelho and Linda Mercer-Botelho', 'theater', 0, 20 ),
		array( 'Musical Theater — Level 2', 'tuesday', '5:30–7:00 p.m.', 'Ages 9–10', 'Roger Botelho, Linda Mercer-Botelho, and Stacy Wong', 'theater', 0, 30 ),
		array( 'Musical Theater — Level 3: Acting & Theater Jazz', 'tuesday', '5:30–7:30 p.m.', 'Ages 11–15', 'Stacy Wong, Roger Botelho, and Linda Mercer-Botelho', 'theater', 0, 40 ),
		array( 'Alumni — Christmas Performance Preparation', 'tuesday', '7:00–8:15 p.m.', '', 'Lisa Mailloux', 'rehearsal', 0, 50 ),

		array( 'Baby Stars — Kinder-Dance', 'wednesday', '4:30–5:15 p.m.', 'Ages 2½–3', 'Linda Mercer-Botelho', 'combo', 1, 10 ),
		array( 'My Mini\'s — Ballet / Tap / Jazz', 'wednesday', '4:30–6:00 p.m.', 'Ages 7–10', 'Stacy Wong', 'combo', 0, 20 ),
		array( 'Bright Stars — Ballet I / Tap I', 'wednesday', '5:15–6:00 p.m.', 'Ages 5–7', 'Linda Mercer-Botelho', 'combo', 0, 30 ),
		array( 'Teen Triple Threat Club — Ballet, Tap, Jazz', 'wednesday', '6:00–7:30 p.m.', 'Ages 10–15', 'Stacy Wong', 'teen', 0, 40 ),
		array( 'Adult Tap and Jazz', 'wednesday', '6:00–7:30 p.m.', 'Jazz: 6:00–7:00 p.m. Tap: 7:00–7:30 p.m.', 'Elle Gendreau', 'teen', 0, 50 ),

		array( 'Give Kids a Chance — Beginner Ballet', 'thursday', '3:30–4:30 p.m.', 'Ages 7–10', 'Azusa Okamoto', 'combo', 0, 10 ),
		array( 'Junior Dance Co. — Ballet', 'thursday', '4:30–5:30 p.m.', '', 'Azusa Okamoto', 'company', 0, 20 ),
		array( 'Tiny Stars — Pre-Ballet / Pre-Tap', 'thursday', '4:30–5:15 p.m.', 'Ages 4–5', 'Linda Mercer-Botelho', 'combo', 1, 30 ),
		array( 'Senior & Senior App — Ballet / Pointe', 'thursday', '5:30–7:00 p.m.', '', 'Azusa Okamoto', 'company', 0, 40 ),
		array( 'Junior Company — Tap / Jazz', 'thursday', '5:30–7:00 p.m.', '', '', 'company', 0, 50 ),
		array( 'Musical Theater — Levels 4 & 5', 'thursday', '7:00–8:00 p.m.', 'Ages 12–18', 'Linda Mercer-Botelho and Roger Botelho', 'theater', 0, 60 ),
		array( 'Christmas Rehearsal', 'thursday', '8:00–8:30 p.m.', 'As needed', '', 'rehearsal', 0, 70 ),

		array( 'Pom / Hip Hop Combo', 'saturday', '10:00–11:00 a.m.', 'Ages 8–12', 'Stacy Wong', 'hiphop', 0, 10 ),
		array( 'Ballet / Pointe — Senior & Senior App', 'saturday', '11:00 a.m.–12:00 p.m.', '', 'Azusa Okamoto', 'company', 0, 20 ),
		array( 'Christmas Show Rehearsal', 'saturday', '11:00 a.m.–1:00 p.m.', 'Junior Company numbers', '', 'rehearsal', 0, 30 ),
		array( 'Contemporary — Senior & Senior App', 'saturday', '12:00–1:00 p.m.', '', 'Azusa Okamoto', 'company', 0, 40 ),
		array( 'Christmas Show Choreography — Junior Youth', 'saturday', '1:00–3:00 p.m.', 'Junior Youth Group, as needed', '', 'rehearsal', 0, 50 ),
		array( 'Christmas Show Choreography — Ensemble', 'saturday', '1:00–3:00 p.m.', 'Dolls, Soldiers, Reindeer, Opening, and Contemporary', '', 'rehearsal', 0, 60 ),
	);
}
