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

            if ( ! isset( $fonts[ $font[0] ] ) ) {
                $fonts[ $font[0] ] = array();
            }

            $weight = greenlight_get_font_weight( $font[1] );

            if ( ! in_array( $weight, $fonts[ $font[0] ] ) ) {
                $fonts[ $font[0] ][] = $weight;
            }

        }
    }

    if ( $fonts ) {
        foreach ( $fonts as $key => $val ) {

            $fonts[$key] = $key . ':' . implode( ',', $val );
            $fonts[$key] = str_replace( ' ', '+', $fonts[$key] );

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

/**
 * Return an array of footer widget areas.
 *
 * @global array $wp_registered_sidebars
 * @since  1.0.0
 *
 * @return array
 */
function greenlight_get_footer_sidebars() {

    global $wp_registered_sidebars;

    $sidebars = preg_grep( '/^footer-(.*)/', array_keys( $wp_registered_sidebars ) );

    /**
	 * Filter the array of footer widget areas.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	return apply_filters( 'greenlight_footer_sidebars', $sidebars );
}

/**
 * Return an array of active footer widget areas.
 *
 * @since 1.0.0
 *
 * @return array
 */
function greenlight_get_active_footer_sidebars() {

	return array_filter( greenlight_get_footer_sidebars(), 'is_active_sidebar' );

}

/**
 * Check if there are active footer widget areas.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function greenlight_has_active_footer_sidebars() {

	return (bool) greenlight_get_active_footer_sidebars();

}

/**
 * Whether to display the floating search
 * in the main menu.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function greenlight_do_menu_search() {

    /**
	 * Filter if search gets applied to main menu.
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
	return apply_filters( 'themeblvd_do_menu_search', true );

}

/**
 * Theme location for primary menu.
 *
 * @since 1.0.0
 *
 * @return string
 */
function greenlight_primary_menu_location() {

    /**
	 * Filter if search gets added to main menu. Useful for
     * filtering in an alternate registed nav menu for different
     * scenarios, like special pages, mobile-specific, etc.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	return apply_filters( 'greenlight_primary_menu_location', 'primary' );

}

/**
 * Whether commetns templat should display.
 *
 * @since 1.0.0
 *
 * @return bool $show
 */
function greenlight_show_comments() {

    $show = true;

    // If the current post's type doesn't support comments, comments
	// presence should be hidden.
	if ( $show && ! post_type_supports( get_post_type(), 'comments' ) ) {

    	$show = false;

    }

	// If comments are closed AND no comments exist, then it doesn't
	// make sense to have any comments presence.
	if ( $show && ! comments_open() && ! have_comments() ) {

    	$show = false;

    }

    /**
	 * Filter if comments template should display
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	return apply_filters( 'greenlight_show_comments', $show );

}

/**
 * Get an rgb or rgba value based on color hex value.
 *
 * @since 2.5.0
 *
 * @param string $hex Color hex - ex: #000 or 000
 * @param string $opacity Opacity value to determine rgb vs rgba - ex: 0.5
 * @return array $classes Classes for element.
 */
function themeblvd_get_rgb( $color, $opacity = '' ) {

	$default = 'rgb(0,0,0)';

	if ( ! $color ) {

		return $default;

	}

	// Sanitize $color if "#" is provided
	$color = str_replace( '#', '', $color );

    // Check if color has 6 or 3 characters and get values
    if ( strlen( $color ) == 6 ) {

        $hex = array( $color[0].$color[1], $color[2].$color[3], $color[4].$color[5] );

    } else if ( strlen($color) == 3 ) {

        $hex = array( $color[0].$color[0], $color[1].$color[1], $color[2].$color[2] );

    } else {

    	return $default;

    }

    // Convert hexadec to rgb
    $rgb =  array_map( 'hexdec', $hex );

    // Check if opacity is set(rgba or rgb)
    if ( $opacity ) {

		if ( abs( $opacity ) > 1 ) {
    		$opacity = '1.0';
    	}

        $output = sprintf( 'rgba(%s,%s)', implode( ',', $rgb ), $opacity );

    } else {

    	$output = sprintf( 'rgb(%s)', implode( ',', $rgb ) );

    }

    return $output;

}
