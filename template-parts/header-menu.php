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
     * @hooked null
     */
	do_action( 'greenlight_header_nav_before' );
	?>

	<nav class="header-menu">

		<?php
		/**
		 * @hooked greenlight_add_header_nav - 10
		 */
		do_action( 'greenlight_header_nav' );
		?>

	</nav><!-- .header-menu -->

	<?php
	/**
     * @hooked null
     */
	do_action( 'greenlight_header_nav_after' );
	?>

</div>
