<?php
/**
 * Displays the footer site info.
 *
 * @package Greenlight
 * @since 1.0.0
 */
?>

<div class="site-info">
    <div class="wrap">

        <?php
        /**
         * @hooked greenlight_add_social_menu - 10
         * @hooked greenlight_add_site_credit - 20
         * @hooked greenlight_add_footer_menu - 30
         *
         * @since 1.0.0
         */
        do_action( 'greenlight_site_info' );
        ?>

    </div><!-- .wrap -->
</div><!-- .site-info -->
