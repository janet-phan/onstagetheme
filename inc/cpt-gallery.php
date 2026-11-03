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
			'show_in_rest'        => false,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'menu_icon'           => 'dashicons-format-gallery',
			'menu_position'       => 7,
			'supports'            => array( 'title', 'thumbnail', 'page-attributes' ),
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
	$thumb_id  = get_post_thumbnail_id( $post->ID );

	if ( $thumb_id ) {
		$cover_preview = wp_get_attachment_image_url( $thumb_id, 'medium' );
	} else {
		$cover_preview = onstage_get_gallery_cover_url( $post->ID );
	}

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
	<!-- Card 1: Cover Image & Quick Info -->
	<div class="onstage-admin-card" style="background:#f8fafc; border:1px solid #cbd5e1; padding:18px; border-radius:8px; margin-bottom:15px; display:flex; gap:24px; align-items:center; flex-wrap:wrap;">
		<div style="text-align:center;">
			<img id="onstage_gallery_cover_preview" src="<?php echo esc_url( $cover_preview ); ?>" alt="Album Cover" style="width:140px; height:105px; object-fit:cover; border-radius:8px; border:2px solid #6A3FC7; box-shadow:0 4px 12px rgba(0,0,0,0.12); display:block; background:#0f172a;" />
		</div>
		<div style="flex:1; min-width:260px;">
			<h4 style="margin:0 0 6px 0; font-size:16px; color:#0f172a;"><?php esc_html_e( 'Album Card Cover Image', 'onstage' ); ?></h4>
			<p class="description" style="margin:0 0 12px 0; font-size:13px; color:#64748b; line-height:1.5;">
				<?php esc_html_e( 'This is the main image displayed on the album card on the /gallery/ page grid. (Syncs automatically with WordPress Featured Image).', 'onstage' ); ?>
			</p>
			<input type="hidden" id="onstage_gallery_cover_id" name="onstage_gallery_cover_id" value="<?php echo esc_attr( $thumb_id ? $thumb_id : '' ); ?>" />
			<div style="display:flex; gap:8px;">
				<button type="button" class="button button-secondary" id="onstage_gallery_cover_btn" style="font-weight:600;">
					<span class="dashicons dashicons-format-image" style="vertical-align:middle; margin-top:-2px;"></span>
					<?php esc_html_e( 'Choose / Upload Cover Image', 'onstage' ); ?>
				</button>
				<button type="button" class="button button-link-delete" id="onstage_gallery_cover_remove_btn" style="<?php echo $thumb_id ? '' : 'display:none;'; ?>">
					<?php esc_html_e( 'Remove Cover', 'onstage' ); ?>
				</button>
			</div>
		</div>
	</div>

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

		// Cover Image Media Library Picker
		var coverFrame;
		$('#onstage_gallery_cover_btn').on('click', function(e) {
			e.preventDefault();
			if (coverFrame) {
				coverFrame.open();
				return;
			}
			coverFrame = wp.media({
				title: '<?php echo esc_js( __( 'Select Album Card Cover Image', 'onstage' ) ); ?>',
				button: { text: '<?php echo esc_js( __( 'Use as Cover Image', 'onstage' ) ); ?>' },
				multiple: false
			});
			coverFrame.on('select', function() {
				var attachment = coverFrame.state().get('selection').first().toJSON();
				$('#onstage_gallery_cover_id').val(attachment.id);
				var imgUrl = attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;
				$('#onstage_gallery_cover_preview').attr('src', imgUrl);
				$('#onstage_gallery_cover_remove_btn').show();
			});
			coverFrame.open();
		});

		$('#onstage_gallery_cover_remove_btn').on('click', function(e) {
			e.preventDefault();
			$('#onstage_gallery_cover_id').val('');
			$('#onstage_gallery_cover_preview').attr('src', '<?php echo esc_js( onstage_img( 'placeholder_show.png' ) ); ?>');
			$(this).hide();
		});

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

	if ( isset( $_POST['onstage_gallery_cover_id'] ) ) {
		$thumb_val = sanitize_text_field( wp_unslash( $_POST['onstage_gallery_cover_id'] ) );
		if ( ! empty( $thumb_val ) ) {
			set_post_thumbnail( $post_id, (int) $thumb_val );
		} else {
			delete_post_thumbnail( $post_id );
		}
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

		// Check if a dedicated page exists with exact clean slug
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

		if ( false === strpos( $clean_slug, 'costumes' ) ) {
			$page = get_page_by_path( $clean_slug . '-costumes' );
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

/**
 * Add Submenus: Drag & Drop Reorder Photo & Costume Galleries.
 */
function onstage_register_gallery_reorder_page() {
	add_submenu_page(
		'edit.php?post_type=gallery',
		__( 'Reorder Photo Galleries', 'onstage' ),
		__( '↕ Reorder Photo Galleries', 'onstage' ),
		'edit_posts',
		'onstage-reorder-galleries',
		'onstage_render_gallery_reorder_page'
	);
	add_submenu_page(
		'edit.php?post_type=gallery',
		__( 'Reorder Costume Galleries', 'onstage' ),
		__( '↕ Reorder Costume Galleries', 'onstage' ),
		'edit_posts',
		'onstage-reorder-costumes',
		'onstage_render_costume_reorder_page'
	);
}
add_action( 'admin_menu', 'onstage_register_gallery_reorder_page' );

/**
 * Render Costume Galleries reorder entry point.
 */
function onstage_render_costume_reorder_page() {
	onstage_render_gallery_reorder_page( 'costume' );
}

/**
 * Render Drag-and-Drop Reorder Galleries admin page with tabs.
 *
 * @param string $initial_tab Initial tab ('photo' or 'costume').
 */
function onstage_render_gallery_reorder_page( $initial_tab = 'photo' ) {
	$tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : $initial_tab;
	if ( ! in_array( $tab, array( 'photo', 'costume' ), true ) ) {
		$tab = 'photo';
	}

	$meta_query = ( 'costume' === $tab )
		? array(
			array(
				'key'     => 'onstage_gallery_type',
				'value'   => 'costume',
				'compare' => '=',
			),
		)
		: array(
			'relation' => 'OR',
			array(
				'key'     => 'onstage_gallery_type',
				'value'   => 'photo',
				'compare' => '=',
			),
			array(
				'key'     => 'onstage_gallery_type',
				'compare' => 'NOT EXISTS',
			),
		);

	$galleries = get_posts( array(
		'post_type'      => 'gallery',
		'post_status'    => array( 'publish', 'draft' ),
		'posts_per_page' => -1,
		'meta_query'     => $meta_query,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'title'      => 'ASC',
		),
	) );
	?>
	<div class="wrap" style="max-width:850px; margin:20px 0; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">
		<h1 style="display:flex; align-items:center; gap:10px; margin-bottom:15px;">
			<span>🖼️</span> <?php esc_html_e( 'Reorder Photo & Costume Galleries', 'onstage' ); ?>
		</h1>

		<!-- Navigation Tabs -->
		<h2 class="nav-tab-wrapper" style="margin-bottom:20px;">
			<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=gallery&page=onstage-reorder-galleries&tab=photo' ) ); ?>" class="nav-tab <?php echo 'photo' === $tab ? 'nav-tab-active' : ''; ?>" style="font-weight:600;">
				📸 <?php esc_html_e( 'Show Photo Galleries (for /gallery/)', 'onstage' ); ?>
			</a>
			<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=gallery&page=onstage-reorder-costumes&tab=costume' ) ); ?>" class="nav-tab <?php echo 'costume' === $tab ? 'nav-tab-active' : ''; ?>" style="font-weight:600;">
				👗 <?php esc_html_e( 'Costume Rental Collections (for /costume-rentals/)', 'onstage' ); ?>
			</a>
		</h2>

		<p class="description" style="font-size:14px; color:#475569; margin-bottom:20px;">
			<?php if ( 'costume' === $tab ) : ?>
				<?php esc_html_e( 'Drag and drop costume collections to change the display order on the /costume-rentals/ page. Changes are saved automatically.', 'onstage' ); ?>
			<?php else : ?>
				<?php esc_html_e( 'Drag and drop show photo albums to change the display order on the /gallery/ page. Changes are saved automatically.', 'onstage' ); ?>
			<?php endif; ?>
		</p>

		<div id="onstage_gallery_reorder_status" style="display:none; padding:12px 16px; border-radius:6px; margin-bottom:15px; font-weight:600;"></div>

		<?php if ( empty( $galleries ) ) : ?>
			<div style="background:#fff; border:1px solid #cbd5e1; border-radius:8px; padding:30px; text-align:center; color:#64748b;">
				<p style="margin:0 0 10px 0; font-size:15px;">
					<?php printf( esc_html__( 'No %s found yet.', 'onstage' ), 'costume' === $tab ? esc_html__( 'costume collections', 'onstage' ) : esc_html__( 'photo galleries', 'onstage' ) ); ?>
				</p>
				<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=gallery' ) ); ?>" class="button button-primary">
					<?php esc_html_e( '+ Add New Album', 'onstage' ); ?>
				</a>
			</div>
		<?php else : ?>
			<div id="onstage_gallery_sortable_list" style="display:flex; flex-direction:column; gap:10px;">
				<?php foreach ( $galleries as $index => $g ) :
					$cover = onstage_get_gallery_cover_url( $g->ID );
					$type  = get_post_meta( $g->ID, 'onstage_gallery_type', true );
					$type_label = ( 'costume' === $type ) ? __( 'Costume Collection', 'onstage' ) : __( 'Photo Gallery', 'onstage' );
					$type_bg    = ( 'costume' === $type ) ? '#fce7f3' : '#e0f2fe';
					$type_color = ( 'costume' === $type ) ? '#be185d' : '#0369a1';
					?>
					<div class="onstage-gallery-sort-item" data-id="<?php echo esc_attr( $g->ID ); ?>" style="background:#fff; border:1px solid #cbd5e1; border-radius:8px; padding:12px 18px; display:flex; align-items:center; gap:16px; box-shadow:0 2px 4px rgba(0,0,0,0.04); cursor:grab; user-select:none;">
						<span class="dashicons dashicons-menu" style="color:#94a3b8; font-size:20px; cursor:grab;"></span>
						<span class="onstage-gallery-badge" style="background:#6A3FC7; color:#fff; font-weight:700; font-size:12px; padding:3px 8px; border-radius:12px; min-width:32px; text-align:center;">
							#<?php echo esc_html( $index + 1 ); ?>
						</span>
						<img src="<?php echo esc_url( $cover ); ?>" alt="" style="width:55px; height:55px; border-radius:6px; object-fit:cover; border:2px solid #e2e8f0; flex-shrink:0;" />
						<div style="flex:1;">
							<strong style="font-size:15px; color:#0f172a; display:block;"><?php echo esc_html( $g->post_title ); ?></strong>
							<span style="display:inline-block; margin-top:3px; background:<?php echo esc_attr( $type_bg ); ?>; color:<?php echo esc_attr( $type_color ); ?>; font-size:11px; font-weight:600; padding:2px 7px; border-radius:4px;">
								<?php echo esc_html( $type_label ); ?>
							</span>
						</div>
						<a href="<?php echo esc_url( get_edit_post_link( $g->ID ) ); ?>" class="button button-small" style="text-decoration:none;"><?php esc_html_e( 'Edit Photos', 'onstage' ); ?></a>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

	<script>
	jQuery(document).ready(function($) {
		$('#onstage_gallery_sortable_list').sortable({
			cursor: 'grabbing',
			opacity: 0.8,
			update: function(event, ui) {
				var order = [];
				$('#onstage_gallery_sortable_list .onstage-gallery-sort-item').each(function(index) {
					order.push($(this).data('id'));
					$(this).find('.onstage-gallery-badge').text('#' + (index + 1));
				});

				$('#onstage_gallery_reorder_status').css({
					background: '#fef3c7',
					color: '#92400e',
					display: 'block'
				}).text('<?php echo esc_js( __( 'Saving new order...', 'onstage' ) ); ?>');

				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action: 'onstage_save_gallery_order',
						order: order,
						nonce: '<?php echo esc_js( wp_create_nonce( 'onstage_gallery_reorder_nonce' ) ); ?>'
					},
					success: function(response) {
						if (response.success) {
							$('#onstage_gallery_reorder_status').css({
								background: '#dcfce7',
								color: '#15803d'
							}).text('<?php echo esc_js( __( '✓ Gallery order saved successfully!', 'onstage' ) ); ?>');
							setTimeout(function() {
								$('#onstage_gallery_reorder_status').fadeOut();
							}, 2500);
						} else {
							$('#onstage_gallery_reorder_status').css({
								background: '#fee2e2',
								color: '#b91c1c'
							}).text('<?php echo esc_js( __( 'Error saving gallery order.', 'onstage' ) ); ?>');
						}
					},
					error: function() {
						$('#onstage_gallery_reorder_status').css({
							background: '#fee2e2',
							color: '#b91c1c'
						}).text('<?php echo esc_js( __( 'Connection error while saving gallery order.', 'onstage' ) ); ?>');
					}
				});
			}
		});
	});
	</script>
	<?php
}

/**
 * AJAX Handler for saving reordered galleries.
 */
function onstage_ajax_save_gallery_order() {
	check_ajax_referer( 'onstage_gallery_reorder_nonce', 'nonce' );

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
add_action( 'wp_ajax_onstage_save_gallery_order', 'onstage_ajax_save_gallery_order' );

/**
 * Helper to extract YouTube video ID from URL or raw ID.
 *
 * @param string $input URL or video ID.
 * @return string Clean 11-char ID or empty.
 */
function onstage_extract_youtube_id( $input ) {
	$input = trim( $input );
	if ( empty( $input ) ) {
		return '';
	}

	// Match watch?v= or youtu.be/ or embed/
	if ( preg_match( '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $input, $matches ) ) {
		return $matches[1];
	}

	// Direct 11-char ID
	if ( preg_match( '/^[a-zA-Z0-9_-]{11}$/', $input ) ) {
		return $input;
	}

	return $input;
}

/**
 * Meta Box on the Photo Gallery Page to easily manage the 4 Featured YouTube videos without shortcodes!
 */
function onstage_gallery_page_videos_meta_box() {
	$screen = get_current_screen();
	if ( ! $screen || 'page' !== $screen->post_type ) {
		return;
	}

	global $post;
	if ( ! $post || ( 'gallery' !== $post->post_name && false === strpos( strtolower( $post->post_title ), 'gallery' ) ) ) {
		return;
	}

	add_meta_box(
		'onstage_gallery_videos_box',
		__( '🎥 Featured YouTube Videos (Shown at Bottom of Gallery Page)', 'onstage' ),
		'onstage_gallery_videos_meta_box_html',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'onstage_gallery_page_videos_meta_box' );

/**
 * Meta Box markup for Featured YouTube Videos.
 *
 * @param WP_Post $post Current post.
 */
function onstage_gallery_videos_meta_box_html( $post ) {
	wp_nonce_field( 'onstage_gallery_videos_meta', 'onstage_gallery_videos_nonce' );

	$defaults = array(
		'v1'      => 'Zc7XV9ESEEc',
		'v2'      => 'o6OmG95CnyM',
		'v3'      => 'IQyLCBmc0nY',
		'v4'      => 'yRWus1LGt6o',
		'channel' => 'https://www.youtube.com/channel/UCYURAEfRUgjAipibRgcIiOg',
	);

	$v1      = get_post_meta( $post->ID, 'onstage_youtube_v1', true ) ?: $defaults['v1'];
	$v2      = get_post_meta( $post->ID, 'onstage_youtube_v2', true ) ?: $defaults['v2'];
	$v3      = get_post_meta( $post->ID, 'onstage_youtube_v3', true ) ?: $defaults['v3'];
	$v4      = get_post_meta( $post->ID, 'onstage_youtube_v4', true ) ?: $defaults['v4'];
	$channel = get_post_meta( $post->ID, 'onstage_youtube_channel', true ) ?: $defaults['channel'];
	?>
	<div style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif; padding:10px 0;">
		<p class="description" style="margin-bottom:15px; font-size:14px; color:#334155;">
			<?php esc_html_e( 'Paste YouTube video links or IDs below to update the featured videos on this page. No shortcodes or code required!', 'onstage' ); ?>
		</p>

		<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap:15px; margin-bottom:15px;">
			<div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:6px; padding:12px;">
				<label for="onstage_youtube_v1" style="display:block; font-weight:700; font-size:13px; margin-bottom:4px; color:#0f172a;">
					🎬 <?php esc_html_e( 'Featured Video 1:', 'onstage' ); ?>
				</label>
				<input type="text" id="onstage_youtube_v1" name="onstage_youtube_v1" value="<?php echo esc_attr( $v1 ); ?>" class="widefat" placeholder="https://youtube.com/watch?v=..." />
			</div>

			<div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:6px; padding:12px;">
				<label for="onstage_youtube_v2" style="display:block; font-weight:700; font-size:13px; margin-bottom:4px; color:#0f172a;">
					🎬 <?php esc_html_e( 'Featured Video 2:', 'onstage' ); ?>
				</label>
				<input type="text" id="onstage_youtube_v2" name="onstage_youtube_v2" value="<?php echo esc_attr( $v2 ); ?>" class="widefat" placeholder="https://youtube.com/watch?v=..." />
			</div>

			<div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:6px; padding:12px;">
				<label for="onstage_youtube_v3" style="display:block; font-weight:700; font-size:13px; margin-bottom:4px; color:#0f172a;">
					🎬 <?php esc_html_e( 'Featured Video 3:', 'onstage' ); ?>
				</label>
				<input type="text" id="onstage_youtube_v3" name="onstage_youtube_v3" value="<?php echo esc_attr( $v3 ); ?>" class="widefat" placeholder="https://youtube.com/watch?v=..." />
			</div>

			<div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:6px; padding:12px;">
				<label for="onstage_youtube_v4" style="display:block; font-weight:700; font-size:13px; margin-bottom:4px; color:#0f172a;">
					🎬 <?php esc_html_e( 'Featured Video 4:', 'onstage' ); ?>
				</label>
				<input type="text" id="onstage_youtube_v4" name="onstage_youtube_v4" value="<?php echo esc_attr( $v4 ); ?>" class="widefat" placeholder="https://youtube.com/watch?v=..." />
			</div>
		</div>

		<div style="background:#fff; border:1px solid #cbd5e1; border-radius:6px; padding:12px;">
			<label for="onstage_youtube_channel" style="display:block; font-weight:700; font-size:13px; margin-bottom:4px; color:#0f172a;">
				🔗 <?php esc_html_e( 'YouTube Channel Link ("VIEW MORE ON YOUTUBE" button):', 'onstage' ); ?>
			</label>
			<input type="url" id="onstage_youtube_channel" name="onstage_youtube_channel" value="<?php echo esc_attr( $channel ); ?>" class="widefat" placeholder="https://www.youtube.com/channel/..." />
		</div>
	</div>
	<?php
}

/**
 * Save Featured YouTube Videos on Gallery page.
 *
 * @param int $post_id Post ID.
 */
function onstage_save_gallery_page_videos( $post_id ) {
	if ( ! isset( $_POST['onstage_gallery_videos_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['onstage_gallery_videos_nonce'] ) ), 'onstage_gallery_videos_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	foreach ( array( 'v1', 'v2', 'v3', 'v4' ) as $key ) {
		$field = 'onstage_youtube_' . $key;
		if ( isset( $_POST[ $field ] ) ) {
			$raw = sanitize_text_field( wp_unslash( $_POST[ $field ] ) );
			$id  = onstage_extract_youtube_id( $raw );
			update_post_meta( $post_id, $field, $id );
		}
	}

	if ( isset( $_POST['onstage_youtube_channel'] ) ) {
		update_post_meta( $post_id, 'onstage_youtube_channel', esc_url_raw( wp_unslash( $_POST['onstage_youtube_channel'] ) ) );
	}
}
add_action( 'save_post_page', 'onstage_save_gallery_page_videos' );

/**
 * Dynamic shortcode for Featured Videos section on Gallery page: [onstage_featured_videos]
 *
 * @return string HTML output.
 */
function onstage_featured_videos_shortcode() {
	$page_id = get_the_ID();
	$v1 = get_post_meta( $page_id, 'onstage_youtube_v1', true ) ?: 'Zc7XV9ESEEc';
	$v2 = get_post_meta( $page_id, 'onstage_youtube_v2', true ) ?: 'o6OmG95CnyM';
	$v3 = get_post_meta( $page_id, 'onstage_youtube_v3', true ) ?: 'IQyLCBmc0nY';
	$v4 = get_post_meta( $page_id, 'onstage_youtube_v4', true ) ?: 'yRWus1LGt6o';
	$channel = get_post_meta( $page_id, 'onstage_youtube_channel', true ) ?: 'https://www.youtube.com/channel/UCYURAEfRUgjAipibRgcIiOg';

	$videos = array( $v1, $v2, $v3, $v4 );
	$chunks = array_chunk( $videos, 2 );

	$html = '';
	foreach ( $chunks as $row ) {
		$html .= '<div class="wp-block-columns youtube-grid">' . "\n";
		foreach ( $row as $vid_id ) {
			$html .= '  <div class="wp-block-column">' . "\n";
			$html .= '    <div class="wp-block-group youtube-card">' . "\n";
			$html .= '      ' . onstage_youtube_shortcode( array( 'id' => $vid_id, 'title' => 'On Stage featured video' ) ) . "\n";
			$html .= '    </div>' . "\n";
			$html .= '  </div>' . "\n";
		}
		$html .= '</div>' . "\n";
	}

	$html .= '<p class="program-child-actions youtube-channel-cta has-text-align-center"><a class="btn btn-pink rounded-pill" href="' . esc_url( $channel ) . '" target="_blank" rel="noreferrer noopener">' . esc_html__( 'VIEW MORE ON YOUTUBE', 'onstage' ) . '</a></p>' . "\n";

	return $html;
}
add_shortcode( 'onstage_featured_videos', 'onstage_featured_videos_shortcode' );

/**
 * Filter Gallery Page content on the front end to automatically inject updated
 * YouTube video selections if the page was previously created with static shortcodes.
 *
 * @param string $content Page post content.
 * @return string Filtered content.
 */
function onstage_filter_gallery_page_content( $content ) {
	if ( ! is_page( array( 'gallery', 'photo-gallery' ) ) ) {
		return $content;
	}

	$page_id = get_the_ID();
	$v1      = get_post_meta( $page_id, 'onstage_youtube_v1', true );
	$v2      = get_post_meta( $page_id, 'onstage_youtube_v2', true );
	$v3      = get_post_meta( $page_id, 'onstage_youtube_v3', true );
	$v4      = get_post_meta( $page_id, 'onstage_youtube_v4', true );
	$channel = get_post_meta( $page_id, 'onstage_youtube_channel', true );

	if ( $v1 || $v2 || $v3 || $v4 || $channel ) {
		if ( $v1 ) {
			$content = preg_replace( '/\[onstage_youtube\s+id=["\']Zc7XV9ESEEc["\']/', '[onstage_youtube id="' . esc_attr( $v1 ) . '"', $content );
		}
		if ( $v2 ) {
			$content = preg_replace( '/\[onstage_youtube\s+id=["\']o6OmG95CnyM["\']/', '[onstage_youtube id="' . esc_attr( $v2 ) . '"', $content );
		}
		if ( $v3 ) {
			$content = preg_replace( '/\[onstage_youtube\s+id=["\']IQyLCBmc0nY["\']/', '[onstage_youtube id="' . esc_attr( $v3 ) . '"', $content );
		}
		if ( $v4 ) {
			$content = preg_replace( '/\[onstage_youtube\s+id=["\']yRWus1LGt6o["\']/', '[onstage_youtube id="' . esc_attr( $v4 ) . '"', $content );
		}
		if ( $channel ) {
			$content = str_replace( 'https://www.youtube.com/channel/UCYURAEfRUgjAipibRgcIiOg', esc_url( $channel ), $content );
		}
	}

	return $content;
}
add_filter( 'the_content', 'onstage_filter_gallery_page_content', 5 );




