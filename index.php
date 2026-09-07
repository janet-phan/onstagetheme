<?php
/**
 * Fallback for classic requests. This is a block theme;
 * templates live in the /templates directory.
 *
 * @package Onstage
 */

if ( function_exists( 'wp_doing_ajax' ) && wp_doing_ajax() ) {
	return;
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
if ( function_exists( 'block_template_part' ) ) {
	block_template_part( 'header' );
}
?>
<main>
	<p><?php esc_html_e( 'This theme requires WordPress 6.4+ with a block theme template. Please update WordPress or switch to a supported environment such as LocalWP.', 'onstage' ); ?></p>
</main>
<?php
if ( function_exists( 'block_template_part' ) ) {
	block_template_part( 'footer' );
}
wp_footer();
?>
</body>
</html>
