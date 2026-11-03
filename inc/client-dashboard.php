<?php
/**
 * Client Dashboard & Administrative Help System.
 *
 * Provides a clean, client-friendly WP Admin dashboard for site management (Linda),
 * embeds helpful field instructions on CPT edit screens, and preserves full
 * technical WP Admin access for Super Admins (devgirl).
 *
 * @package Onstage
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if the current user is a Super Admin / Technical Admin.
 *
 * Super Admins see the standard unrestricted WP Admin backend.
 * Regular Admins & Studio Admins see the simplified client dashboard.
 *
 * @return bool True if super admin, false otherwise.
 */
function onstage_is_super_admin() {
	if ( ! is_user_logged_in() ) {
		return false;
	}

	$user = wp_get_current_user();
	if ( ! $user ) {
		return false;
	}

	// Technical superadmin accounts or network superadmins
	if ( 'devgirl' === $user->user_login || is_super_admin( $user->ID ) || current_user_can( 'manage_network' ) ) {
		return true;
	}

	// Explicit override option if set
	if ( get_user_meta( $user->ID, 'onstage_is_super_admin', true ) === '1' ) {
		return true;
	}

	return false;
}

/**
 * Register Studio Admin role for Linda and clean up deprecated instructor role.
 */
function onstage_register_studio_admin_role() {
	// Remove deprecated instructor role if it exists
	if ( get_role( 'onstage_instructor' ) ) {
		remove_role( 'onstage_instructor' );
	}

	if ( ! get_role( 'studio_admin' ) ) {
		$admin = get_role( 'administrator' );
		$caps  = $admin ? $admin->capabilities : array();
		add_role( 'studio_admin', __( 'Studio Admin', 'onstage' ), $caps );
	}
}
add_action( 'init', 'onstage_register_studio_admin_role' );

/**
 * Add Inline Instructional Help Banners on Class, Show, Gallery, and Staff edit screens.
 */
function onstage_admin_cpt_help_banners() {
	$screen = get_current_screen();
	if ( ! $screen ) {
		return;
	}

	if ( 'studio_class' === $screen->post_type && 'post' === $screen->base ) {
		?>
		<div class="notice notice-info" style="border-left-color: #E95BAF; background:#fff; padding:15px; margin-top:15px; border-radius:6px; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
			<h3 style="margin:0 0 8px 0; color:#E95BAF; display:flex; align-items:center; gap:8px;">
				<span>🩰</span> <?php esc_html_e( 'How to Add or Edit a Studio Class', 'onstage' ); ?>
			</h3>
			<p style="margin:0 0 10px 0; font-size:14px; color:#334155;">
				<?php esc_html_e( 'All class details are right in the main box below the title. Classes automatically sort into chronological time order from morning to evening:', 'onstage' ); ?>
			</p>
			<ul style="list-style:disc; margin:0 0 10px 20px; font-size:13px; color:#475569;">
				<li><strong><?php esc_html_e( 'Class Name (Title above):', 'onstage' ); ?></strong> <?php esc_html_e( 'Enter the class title (e.g., "Advanced Ballet & Pointe" or "KinderDance Combo").', 'onstage' ); ?></li>
				<li><strong><?php esc_html_e( 'Day of the Week:', 'onstage' ); ?></strong> <?php esc_html_e( 'Select Monday, Tuesday, Wednesday, Thursday, or Saturday.', 'onstage' ); ?></li>
				<li><strong><?php esc_html_e( 'Class Time:', 'onstage' ); ?></strong> <?php esc_html_e( 'Enter the time range (e.g. 3:30–4:30 p.m. or 9:00–10:00 a.m.). Classes are sorted chronologically automatically.', 'onstage' ); ?></li>
				<li><strong><?php esc_html_e( 'Age Group & Instructor:', 'onstage' ); ?></strong> <?php esc_html_e( 'Enter the student age group (e.g., Ages 4–6) and instructor name(s).', 'onstage' ); ?></li>
				<li><strong><?php esc_html_e( 'Category & Color:', 'onstage' ); ?></strong> <?php esc_html_e( 'Pick the category color style for the website schedule card.', 'onstage' ); ?></li>
				<li><strong><?php esc_html_e( 'Highlight as NEW Class?:', 'onstage' ); ?></strong> <?php esc_html_e( 'Check this box to display a bright "NEW" badge on the schedule card.', 'onstage' ); ?></li>
			</ul>
		</div>
		<?php
	} elseif ( 'show' === $screen->post_type && 'post' === $screen->base ) {
		?>
		<div class="notice notice-info" style="border-left-color: #81D4FA; background:#fff; padding:15px; margin-top:15px; border-radius:6px; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
			<h3 style="margin:0 0 8px 0; color:#0284c7; display:flex; align-items:center; gap:8px;">
				<span>🎭</span> <?php esc_html_e( 'How to Add or Edit a Show / Production', 'onstage' ); ?>
			</h3>
			<p style="margin:0 0 10px 0; font-size:14px; color:#334155;">
				<?php esc_html_e( 'All production details, dates, and the show poster are in ONE unified panel below the title:', 'onstage' ); ?>
			</p>
			<ul style="list-style:disc; margin:0 0 10px 20px; font-size:13px; color:#475569;">
				<li><strong><?php esc_html_e( 'Show Title (Title above):', 'onstage' ); ?></strong> <?php esc_html_e( 'Enter the production name (e.g., 30th Anniversary Christmas Spectacular).', 'onstage' ); ?></li>
				<li><strong><?php esc_html_e( 'Show Poster Artwork:', 'onstage' ); ?></strong> <?php esc_html_e( 'Click "Choose / Upload Poster" right in the box below to select or upload the artwork.', 'onstage' ); ?></li>
				<li><strong><?php esc_html_e( 'Opening Date:', 'onstage' ); ?></strong> <?php esc_html_e( 'Select the date of the first performance so shows automatically display in chronological order (soonest first).', 'onstage' ); ?></li>
				<li><strong><?php esc_html_e( 'Performance Dates & Showtimes:', 'onstage' ); ?></strong> <?php esc_html_e( 'Enter the exact text shown on the website (e.g. December 5, 2026 - 6:00 PM).', 'onstage' ); ?></li>
				<li><strong><?php esc_html_e( 'Venue Location & Ticket URL:', 'onstage' ); ?></strong> <?php esc_html_e( 'Enter theater location and external ticket link (or leave blank to use default link).', 'onstage' ); ?></li>
			</ul>
		</div>
		<?php
	} elseif ( 'staff_member' === $screen->post_type && 'post' === $screen->base ) {
		?>
		<div class="notice notice-info" style="border-left-color: #E95BAF; background:#fff; padding:15px; margin-top:15px; border-radius:6px; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
			<h3 style="margin:0 0 8px 0; color:#E95BAF; display:flex; align-items:center; gap:8px;">
				<span>👥</span> <?php esc_html_e( 'Staff & Teacher Profiles', 'onstage' ); ?>
			</h3>
			<p style="margin:0 0 10px 0; font-size:14px; color:#334155;">
				<?php esc_html_e( 'Manage instructors and leadership for the About page in one place:', 'onstage' ); ?>
			</p>
			<ul style="list-style:disc; margin:0 0 10px 20px; font-size:13px; color:#475569;">
				<li><strong><?php esc_html_e( 'Staff Member Name (Title above):', 'onstage' ); ?></strong> <?php esc_html_e( 'Enter the person’s full name (e.g., Linda Mercer-Botelho).', 'onstage' ); ?></li>
				<li><strong><?php esc_html_e( 'Profile Photo:', 'onstage' ); ?></strong> <?php esc_html_e( 'Click "Choose / Upload Photo" to select a portrait photo.', 'onstage' ); ?></li>
				<li><strong><?php esc_html_e( 'Biographical Info:', 'onstage' ); ?></strong> <?php esc_html_e( 'Type their background and teaching bio. Separate paragraphs with a blank line.', 'onstage' ); ?></li>
				<li><strong><?php esc_html_e( 'Reordering:', 'onstage' ); ?></strong> <?php esc_html_e( 'Go to Staff → Reorder Staff to drag and drop people into any order!', 'onstage' ); ?></li>
			</ul>
		</div>
		<?php
	} elseif ( 'gallery' === $screen->post_type && 'post' === $screen->base ) {
		?>
		<div class="notice notice-info" style="border-left-color: #6A3FC7; background:#fff; padding:15px; margin-top:15px; border-radius:6px; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
			<h3 style="margin:0 0 8px 0; color:#6A3FC7; display:flex; align-items:center; gap:8px;">
				<span>🖼️</span> <?php esc_html_e( 'How to Add or Edit a Photo or Costume Gallery', 'onstage' ); ?>
			</h3>
			<p style="margin:0 0 10px 0; font-size:14px; color:#334155;">
				<?php esc_html_e( 'Create or update gallery cards for the website:', 'onstage' ); ?>
			</p>
			<ul style="list-style:disc; margin:0 0 10px 20px; font-size:13px; color:#475569;">
				<li><strong><?php esc_html_e( 'Gallery Title (Title above):', 'onstage' ); ?></strong> <?php esc_html_e( 'Enter the show or costume name (e.g., Peter Pan Gallery).', 'onstage' ); ?></li>
				<li><strong><?php esc_html_e( 'Cover Image:', 'onstage' ); ?></strong> <?php esc_html_e( 'Click "Choose / Upload Cover Image" right in the panel below to set the album card photo.', 'onstage' ); ?></li>
				<li><strong><?php esc_html_e( 'Gallery Category:', 'onstage' ); ?></strong> <?php esc_html_e( 'Choose "Show Photo Gallery" or "Costume Rental Gallery" in Gallery Details.', 'onstage' ); ?></li>
				<li><strong><?php esc_html_e( 'Adding Photos:', 'onstage' ); ?></strong> <?php esc_html_e( 'Click "Add Photos from Media Library" below to upload and drag-and-drop photos.', 'onstage' ); ?></li>
			</ul>
		</div>
		<?php
	} elseif ( 'page' === $screen->post_type && 'post' === $screen->base ) {
		global $post;
		if ( $post && in_array( $post->post_name, array( 'gallery', 'photo-gallery' ), true ) ) {
			?>
			<div class="notice notice-info" style="border-left-color: #6A3FC7; background:#fff; padding:15px; margin-top:15px; border-radius:6px; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
				<h3 style="margin:0 0 8px 0; color:#6A3FC7; display:flex; align-items:center; gap:8px;">
					<span>📸</span> <?php esc_html_e( 'Managing the Photo & Video Gallery Page', 'onstage' ); ?>
				</h3>
				<p style="margin:0 0 10px 0; font-size:14px; color:#334155;">
					<?php esc_html_e( 'Good news! You do not need to touch shortcodes or page blocks to update the gallery:', 'onstage' ); ?>
				</p>
				<ul style="list-style:disc; margin:0 0 10px 20px; font-size:13px; color:#475569; line-height:1.6;">
					<li><strong><?php esc_html_e( 'Show Photo Albums:', 'onstage' ); ?></strong> <?php printf( wp_kses_post( __( 'Go to <a href="%s" style="color:#6A3FC7; font-weight:600;">Galleries</a> in the left menu to add new shows or change photos. Any album you create there automatically appears on this page!', 'onstage' ) ), esc_url( admin_url( 'edit.php?post_type=gallery' ) ) ); ?></li>
					<li><strong><?php esc_html_e( 'Reorder Album Cards:', 'onstage' ); ?></strong> <?php printf( wp_kses_post( __( 'Go to <a href="%s" style="color:#6A3FC7; font-weight:600;">Galleries → Reorder Albums</a> to drag and drop show albums into any order.', 'onstage' ) ), esc_url( admin_url( 'edit.php?post_type=gallery&page=onstage-reorder-galleries' ) ) ); ?></li>
					<li><strong><?php esc_html_e( 'Featured YouTube Videos:', 'onstage' ); ?></strong> <?php esc_html_e( 'Scroll down to the "🎬 Featured YouTube Videos & Channel Link" box below this editor to change any of the 4 YouTube links or channel button.', 'onstage' ); ?></li>
				</ul>
			</div>
			<?php
		}
	}
}
add_action( 'edit_form_after_title', 'onstage_admin_cpt_help_banners' );

/**
 * Custom Client Dashboard for non-Super Admins.
 */
function onstage_render_client_dashboard() {
	if ( onstage_is_super_admin() ) {
		return;
	}

	$user = wp_get_current_user();
	?>
	<div class="wrap onstage-client-dashboard" style="max-width:1100px; margin:20px auto 40px auto; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">
		<div style="background:linear-gradient(135deg, #E95BAF 0%, #6A3FC7 100%); padding:30px; border-radius:12px; color:#fff; box-shadow:0 10px 25px rgba(233,91,175,0.25); margin-bottom:30px;">
			<h1 style="margin:0 0 8px 0; color:#fff; font-size:28px; font-weight:700;">
				<?php printf( esc_html__( 'Welcome to On Stage Site Management, %s! 👋', 'onstage' ), esc_html( $user->display_name ) ); ?>
			</h1>
			<p style="margin:0; font-size:16px; opacity:0.95; max-width:700px;">
				<?php esc_html_e( 'Use the quick control cards below to manage classes, upcoming shows, photo galleries, staff biographies, and pages.', 'onstage' ); ?>
			</p>
		</div>

		<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:20px;">
			<!-- Class Management Card -->
			<div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:24px; box-shadow:0 4px 6px rgba(0,0,0,0.03); display:flex; flex-direction:column; justify-content:space-between;">
				<div>
					<div style="width:48px; height:48px; border-radius:10px; background:#fce7f3; color:#E95BAF; display:flex; align-items:center; justify-content:center; font-size:24px; margin-bottom:16px;">🩰</div>
					<h2 style="margin:0 0 8px 0; font-size:18px; color:#0f172a;"><?php esc_html_e( 'Classes & Schedule', 'onstage' ); ?></h2>
					<p style="margin:0 0 20px 0; color:#64748b; font-size:14px; line-height:1.5;">
						<?php esc_html_e( 'Add dance & theater classes. Classes automatically sort chronologically on the website schedule by time.', 'onstage' ); ?>
					</p>
				</div>
				<div style="display:flex; gap:10px; flex-wrap:wrap;">
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=studio_class' ) ); ?>" class="button button-primary" style="background:#E95BAF; border-color:#E95BAF; font-weight:600;"><?php esc_html_e( 'View All Classes', 'onstage' ); ?></a>
					<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=studio_class' ) ); ?>" class="button button-secondary"><?php esc_html_e( '+ Add New Class', 'onstage' ); ?></a>
				</div>
			</div>

			<!-- Shows & Tickets Card -->
			<div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:24px; box-shadow:0 4px 6px rgba(0,0,0,0.03); display:flex; flex-direction:column; justify-content:space-between;">
				<div>
					<div style="width:48px; height:48px; border-radius:10px; background:#e0f2fe; color:#0284c7; display:flex; align-items:center; justify-content:center; font-size:24px; margin-bottom:16px;">🎭</div>
					<h2 style="margin:0 0 8px 0; font-size:18px; color:#0f172a;"><?php esc_html_e( 'Shows & Tickets', 'onstage' ); ?></h2>
					<p style="margin:0 0 20px 0; color:#64748b; font-size:14px; line-height:1.5;">
						<?php esc_html_e( 'Create upcoming productions, edit showtimes, and upload posters. Shows display chronologically (soonest first).', 'onstage' ); ?>
					</p>
				</div>
				<div style="display:flex; gap:10px; flex-wrap:wrap;">
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=show' ) ); ?>" class="button button-primary" style="background:#0284c7; border-color:#0284c7; font-weight:600;"><?php esc_html_e( 'View All Shows', 'onstage' ); ?></a>
					<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=show' ) ); ?>" class="button button-secondary"><?php esc_html_e( '+ Add New Show', 'onstage' ); ?></a>
				</div>
			</div>

			<!-- Staff & Teachers Card -->
			<div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:24px; box-shadow:0 4px 6px rgba(0,0,0,0.03); display:flex; flex-direction:column; justify-content:space-between;">
				<div>
					<div style="width:48px; height:48px; border-radius:10px; background:#fef3c7; color:#d97706; display:flex; align-items:center; justify-content:center; font-size:24px; margin-bottom:16px;">👥</div>
					<h2 style="margin:0 0 8px 0; font-size:18px; color:#0f172a;"><?php esc_html_e( 'Staff & Instructors', 'onstage' ); ?></h2>
					<p style="margin:0 0 20px 0; color:#64748b; font-size:14px; line-height:1.5;">
						<?php esc_html_e( 'Update teacher bios and profile photos for the About page. Easily drag and drop to rearrange their order.', 'onstage' ); ?>
					</p>
				</div>
				<div style="display:flex; gap:10px; flex-wrap:wrap;">
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=staff_member' ) ); ?>" class="button button-primary" style="background:#d97706; border-color:#d97706; font-weight:600;"><?php esc_html_e( 'View All Staff', 'onstage' ); ?></a>
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=staff_member&page=onstage-reorder-staff' ) ); ?>" class="button button-secondary"><?php esc_html_e( '↕ Reorder Staff', 'onstage' ); ?></a>
					<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=staff_member' ) ); ?>" class="button button-secondary"><?php esc_html_e( '+ Add Staff', 'onstage' ); ?></a>
				</div>
			</div>

			<!-- Galleries Card -->
			<div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:24px; box-shadow:0 4px 6px rgba(0,0,0,0.03); display:flex; flex-direction:column; justify-content:space-between;">
				<div>
					<div style="width:48px; height:48px; border-radius:10px; background:#f3e8ff; color:#6A3FC7; display:flex; align-items:center; justify-content:center; font-size:24px; margin-bottom:16px;">🖼️</div>
					<h2 style="margin:0 0 8px 0; font-size:18px; color:#0f172a;"><?php esc_html_e( 'Photo & Costume Galleries', 'onstage' ); ?></h2>
					<p style="margin:0 0 20px 0; color:#64748b; font-size:14px; line-height:1.5;">
						<?php esc_html_e( 'Add new photo galleries or costume rental collections, upload photos, and reorder album cards.', 'onstage' ); ?>
					</p>
				</div>
				<div style="display:flex; gap:10px; flex-wrap:wrap;">
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=gallery' ) ); ?>" class="button button-primary" style="background:#6A3FC7; border-color:#6A3FC7; font-weight:600;"><?php esc_html_e( 'View All Albums', 'onstage' ); ?></a>
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=gallery&page=onstage-reorder-galleries' ) ); ?>" class="button button-secondary"><?php esc_html_e( '↕ Reorder Albums', 'onstage' ); ?></a>
					<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=gallery' ) ); ?>" class="button button-secondary"><?php esc_html_e( '+ Add New Album', 'onstage' ); ?></a>
				</div>
			</div>

			<!-- Page Content Card -->
			<div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:24px; box-shadow:0 4px 6px rgba(0,0,0,0.03); display:flex; flex-direction:column; justify-content:space-between;">
				<div>
					<div style="width:48px; height:48px; border-radius:10px; background:#dcfce7; color:#16a34a; display:flex; align-items:center; justify-content:center; font-size:24px; margin-bottom:16px;">📄</div>
					<h2 style="margin:0 0 8px 0; font-size:18px; color:#0f172a;"><?php esc_html_e( 'Website Pages', 'onstage' ); ?></h2>
					<p style="margin:0 0 20px 0; color:#64748b; font-size:14px; line-height:1.5;">
						<?php esc_html_e( 'Edit main website pages like Home, About, Programs, Scholarships, or Costume Rentals.', 'onstage' ); ?>
					</p>
				</div>
				<div>
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=page' ) ); ?>" class="button button-primary" style="background:#16a34a; border-color:#16a34a; font-weight:600;"><?php esc_html_e( 'Edit Pages', 'onstage' ); ?></a>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Replace standard WP Admin Dashboard widgets for Client Admins.
 */
function onstage_setup_client_dashboard_widgets() {
	if ( onstage_is_super_admin() ) {
		return;
	}

	remove_action( 'welcome_panel', 'wp_welcome_panel' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );

	add_action( 'admin_notices', 'onstage_render_client_dashboard' );
}
add_action( 'wp_dashboard_setup', 'onstage_setup_client_dashboard_widgets' );

/**
 * Simplify WP Admin Sidebar Navigation Menu for Client Admins (Linda / Studio Admins).
 */
function onstage_clean_admin_menu_for_clients() {
	if ( onstage_is_super_admin() ) {
		return;
	}

	remove_menu_page( 'plugins.php' );
	remove_menu_page( 'tools.php' );
	remove_menu_page( 'options-general.php' );
	remove_submenu_page( 'index.php', 'update-core.php' );
	remove_submenu_page( 'themes.php', 'theme-editor.php' );
	remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
}
add_action( 'admin_menu', 'onstage_clean_admin_menu_for_clients', 999 );

/**
 * Lock down Block Editor layout editing for non-Admin editors.
 *
 * @param array                   $settings Editor settings.
 * @param WP_Block_Editor_Context $context  Editor context.
 * @return array Modified settings.
 */
function onstage_lock_editor_layout_for_editors( $settings, $context ) {
	if ( ! current_user_can( 'administrator' ) && ! current_user_can( 'studio_admin' ) ) {
		$settings['codeEditingEnabled'] = false;
		$settings['canLockBlocks']      = false;
	}

	return $settings;
}
add_filter( 'block_editor_settings_all', 'onstage_lock_editor_layout_for_editors', 10, 2 );
