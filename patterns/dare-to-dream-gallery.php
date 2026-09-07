<?php
/**
 * Title: Dare to Dream Gallery
 * Slug: onstage/dare-to-dream-gallery
 * Categories: onstage
 * Block Types: core/post-content
 * Post Types: page
 */
echo onstage_show_gallery_page_blocks(
	array(
		'title'    => 'DARE TO DREAM',
		'hero'     => onstage_img( 'gallery-dare-to-dream.jpg' ),
		'hero_alt' => 'Dare to Dream production still',
		'intro'    => 'Celebrate the magic and talent of our performers in the On Stage production of <strong>Dare to Dream</strong>. Browse moments captured on stage as the cast brings their stories and dances to life.',
		'intro2'   => 'These photos highlight rehearsal, ensemble, and performance looks from the On Stage archive. Click any image to open a larger view.',
		'images'   => array(
			array( 'src' => onstage_img( 'gallery-dare-to-dream.jpg' ), 'alt' => 'Dare to Dream performance' ),
			array( 'src' => onstage_img( 'bts-1.jpg' ), 'alt' => 'Dare to Dream rehearsal' ),
			array( 'src' => onstage_img( 'bts-2.jpg' ), 'alt' => 'Dare to Dream cast' ),
			array( 'src' => onstage_img( 'bts-3.jpg' ), 'alt' => 'Dare to Dream onstage moment' ),
			array( 'src' => onstage_img( 'current-show.jpg' ), 'alt' => 'Dare to Dream production still' ),
			array( 'src' => onstage_img( 'student-showcase.jpg' ), 'alt' => 'Dare to Dream ensemble' ),
			array( 'src' => onstage_img( 'bts-8.jpg' ), 'alt' => 'Dare to Dream curtain call' ),
			array( 'src' => onstage_img( 'bts-9.jpg' ), 'alt' => 'Dare to Dream performance moment' ),
		),
	)
);
