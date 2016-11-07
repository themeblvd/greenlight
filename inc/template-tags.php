<?php
/**
 * Template Tags
 *
 * @package Greenlight
 * @since 1.0.0
 */

/**
 * Display HTML class for site header.
 *
 * @since 1.0.0
 */
function greenlight_header_class() {

    $class = array('site-header');

    if ( greenlight_has_custom_logo() ) {
        $class[] = 'has-logo';
    }

	if ( $class = apply_filters('themeblvd_header_class', $class ) ) {

		$output = sprintf( 'class="%s"', esc_attr( implode(' ', $class) ) );

        echo apply_filters('themeblvd_header_class_output', $output, $class);

    }
}

/**
 * Display the site logo. This will only display the logo
 * in WordPress 4.5+.
 *
 * Note that before calling this, you should check for a
 * logo by calling greenlight_has_custom_logo() which will
 * verify that the feature exists and that the user has setup
 * a logo image.
 *
 * @since 1.0.0
 */
function greenlight_the_custom_logo() {

    /**
	 * For backwards compatibility prior to WordPress 4.5.
	 *
	 * @link  https://developer.wordpress.org/reference/functions/the_custom_logo/
	 * @since 1.0.0
	 */
	if ( function_exists( 'the_custom_logo' ) ) {

		the_custom_logo();

		return;

	}

}

/**
 * Display the site title.
 *
 * @since 1.0.0
 */
function greenlight_the_site_title() {

    $html = sprintf(
		'<h1 class="site-title"><a href="%s" rel="home">%s</a></h1>',
		esc_url( home_url( '/' ) ),
		get_bloginfo( 'name' )
	);

	/**
	 * Filter the site title HTML.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	echo apply_filters( 'greenlight_the_site_title', $html );

}

/**
 * Display the site description.
 *
 * @since 1.0.0
 */
function greenlight_the_site_description() {

    $html = sprintf(
		'<div class="site-description">%s</div>',
		get_bloginfo( 'description' )
	);

	/**
	 * Filter the site description HTML.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	echo apply_filters( 'greenlight_the_site_description', $html );

}
