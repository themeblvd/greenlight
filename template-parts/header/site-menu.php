<?php
/**
 * Displays the primary navigation.
 *
 * @package Greenlight
 * @since   1.0.0
 */
?>

<div class="main-navigation-container">

	<?php
	/**
     * @hooked null
     */
	do_action( 'greenlight_site_nav_before' );
	?>

	<nav id="site-navigation" class="main-navigation">

		<?php
		/**
		 * @hooked greenlight_add_site_nav - 10
		 */
		do_action( 'greenlight_site_nav' );
		?>

	</nav><!-- #site-navigation -->

	<?php
	/**
     * @hooked null
     */
	do_action( 'greenlight_site_nav_after' );
	?>

</div>
