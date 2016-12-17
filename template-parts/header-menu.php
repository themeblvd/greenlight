<?php
/**
 * Displays the primary navigation.
 *
 * @package Greenlight
 * @since 1.0.0
 */

?>

<div class="header-menu-container">

	<?php
	/**
	 * Fires before the main menu.
	 *
	 * @since 1.0.0
	 */
	do_action( 'greenlight_header_nav_before' );
	?>

	<nav class="header-menu">

		<?php
		/**
		 * Fires for the main menu.
		 *
		 * @since 1.0.0
		 * @hooked greenlight_add_header_nav - 10
		 */
		do_action( 'greenlight_header_nav' );
		?>

	</nav><!-- .header-menu -->

	<?php
	/**
	 * Firest after the main menu.
	 *
	 * @since 1.0.0
	 */
	do_action( 'greenlight_header_nav_after' );
	?>

</div>
