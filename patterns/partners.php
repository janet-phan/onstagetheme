<?php
/**
 * Title: Community partners
 * Slug: onstage/partners
 * Categories: onstage
 */
$mcc = onstage_img( 'mass_cultural_logo.jpg' );
$aci = onstage_img( 'anthonycordeirologo.jpg' );
$wff = onstage_img( 'whitefamilyfoundationlogo.jpg' );
$apf = onstage_img( 'ameliapeabodyfoundation_bluelogo.png' );
?>
<!-- wp:group {"align":"full","className":"supporters","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull supporters">
	<!-- wp:heading {"textAlign":"center","className":"pink-text"} -->
	<h2 class="wp-block-heading has-text-align-center pink-text">Our Supporters &amp; Community Partners</h2>
	<!-- /wp:heading -->
	<!-- wp:html -->
	<div class="logos-grid">
		<img alt="Mass Cultural Council" src="<?php echo $mcc; ?>" />
		<div class="text-sponsor">Fall River Cultural Council<br /><span>A Local Agency of the<br />Massachusetts Cultural Council</span></div>
		<img alt="Anthony Cordeiro Insurance" src="<?php echo $aci; ?>" />
		<img alt="White Family Foundation" src="<?php echo $wff; ?>" />
		<img alt="Amelia Peabody Foundation" src="<?php echo $apf; ?>" />
	</div>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
