<?php
/**
 * On Stage Theatrical Productions — block theme functions.
 *
 * Native Full Site Editing only. No Elementor or page-builder plugins.
 *
 * @package Onstage
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ONSTAGE_VERSION', '1.0.18' );
define( 'ONSTAGE_CONTENT_VERSION', '1.0.18' );
define( 'ONSTAGE_TICKETS_URL', 'https://30865.smallvenueticketing.com/nocookie/start-session.cfm?goto=%2F' );
define( 'ONSTAGE_STUDIO_URL', 'https://portal.akadadance.com/auth?schoolId=225' );
define( 'ONSTAGE_SCHOLARSHIP_FORM', 'https://forms.gle/xSwt6845z1gy8TQE8' );
define( 'ONSTAGE_PHONE', '(508) 673-4880' );
define( 'ONSTAGE_PHONE_TEL', '15086734880' );
define( 'ONSTAGE_EMAIL', 'LindaOnStage@AOL.com' );

require get_template_directory() . '/inc/cpt-show.php';
require get_template_directory() . '/inc/cpt-class.php';
require get_template_directory() . '/inc/inner-pages.php';
require get_template_directory() . '/inc/setup.php';

/**
 * Theme supports and editor styles.
 */
function onstage_setup() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style.css' );
	add_editor_style( 'assets/css/layout-fixes.css' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-logo', array(
		'height'      => 250,
		'width'       => 250,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Navigation', 'onstage' ),
		)
	);

	load_theme_textdomain( 'onstage', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'onstage_setup' );

/**
 * Front-end assets: Google Fonts, Font Awesome (icons from the mockup), theme CSS.
 */
function onstage_enqueue_assets() {
	wp_enqueue_style(
		'onstage-fonts',
		'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap',
		array(),
		null
	);
	wp_enqueue_style(
		'onstage-fontawesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
		array(),
		'6.4.0'
	);
	wp_enqueue_style(
		'onstage-style',
		get_stylesheet_uri(),
		array( 'onstage-fonts', 'onstage-fontawesome' ),
		ONSTAGE_VERSION
	);
	wp_enqueue_style(
		'onstage-layout-fixes',
		get_theme_file_uri( 'assets/css/layout-fixes.css' ),
		array( 'onstage-style' ),
		ONSTAGE_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'onstage_enqueue_assets' );

/**
 * Load layout CSS in the block editor iframe too (core Image height:auto
 * otherwise wins and cards look uneven in Edit Page).
 */
function onstage_enqueue_block_assets() {
	wp_enqueue_style(
		'onstage-layout-fixes',
		get_theme_file_uri( 'assets/css/layout-fixes.css' ),
		array(),
		ONSTAGE_VERSION
	);
}
add_action( 'enqueue_block_assets', 'onstage_enqueue_block_assets' );

/**
 * Header logo: strip Site Logo inline width/height so CSS can use the mockup
 * 250px mark (with negative margins). If the Customizer logo is missing or
 * broken, fall back to the theme asset so the nav is never empty.
 *
 * @param string $html  Block HTML.
 * @param array  $block Block data.
 * @return string
 */
function onstage_render_header_logo( $html, $block ) {
	$class = isset( $block['attrs']['className'] ) ? (string) $block['attrs']['className'] : '';
	if ( false === strpos( $class, 'nav-site-logo' ) ) {
		return $html;
	}
	$html = preg_replace( '/\sstyle="[^"]*"/i', '', $html );
	$html = preg_replace( '/\swidth="\d+"/i', '', $html );
	$html = preg_replace( '/\sheight="\d+"/i', '', $html );
	if ( false === stripos( $html, '<img' ) ) {
		$src  = onstage_img( 'onstage_logo_transparent.png' );
		$html = '<div class="wp-block-site-logo nav-site-logo"><a href="' . esc_url( home_url( '/' ) ) . '" class="custom-logo-link" rel="home"><img class="custom-logo nav-logo" src="' . $src . '" alt="' . esc_attr__( 'On Stage Theatrical Productions', 'onstage' ) . '"/></a></div>';
	}
	return $html;
}
add_filter( 'render_block_core/site-logo', 'onstage_render_header_logo', 10, 2 );

/**
 * Keep eligibility checkboxes and YouTube iframes when pages are re-saved.
 *
 * @param array  $tags    Allowed HTML.
 * @param string $context KSES context.
 * @return array
 */
function onstage_kses_allowed_html( $tags, $context ) {
	if ( 'post' !== $context ) {
		return $tags;
	}
	$tags['form']  = array_merge(
		isset( $tags['form'] ) ? $tags['form'] : array(),
		array(
			'id'     => true,
			'class'  => true,
			'action' => true,
			'method' => true,
		)
	);
	$tags['label'] = array_merge(
		isset( $tags['label'] ) ? $tags['label'] : array(),
		array(
			'class' => true,
			'for'   => true,
		)
	);
	$tags['input'] = array_merge(
		isset( $tags['input'] ) ? $tags['input'] : array(),
		array(
			'type'    => true,
			'name'    => true,
			'value'   => true,
			'id'      => true,
			'class'   => true,
			'checked' => true,
		)
	);
	$tags['i'] = array_merge(
		isset( $tags['i'] ) ? $tags['i'] : array(),
		array(
			'class'       => true,
			'aria-hidden' => true,
		)
	);
	$tags['span'] = array_merge(
		isset( $tags['span'] ) ? $tags['span'] : array(),
		array(
			'class' => true,
		)
	);
	$tags['article'] = array_merge(
		isset( $tags['article'] ) ? $tags['article'] : array(),
		array(
			'class' => true,
		)
	);
	$tags['iframe'] = array_merge(
		isset( $tags['iframe'] ) ? $tags['iframe'] : array(),
		array(
			'src'             => true,
			'title'           => true,
			'allow'           => true,
			'allowfullscreen' => true,
			'loading'         => true,
			'width'           => true,
			'height'          => true,
			'frameborder'     => true,
			'referrerpolicy'  => true,
			'class'           => true,
		)
	);
	return $tags;
}
add_filter( 'wp_kses_allowed_html', 'onstage_kses_allowed_html', 10, 2 );

/**
 * Direct YouTube iframe (Local oEmbed often fails and prints the raw URL).
 *
 * Usage: [onstage_youtube id="Zc7XV9ESEEc" title="On Stage video"]
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
function onstage_youtube_shortcode( $atts = array() ) {
	$atts = shortcode_atts(
		array(
			'id'    => '',
			'title' => __( 'On Stage video', 'onstage' ),
		),
		$atts,
		'onstage_youtube'
	);
	$id = preg_replace( '/[^A-Za-z0-9_-]/', '', (string) $atts['id'] );
	if ( ! $id ) {
		return '';
	}
	return '<div class="youtube-wrapper"><iframe src="https://www.youtube.com/embed/' . esc_attr( $id ) . '" title="' . esc_attr( $atts['title'] ) . '" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen loading="lazy"></iframe></div>';
}
add_shortcode( 'onstage_youtube', 'onstage_youtube_shortcode' );

/**
 * If a core Embed block stored a YouTube URL but oEmbed returned no iframe,
 * inject the same player the mockup uses.
 *
 * @param string $html  Block HTML.
 * @param array  $block Block data.
 * @return string
 */
function onstage_embed_youtube_iframe( $html, $block ) {
	if ( false !== strpos( $html, '<iframe' ) ) {
		return $html;
	}
	$url = isset( $block['attrs']['url'] ) ? (string) $block['attrs']['url'] : '';
	if ( ! $url || ! preg_match( '#(?:youtube\.com/watch\?v=|youtube\.com/embed/|youtu\.be/)([A-Za-z0-9_-]+)#', $url, $match ) ) {
		return $html;
	}
	return '<figure class="wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube"><div class="wp-block-embed__wrapper">' . onstage_youtube_shortcode(
		array(
			'id'    => $match[1],
			'title' => __( 'On Stage video', 'onstage' ),
		)
	) . '</div></figure>';
}
add_filter( 'render_block_core/embed', 'onstage_embed_youtube_iframe', 10, 2 );

/**
 * Pattern category for On Stage sections.
 */
function onstage_register_pattern_categories() {
	register_block_pattern_category(
		'onstage',
		array( 'label' => __( 'On Stage', 'onstage' ) )
	);
}
add_action( 'init', 'onstage_register_pattern_categories' );

/**
 * Button block styles matching the mockup.
 */
function onstage_register_block_styles() {
	register_block_style( 'core/button', array(
		'name'  => 'onstage-pink',
		'label' => __( 'On Stage Pink', 'onstage' ),
	) );
	register_block_style( 'core/button', array(
		'name'  => 'onstage-black',
		'label' => __( 'On Stage Black', 'onstage' ),
	) );
	register_block_style( 'core/button', array(
		'name'  => 'onstage-pill',
		'label' => __( 'On Stage Pill', 'onstage' ),
	) );
	register_block_style( 'core/button', array(
		'name'  => 'onstage-blue',
		'label' => __( 'On Stage Blue', 'onstage' ),
	) );
	register_block_style( 'core/button', array(
		'name'  => 'onstage-green',
		'label' => __( 'On Stage Green', 'onstage' ),
	) );
	register_block_style( 'core/button', array(
		'name'  => 'onstage-white-purple',
		'label' => __( 'On Stage White on Purple', 'onstage' ),
	) );
}
add_action( 'init', 'onstage_register_block_styles' );

/**
 * Allow the Query Loop block to request the Show CPT.
 *
 * @param array $query WP_Query args.
 * @param WP_Block $block Block instance.
 * @return array
 */
function onstage_query_loop_show_cpt( $query, $block ) {
	$post_type = $block->context['query']['postType'] ?? '';
	if ( 'show' === $post_type ) {
		$query['post_type']   = 'show';
		$query['post_status'] = array( 'publish', 'future' );
	}
	return $query;
}
add_filter( 'query_loop_block_query_vars', 'onstage_query_loop_show_cpt', 10, 2 );

/**
 * Published and scheduled Shows always list on the front end.
 * Performance dates live in meta — a future WP publish date must not hide a show.
 *
 * @param WP_Query $query Query.
 */
function onstage_include_upcoming_shows( $query ) {
	if ( is_admin() ) {
		return;
	}

	$types = $query->get( 'post_type' );
	$types = is_array( $types ) ? $types : array( $types );
	$is_show_query = in_array( 'show', $types, true ) || $query->is_post_type_archive( 'show' );

	if ( $query->is_singular && $query->get( 'post_type' ) === 'show' ) {
		$is_show_query = true;
	}

	if ( $is_show_query ) {
		$query->set( 'post_status', array( 'publish', 'future' ) );
	}
}
add_action( 'pre_get_posts', 'onstage_include_upcoming_shows' );

/**
 * Theme image URL helper for patterns.
 *
 * @param string $file Filename inside assets/images/.
 * @return string
 */
function onstage_img( $file ) {
	return esc_url( get_theme_file_uri( 'assets/images/' . ltrim( $file, '/' ) ) );
}

/**
 * Load a pattern file's rendered block markup (for first-time page seeding).
 *
 * @param string $filename Pattern filename in /patterns.
 * @return string
 */
function onstage_load_pattern_file( $filename ) {
	$path = get_template_directory() . '/patterns/' . $filename;
	if ( ! file_exists( $path ) ) {
		return '';
	}
	ob_start();
	include $path;
	return trim( ob_get_clean() );
}

/**
 * Dynamic show dates / venue / ticket link. PHP patterns are snapshotted on
 * `init`, so post meta must be output through a shortcode (or a dynamic block).
 *
 * Usage: [onstage_show_details]
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
function onstage_show_details_shortcode( $atts = array() ) {
	if ( 'show' !== get_post_type() ) {
		return '';
	}
	$atts = shortcode_atts(
		array(
			'tickets' => is_singular( 'show' ) ? '1' : '0',
		),
		$atts,
		'onstage_show_details'
	);

	$dates  = get_post_meta( get_the_ID(), 'onstage_show_dates', true );
	$venue  = get_post_meta( get_the_ID(), 'onstage_show_venue', true );
	$ticket = get_post_meta( get_the_ID(), 'onstage_show_ticket_url', true );
	if ( ! $ticket ) {
		$ticket = ONSTAGE_TICKETS_URL;
	}

	ob_start();
	echo '<div class="onstage-show-details">';
	if ( $dates ) {
		echo '<p class="onstage-show-meta event-date">' . nl2br( esc_html( $dates ) ) . '</p>';
	} else {
		echo '<p class="onstage-show-meta event-date show-date-tba">' . esc_html__( 'TBA', 'onstage' ) . '</p>';
	}
	if ( $venue ) {
		echo '<p class="onstage-show-venue event-loc">' . esc_html( $venue ) . '</p>';
	}
	if ( '1' === (string) $atts['tickets'] && $ticket ) {
		echo '<p class="onstage-ticket-btn"><a class="btn btn-pink-large" href="' . esc_url( $ticket ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Buy Tickets', 'onstage' ) . '</a></p>';
	}
	echo '</div>';
	return ob_get_clean();
}
add_shortcode( 'onstage_show_details', 'onstage_show_details_shortcode' );

/**
 * Split Dates/times meta into one line per performance.
 *
 * @param int $post_id Show ID.
 * @return string[]
 */
function onstage_get_show_date_lines( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_the_ID();
	$dates   = get_post_meta( $post_id, 'onstage_show_dates', true );
	if ( ! is_string( $dates ) || '' === trim( $dates ) ) {
		return array();
	}
	$lines = preg_split( '/\r\n|\r|\n/', $dates );
	$lines = array_map( 'trim', $lines );
	return array_values( array_filter( $lines, 'strlen' ) );
}

/**
 * Home / listing card meta: calendar date lines plus venue.
 *
 * @param int $post_id Show ID.
 * @return string
 */
function onstage_render_show_listing_meta( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_the_ID();
	if ( ! $post_id || 'show' !== get_post_type( $post_id ) ) {
		return '';
	}

	$lines = onstage_get_show_date_lines( $post_id );
	$venue = get_post_meta( $post_id, 'onstage_show_venue', true );

	ob_start();
	echo '<div class="onstage-show-listing-meta">';
	echo '<div class="onstage-show-dates">';
	if ( $lines ) {
		foreach ( $lines as $line ) {
			echo '<p class="onstage-show-date-line">';
			echo '<span class="onstage-cal-icon" aria-hidden="true"></span>';
			echo '<span class="onstage-show-date-text">' . esc_html( $line ) . '</span>';
			echo '</p>';
		}
	} else {
		echo '<p class="onstage-show-date-line show-date-tba">';
		echo '<span class="onstage-cal-icon" aria-hidden="true"></span>';
		echo '<span class="onstage-show-date-text">' . esc_html__( 'TBA', 'onstage' ) . '</span>';
		echo '</p>';
	}
	echo '</div>';

	if ( is_string( $venue ) && '' !== trim( $venue ) ) {
		$parts = array_map( 'trim', explode( ',', $venue, 2 ) );
		echo '<div class="onstage-show-venue event-loc">';
		foreach ( $parts as $part ) {
			if ( '' !== $part ) {
				echo '<p>' . esc_html( $part ) . '</p>';
			}
		}
		echo '</div>';
	}
	echo '</div>';
	return ob_get_clean();
}

/**
 * Shortcode alias for listing cards. Usage: [onstage_show_listing_meta]
 *
 * @return string
 */
function onstage_show_listing_meta_shortcode() {
	return onstage_render_show_listing_meta();
}
add_shortcode( 'onstage_show_listing_meta', 'onstage_show_listing_meta_shortcode' );

/**
 * Dynamic block: dates + venue inside a Show Query Loop (renders in the editor).
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Inner content.
 * @param WP_Block $block      Block instance.
 * @return string
 */
function onstage_render_show_listing_meta_block( $attributes, $content, $block ) {
	$post_id = 0;
	if ( isset( $block->context['postId'] ) ) {
		$post_id = (int) $block->context['postId'];
	}
	if ( ! $post_id && isset( $_GET['post_id'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$post_id = absint( wp_unslash( $_GET['post_id'] ) );
	}
	if ( ! $post_id ) {
		$post_id = (int) get_the_ID();
	}
	return onstage_render_show_listing_meta( $post_id );
}

/**
 * Register the Show listing meta block and its editor script.
 */
function onstage_register_show_listing_meta_block() {
	wp_register_script(
		'onstage-show-listing-meta-editor',
		get_theme_file_uri( 'assets/js/show-listing-meta.js' ),
		array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-server-side-render' ),
		ONSTAGE_VERSION,
		true
	);

	register_block_type(
		'onstage/show-listing-meta',
		array(
			'api_version'     => 3,
			'title'           => __( 'Show dates and venue', 'onstage' ),
			'description'     => __( 'Calendar date lines and venue from the current Show post.', 'onstage' ),
			'category'        => 'theme',
			'icon'            => 'calendar-alt',
			'supports'        => array(
				'html'     => false,
				'reusable' => false,
			),
			'uses_context'    => array( 'postId', 'postType' ),
			'render_callback' => 'onstage_render_show_listing_meta_block',
			'editor_script'   => 'onstage-show-listing-meta-editor',
		)
	);
}
add_action( 'init', 'onstage_register_show_listing_meta_block' );

/**
 * Hashtag pills for a show title (mockup event card).
 *
 * @param string $title Show title.
 * @return string[]
 */
function onstage_show_hashtags( $title ) {
	$tags       = array();
	$short_name = trim( preg_replace( '/\s+\d.*$/', '', (string) $title ) );
	$compact    = preg_replace( '/[^A-Za-z0-9]+/', '', $short_name );
	if ( $compact ) {
		$tags[] = '#' . $compact;
	}
	if ( false !== stripos( $title, 'christmas' ) ) {
		$tags[] = '#HolidaySpectacular';
	}
	$tags[] = '#OnStageTheatricalProductions';
	return array_unique( $tags );
}

/**
 * Right-hand Event Information card on the single Show template.
 *
 * Usage: [onstage_show_event_card]
 *
 * @return string
 */
function onstage_show_event_card_shortcode() {
	if ( 'show' !== get_post_type() ) {
		return '';
	}

	$dates  = get_post_meta( get_the_ID(), 'onstage_show_dates', true );
	$venue  = get_post_meta( get_the_ID(), 'onstage_show_venue', true );
	$ticket = get_post_meta( get_the_ID(), 'onstage_show_ticket_url', true );
	if ( ! $ticket ) {
		$ticket = ONSTAGE_TICKETS_URL;
	}

	ob_start();
	echo '<aside class="sidebar-card show-event-card">';
	if ( has_post_thumbnail() ) {
		echo get_the_post_thumbnail(
			get_the_ID(),
			'large',
			array(
				'class' => 'show-event-poster',
				'alt'   => get_the_title(),
			)
		);
	}
	echo '<h3>' . esc_html__( 'Event Information', 'onstage' ) . '</h3>';

	echo '<div class="show-meta-item">';
	echo '<i class="fa-solid fa-calendar-days" aria-hidden="true"></i>';
	echo '<div class="show-meta-content"><strong>' . esc_html__( 'Date & Time', 'onstage' ) . '</strong>';
	echo $dates ? nl2br( esc_html( $dates ) ) : esc_html__( 'TBA', 'onstage' );
	echo '</div></div>';
	if ( $venue ) {
		echo '<div class="show-meta-item">';
		echo '<i class="fa-solid fa-location-dot" aria-hidden="true"></i>';
		echo '<div class="show-meta-content"><strong>' . esc_html__( 'Venue', 'onstage' ) . '</strong>' . esc_html( $venue ) . '</div>';
		echo '</div>';
	}

	echo '<div class="show-meta-item">';
	echo '<i class="fa-solid fa-ticket" aria-hidden="true"></i>';
	echo '<div class="show-meta-content"><strong>' . esc_html__( 'Tickets', 'onstage' ) . '</strong>';
	if ( $ticket ) {
		echo '<a href="' . esc_url( $ticket ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Buy Tickets', 'onstage' ) . '</a>';
	} else {
		echo esc_html__( 'TBA / Coming Soon', 'onstage' );
	}
	echo '</div></div>';

	echo '<div class="hashtag-pill-container">';
	foreach ( onstage_show_hashtags( get_the_title() ) as $tag ) {
		echo '<span class="hashtag-pill">' . esc_html( $tag ) . '</span>';
	}
	echo '</div></aside>';
	return ob_get_clean();
}
add_shortcode( 'onstage_show_event_card', 'onstage_show_event_card_shortcode' );
