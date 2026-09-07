<?php
/**
 * Title: Join the Studio / Buy Tickets
 * Slug: onstage/cta-join-tickets
 * Categories: onstage
 * Description: External studio portal and ticketing buttons.
 */
$tickets = ONSTAGE_TICKETS_URL;
$studio  = ONSTAGE_STUDIO_URL;
?>
<!-- wp:group {"align":"full","className":"big-ctas","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull big-ctas">
	<!-- wp:buttons {"className":"cta-buttons","layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons cta-buttons">
		<!-- wp:button {"className":"is-style-onstage-pink"} -->
		<div class="wp-block-button is-style-onstage-pink"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $studio ); ?>" target="_blank" rel="noreferrer noopener">Join the Studio</a></div>
		<!-- /wp:button -->
		<!-- wp:button {"className":"is-style-onstage-pink"} -->
		<div class="wp-block-button is-style-onstage-pink"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $tickets ); ?>" target="_blank" rel="noreferrer noopener">Buy Tickets</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
