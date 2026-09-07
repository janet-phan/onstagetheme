<?php
/**
 * Title: Peter Pan Costumes
 * Slug: onstage/peter-pan-costumes
 * Categories: onstage
 * Block Types: core/post-content
 * Post Types: page
 */
echo onstage_costume_collection_page_blocks(
	array(
		'title'    => 'PETER PAN COSTUME GALLERY',
		'subject'  => 'Inquiry About Peter Pan Costume Package',
		'hero'     => onstage_img( 'costume-peter-pan.jpg' ),
		'hero_alt' => 'Peter Pan costume collection',
		'intro'    => 'Explore theatrical costume examples from <strong>Peter Pan</strong>. Lost Boys, pirates, and Neverland looks are represented here for a full production.',
		'intro2'   => 'Contact Linda for current availability, sizing, pricing, and production-specific rental information. Click any image to open a larger view.',
		'images'   => array(
			array( 'src' => onstage_img( 'costume-peter-pan.jpg' ), 'alt' => 'Peter Pan costume collection' ),
			array( 'src' => onstage_img( 'gallery-peter-pan.jpg' ), 'alt' => 'Peter Pan production still' ),
			array( 'src' => onstage_img( 'bts-3.jpg' ), 'alt' => 'Peter Pan costume detail' ),
			array( 'src' => onstage_img( 'bts-7.jpg' ), 'alt' => 'Peter Pan ensemble costumes' ),
			array( 'src' => onstage_img( 'dance.jpg' ), 'alt' => 'Peter Pan stage costume' ),
			array( 'src' => onstage_img( 'recital.jpg' ), 'alt' => 'Peter Pan costume example' ),
		),
	)
);
