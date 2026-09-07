<?php
/**
 * Title: A Christmas Carol Gallery
 * Slug: onstage/christmas-carol-gallery
 * Categories: onstage
 * Block Types: core/post-content
 * Post Types: page
 */
echo onstage_show_gallery_page_blocks(
	array(
		'title'    => 'A CHRISTMAS CAROL',
		'hero'     => onstage_img( 'gallery-christmas-carol.jpg' ),
		'hero_alt' => 'A Christmas Carol production still',
		'intro'    => 'Celebrate the magic and talent of our performers in the On Stage production of <strong>A Christmas Carol</strong>. Browse Victorian-era scenes, ensemble numbers, and holiday moments from the show.',
		'intro2'   => 'These photos highlight rehearsal, ensemble, and performance looks from the On Stage archive. Click any image to open a larger view.',
		'images'   => array(
			array( 'src' => onstage_img( 'gallery-christmas-carol.jpg' ), 'alt' => 'A Christmas Carol performance' ),
			array( 'src' => onstage_img( 'costume-christmas-carol.jpg' ), 'alt' => 'A Christmas Carol costumes' ),
			array( 'src' => onstage_img( 'christmas-spectacular.jpg' ), 'alt' => 'A Christmas Carol holiday scene' ),
			array( 'src' => onstage_img( 'bts-2.jpg' ), 'alt' => 'A Christmas Carol cast' ),
			array( 'src' => onstage_img( 'bts-4.jpg' ), 'alt' => 'A Christmas Carol rehearsal' ),
			array( 'src' => onstage_img( 'curtains.jpg' ), 'alt' => 'A Christmas Carol stage' ),
			array( 'src' => onstage_img( 'bts-6.jpg' ), 'alt' => 'A Christmas Carol production still' ),
			array( 'src' => onstage_img( 'bts-8.jpg' ), 'alt' => 'A Christmas Carol ensemble' ),
		),
	)
);
