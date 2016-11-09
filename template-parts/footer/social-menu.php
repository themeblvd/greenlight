<?php
/**
 * The template for displaying the social menu.
 *
 * @package Greenlight
 * @since 1.0.0
 */
?>

<?php if ( has_nav_menu('social') ) : ?>

    <nav class="social-menu">

    	<?php
    	wp_nav_menu( array(
            'theme_location'    => 'social',
            'depth'             => 1,
            'fallback_cb'       => false,
            'container'         => 'ul'
    	));
    	?>

    </nav><!-- .social-menu -->

<?php endif; ?>
