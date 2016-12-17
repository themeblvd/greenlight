<?php
/**
 * Displays top bar above header.
 *
 * @package Greenlight
 * @since 1.0.0
 */

?>

<?php if ( greenlight_do_top_bar() ) : ?>

	<div id="top" <?php greenlight_top_bar_class(); ?>>
		<div class="wrap clearfix">

			<?php greenlight_the_top_menu(); ?>

			<?php greenlight_the_top_social(); ?>

			<?php greenlight_the_top_text(); ?>

		</div><!-- .wrap -->
	</div><!-- .site-top-bar -->

<?php endif; ?>
