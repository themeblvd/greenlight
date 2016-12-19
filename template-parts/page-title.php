<?php
/**
 * Template part for displaying the page title.
 *
 * @package Greenlight
 * @since 1.0.0
 */

?>

<header class="entry-header">
	<div class="wrap">

		<?php
		/**
		 * Fires before the title of a page in The Loop.
		 *
		 * @since 1.0.0
		 */
		do_action( 'greenlight_page_title_before' );
		?>

		<h1 class="entry-title"><?php the_title(); ?></h1>

		<?php
		/**
		 * Fires after the title of a page in The Loop.
		 *
		 * @since 1.0.0
		 */
		do_action( 'greenlight_page_title_after' );
		?>

	</div><!-- .wrap -->
</header><!-- .entry-header -->
