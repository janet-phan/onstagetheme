<?php
/**
 * Title: Oliver Costumes
 * Slug: onstage/oliver-costumes
 * Categories: onstage
 * Block Types: core/post-content
 * Post Types: page
 */
echo onstage_costume_collection_page_blocks(
	array(
		'title'    => 'OLIVER COSTUME GALLERY',
		'subject'  => 'Inquiry About Oliver Costume Package',
		'hero'     => onstage_img( 'costume-oliver.jpg' ),
		'hero_alt' => 'Oliver costume collection',
		'intro'    => 'Explore theatrical costume examples from <strong>Oliver</strong>. From workhouse looks to Fagin’s gang and Victorian streetwear, this collection includes stage-ready pieces for a full cast.',
		'intro2'   => 'Contact Linda for current availability, sizing, pricing, and production-specific rental information. Click any image to open a larger view.',
		'images'   => array(
			array( 'src' => onstage_img( 'costume-oliver.jpg' ), 'alt' => 'Oliver costume collection' ),
			array( 'src' => onstage_img( 'gallery-oliver.jpg' ), 'alt' => 'Oliver production still' ),
			array( 'src' => onstage_img( 'bts-5.jpg' ), 'alt' => 'Oliver costume detail' ),
			array( 'src' => onstage_img( 'bts-6.jpg' ), 'alt' => 'Oliver ensemble costumes' ),
			array( 'src' => onstage_img( 'musical.jpg' ), 'alt' => 'Oliver stage costume' ),
			array( 'src' => onstage_img( 'bts-1.jpg' ), 'alt' => 'Oliver costume example' ),
		),
	)
);
