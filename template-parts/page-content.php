<?php
/**
 * Template part for displaying the page content.
 *
 * @package Greenlight
 * @since 1.0.0
 */

?>

<div class="entry-content">

	<?php the_content(); ?>

	<?php greenlight_link_pages(); // Wrapper for WP's link_pages(). ?>

	<?php edit_post_link( esc_html__( 'Edit', 'greenlight' ), '<span class="edit-link">', '</span>' ); ?>

</div><!-- .entry-content -->
