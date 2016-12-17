<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#sidebar-php
 *
 * @package Greenlight
 * @since 1.0.0
 */

?>

<?php if ( greenlight_has_sidebar() ) : ?>

	<div id="secondary" class="site-sidebar widget-area" role="complementary">

		<?php dynamic_sidebar( 'sidebar' ); ?>

	</div><!-- #secondary -->

<?php endif; ?>
