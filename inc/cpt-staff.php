<?php
/**
 * Staff & Leadership Custom Post Type.
 *
 * Allows client admins (Linda) to manage staff members, profile photos,
 * roles, bios, and order on the About page without requiring instructors
 * to have individual WordPress user logins.
 *
 * @package Onstage
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Staff Member CPT.
 */
function onstage_register_staff_cpt() {
	$labels = array(
		'name'               => __( 'Staff & Teachers', 'onstage' ),
		'singular_name'      => __( 'Staff Member', 'onstage' ),
		'add_new'            => __( 'Add Staff Member', 'onstage' ),
		'add_new_item'       => __( 'Add New Staff Member', 'onstage' ),
		'edit_item'          => __( 'Edit Staff Member', 'onstage' ),
		'new_item'           => __( 'New Staff Member', 'onstage' ),
		'view_item'          => __( 'View Staff Member', 'onstage' ),
		'search_items'       => __( 'Search Staff', 'onstage' ),
		'not_found'          => __( 'No staff members found', 'onstage' ),
		'not_found_in_trash' => __( 'No staff members found in trash', 'onstage' ),
		'menu_name'          => __( 'Staff', 'onstage' ),
		'all_items'          => __( 'All Staff', 'onstage' ),
	);

	register_post_type(
		'staff_member',
		array(
			'labels'              => $labels,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => true,
			'has_archive'         => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'menu_icon'           => 'dashicons-groups',
			'menu_position'       => 8,
			'supports'            => array( 'title', 'thumbnail', 'page-attributes' ),
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

	register_post_meta( 'staff_member', 'onstage_staff_title', array_merge( $meta_args, array(
		'description' => __( 'Role or Title, e.g. Founder & Executive Director', 'onstage' ),
	) ) );

	register_post_meta( 'staff_member', 'onstage_staff_bio', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'auth_callback'     => function () {
			return current_user_can( 'edit_posts' );
		},
		'sanitize_callback' => 'sanitize_textarea_field',
		'description'       => __( 'Biographical information displayed on the About page', 'onstage' ),
	) );

	register_post_meta( 'staff_member', 'onstage_staff_photo', array_merge( $meta_args, array(
		'description' => __( 'Profile photo image URL or asset filename', 'onstage' ),
	) ) );

	register_post_meta( 'staff_member', 'onstage_staff_show_on_about', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'auth_callback'     => function () {
			return current_user_can( 'edit_posts' );
		},
		'sanitize_callback' => 'sanitize_text_field',
		'description'       => __( '1 to show on About page, 0 to hide', 'onstage' ),
	) );
}
add_action( 'init', 'onstage_register_staff_cpt' );

/**
 * Centered Meta Box for Staff Member Details.
 */
function onstage_staff_meta_box() {
	add_meta_box(
		'onstage_staff_details',
		__( 'Staff Profile Details & Bio', 'onstage' ),
		'onstage_staff_meta_box_html',
		'staff_member',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'onstage_staff_meta_box' );

/**
 * Meta box markup.
 *
 * @param WP_Post $post Current post.
 */
function onstage_staff_meta_box_html( $post ) {
	wp_nonce_field( 'onstage_staff_meta', 'onstage_staff_meta_nonce' );

	$title       = get_post_meta( $post->ID, 'onstage_staff_title', true );
	$bio         = get_post_meta( $post->ID, 'onstage_staff_bio', true );
	$photo       = get_post_meta( $post->ID, 'onstage_staff_photo', true );
	$show        = get_post_meta( $post->ID, 'onstage_staff_show_on_about', true );
	$order       = $post->menu_order;

	if ( '' === (string) $show ) {
		$show = '1';
	}

	$thumb_id = get_post_thumbnail_id( $post->ID );
	if ( $thumb_id ) {
		$preview_url = wp_get_attachment_image_url( $thumb_id, 'medium' );
	} elseif ( ! empty( $photo ) ) {
		$preview_url = ( 0 === strpos( $photo, 'http' ) || 0 === strpos( $photo, '/' ) ) ? $photo : onstage_img( $photo );
	} else {
		$preview_url = onstage_img( 'staff-linda.jpg' );
	}
	?>
	<div style="padding:10px 0; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">
		<!-- Profile Photo Section -->
		<div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:8px; padding:18px; margin-bottom:20px; display:flex; gap:20px; align-items:center;">
			<img id="onstage_staff_photo_preview" src="<?php echo esc_url( $preview_url ); ?>" alt="Preview" style="width:110px; height:110px; border-radius:50%; object-fit:cover; border:3px solid #E95BAF; box-shadow:0 4px 10px rgba(0,0,0,0.1); background:#fff; flex-shrink:0;" />
			<div style="flex:1;">
				<h4 style="margin:0 0 6px 0; font-size:15px; color:#0f172a;"><?php esc_html_e( 'Staff Profile Photo', 'onstage' ); ?></h4>
				<p class="description" style="margin:0 0 10px 0; font-size:13px; color:#64748b;">
					<?php esc_html_e( 'Choose a clear portrait or headshot for the About page.', 'onstage' ); ?>
				</p>
				<input type="hidden" name="onstage_staff_photo" id="onstage_staff_photo" value="<?php echo esc_attr( $photo ); ?>" />
				<input type="hidden" name="onstage_staff_thumbnail_id" id="onstage_staff_thumbnail_id" value="<?php echo esc_attr( $thumb_id ); ?>" />
				<button type="button" class="button button-primary" id="onstage_choose_staff_photo_btn" style="background:#E95BAF; border-color:#E95BAF; font-weight:600;">
					<span class="dashicons dashicons-camera" style="vertical-align:middle; margin-top:-2px;"></span> <?php esc_html_e( 'Choose / Upload Photo', 'onstage' ); ?>
				</button>
				<button type="button" class="button button-secondary" id="onstage_remove_staff_photo_btn" style="margin-left:8px;">
					<?php esc_html_e( 'Remove Photo', 'onstage' ); ?>
				</button>
			</div>
		</div>

		<!-- Role / Title -->
		<p style="margin-bottom:18px;">
			<label for="onstage_staff_title" style="display:block; font-weight:600; font-size:14px; margin-bottom:6px; color:#1e293b;">
				<?php esc_html_e( 'Role / Title (Optional subtitle):', 'onstage' ); ?>
			</label>
			<input type="text" id="onstage_staff_title" name="onstage_staff_title" value="<?php echo esc_attr( $title ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'e.g. Founder & Executive Director or Dance Instructor', 'onstage' ); ?>" style="padding:8px 12px; font-size:14px; border-radius:4px;" />
		</p>

		<!-- Bio Textarea -->
		<p style="margin-bottom:18px;">
			<label for="onstage_staff_bio" style="display:block; font-weight:600; font-size:14px; margin-bottom:6px; color:#1e293b;">
				<?php esc_html_e( 'Biographical Information (Bio):', 'onstage' ); ?>
			</label>
			<textarea id="onstage_staff_bio" name="onstage_staff_bio" rows="8" class="widefat" placeholder="<?php esc_attr_e( 'Enter paragraphs about this teacher/staff member. Separate paragraphs with a blank line.', 'onstage' ); ?>" style="padding:10px 12px; font-size:14px; line-height:1.6; border-radius:4px;"><?php echo esc_textarea( $bio ); ?></textarea>
			<span class="description" style="display:block; margin-top:4px; font-size:12px; color:#64748b;">
				<?php esc_html_e( 'This bio text will be displayed directly beside their photo on the About page.', 'onstage' ); ?>
			</span>
		</p>

		<!-- Display & Order Settings -->
		<div style="background:#f1f5f9; border-radius:6px; padding:12px 16px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
			<label style="display:flex; align-items:center; gap:8px; font-weight:600; color:#334155; cursor:pointer;">
				<input type="checkbox" name="onstage_staff_show_on_about" value="1" <?php checked( '1', (string) $show ); ?> />
				<?php esc_html_e( 'Display this staff member on the About page', 'onstage' ); ?>
			</label>
			<div style="display:flex; align-items:center; gap:8px;">
				<label for="menu_order" style="font-weight:600; color:#475569; font-size:13px;"><?php esc_html_e( 'Display Order #:', 'onstage' ); ?></label>
				<input type="number" name="menu_order" id="menu_order" value="<?php echo esc_attr( $order ); ?>" style="width:70px; text-align:center;" />
				<span class="description" style="font-size:12px; color:#64748b;"><?php esc_html_e( '(Lower numbers appear higher)', 'onstage' ); ?></span>
			</div>
		</div>
	</div>

	<script>
	jQuery(document).ready(function($) {
		var mediaFrame;
		$('#onstage_choose_staff_photo_btn').on('click', function(e) {
			e.preventDefault();
			if (mediaFrame) {
				mediaFrame.open();
				return;
			}
			mediaFrame = wp.media({
				title: '<?php echo esc_js( __( 'Select or Upload Staff Profile Photo', 'onstage' ) ); ?>',
				button: { text: '<?php echo esc_js( __( 'Use This Photo', 'onstage' ) ); ?>' },
				multiple: false
			});
			mediaFrame.on('select', function() {
				var attachment = mediaFrame.state().get('selection').first().toJSON();
				$('#onstage_staff_photo').val(attachment.url);
				$('#onstage_staff_thumbnail_id').val(attachment.id);
				$('#onstage_staff_photo_preview').attr('src', attachment.url);
			});
			mediaFrame.open();
		});

		$('#onstage_remove_staff_photo_btn').on('click', function(e) {
			e.preventDefault();
			$('#onstage_staff_photo').val('');
			$('#onstage_staff_thumbnail_id').val('');
			$('#onstage_staff_photo_preview').attr('src', '<?php echo esc_js( onstage_img( 'staff-linda.jpg' ) ); ?>');
		});
	});
	</script>
	<?php
}

/**
 * Save Staff Member Meta.
 *
 * @param int $post_id Post ID.
 */
function onstage_save_staff_meta( $post_id ) {
	if ( ! isset( $_POST['onstage_staff_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['onstage_staff_meta_nonce'] ) ), 'onstage_staff_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['onstage_staff_title'] ) ) {
		update_post_meta( $post_id, 'onstage_staff_title', sanitize_text_field( wp_unslash( $_POST['onstage_staff_title'] ) ) );
	}

	if ( isset( $_POST['onstage_staff_bio'] ) ) {
		update_post_meta( $post_id, 'onstage_staff_bio', sanitize_textarea_field( wp_unslash( $_POST['onstage_staff_bio'] ) ) );
	}

	if ( isset( $_POST['onstage_staff_photo'] ) ) {
		update_post_meta( $post_id, 'onstage_staff_photo', sanitize_text_field( wp_unslash( $_POST['onstage_staff_photo'] ) ) );
	}

	$show = ! empty( $_POST['onstage_staff_show_on_about'] ) ? '1' : '0';
	update_post_meta( $post_id, 'onstage_staff_show_on_about', $show );

	if ( ! empty( $_POST['onstage_staff_thumbnail_id'] ) ) {
		set_post_thumbnail( $post_id, (int) $_POST['onstage_staff_thumbnail_id'] );
	} elseif ( isset( $_POST['onstage_staff_photo'] ) && empty( $_POST['onstage_staff_photo'] ) ) {
		delete_post_thumbnail( $post_id );
	}
}
add_action( 'save_post_staff_member', 'onstage_save_staff_meta' );

/**
 * Custom Admin Columns for Staff list.
 *
 * @param array $columns Columns.
 * @return array
 */
function onstage_staff_columns( $columns ) {
	$new_columns = array();
	$new_columns['cb']                  = $columns['cb'];
	$new_columns['onstage_photo']       = __( 'Photo', 'onstage' );
	$new_columns['title']               = __( 'Staff Name', 'onstage' );
	$new_columns['onstage_staff_title'] = __( 'Role / Title', 'onstage' );
	$new_columns['onstage_staff_show']  = __( 'On About Page', 'onstage' );
	$new_columns['onstage_order']       = __( 'Order', 'onstage' );
	return $new_columns;
}
add_filter( 'manage_staff_member_posts_columns', 'onstage_staff_columns' );

/**
 * Custom Admin Column Content for Staff.
 *
 * @param string $column  Column name.
 * @param int    $post_id Post ID.
 */
function onstage_staff_column_content( $column, $post_id ) {
	if ( 'onstage_photo' === $column ) {
		$thumb_id = get_post_thumbnail_id( $post_id );
		$photo    = get_post_meta( $post_id, 'onstage_staff_photo', true );
		if ( $thumb_id ) {
			echo wp_get_attachment_image( $thumb_id, array( 45, 45 ), false, array( 'style' => 'border-radius:50%; object-fit:cover;' ) );
		} elseif ( $photo ) {
			$src = ( 0 === strpos( $photo, 'http' ) || 0 === strpos( $photo, '/' ) ) ? $photo : onstage_img( $photo );
			echo '<img src="' . esc_url( $src ) . '" alt="" style="width:45px; height:45px; border-radius:50%; object-fit:cover;" />';
		} else {
			echo '<span class="dashicons dashicons-admin-users" style="font-size:30px; color:#cbd5e1;"></span>';
		}
	}
	if ( 'onstage_staff_title' === $column ) {
		$t = get_post_meta( $post_id, 'onstage_staff_title', true );
		echo $t ? esc_html( $t ) : '<em style="color:#94a3b8;">' . esc_html__( '—', 'onstage' ) . '</em>';
	}
	if ( 'onstage_staff_show' === $column ) {
		$show = get_post_meta( $post_id, 'onstage_staff_show_on_about', true );
		if ( '0' === (string) $show ) {
			echo '<span style="color:#ef4444; font-weight:600;">✕ ' . esc_html__( 'Hidden', 'onstage' ) . '</span>';
		} else {
			echo '<span style="color:#16a34a; font-weight:600;">✓ ' . esc_html__( 'Visible', 'onstage' ) . '</span>';
		}
	}
	if ( 'onstage_order' === $column ) {
		$post = get_post( $post_id );
		echo '<span class="badge" style="background:#e2e8f0; padding:2px 8px; border-radius:10px; font-weight:600;">#' . esc_html( $post->menu_order ) . '</span>';
	}
}
add_action( 'manage_staff_member_posts_custom_column', 'onstage_staff_column_content', 10, 2 );

/**
 * Make Order column sortable in admin.
 *
 * @param array $columns Sortable columns.
 * @return array
 */
function onstage_staff_sortable_columns( $columns ) {
	$columns['onstage_order'] = 'menu_order';
	return $columns;
}
add_filter( 'manage_edit-staff_member_sortable_columns', 'onstage_staff_sortable_columns' );

/**
 * Add Submenu: Drag & Drop Reorder Staff.
 */
function onstage_register_staff_reorder_page() {
	add_submenu_page(
		'edit.php?post_type=staff_member',
		__( 'Reorder Staff', 'onstage' ),
		__( 'Reorder Staff', 'onstage' ),
		'edit_posts',
		'onstage-reorder-staff',
		'onstage_render_staff_reorder_page'
	);
}
add_action( 'admin_menu', 'onstage_register_staff_reorder_page' );

/**
 * Render Drag-and-Drop Reorder Staff admin page.
 */
function onstage_render_staff_reorder_page() {
	$staff_members = get_posts( array(
		'post_type'      => 'staff_member',
		'post_status'    => array( 'publish', 'draft' ),
		'posts_per_page' => -1,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'title'      => 'ASC',
		),
	) );
	?>
	<div class="wrap" style="max-width:850px; margin:20px 0; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">
		<h1 style="display:flex; align-items:center; gap:10px; margin-bottom:15px;">
			<span>👥</span> <?php esc_html_e( 'Reorder Staff & Teachers', 'onstage' ); ?>
		</h1>
		<p class="description" style="font-size:14px; color:#475569; margin-bottom:20px;">
			<?php esc_html_e( 'Drag and drop staff members to rearrange the display order on the About page. Changes are saved automatically.', 'onstage' ); ?>
		</p>

		<div id="onstage_reorder_status" style="display:none; padding:12px 16px; border-radius:6px; margin-bottom:15px; font-weight:600;"></div>

		<div id="onstage_staff_sortable_list" style="display:flex; flex-direction:column; gap:10px;">
			<?php foreach ( $staff_members as $index => $staff ) :
				$thumb_id = get_post_thumbnail_id( $staff->ID );
				$photo    = get_post_meta( $staff->ID, 'onstage_staff_photo', true );
				$title    = get_post_meta( $staff->ID, 'onstage_staff_title', true );
				$show     = get_post_meta( $staff->ID, 'onstage_staff_show_on_about', true );

				if ( $thumb_id ) {
					$img_url = wp_get_attachment_image_url( $thumb_id, 'thumbnail' );
				} elseif ( $photo ) {
					$img_url = ( 0 === strpos( $photo, 'http' ) || 0 === strpos( $photo, '/' ) ) ? $photo : onstage_img( $photo );
				} else {
					$img_url = onstage_img( 'staff-linda.jpg' );
				}
				?>
				<div class="onstage-staff-item" data-id="<?php echo esc_attr( $staff->ID ); ?>" style="background:#fff; border:1px solid #cbd5e1; border-radius:8px; padding:12px 18px; display:flex; align-items:center; gap:16px; box-shadow:0 2px 4px rgba(0,0,0,0.04); cursor:grab; user-select:none;">
					<span class="dashicons dashicons-menu" style="color:#94a3b8; font-size:20px; cursor:grab;"></span>
					<span class="onstage-staff-badge" style="background:#E95BAF; color:#fff; font-weight:700; font-size:12px; padding:3px 8px; border-radius:12px; min-width:32px; text-align:center;">
						#<?php echo esc_html( $index + 1 ); ?>
					</span>
					<img src="<?php echo esc_url( $img_url ); ?>" alt="" style="width:48px; height:48px; border-radius:50%; object-fit:cover; border:2px solid #e2e8f0; flex-shrink:0;" />
					<div style="flex:1;">
						<strong style="font-size:15px; color:#0f172a; display:block;"><?php echo esc_html( $staff->post_title ); ?></strong>
						<?php if ( $title ) : ?>
							<span style="font-size:13px; color:#64748b;"><?php echo esc_html( $title ); ?></span>
						<?php endif; ?>
					</div>
					<div>
						<?php if ( '0' === (string) $show ) : ?>
							<span style="background:#fee2e2; color:#b91c1c; font-size:12px; font-weight:600; padding:3px 8px; border-radius:4px;"><?php esc_html_e( 'Hidden from About', 'onstage' ); ?></span>
						<?php else : ?>
							<span style="background:#dcfce7; color:#15803d; font-size:12px; font-weight:600; padding:3px 8px; border-radius:4px;"><?php esc_html_e( 'Visible on About', 'onstage' ); ?></span>
						<?php endif; ?>
					</div>
					<a href="<?php echo esc_url( get_edit_post_link( $staff->ID ) ); ?>" class="button button-small" style="text-decoration:none;"><?php esc_html_e( 'Edit', 'onstage' ); ?></a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<script>
	jQuery(document).ready(function($) {
		$('#onstage_staff_sortable_list').sortable({
			cursor: 'grabbing',
			opacity: 0.8,
			update: function(event, ui) {
				var order = [];
				$('#onstage_staff_sortable_list .onstage-staff-item').each(function(index) {
					order.push($(this).data('id'));
					$(this).find('.onstage-staff-badge').text('#' + (index + 1));
				});

				$('#onstage_reorder_status').css({
					background: '#fef3c7',
					color: '#92400e',
					display: 'block'
				}).text('<?php echo esc_js( __( 'Saving new order...', 'onstage' ) ); ?>');

				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action: 'onstage_save_staff_order',
						order: order,
						nonce: '<?php echo esc_js( wp_create_nonce( 'onstage_staff_reorder_nonce' ) ); ?>'
					},
					success: function(response) {
						if (response.success) {
							$('#onstage_reorder_status').css({
								background: '#dcfce7',
								color: '#15803d'
							}).text('<?php echo esc_js( __( '✓ Order saved successfully!', 'onstage' ) ); ?>');
							setTimeout(function() {
								$('#onstage_reorder_status').fadeOut();
							}, 2500);
						} else {
							$('#onstage_reorder_status').css({
								background: '#fee2e2',
								color: '#b91c1c'
							}).text('<?php echo esc_js( __( 'Error saving order. Please try again.', 'onstage' ) ); ?>');
						}
					},
					error: function() {
						$('#onstage_reorder_status').css({
							background: '#fee2e2',
							color: '#b91c1c'
						}).text('<?php echo esc_js( __( 'Connection error while saving order.', 'onstage' ) ); ?>');
					}
				});
			}
		});
	});
	</script>
	<?php
}

/**
 * AJAX Handler for saving reordered staff.
 */
function onstage_ajax_save_staff_order() {
	check_ajax_referer( 'onstage_staff_reorder_nonce', 'nonce' );

	if ( ! current_user_can( 'edit_posts' ) ) {
		wp_send_json_error( 'Unauthorized' );
	}

	$order = isset( $_POST['order'] ) ? (array) $_POST['order'] : array();
	if ( empty( $order ) ) {
		wp_send_json_error( 'Empty order' );
	}

	foreach ( $order as $index => $post_id ) {
		$post_id = (int) $post_id;
		if ( $post_id ) {
			wp_update_post( array(
				'ID'         => $post_id,
				'menu_order' => ( $index + 1 ) * 10,
			) );
		}
	}

	wp_send_json_success();
}
add_action( 'wp_ajax_onstage_save_staff_order', 'onstage_ajax_save_staff_order' );

/**
 * Auto-Seed Staff Member CPT from seed data if table is empty.
 * Strictly excludes Elle Gendreau.
 */
function onstage_auto_seed_staff_members() {
	// Only run in admin or when initializing
	if ( ! is_admin() ) {
		return;
	}

	$existing = get_posts( array(
		'post_type'      => 'staff_member',
		'post_status'    => array( 'publish', 'draft' ),
		'posts_per_page' => 1,
	) );

	if ( ! empty( $existing ) ) {
		return;
	}

	$seed_data = array(
		array(
			'name'  => 'Linda Mercer-Botelho',
			'title' => 'Founder & Executive Director',
			'image' => 'staff-linda.jpg',
			'order' => 10,
			'bio'   => "Linda Mercer-Botelho is the Founder and Executive Director of On Stage Academy of Performing Arts and On Stage Theatrical Productions. For more than 40 years, Linda has dedicated her career to providing children with professional performing arts training in a safe, nurturing, and educational environment.\n\nLinda studied Dance Education through the Boston Conservatory Teacher Certification Program and has continued her professional development through extensive training in Ballet, Jazz, Musical Theater, and Dance Education. She has studied with nationally recognized educators including Charles Kelley and Frank Hatchett and has participated in professional intensives through the American Ballet Academy at Vassar College.\n\nUnder Linda's direction, thousands of students have received training in dance, theater, and voice while building confidence, discipline, creativity, and leadership skills that extend far beyond the stage. Her passion for arts education continues to inspire generations of young performers throughout the South Coast community.\n\nLinda is a member of the JKSOM – Julie Kay Studio Owners Organization, as well as both the Dance Teachers Club of Boston and Dance Masters of America Chapter 5. Through these organizations, she continues to stay active in professional development, dance education, and industry training opportunities.",
		),
		array(
			'name'  => 'Roger Botelho Jr.',
			'title' => 'Music Director & Voice Instructor',
			'image' => 'staff-roger.jpg',
			'order' => 20,
			'bio'   => "Roger Botelho Jr. serves as the Music Director and Voice Instructor for On Stage Academy of Performing Arts and On Stage Theatrical Productions. Roger works closely with students in voice, piano, musical theater, and performance preparation, helping young performers develop strong vocal technique, musicianship, and stage confidence.\n\nRoger holds a Master's Degree in Special Education and brings both educational expertise and musical leadership to the organization. His supportive teaching style allows students of all experience levels to feel comfortable while growing artistically and personally.\n\nIn addition to directing music for productions and showcases, Roger has helped guide countless students through auditions, performances, and vocal development programs over the years.",
		),
		array(
			'name'  => 'Stacy Wong',
			'title' => 'Dance Instructor & Choreographer',
			'image' => 'staff-stacy.jpg',
			'order' => 30,
			'bio'   => "Stacy Wong has been part of the On Stage family for many years as both a performer and instructor. She specializes in Jazz, Tap, Musical Theater Dance, and performance choreography.\n\nStacy attended Providence College where she was a member of the Providence College Dance Team. Her strong technical background, performance experience, and upbeat teaching style make her a favorite among students of all ages.\n\nShe is passionate about helping children develop confidence, teamwork, and strong dance technique while creating a positive and encouraging classroom atmosphere. Stacy has choreographed numerous productions, showcases, and competition performances for On Stage students.",
		),
		array(
			'name'  => 'Hillary Coelho',
			'title' => 'Administrative Assistant',
			'image' => 'staff-hillary.jpg',
			'order' => 40,
			'bio'   => "Hillary Pavao serves as the Administrative Assistant for On Stage Academy of Performing Arts and On Stage Theatrical Productions. She works closely with students, parents, and staff to help keep daily operations organized and running smoothly.\n\nHillary assists with front desk operations, parent communications, registration support, scheduling, costumes, and event coordination throughout the year. Her welcoming personality, attention to detail, and dedication to the students and families of On Stage make her an important part of the organization.\n\nHillary is also a former On Stage student and graduate who began dancing at On Stage at the age of 5. Growing up through the program gave her a lifelong appreciation for the performing arts and the positive impact arts education can have on children and families.\n\nIn addition to her work at On Stage, Hillary currently works within the Fall River Public Schools system as a Speech Pathologist. Her background in education and communication, combined with her passion for youth development, helps create a welcoming and supportive experience for all students and families involved with On Stage Academy of Performing Arts.",
		),
		array(
			'name'  => 'Lisa Mailloux',
			'title' => 'Dance Educator',
			'image' => 'staff-lisa.jpg',
			'order' => 50,
			'bio'   => "Lisa Mailloux is an experienced dance educator and former studio owner with a lifelong dedication to dance education and the performing arts. Her extensive background in teaching, choreography, and studio leadership has made her a respected member of the dance community throughout the South Coast region.\n\nLisa has trained extensively in Ballet, Jazz, Tap, and Dance Education and has participated in numerous professional development programs and teacher training conferences throughout her career. She is committed to helping students build strong technical foundations while encouraging creativity, confidence, and artistic expression.\n\nThroughout the years, Lisa has worked with dancers of all ages and levels, sharing her knowledge, passion, and love of the arts with countless students. Her positive teaching style and dedication to quality arts education continue to inspire young performers both in and out of the classroom.\n\nOn Stage Academy of Performing Arts is proud to have Lisa as part of its extended performing arts family, where she continues to support and encourage the next generation of dancers and performers.",
		),
		array(
			'name'  => 'Azusa Okamoto',
			'title' => 'Classical Ballet Instructor',
			'image' => 'staff-azusa.jpg',
			'order' => 60,
			'bio'   => "Azusa Okamoto was born in Kyoto, Japan, and began her training at the age of three with the Fukutani Yoko Ballet Studio. At the age of 16, she was offered a full scholarship to attend the Victoria Academy of Ballet, where she graduated from the Post-Secondary Bridge Program, earning a diploma in Classical Ballet. Since moving to the U.S. in 2017, Azusa has performed numerous principal roles, including Sugar Plum, Snow Queen, Dew Drop in The Nutcracker, Snow White in Snow White, Cinderella and Fairy Godmother in Cinderella, and Michaela in Carmen among others. She has danced professionally for 9 years with Roxey Ballet, Utah Metropolitan Ballet, and Syracuse City Ballet.",
		),
		array(
			'name'  => 'Hannah Miller',
			'title' => 'Vocal Educator & Performer',
			'image' => 'staff-hannah.jpg',
			'order' => 70,
			'bio'   => "Hannah Miller is a vocal educator and performer passionate about helping singers of all ages develop healthy technique, confidence, and expressive storytelling skills. She earned her Bachelor of Music in Vocal Performance with a concentration in Teaching Artistry and Music Education from New England Conservatory, where she focused primarily on classical voice while also pursuing training in musical theatre and contemporary styles. Hannah's teaching approach emphasizes strong vocal foundations, musical curiosity, and creating a supportive environment where students can grow as confident artists.\n\nIn addition to maintaining a private voice studio, Hannah has taught through theatre camps, classroom settings, and organizations including Boston City Singers, Boston Hope Music, Fulton Theatre, Popovsky Performing Arts, and Servant Stage Company. She has worked with singers and performers of many ages and experience levels, both in individual instruction and collaborative rehearsal environments.\n\nAs a performer, Hannah has appeared in productions including Titanic, Dido and Aeneas, scenes from West Side Story, L'incoronazione di Poppea, and Die Zauberflöte. She has also performed as a soloist in recitals, concerts, and benefit performances throughout the Boston and Lancaster areas, including appearances with the Lancaster Symphony Choir.",
		),
	);

	foreach ( $seed_data as $data ) {
		$post_id = wp_insert_post( array(
			'post_title'  => $data['name'],
			'post_type'   => 'staff_member',
			'post_status' => 'publish',
			'menu_order'  => $data['order'],
		) );

		if ( $post_id && ! is_wp_error( $post_id ) ) {
			update_post_meta( $post_id, 'onstage_staff_title', $data['title'] );
			update_post_meta( $post_id, 'onstage_staff_bio', $data['bio'] );
			update_post_meta( $post_id, 'onstage_staff_photo', $data['image'] );
			update_post_meta( $post_id, 'onstage_staff_show_on_about', '1' );
		}
	}
}
add_action( 'admin_init', 'onstage_auto_seed_staff_members' );
