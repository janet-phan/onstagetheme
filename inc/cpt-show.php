<?php
/**
 * Show custom post type — productions the client updates often.
 *
 * Fields: title, dates, venue, ticket URL, featured image, body copy.
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
			'show_in_rest'        => true,
			'has_archive'         => false,
			'menu_icon'           => 'dashicons-tickets-alt',
			'menu_position'       => 5,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
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

	register_post_meta( 'show', 'onstage_show_dates', array_merge( $meta_args, array(
		'description'        => __( 'Performance dates as shown on the site, e.g. December 5, 2026 - 6:00 PM', 'onstage' ),
		'sanitize_callback'  => 'sanitize_textarea_field',
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
 * Meta box so dates / venue / ticket URL are obvious in the editor.
 */
function onstage_show_meta_box() {
	add_meta_box(
		'onstage_show_details',
		__( 'Show details', 'onstage' ),
		'onstage_show_meta_box_html',
		'show',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'onstage_show_meta_box' );

/**
 * Meta box markup.
 *
 * @param WP_Post $post Current post.
 */
function onstage_show_meta_box_html( $post ) {
	wp_nonce_field( 'onstage_show_meta', 'onstage_show_meta_nonce' );
	$dates  = get_post_meta( $post->ID, 'onstage_show_dates', true );
	$venue  = get_post_meta( $post->ID, 'onstage_show_venue', true );
	$ticket = get_post_meta( $post->ID, 'onstage_show_ticket_url', true );
	?>
	<p>
		<label for="onstage_show_dates"><strong><?php esc_html_e( 'Dates / times', 'onstage' ); ?></strong></label><br />
		<textarea id="onstage_show_dates" name="onstage_show_dates" rows="3" class="widefat" placeholder="<?php esc_attr_e( 'Leave blank to show TBA', 'onstage' ); ?>"><?php echo esc_textarea( $dates ); ?></textarea>
		<span class="description"><?php esc_html_e( 'Shown on listings and the show page. Leave empty for TBA. This is not the WordPress publish date.', 'onstage' ); ?></span>
	</p>
	<p>
		<label for="onstage_show_venue"><strong><?php esc_html_e( 'Venue', 'onstage' ); ?></strong></label><br />
		<input type="text" id="onstage_show_venue" name="onstage_show_venue" class="widefat" value="<?php echo esc_attr( $venue ); ?>" />
	</p>
	<p>
		<label for="onstage_show_ticket_url"><strong><?php esc_html_e( 'Ticket URL (external)', 'onstage' ); ?></strong></label><br />
		<input type="url" id="onstage_show_ticket_url" name="onstage_show_ticket_url" class="widefat" value="<?php echo esc_attr( $ticket ); ?>" placeholder="https://" />
	</p>
	<p class="description"><?php esc_html_e( 'Leave ticket URL blank to use the studio-wide Small Venue Ticketing link. Set the Featured Image for the card artwork. Publish the show now — do not schedule the post for the performance date, or WordPress will hide it until that day. Use an earlier (or today’s) publish date only to control sort order.', 'onstage' ); ?></p>
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
	if ( isset( $_POST['onstage_show_dates'] ) ) {
		update_post_meta( $post_id, 'onstage_show_dates', sanitize_textarea_field( wp_unslash( $_POST['onstage_show_dates'] ) ) );
	}
	if ( isset( $_POST['onstage_show_venue'] ) ) {
		update_post_meta( $post_id, 'onstage_show_venue', sanitize_text_field( wp_unslash( $_POST['onstage_show_venue'] ) ) );
	}
	if ( isset( $_POST['onstage_show_ticket_url'] ) ) {
		update_post_meta( $post_id, 'onstage_show_ticket_url', esc_url_raw( wp_unslash( $_POST['onstage_show_ticket_url'] ) ) );
	}
}
add_action( 'save_post_show', 'onstage_save_show_meta' );

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
		$now                     = current_time( 'mysql' );
		$data['post_status']     = 'publish';
		$data['post_date']       = $now;
		$data['post_date_gmt']   = get_gmt_from_date( $now );
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
	$columns['onstage_dates']  = __( 'Dates', 'onstage' );
	$columns['onstage_venue']  = __( 'Venue', 'onstage' );
	$columns['onstage_ticket'] = __( 'Tickets', 'onstage' );
	return $columns;
}
add_filter( 'manage_show_posts_columns', 'onstage_show_columns' );

/**
 * Admin column values.
 *
 * @param string $column Column id.
 * @param int    $post_id Post ID.
 */
function onstage_show_column_content( $column, $post_id ) {
	if ( 'onstage_dates' === $column ) {
		$dates = get_post_meta( $post_id, 'onstage_show_dates', true );
		echo $dates ? esc_html( $dates ) : esc_html__( 'TBA', 'onstage' );
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
