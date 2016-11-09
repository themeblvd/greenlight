<?php
/**
 * The template for displaying the footer menu.
 *
 * @package Greenlight
 * @since 1.0.0
 */
?>

<?php if ( has_nav_menu('footer') ) : ?>

    <nav class="footer-menu">

    	<?php
    	wp_nav_menu( array(
            'theme_location'    => 'footer',
            'depth'             => 1,
            'fallback_cb'       => false,
            'container'         => 'ul'
    	));
    	?>

    </nav><!-- .footer-menu -->

<?php endif; ?>
