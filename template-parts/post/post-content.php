<?php
/**
 * Template part for displaying the post content inside The Loop.
 *
 * @package Greenlight
 * @since   1.0.0
 */
?>

<div class="entry-content">

	<?php /* @TODO // ... this should be Read More button somehow, filtered in maybe? */ the_content( __( 'Read More <span class="meta-nav">&rarr;</span>', 'greenlight' ) ); ?>

	<?php greenlight_link_pages(); ?>

</div><!-- .entry-content -->
