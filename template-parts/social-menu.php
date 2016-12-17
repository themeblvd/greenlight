<?php
/**
 * The template for displaying the social menu. This
 * template file displays in the website footer,
 * when a menu is assigned. It can also be shown
 * within the top bar above the website header, as well.
 *
 * @package Greenlight
 * @since 1.0.0
 */

?>

<?php if ( has_nav_menu( 'social' ) ) : ?>

	<nav class="social-menu">

		<?php
		/**
		 * Filter arguments used for social menu.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		wp_nav_menu( apply_filters( 'greenlight_footer_nav_args', array(
			'theme_location'    => 'social',
			'depth'             => 1,
			'fallback_cb'       => false,
			'container'         => 'ul',
		));
		?>

	</nav><!-- .social-menu -->

<?php endif; ?>
