<?php
/**
 * Gallery Custom Post Type — Photo & Costume Galleries.
 *
 * Provides dynamic management of show photo galleries and costume rental
 * galleries in WP Admin.
 *
 * @package Onstage
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Gallery CPT (admin: Galleries).
 */
function onstage_register_gallery_cpt() {
	$labels = array(
		'name'               => __( 'Galleries', 'onstage' ),
		'singular_name'      => __( 'Gallery', 'onstage' ),
		'add_new'            => __( 'Add Gallery', 'onstage' ),
		'add_new_item'       => __( 'Add New Gallery', 'onstage' ),
		'edit_item'          => __( 'Edit Gallery', 'onstage' ),
		'new_item'           => __( 'New Gallery', 'onstage' ),
		'view_item'          => __( 'View Gallery', 'onstage' ),
		'search_items'       => __( 'Search Galleries', 'onstage' ),
		'not_found'          => __( 'No galleries found', 'onstage' ),
		'not_found_in_trash' => __( 'No galleries found in trash', 'onstage' ),
		'menu_name'          => __( 'Galleries', 'onstage' ),
		'all_items'          => __( 'All Galleries', 'onstage' ),
	);

	register_post_type(
		'gallery',
		array(
			'labels'              => $labels,
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'menu_icon'           => 'dashicons-format-gallery',
			'menu_position'       => 7,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'rewrite'             => array( 'slug' => 'gallery-item' ),
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

	register_post_meta( 'gallery', 'onstage_gallery_type', array_merge( $meta_args, array(
		'description' => __( 'Gallery type: photo or costume', 'onstage' ),
	) ) );
	register_post_meta( 'gallery', 'onstage_show_on_gallery_page', array_merge( $meta_args, array(
		'description' => __( 'Show this gallery on the main Photo & Video Gallery page (/gallery/)', 'onstage' ),
	) ) );
	register_post_meta( 'gallery', 'onstage_gallery_subtitle', array_merge( $meta_args, array(
		'description' => __( 'Subtitle or production note', 'onstage' ),
	) ) );
	register_post_meta( 'gallery', 'onstage_gallery_link', array_merge( $meta_args, array(
		'description' => __( 'Custom page link URL if overriding single page', 'onstage' ),
	) ) );
	register_post_meta( 'gallery', 'onstage_gallery_focal_point', array_merge( $meta_args, array(
		'description' => __( 'Image focal point: top center, center center, bottom center, etc.', 'onstage' ),
	) ) );
	register_post_meta( 'gallery', 'onstage_gallery_images', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'auth_callback'     => function () {
			return current_user_can( 'edit_posts' );
		},
		'sanitize_callback' => 'sanitize_textarea_field',
		'description'       => __( 'Comma-separated image URLs or attachment IDs for photo collection', 'onstage' ),
	) );
}
add_action( 'init', 'onstage_register_gallery_cpt' );

/**
 * Add Meta Box for Gallery settings.
 */
function onstage_gallery_meta_box() {
	add_meta_box(
		'onstage_gallery_details',
		__( 'Gallery Details & Settings', 'onstage' ),
		'onstage_gallery_meta_box_html',
		'gallery',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'onstage_gallery_meta_box' );

/**
 * Helper: Retrieve default or seeded image list for a gallery post.
 *
 * @param int $post_id Post ID.
 * @return string Newline-separated image URLs.
 */
function onstage_get_default_gallery_images( $post_id ) {
	$images = get_post_meta( $post_id, 'onstage_gallery_images', true );
	if ( ! empty( $images ) ) {
		return $images;
	}

	$post  = get_post( $post_id );
	$title = $post ? strtolower( $post->post_title ) : '';
	$type  = get_post_meta( $post_id, 'onstage_gallery_type', true );

	$list = array();
	if ( 'costume' === $type ) {
		if ( false !== strpos( $title, 'peter' ) ) {
			$list = array(
				onstage_img( 'costume-peter-pan.jpg' ),
				onstage_img( 'bts-3.jpg' ),
				onstage_img( 'dance.jpg' ),
				onstage_img( 'recital.jpg' ),
			);
		} elseif ( false !== strpos( $title, 'carol' ) || false !== strpos( $title, 'christmas' ) ) {
			$list = array(
				onstage_img( 'costume-christmas-carol.jpg' ),
				onstage_img( 'christmas-spectacular.jpg' ),
				onstage_img( 'bts-2.jpg' ),
				onstage_img( 'curtains.jpg' ),
			);
		} elseif ( false !== strpos( $title, 'oliver' ) ) {
			$list = array(
				onstage_img( 'costume-oliver.jpg' ),
				onstage_img( 'bts-5.jpg' ),
				onstage_img( 'musical.jpg' ),
				onstage_img( 'hero.jpg' ),
			);
		} else {
			$list = array( onstage_img( 'costume-banner.jpg' ) );
		}
	} else {
		if ( false !== strpos( $title, 'dare' ) || false !== strpos( $title, 'dream' ) ) {
			$list = array(
				onstage_img( 'gallery-dare-to-dream.jpg' ),
				onstage_img( 'bts-1.jpg' ),
				onstage_img( 'bts-2.jpg' ),
				onstage_img( 'bts-3.jpg' ),
				onstage_img( 'current-show.jpg' ),
				onstage_img( 'student-showcase.jpg' ),
				onstage_img( 'bts-8.jpg' ),
				onstage_img( 'bts-9.jpg' ),
			);
		} elseif ( false !== strpos( $title, 'peter' ) ) {
			$list = array(
				onstage_img( 'gallery-peter-pan.jpg' ),
				onstage_img( 'costume-peter-pan.jpg' ),
				onstage_img( 'bts-3.jpg' ),
				onstage_img( 'bts-7.jpg' ),
				onstage_img( 'dance.jpg' ),
				onstage_img( 'recital.jpg' ),
				onstage_img( 'bts-4.jpg' ),
				onstage_img( 'hero.jpg' ),
			);
		} elseif ( false !== strpos( $title, 'carol' ) || false !== strpos( $title, 'christmas' ) ) {
			$list = array(
				onstage_img( 'gallery-christmas-carol.jpg' ),
				onstage_img( 'costume-christmas-carol.jpg' ),
				onstage_img( 'christmas-spectacular.jpg' ),
				onstage_img( 'bts-2.jpg' ),
				onstage_img( 'bts-4.jpg' ),
				onstage_img( 'curtains.jpg' ),
				onstage_img( 'bts-6.jpg' ),
				onstage_img( 'bts-8.jpg' ),
			);
		} elseif ( false !== strpos( $title, 'oliver' ) ) {
			$list = array(
				onstage_img( 'gallery-oliver.jpg' ),
				onstage_img( 'costume-oliver.jpg' ),
				onstage_img( 'bts-5.jpg' ),
				onstage_img( 'bts-6.jpg' ),
				onstage_img( 'musical.jpg' ),
				onstage_img( 'hero.jpg' ),
				onstage_img( 'bts-1.jpg' ),
				onstage_img( 'current-show.jpg' ),
			);
		}
	}

	return implode( "\n", $list );
}

/**
 * Render Gallery Meta Box.
 *
 * @param WP_Post $post Current post.
 */
function onstage_gallery_meta_box_html( $post ) {
	wp_nonce_field( 'onstage_gallery_meta', 'onstage_gallery_meta_nonce' );
	$type      = get_post_meta( $post->ID, 'onstage_gallery_type', true );
	$show_grid = get_post_meta( $post->ID, 'onstage_show_on_gallery_page', true );
	$subtitle  = get_post_meta( $post->ID, 'onstage_gallery_subtitle', true );
	$link      = get_post_meta( $post->ID, 'onstage_gallery_link', true );
	$focal     = get_post_meta( $post->ID, 'onstage_gallery_focal_point', true );
	$images    = get_post_meta( $post->ID, 'onstage_gallery_images', true );

	if ( empty( $images ) ) {
		$images = onstage_get_default_gallery_images( $post->ID );
	}

	if ( empty( $type ) ) {
		$type = 'photo';
	}
	if ( '' === (string) $show_grid ) {
		$show_grid = '1';
	}
	if ( empty( $focal ) ) {
		$focal = 'top center';
	}
	?>
	<div class="onstage-admin-card" style="background:#f8fafc; border:1px solid #cbd5e1; padding:15px; border-radius:6px; margin-bottom:15px;">
		<h4 style="margin:0 0 10px 0; color:#0f172a;"><?php esc_html_e( '📌 Gallery Category & Page Visibility', 'onstage' ); ?></h4>
		
		<p style="background:#f1f5f9; padding:12px 14px; border-radius:6px; border-left:4px solid #e95baf; margin-bottom:15px;">
			<label for="onstage_show_on_gallery_page" style="cursor:pointer; font-size:14px;">
				<input type="checkbox" id="onstage_show_on_gallery_page" name="onstage_show_on_gallery_page" value="1" <?php checked( $show_grid, '1' ); ?> style="margin-right:6px;" />
				<strong><?php esc_html_e( 'Display this gallery on the main Photo & Video Gallery page (/gallery/)', 'onstage' ); ?></strong>
			</label>
			<span class="description" style="display:block; margin-top:4px; margin-left:24px; color:#475569;"><?php esc_html_e( 'Check this box to include this gallery card on the main /gallery/ page. Uncheck if you want to keep the gallery active but hidden from the main page grid list.', 'onstage' ); ?></span>
		</p>

		<p>
			<label for="onstage_gallery_type"><strong><?php esc_html_e( 'Gallery Category:', 'onstage' ); ?></strong></label><br />
			<select id="onstage_gallery_type" name="onstage_gallery_type" class="widefat" style="max-width:400px; margin-top:4px;">
				<option value="photo" <?php selected( $type, 'photo' ); ?>><?php esc_html_e( 'Show Photo Gallery (Displays on /gallery/ page)', 'onstage' ); ?></option>
				<option value="costume" <?php selected( $type, 'costume' ); ?>><?php esc_html_e( 'Costume Rental Gallery (Displays on /costume-rentals/ page)', 'onstage' ); ?></option>
			</select>
		</p>
		<p>
			<label for="onstage_gallery_focal_point"><strong><?php esc_html_e( 'Cover Photo Crop Focus / Focal Point:', 'onstage' ); ?></strong></label><br />
			<select id="onstage_gallery_focal_point" name="onstage_gallery_focal_point" class="widefat" style="max-width:400px; margin-top:4px;">
				<option value="top center" <?php selected( $focal, 'top center' ); ?>><?php esc_html_e( 'Top / Heads Focus (Keeps heads from getting cut off)', 'onstage' ); ?></option>
				<option value="center center" <?php selected( $focal, 'center center' ); ?>><?php esc_html_e( 'Center Focus (Default)', 'onstage' ); ?></option>
				<option value="bottom center" <?php selected( $focal, 'bottom center' ); ?>><?php esc_html_e( 'Bottom Focus', 'onstage' ); ?></option>
				<option value="center left" <?php selected( $focal, 'center left' ); ?>><?php esc_html_e( 'Left Focus', 'onstage' ); ?></option>
				<option value="center right" <?php selected( $focal, 'center right' ); ?>><?php esc_html_e( 'Right Focus', 'onstage' ); ?></option>
			</select>
			<span class="description" style="display:block; margin-top:4px;"><?php esc_html_e( 'Controls image positioning on cropped card thumbnails to prevent heads from getting cut off.', 'onstage' ); ?></span>
		</p>
		<p>
			<label for="onstage_gallery_subtitle"><strong><?php esc_html_e( 'Subtitle / Tagline:', 'onstage' ); ?></strong></label><br />
			<input type="text" id="onstage_gallery_subtitle" name="onstage_gallery_subtitle" value="<?php echo esc_attr( $subtitle ); ?>" class="widefat" style="max-width:500px;" placeholder="e.g. 30th Anniversary Production" />
		</p>
		<p>
			<label for="onstage_gallery_link"><strong><?php esc_html_e( 'Custom Page Link (Optional):', 'onstage' ); ?></strong></label><br />
			<input type="text" id="onstage_gallery_link" name="onstage_gallery_link" value="<?php echo esc_attr( $link ); ?>" class="widefat" style="max-width:500px;" placeholder="/peter-pan-gallery/" />
			<span class="description" style="display:block; margin-top:4px;"><?php esc_html_e( 'Leave empty to link automatically to this gallery post page.', 'onstage' ); ?></span>
		</p>
	</div>

	<div class="onstage-admin-card" style="background:#f8fafc; border:1px solid #cbd5e1; padding:15px; border-radius:6px;">
		<h4 style="margin:0 0 10px 0; color:#0f172a;"><?php esc_html_e( '📸 Gallery Photos (Add, Remove & Drag to Reorder)', 'onstage' ); ?></h4>
		<p class="description" style="margin-bottom:12px;">
			<?php esc_html_e( 'Click "Add / Select Photos" to select or upload multiple photos. Drag and drop photo thumbnails below to reorder them, or click the red × button to remove a photo.', 'onstage' ); ?>
		</p>
		
		<div style="display:flex; align-items:center; gap:15px; margin-bottom:15px; flex-wrap:wrap;">
			<button type="button" class="button button-primary button-large" id="onstage_add_gallery_photos_btn" style="background:#e95baf; border-color:#e95baf; font-weight:600;">
				<span class="dashicons dashicons-format-gallery" style="vertical-align:middle; margin-top:-2px; margin-right:4px;"></span>
				<?php esc_html_e( 'Add / Select Photos from Media Library', 'onstage' ); ?>
			</button>
			<span id="onstage_photo_count_badge" style="background:#e2e8f0; color:#1e293b; padding:6px 12px; border-radius:12px; font-weight:700; font-size:13px;">📸 0 Photos</span>
		</div>

		<!-- Visual Thumbnail Preview Grid with Drag & Drop Reordering and Remove Buttons -->
		<div id="onstage_gallery_preview_grid" style="display:flex; flex-wrap:wrap; gap:12px; margin-bottom:15px; padding:14px; background:#ffffff; border:1px solid #cbd5e1; border-radius:6px; min-height:90px; align-items:center;"></div>

		<details>
			<summary style="cursor:pointer; color:#0284c7; font-weight:600; margin-bottom:6px;"><?php esc_html_e( 'Advanced: Direct Image URLs / Attachment IDs List', 'onstage' ); ?></summary>
			<textarea id="onstage_gallery_images" name="onstage_gallery_images" rows="4" class="widefat" style="margin-top:6px;" placeholder="Image URLs, one per line"><?php echo esc_textarea( $images ); ?></textarea>
		</details>
	</div>

	<script>
	jQuery(document).ready(function($) {
		function updateTextareaFromDOM() {
			var urls = [];
			$('#onstage_gallery_preview_grid .onstage-thumb-item').each(function() {
				var u = $(this).attr('data-url');
				if (u) urls.push(u);
			});
			$('#onstage_gallery_images').val(urls.join("\n"));
			updateBadges();
		}

		function updateBadges() {
			var $items = $('#onstage_gallery_preview_grid .onstage-thumb-item');
			var total = $items.length;
			$('#onstage_photo_count_badge').text('📸 ' + total + (total === 1 ? ' Photo' : ' Photos'));
			$items.each(function(index) {
				$(this).find('.onstage-thumb-badge').text('⋮⋮ #' + (index + 1));
			});
		}

		function initSortable() {
			if ($.fn.sortable) {
				$('#onstage_gallery_preview_grid').sortable({
					items: '.onstage-thumb-item',
					cursor: 'grabbing',
					opacity: 0.75,
					placeholder: 'onstage-sortable-placeholder',
					start: function(e, ui) {
						ui.placeholder.css({
							width: '100px',
							height: '100px',
							background: '#cbd5e1',
							borderRadius: '8px',
							border: '2px dashed #64748b'
						});
					},
					update: function() {
						updateTextareaFromDOM();
					}
				});
			}
		}

		function renderPreviewGrid() {
			var raw = $('#onstage_gallery_images').val().trim();
			var $grid = $('#onstage_gallery_preview_grid').empty();
			if (!raw) {
				$grid.html('<span style="color:#94a3b8; font-style:italic; font-size:13px;"><?php echo esc_js( __( 'No photos added yet. Click "Add / Select Photos from Media Library" above to add photos.', 'onstage' ) ); ?></span>');
				$('#onstage_photo_count_badge').text('📸 0 Photos');
				return;
			}

			var lines = raw.split(/[\r\n,]+/);
			var validLines = [];
			lines.forEach(function(url) {
				url = url.trim();
				if (url) validLines.push(url);
			});

			$('#onstage_photo_count_badge').text('📸 ' + validLines.length + (validLines.length === 1 ? ' Photo' : ' Photos'));

			validLines.forEach(function(url, index) {
				var $thumb = $('<div class="onstage-thumb-item" data-url="' + url + '" style="position:relative; width:100px; height:100px; border-radius:8px; overflow:hidden; border:2px solid #cbd5e1; background:#0f172a; box-shadow:0 3px 6px rgba(0,0,0,0.15); cursor:grab; user-select:none;"></div>');
				var $img = $('<img style="width:100%; height:100%; object-fit:cover; display:block; pointer-events:none;" />').attr('src', url);
				var $badge = $('<span class="onstage-thumb-badge" style="position:absolute; bottom:4px; left:4px; background:rgba(15,23,42,0.85); color:#fff; font-size:11px; font-weight:700; padding:2px 6px; border-radius:4px; font-family:sans-serif; cursor:grab;" title="<?php echo esc_js( __( 'Drag to reorder', 'onstage' ) ); ?>">⋮⋮ #' + (index + 1) + '</span>');
				var $removeBtn = $('<button type="button" title="<?php echo esc_js( __( 'Remove photo', 'onstage' ) ); ?>" style="position:absolute; top:4px; right:4px; background:#ef4444; color:#ffffff; border:none; border-radius:50%; width:24px; height:24px; font-weight:bold; font-size:15px; cursor:pointer; line-height:22px; text-align:center; padding:0; box-shadow:0 2px 5px rgba(0,0,0,0.5); z-index:10;">&times;</button>');
				
				$removeBtn.on('click', function(e) {
					e.preventDefault();
					e.stopPropagation();
					$thumb.remove();
					updateTextareaFromDOM();
					if ($('#onstage_gallery_preview_grid .onstage-thumb-item').length === 0) {
						renderPreviewGrid();
					}
				});

				$thumb.append($img).append($badge).append($removeBtn);
				$grid.append($thumb);
			});

			initSortable();
		}

		renderPreviewGrid();

		var frame;
		$('#onstage_add_gallery_photos_btn').on('click', function(e) {
			e.preventDefault();
			if (frame) {
				frame.open();
				return;
			}
			frame = wp.media({
				title: '<?php echo esc_js( __( 'Select Gallery Photos', 'onstage' ) ); ?>',
				button: { text: '<?php echo esc_js( __( 'Add Selected Photos to Gallery', 'onstage' ) ); ?>' },
				multiple: true
			});
			frame.on('select', function() {
				var selection = frame.state().get('selection');
				var currentRaw = $('#onstage_gallery_images').val().trim();
				var existing = [];
				if (currentRaw) {
					currentRaw.split(/[\r\n,]+/).forEach(function(u) {
						u = u.trim();
						if (u) existing.push(u);
					});
				}
				selection.each(function(attachment) {
					var url = attachment.attributes.url;
					if (existing.indexOf(url) === -1) {
						existing.push(url);
					}
				});
				$('#onstage_gallery_images').val(existing.join("\n"));
				renderPreviewGrid();
			});
			frame.open();
		});
	});
	</script>
	<?php
}


/**
 * Save Gallery Meta.
 *
 * @param int $post_id Post ID.
 */
function onstage_save_gallery_meta( $post_id ) {
	if ( ! isset( $_POST['onstage_gallery_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['onstage_gallery_meta_nonce'] ) ), 'onstage_gallery_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['onstage_gallery_type'] ) ) {
		update_post_meta( $post_id, 'onstage_gallery_type', sanitize_text_field( wp_unslash( $_POST['onstage_gallery_type'] ) ) );
	}
	$show_val = ( isset( $_POST['onstage_show_on_gallery_page'] ) && '1' === $_POST['onstage_show_on_gallery_page'] ) ? '1' : '0';
	update_post_meta( $post_id, 'onstage_show_on_gallery_page', $show_val );

	if ( isset( $_POST['onstage_gallery_focal_point'] ) ) {
		update_post_meta( $post_id, 'onstage_gallery_focal_point', sanitize_text_field( wp_unslash( $_POST['onstage_gallery_focal_point'] ) ) );
	}
	if ( isset( $_POST['onstage_gallery_subtitle'] ) ) {
		update_post_meta( $post_id, 'onstage_gallery_subtitle', sanitize_text_field( wp_unslash( $_POST['onstage_gallery_subtitle'] ) ) );
	}
	if ( isset( $_POST['onstage_gallery_link'] ) ) {
		update_post_meta( $post_id, 'onstage_gallery_link', sanitize_text_field( wp_unslash( $_POST['onstage_gallery_link'] ) ) );
	}
	if ( isset( $_POST['onstage_gallery_images'] ) ) {
		update_post_meta( $post_id, 'onstage_gallery_images', sanitize_textarea_field( wp_unslash( $_POST['onstage_gallery_images'] ) ) );
	}
}
add_action( 'save_post_gallery', 'onstage_save_gallery_meta' );

/**
 * Helper: Resolve the cover image URL for a gallery post.
 * Checks featured image, custom images meta, title keywords, and fallback assets.
 *
 * @param int $post_id Post ID.
 * @return string Image URL.
 */
function onstage_get_gallery_cover_url( $post_id ) {
	$thumb_id = get_post_thumbnail_id( $post_id );
	if ( $thumb_id ) {
		$url = wp_get_attachment_image_url( $thumb_id, 'large' );
		if ( $url ) {
			return $url;
		}
	}

	$meta_images = get_post_meta( $post_id, 'onstage_gallery_images', true );
	if ( ! empty( $meta_images ) ) {
		$lines = preg_split( '/[\r\n,]+/', $meta_images );
		foreach ( $lines as $line ) {
			$line = trim( $line );
			if ( ! empty( $line ) ) {
				if ( filter_var( $line, FILTER_VALIDATE_URL ) ) {
					return $line;
				}
				if ( is_numeric( $line ) ) {
					$url = wp_get_attachment_image_url( (int) $line, 'large' );
					if ( $url ) {
						return $url;
					}
				}
			}
		}
	}

	$post  = get_post( $post_id );
	$title = $post ? strtolower( $post->post_title ) : '';
	$type  = get_post_meta( $post_id, 'onstage_gallery_type', true );

	if ( 'costume' === $type ) {
		if ( false !== strpos( $title, 'peter' ) ) {
			return onstage_img( 'costume-peter-pan.jpg' );
		}
		if ( false !== strpos( $title, 'carol' ) || false !== strpos( $title, 'christmas' ) ) {
			return onstage_img( 'costume-christmas-carol.jpg' );
		}
		if ( false !== strpos( $title, 'oliver' ) ) {
			return onstage_img( 'costume-oliver.jpg' );
		}
		return onstage_img( 'costume-banner.jpg' );
	}

	if ( false !== strpos( $title, 'dare' ) || false !== strpos( $title, 'dream' ) ) {
		return onstage_img( 'gallery-dare-to-dream.jpg' );
	}
	if ( false !== strpos( $title, 'peter' ) ) {
		return onstage_img( 'gallery-peter-pan.jpg' );
	}
	if ( false !== strpos( $title, 'carol' ) || false !== strpos( $title, 'christmas' ) ) {
		return onstage_img( 'gallery-christmas-carol.jpg' );
	}
	if ( false !== strpos( $title, 'oliver' ) ) {
		return onstage_img( 'gallery-oliver.jpg' );
	}

	return onstage_img( 'curtains.jpg' );
}

/**
 * Helper: Resolve the destination page URL for a gallery card.
 *
 * @param int $post_id Post ID.
 * @return string Target URL.
 */
function onstage_get_gallery_link( $post_id ) {
	$link = get_post_meta( $post_id, 'onstage_gallery_link', true );
	if ( ! empty( $link ) ) {
		return site_url( $link );
	}

	$post = get_post( $post_id );
	if ( $post ) {
		$slug       = $post->post_name;
		$clean_slug = str_replace( '-cpt', '', $slug );

		// Check if a dedicated page exists with slug like 'dare-to-dream-gallery'
		$page = get_page_by_path( $clean_slug );
		if ( $page ) {
			return get_permalink( $page->ID );
		}

		if ( false === strpos( $clean_slug, 'gallery' ) ) {
			$page = get_page_by_path( $clean_slug . '-gallery' );
			if ( $page ) {
				return get_permalink( $page->ID );
			}
		}

		return get_permalink( $post_id );
	}

	return '#';
}

/**
 * Dynamic Shortcode for Gallery Grid: [onstage_gallery_grid type="photo|costume"]
 *
 * @param array $atts Shortcode attributes.
 * @return string HTML output.
 */
function onstage_render_gallery_grid( $atts ) {
	$atts = shortcode_atts(
		array(
			'type'  => 'photo',
			'count' => -1,
		),
		$atts,
		'onstage_gallery_grid'
	);

	$args = array(
		'post_type'      => 'gallery',
		'posts_per_page' => (int) $atts['count'],
		'post_status'    => 'publish',
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
		'meta_query'     => array(
			'relation' => 'AND',
			array(
				'relation' => 'OR',
				array(
					'key'     => 'onstage_gallery_type',
					'value'   => $atts['type'],
					'compare' => '=',
				),
				array(
					'key'     => 'onstage_gallery_type',
					'compare' => 'NOT EXISTS',
				),
			),
			array(
				'relation' => 'OR',
				array(
					'key'     => 'onstage_show_on_gallery_page',
					'value'   => '0',
					'compare' => '!=',
				),
				array(
					'key'     => 'onstage_show_on_gallery_page',
					'compare' => 'NOT EXISTS',
				),
			),
		),
	);


	$galleries = get_posts( $args );
	if ( empty( $galleries ) ) {
		return '';
	}

	$html = '<div class="wp-block-columns gallery-grid-new show-gallery-grid">' . "\n";
	foreach ( $galleries as $post ) {
		$title = get_the_title( $post->ID );
		$cover = onstage_get_gallery_cover_url( $post->ID );
		$link  = onstage_get_gallery_link( $post->ID );
		$focal = get_post_meta( $post->ID, 'onstage_gallery_focal_point', true );
		if ( empty( $focal ) ) {
			$focal = 'top center';
		}

		$html .= '<div class="wp-block-column gallery-item-new">' . "\n";
		$html .= '  <div class="show-gallery-card-wrapper">' . "\n";
		$html .= '    <a href="' . esc_url( $link ) . '" class="show-gallery-card-link" aria-label="' . esc_attr( sprintf( __( 'View %s gallery', 'onstage' ), $title ) ) . '">' . "\n";
		$html .= '      <div class="show-gallery-card">' . "\n";
		$html .= '        <img class="show-gallery-card-img" alt="' . esc_attr( $title ) . '" src="' . esc_url( $cover ) . '" style="object-position:' . esc_attr( $focal ) . ';" />' . "\n";
		$html .= '        <div class="show-gallery-card-gradient"></div>' . "\n";
		$html .= '        <div class="show-gallery-card-content">' . "\n";
		$html .= '          <h3 class="show-gallery-card-title">' . esc_html( mb_strtoupper( $title ) ) . '</h3>' . "\n";
		$html .= '          <span class="show-gallery-card-subtext">' . __( 'VIEW GALLERY', 'onstage' ) . '</span>' . "\n";
		$html .= '        </div>' . "\n";
		$html .= '      </div>' . "\n";
		$html .= '    </a>' . "\n";
		$html .= '  </div>' . "\n";
		$html .= '</div>' . "\n";
	}
	$html .= '</div>' . "\n";

	return $html;
}
add_shortcode( 'onstage_gallery_grid', 'onstage_render_gallery_grid' );

/**
 * Filter content of single Gallery CPT posts so any gallery created in WP Admin
 * renders a responsive photo grid with lightbox support.
 *
 * @param string $content Post content.
 * @return string Filtered content.
 */
function onstage_single_gallery_content( $content ) {
	if ( ! is_singular( 'gallery' ) ) {
		return $content;
	}

	$post_id     = get_the_ID();
	$images_meta = get_post_meta( $post_id, 'onstage_gallery_images', true );
	$title       = get_the_title( $post_id );
	$type        = get_post_meta( $post_id, 'onstage_gallery_type', true );

	$image_list = array();

	// 1. Parse images from meta if provided
	if ( ! empty( $images_meta ) ) {
		$lines = preg_split( '/[\r\n,]+/', $images_meta );
		foreach ( $lines as $idx => $line ) {
			$line = trim( $line );
			if ( ! empty( $line ) ) {
				if ( filter_var( $line, FILTER_VALIDATE_URL ) ) {
					$image_list[] = array( 'src' => $line, 'alt' => sprintf( '%s photo %d', $title, $idx + 1 ) );
				} elseif ( is_numeric( $line ) ) {
					$url = wp_get_attachment_image_url( (int) $line, 'large' );
					if ( $url ) {
						$image_list[] = array( 'src' => $url, 'alt' => sprintf( '%s photo %d', $title, $idx + 1 ) );
					}
				}
			}
		}
	}

	// 2. Extract image sources from post_content if any gallery or image blocks exist
	if ( empty( $image_list ) && ! empty( $content ) ) {
		preg_match_all( '/<img[^>]+src=["\']([^"\']+)["\']/i', $content, $matches );
		if ( ! empty( $matches[1] ) ) {
			foreach ( $matches[1] as $idx => $src ) {
				$image_list[] = array( 'src' => $src, 'alt' => sprintf( '%s photo %d', $title, $idx + 1 ) );
			}
		}
	}

	// 3. Fallback sample images if post was created without images
	if ( empty( $image_list ) ) {
		$cover = onstage_get_gallery_cover_url( $post_id );
		$image_list[] = array( 'src' => $cover, 'alt' => $title . ' main photo' );
		$image_list[] = array( 'src' => onstage_img( 'bts-1.jpg' ), 'alt' => $title . ' photo 2' );
		$image_list[] = array( 'src' => onstage_img( 'bts-2.jpg' ), 'alt' => $title . ' photo 3' );
		$image_list[] = array( 'src' => onstage_img( 'bts-3.jpg' ), 'alt' => $title . ' photo 4' );
		$image_list[] = array( 'src' => onstage_img( 'bts-4.jpg' ), 'alt' => $title . ' photo 5' );
		$image_list[] = array( 'src' => onstage_img( 'bts-5.jpg' ), 'alt' => $title . ' photo 6' );
	}

	$grid_html = function_exists( 'onstage_media_card_grid' ) ? onstage_media_card_grid( $image_list ) : '';

	$back_url   = ( 'costume' === $type ) ? '/costume-rentals/' : '/gallery/';
	$back_label = ( 'costume' === $type ) ? '← BACK TO COSTUME RENTALS' : '← BACK TO PHOTO GALLERY';
	$youtube    = 'https://www.youtube.com/channel/UCYURAEfRUgjAipibRgcIiOg';

	$actions = '<p class="program-child-actions" style="margin-top:40px; text-align:center;"><a class="btn btn-pink rounded-pill" href="' . esc_url( $back_url ) . '">VIEW ALL GALLERIES</a><a class="btn btn-black" href="' . esc_url( $youtube ) . '" target="_blank" rel="noreferrer noopener">VIEW MORE ON YOUTUBE</a></p>';

	$output  = '<div class="single-gallery-container">' . "\n";
	$output .= '  <div class="gallery-back-link" style="margin-bottom:20px;"><a href="' . esc_url( $back_url ) . '">' . esc_html( $back_label ) . '</a></div>' . "\n";
	if ( ! empty( $content ) ) {
		$output .= '  <div class="gallery-description bg-light-gray" style="padding:20px; border-radius:8px; margin-bottom:30px;">' . $content . '</div>' . "\n";
	}
	$output .= '  <div class="single-gallery-photos-grid">' . $grid_html . '</div>' . "\n";
	$output .= '  ' . $actions . "\n";
	$output .= '</div>' . "\n";

	return $output;
}
add_filter( 'the_content', 'onstage_single_gallery_content' );


