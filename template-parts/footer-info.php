<?php
/**
 * Displays the footer site info.
 *
 * @package Greenlight
 * @since 1.0.0
 */

?>

<div class="footer-info">
	<div class="wrap">

		<?php
		/**
		 * Fires within footer info section. Use this hook
		 * to display anything below the footer of the website.
		 *
		 * @since 1.0.0
		 * @hooked greenlight_add_social_menu - 10
		 * @hooked greenlight_add_footer_credit - 20
		 * @hooked greenlight_add_footer_menu - 30
		 *
		 * @since 1.0.0
		 */
		do_action( 'greenlight_site_info' );
		?>

	</div><!-- .wrap -->
</div><!-- .footer-info -->
