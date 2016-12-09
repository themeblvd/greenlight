<?php
/**
 * Displays searchform in header.
 *
 * @package Greenlight
 * @since 1.0.0
 */
?>

<?php if ( greenlight_do_menu_search() ) : ?>

    <div class="site-search">

        <?php get_search_form(); ?>

    </div><!-- .site-search -->

<?php endif; ?>
