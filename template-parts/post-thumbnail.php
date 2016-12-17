<?php
/**
 * Template part for displaying the post thumbnail inside The Loop.
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
		do_action( 'greenlight_post_thumbnail_before' );
		?>

		<?php if ( ! is_single() ) : ?>

			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( greenlight_get_featured_image_size() ); ?>
			</a>

		<?php else : ?>

			<?php the_post_thumbnail( greenlight_get_featured_image_size() ); ?>

		<?php endif; ?>

		<?php
		/**
		 * Fires after the featured image.
		 *
		 * @since 1.0.0
		 */
		do_action( 'greenlight_post_thumbnail_after' );
		?>

	</div><!-- .featured-image -->

<?php endif; ?>
