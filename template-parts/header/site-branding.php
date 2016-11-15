<?php
/**
 * Displays the primary navigation.
 *
 * @package Greenlight
 * @since 1.0.0
 */
?>

<div class="site-branding">

    <?php if ( greenlight_has_custom_logo() ) : ?>

        <?php greenlight_the_custom_logo(); ?>

    <?php else : ?>

        <?php greenlight_the_site_title(); ?>

        <?php greenlight_the_site_description(); ?>

    <?php endif; ?>

    <?php greenlight_the_site_menu_toggle(); ?>

</div><!-- .site-title -->
