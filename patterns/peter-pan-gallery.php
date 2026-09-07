<?php
/**
 * Title: Peter Pan Gallery
 * Slug: onstage/peter-pan-gallery
 * Categories: onstage
 * Block Types: core/post-content
 * Post Types: page
 */
echo onstage_show_gallery_page_blocks(
	array(
		'title'    => 'PETER PAN',
		'hero'     => onstage_img( 'gallery-peter-pan.jpg' ),
		'hero_alt' => 'Peter Pan 2025 production still',
		'intro'    => 'Take flight to Neverland with the On Stage 2025 production of <strong>Peter Pan</strong>. Browse scenes from the Darling nursery to the pirate ship as the cast brings the story to life.',
		'intro2'   => 'These photos highlight rehearsal, ensemble, and performance looks from the On Stage archive. Click any image to open a larger view.',
		'images'   => array(
			array( 'src' => onstage_img( 'gallery-peter-pan.jpg' ), 'alt' => 'Peter Pan performance' ),
			array( 'src' => onstage_img( 'costume-peter-pan.jpg' ), 'alt' => 'Peter Pan costumes on stage' ),
			array( 'src' => onstage_img( 'bts-3.jpg' ), 'alt' => 'Peter Pan cast' ),
			array( 'src' => onstage_img( 'bts-7.jpg' ), 'alt' => 'Peter Pan rehearsal' ),
			array( 'src' => onstage_img( 'dance.jpg' ), 'alt' => 'Peter Pan dance number' ),
			array( 'src' => onstage_img( 'recital.jpg' ), 'alt' => 'Peter Pan ensemble' ),
			array( 'src' => onstage_img( 'bts-4.jpg' ), 'alt' => 'Peter Pan production still' ),
			array( 'src' => onstage_img( 'hero.jpg' ), 'alt' => 'Peter Pan performance moment' ),
		),
	)
);
