<?php
/**
 * Template part for displaying the post thumbnail for a page.
 *
 * @package Greenlight
 * @since 1.0.0
 */

?>

<?php if ( has_post_thumbnail() ) : ?>

	<div class="featured-image">

		<?php
		/**
		 * Fires before the featured image.
		 *
		 * @since 1.0.0
		 */
		do_action( 'greenlight_page_thumbnail_before' );
		?>

		<?php the_post_thumbnail( greenlight_get_featured_image_size() ); ?>

		<?php
		/**
		 * Fires after the featured image.
		 *
		 * @since 1.0.0
		 */
		do_action( 'greenlight_page_thumbnail_after' );
		?>

	</div><!-- .featured-image -->

<?php endif; ?>
