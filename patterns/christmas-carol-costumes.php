<?php
/**
 * Title: A Christmas Carol costume gallery
 * Slug: onstage/christmas-carol-costumes
 * Categories: onstage
 * Block Types: core/post-content
 * Post Types: page
 */
echo onstage_costume_collection_page_blocks(
	array(
		'title'    => 'A CHRISTMAS CAROL COSTUME GALLERY',
		'subject'  => 'Inquiry About A Christmas Carol Costume Package',
		'hero'     => onstage_img( 'costume-christmas-carol.jpg' ),
		'hero_alt' => 'A Christmas Carol costume collection',
		'intro'    => 'Explore our theatrical costume package for <strong>A Christmas Carol</strong>. From Scrooge’s nighttime attire to Victorian street dresses, heavy winter coats, and spectral garments for the Ghosts, this collection contains premium, stage-ready costumes for a complete cast.',
		'intro2'   => 'Contact Linda for current availability, sizing, pricing, and production-specific rental information. Click any image to open a larger view.',
		'images'   => array(
			array( 'src' => onstage_img( 'costume-christmas-carol.jpg' ), 'alt' => 'A Christmas Carol costume collection' ),
			array( 'src' => onstage_img( 'gallery-christmas-carol.jpg' ), 'alt' => 'A Christmas Carol production still' ),
			array( 'src' => onstage_img( 'christmas-spectacular.jpg' ), 'alt' => 'A Christmas Carol holiday costume' ),
			array( 'src' => onstage_img( 'bts-2.jpg' ), 'alt' => 'A Christmas Carol costume detail' ),
			array( 'src' => onstage_img( 'bts-4.jpg' ), 'alt' => 'A Christmas Carol ensemble costumes' ),
			array( 'src' => onstage_img( 'curtains.jpg' ), 'alt' => 'A Christmas Carol stage costume' ),
		),
	)
);
