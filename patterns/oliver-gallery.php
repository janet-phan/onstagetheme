<?php
/**
 * Title: Oliver! Gallery
 * Slug: onstage/oliver-gallery
 * Categories: onstage
 * Block Types: core/post-content
 * Post Types: page
 */
echo onstage_show_gallery_page_blocks(
	array(
		'title'    => 'OLIVER!',
		'hero'     => onstage_img( 'gallery-oliver.jpg' ),
		'hero_alt' => 'Oliver! production still',
		'intro'    => 'Celebrate the magic and talent of our performers in the On Stage production of <strong>Oliver!</strong>. Browse scenes from the workhouse, Fagin’s den, and the London streets.',
		'intro2'   => 'These photos highlight rehearsal, ensemble, and performance looks from the On Stage archive. Click any image to open a larger view.',
		'images'   => array(
			array( 'src' => onstage_img( 'gallery-oliver.jpg' ), 'alt' => 'Oliver! performance' ),
			array( 'src' => onstage_img( 'costume-oliver.jpg' ), 'alt' => 'Oliver! costumes on stage' ),
			array( 'src' => onstage_img( 'bts-5.jpg' ), 'alt' => 'Oliver! cast' ),
			array( 'src' => onstage_img( 'bts-6.jpg' ), 'alt' => 'Oliver! rehearsal' ),
			array( 'src' => onstage_img( 'musical.jpg' ), 'alt' => 'Oliver! musical number' ),
			array( 'src' => onstage_img( 'hero.jpg' ), 'alt' => 'Oliver! ensemble' ),
			array( 'src' => onstage_img( 'bts-1.jpg' ), 'alt' => 'Oliver! production still' ),
			array( 'src' => onstage_img( 'current-show.jpg' ), 'alt' => 'Oliver! performance moment' ),
		),
	)
);
