<?php
/**
 * Helper Functions
 *
 * @package Greenlight
 * @since 1.0.0
 */

/**
 * Whether to display sidebar.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function greenlight_has_sidebar() {

    // ... @TODO Incorporate checking the sidebar layout once we've created this feature.

    $has = false;

    if ( is_active_sidebar( 'sidebar' ) ) {
        $has = true;
    }

    return apply_filters('greenlight_has_sidebar', $has);
}

/**
 * Get featured image size.
 *
 * @since 1.0.0
 */
function greenlight_get_featured_image_size() {

    // ... @TODO

    return '';
}

/**
 * Whether the current post is displaying the featured image
 * as an "epic thumbnail" above the content.
 *
 * @since 1.0.0
 */
function greenlight_has_epic_thumb() {

    // ... @TODO

    return false;
}

/**
 * Check if the site has a custom logo.
 *
 * Note: If prior to WordPress 4.5, the feature won't exist and
 * will return false.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function greenlight_has_custom_logo () {

    /**
	 * For backwards compatibility prior to WordPress 4.5.
	 *
	 * @link  https://developer.wordpress.org/reference/functions/has_custom_logo/
	 * @since 1.0.0
	 */
    $enabled = function_exists( 'has_custom_logo' ) ? has_custom_logo() : false;

    /**
	 * Filter if the site has a custom logo.
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
	return apply_filters( 'greenlight_has_custom_logo', $enabled );

}

/**
 * Check if the site has active categories.
 *
 * We will store the result in a transient so this function
 * can be called frequently without any performance concern.
 *
 * @see   greenlight_has_active_categories_reset()
 * @since 1.0.0
 *
 * @return bool
 */
function greenlight_has_active_categories() {

    if ( WP_DEBUG || false === ( $has_active_categories = get_transient( 'greenlight_has_active_categories' ) ) ) {

        $categories = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			'number'     => 2, // We only care if more than 1 exists
		));

		$has_active_categories = ( count( $categories ) > 1 );

        set_transient( 'greenlight_has_active_categories', $has_active_categories );

    }

	/**
	 * Filter if the site has active categories.
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
	return (bool) apply_filters( 'greenlight_has_active_categories', ! empty( $has_active_categories ) );

}

/**
 * Get URL to include fonts.
 *
 * @since 1.0.0
 *
 * @return str $url URL to include fonts
 */
function greenlight_get_fonts_url() {

    $types = greenlight_get_font_types();

    $fonts = array();

    if ( $types ) {
        foreach ( $types as $key => $args ) {

            $font = get_theme_mod( $key, $args['default'] );

            if ( ! $font || $font == 'None' ) {
                continue;
            }

            $font = explode( ' - ', $font );

            $fonts[] = $font[0] . ':' . greenlight_get_font_weight( $font[1] );

        }
    }

    /**
     * Filter URL to retrieve web fonts.
     *
     * @since 1.0.0
     *
     * @var str
     */
    return apply_filters( 'greenlight_fonts_url', 'https://fonts.googleapis.com/css?family=' . implode( '|', $fonts ) );

}

/**
 * Convert human readable font weight name to CSS font
 * weight value.
 *
 * @since 1.0.0
 *
 * @return str $weight URL to include fonts
 */
function greenlight_get_font_weight( $name ) {

    $weight = '400'; // default

    switch ( $name ) {

        case 'Thin' :
            $weight = '100';
            break;

        case 'Extra-Light' :
            $weight = '200';
            break;

        case 'Light' :
            $weight = '300';
            break;

        case 'Regular' :
            $weight = '400';
            break;

        case 'Medium' :
            $weight = '500';
            break;

        case 'Semi-Bold' :
            $weight = '600';
            break;

        case 'Bold' :
            $weight = '700';
            break;

        case 'Extra-Bold' :
            $weight = '800';
            break;

        case 'Black' :
            $weight = '900';

    }

    /**
     * Filter converted CSS font weight.
     *
     * @since 1.0.0
     *
     * @var str
     */
    return apply_filters( 'greenlight_font_weight', $weight, $name );

}

/**
 * Whether the URL returns an http 200 status.
 *
 * We use this primarily to determine if the URL to
 * some file we're trying to display is accessible,
 * like a video or image URL, for example.
 *
 * @since 1.0.0
 *
 * @var string $url The URL to some file, local or external
 * @return bool Whether the https status was 200
 */
function greenlight_is_200( $url ) {

	$code = 0;

	$response = wp_remote_head( $url, array(
        'timeout' => 5
    ));

	if ( ! is_wp_error( $response ) && isset( $response['response']['code'] ) ) {
		$code = $response['response']['code'];
	}

	return $code === 200;
}
