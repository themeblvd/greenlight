<?php
/**
 * Template part for displaying the post excerpt inside The Loop.
 *
 * @package Greenlight
 * @since   1.0.0
 */
?>

<div class="entry-summary">

	<?php the_excerpt(); ?>

	<p><a class="button" href="<?php the_permalink(); ?>"><?php printf( esc_html_x( 'Continue Reading %s', 'right arrow (LTR) / left arrow (RTL)', 'greenlight' ), is_rtl() ? '&larr;' : '&rarr;' ); ?></a></p>

</div><!-- .entry-summary -->
