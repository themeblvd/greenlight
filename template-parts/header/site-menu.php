<?php
/**
 * Displays the primary navigation.
 *
 * @package Greenlight
 * @since 1.0.0
 */
?>

<div class="site-menu-container">

	<?php
	/**
     * @hooked null
     */
	do_action( 'greenlight_site_nav_before' );
	?>

	<nav class="site-menu">

		<?php
		/**
		 * @hooked greenlight_add_site_nav - 10
		 */
		do_action( 'greenlight_site_nav' );
		?>

	</nav><!-- .site-menu -->

	<?php
	/**
     * @hooked null
     */
	do_action( 'greenlight_site_nav_after' );
	?>

</div>
