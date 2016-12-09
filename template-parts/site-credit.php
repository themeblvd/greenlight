<?php
/**
 * The template for displaying the site credit
 * and copyright info.
 *
 * @package Greenlight
 * @since 1.0.0
 */
?>

<div class="site-credit">
    <div class="wrap">

        <?php
        printf(
            esc_html_x( 'Copyright %1$s %2$d %3$s', '1. copyright symbol, 2. year, 3. site title', 'greenlight' ),
            '&copy;',
            date( 'Y' ),
            get_bloginfo( 'blogname' )
        );

        /**
         * Filter the footer author credit display.
         *
         * @since 1.0.0
         *
         * @var bool
         */
        if ( apply_filters( 'greenlight_author_credit', true ) ) {

        	echo ' &mdash; ';

            $theme = wp_get_theme();

            printf(
        		esc_html_x( 'Design by %1$s', 'theme author link', 'greenlight' ),
        		sprintf(
        			'<a href="%s" rel="author" target="_blank">%s</a>',
        			esc_url( $theme->get( 'AuthorURI' ) ),
        			esc_html( $theme->get( 'Author' ) )
        		)
        	);

        }
        ?>

    </div><!-- .wrap -->
</div><!-- .site-credit -->
