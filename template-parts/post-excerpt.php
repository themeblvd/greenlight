<?php
/**
 * Template part for displaying the post excerpt inside The Loop.
 *
 * @package Greenlight
 * @since 1.0.0
 */

?>

<div class="entry-summary">

	<?php the_excerpt(); ?>

	<p>
		<a class="btn btn-default" href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
			<?php esc_html_e( 'Read More', 'greenlight' ); ?>
		</a>
	</p>

</div><!-- .entry-summary -->
