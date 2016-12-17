<?php
/**
 * Template part for displaying the post content inside The Loop.
 *
 * @package Greenlight
 * @since 1.0.0
 */

?>

<div class="entry-content">

	<?php the_content( __( 'Read More <span class="meta-nav">&rarr;</span>', 'greenlight' ) ); ?>

	<?php greenlight_link_pages(); // Wrapper for WP's link_pages(). ?>

</div><!-- .entry-content -->
