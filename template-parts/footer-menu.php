<?php
/**
 * The template for displaying the footer menu.
 *
 * @package Greenlight
 * @since 1.0.0
 */

?>

<?php if ( has_nav_menu( 'footer' ) ) : ?>

	<nav class="footer-menu">

		<?php
		/**
		 * Filter arguments used for footer menu.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		wp_nav_menu( apply_filters( 'greenlight_footer_nav_args', array(
			'theme_location'    => 'footer',
			'depth'             => 1,
			'fallback_cb'       => false,
			'container'         => 'ul',
		)));
		?>

	</nav><!-- .footer-menu -->

<?php endif; ?>
