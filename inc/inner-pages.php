<?php
/**
 * Shared block markup for seeded inner program, gallery, and costume pages.
 *
 * @package Onstage
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Give Kids A Chance application strip used on program subpages.
 *
 * @return string
 */
function onstage_gkac_box_blocks() {
	$form = ONSTAGE_SCHOLARSHIP_FORM;
	return '<!-- wp:group {"align":"full","className":"gkac-application-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull gkac-application-section">
	<!-- wp:group {"className":"gkac-application-box"} -->
	<div class="wp-block-group gkac-application-box">
		<!-- wp:paragraph {"className":"gkac-application-icon"} -->
		<p class="gkac-application-icon"><i class="fa-solid fa-graduation-cap" aria-hidden="true"></i></p>
		<!-- /wp:paragraph -->
		<!-- wp:group {"className":"gkac-application-content"} -->
		<div class="wp-block-group gkac-application-content">
			<!-- wp:heading {"level":2} -->
			<h2 class="wp-block-heading">Give Kids A Chance</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Financial assistance may be available for eligible families through the Give Kids A Chance Program. Complete the online application to be considered for participation.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<!-- wp:html -->
		<p class="gkac-application-action"><a class="btn gkac-application-button" href="' . esc_url( $form ) . '" target="_blank" rel="noreferrer noopener">Apply for the Give Kids A Chance Program</a></p>
		<!-- /wp:html -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->';
}

/**
 * Hover-zoom media cards used on gallery and costume collection pages.
 *
 * @param array $images List of src/alt pairs.
 * @return string
 */
function onstage_media_card_grid( $images ) {
	$html = '<div class="costume-gallery-grid destination-gallery-grid">';
	foreach ( $images as $image ) {
		$src = esc_url( $image['src'] );
		$alt = esc_attr( $image['alt'] );
		$html .= '<a class="gallery-card-item" href="' . $src . '">';
		$html .= '<img src="' . $src . '" alt="' . $alt . '"/>';
		$html .= '<span class="gallery-card-overlay"><span class="gallery-zoom-icon"><i class="fa-solid fa-magnifying-glass-plus" aria-hidden="true"></i></span></span>';
		$html .= '</a>';
	}
	$html .= '</div>';
	return $html;
}

/**
 * Compact program detail page fallback (dedicated patterns are preferred).
 *
 * @param array $args Page data.
 * @return string
 */
function onstage_program_page_blocks( $args ) {
	$title    = $args['title'];
	$kicker   = isset( $args['kicker'] ) ? $args['kicker'] : '';
	$intro    = isset( $args['intro'] ) ? $args['intro'] : array();
	$sections = isset( $args['sections'] ) ? $args['sections'] : array();
	$office   = 'tel:' . ONSTAGE_PHONE_TEL;
	$email    = 'mailto:' . ONSTAGE_EMAIL;

	$html  = '<!-- wp:group {"align":"full","className":"page-header inner-program-page","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull page-header inner-program-page">
	<!-- wp:paragraph {"className":"gallery-back-link"} -->
	<p class="gallery-back-link"><a href="/programs/">← Back to Programs &amp; Classes</a></p>
	<!-- /wp:paragraph -->
	<!-- wp:heading {"textAlign":"center","level":1,"className":"pink-text program-child-title"} -->
	<h1 class="wp-block-heading has-text-align-center pink-text program-child-title">' . esc_html( $title ) . '</h1>
	<!-- /wp:heading -->';

	if ( $kicker ) {
		$html .= '
	<!-- wp:heading {"textAlign":"center","level":2,"className":"green-text inner-program-kicker"} -->
	<h2 class="wp-block-heading has-text-align-center green-text inner-program-kicker">' . esc_html( $kicker ) . '</h2>
	<!-- /wp:heading -->';
	}

	foreach ( $intro as $para ) {
		$html .= '
	<!-- wp:paragraph {"align":"center"} -->
	<p class="has-text-align-center">' . wp_kses_post( $para ) . '</p>
	<!-- /wp:paragraph -->';
	}

	foreach ( $sections as $section ) {
		$html .= '
	<!-- wp:heading {"level":3,"className":"pink-text"} -->
	<h3 class="wp-block-heading pink-text">' . esc_html( $section['title'] ) . '</h3>
	<!-- /wp:heading -->';
		if ( ! empty( $section['meta'] ) ) {
			$html .= '
	<!-- wp:paragraph -->
	<p><strong>' . wp_kses_post( $section['meta'] ) . '</strong></p>
	<!-- /wp:paragraph -->';
		}
		foreach ( $section['paras'] as $para ) {
			$html .= '
	<!-- wp:paragraph -->
	<p>' . wp_kses_post( $para ) . '</p>
	<!-- /wp:paragraph -->';
		}
	}

	$html .= '
	<!-- wp:html -->
	<p class="program-child-actions"><a class="btn btn-pink" href="' . esc_url( $office ) . '">CALL THE FRONT OFFICE</a><a class="btn btn-black" href="' . esc_url( $email ) . '">EMAIL ON STAGE</a></p>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
';

	return $html . onstage_gkac_box_blocks();
}

/**
 * Shared Recreational Dance–quality layout for gallery and costume children:
 * pink title, two-column gray photo intro, pink section heading, card grid, pills.
 *
 * @param array $args Page data.
 * @return string
 */
function onstage_destination_media_page_blocks( $args ) {
	$title      = $args['title'];
	$back_href  = $args['back_href'];
	$back_label = $args['back_label'];
	$hero       = $args['hero'];
	$hero_alt   = isset( $args['hero_alt'] ) ? $args['hero_alt'] : $title;
	$kicker     = $args['kicker'];
	$tagline    = isset( $args['tagline'] ) ? $args['tagline'] : '';
	$intro      = $args['intro'];
	$intro2     = isset( $args['intro2'] ) ? $args['intro2'] : '';
	$section    = $args['section'];
	$actions    = isset( $args['actions'] ) ? $args['actions'] : '';
	$page_class = isset( $args['page_class'] ) ? $args['page_class'] : 'destination-media-page';

	$html  = '<!-- wp:group {"align":"full","className":"page-header ' . esc_attr( $page_class ) . '","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull page-header ' . esc_attr( $page_class ) . '">
	<!-- wp:paragraph {"className":"gallery-back-link"} -->
	<p class="gallery-back-link"><a href="' . esc_url( $back_href ) . '">' . esc_html( $back_label ) . '</a></p>
	<!-- /wp:paragraph -->
	<!-- wp:heading {"textAlign":"center","level":1,"className":"pink-text program-child-title"} -->
	<h1 class="wp-block-heading has-text-align-center pink-text program-child-title">' . esc_html( $title ) . '</h1>
	<!-- /wp:heading -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"announcement-section bg-light-gray destination-intro-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull announcement-section bg-light-gray destination-intro-section">
	<!-- wp:columns {"verticalAlignment":"center","className":"announcement-content"} -->
	<div class="wp-block-columns announcement-content are-vertically-aligned-center">
		<!-- wp:column {"className":"announcement-img"} -->
		<div class="wp-block-column announcement-img">
			<!-- wp:image {"sizeSlug":"large"} -->
			<figure class="wp-block-image size-large"><img src="' . esc_url( $hero ) . '" alt="' . esc_attr( $hero_alt ) . '"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"announcement-text"} -->
		<div class="wp-block-column announcement-text">
			<!-- wp:heading {"level":2} -->
			<h2 class="wp-block-heading">' . esc_html( $kicker ) . '</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"className":"mb-30"} -->
			<p class="mb-30">' . wp_kses_post( $intro ) . '</p>
			<!-- /wp:paragraph -->';

	if ( $tagline ) {
		$html .= '
			<!-- wp:heading {"level":3,"className":"pink-text"} -->
			<h3 class="wp-block-heading pink-text">' . esc_html( $tagline ) . '</h3>
			<!-- /wp:heading -->';
	}

	if ( $intro2 ) {
		$html .= '
			<!-- wp:paragraph -->
			<p>' . wp_kses_post( $intro2 ) . '</p>
			<!-- /wp:paragraph -->';
	}

	if ( $actions ) {
		$html .= '
			<!-- wp:html -->
			' . $actions . '
			<!-- /wp:html -->';
	}

	$html .= '
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"acting-programs-section destination-gallery-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull acting-programs-section destination-gallery-section">
	<!-- wp:heading {"textAlign":"center","className":"pink-text"} -->
	<h2 class="wp-block-heading has-text-align-center pink-text">' . esc_html( $section ) . '</h2>
	<!-- /wp:heading -->
	<!-- wp:html -->
	' . onstage_media_card_grid( $args['images'] ) . '
	<!-- /wp:html -->';

	if ( $actions ) {
		$html .= '
	<!-- wp:html -->
	' . $actions . '
	<!-- /wp:html -->';
	}

	$html .= '
</div>
<!-- /wp:group -->';

	return $html;
}

/**
 * Show photo gallery landing page.
 *
 * @param array $args Page data.
 * @return string
 */
function onstage_show_gallery_page_blocks( $args ) {
	$youtube = 'https://www.youtube.com/channel/UCYURAEfRUgjAipibRgcIiOg';
	$hero    = isset( $args['hero'] ) ? $args['hero'] : $args['images'][0]['src'];
	$actions = '<p class="program-child-actions"><a class="btn btn-pink rounded-pill" href="/gallery/">VIEW ALL GALLERIES</a><a class="btn btn-black" href="' . esc_url( $youtube ) . '" target="_blank" rel="noreferrer noopener">VIEW MORE ON YOUTUBE</a></p>';

	return onstage_destination_media_page_blocks(
		array_merge(
			array(
				'back_href'  => '/gallery/',
				'back_label' => '← BACK TO PHOTO GALLERY',
				'hero'       => $hero,
				'kicker'     => 'PRODUCTION HIGHLIGHTS',
				'tagline'    => 'SING. DANCE. ACT. PERFORM.',
				'section'    => 'PRODUCTION PHOTOS',
				'actions'    => $actions,
				'page_class' => 'show-gallery-page destination-media-page',
			),
			$args
		)
	);
}

/**
 * Costume collection page.
 *
 * @param array $args Page data.
 * @return string
 */
function onstage_costume_collection_page_blocks( $args ) {
	$email   = 'mailto:' . ONSTAGE_EMAIL . '?subject=' . rawurlencode( $args['subject'] );
	$hero    = isset( $args['hero'] ) ? $args['hero'] : $args['images'][0]['src'];
	$actions = '<p class="program-child-actions"><a class="btn btn-pink rounded-pill" href="' . esc_url( $email ) . '">EMAIL INQUIRY</a><a class="btn btn-black" href="/costume-rentals/">BACK TO COSTUME RENTALS</a></p>';

	return onstage_destination_media_page_blocks(
		array_merge(
			array(
				'back_href'  => '/costume-rentals/',
				'back_label' => '← BACK TO COSTUME RENTALS',
				'hero'       => $hero,
				'kicker'     => 'COSTUME RENTAL COLLECTION',
				'tagline'    => 'STAGE-READY LOOKS FOR YOUR CAST',
				'section'    => 'COSTUME COLLECTION',
				'actions'    => $actions,
				'page_class' => 'costume-collection-page destination-media-page',
			),
			$args
		)
	);
}
