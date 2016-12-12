<?php
/**
 * Helper Functions
 *
 * @package Greenlight
 * @since 1.0.0
 */

/**
 * Get current sidebar layout for page.
 *
 * @global $post
 * @since 1.0.0
 *
 * @return string $layout Current page's sidebar layout.
 */
function greenlight_get_layout() {

    global $post;

    $types = greenlight_get_layout_types();

    /**
	 * Filter which post types get the layout designated
     * for "single posts."
     *
     * Note: Filtering more post types onto this array
     * will also automatically add the cooresponding
     * meta box for the layout override whene diting the
     * post types (see greenlight_add_meta_boxes()).
	 *
	 * @since 1.0.0
     *
	 * @var array
	 */
    if ( is_singular( apply_filters( 'greenlight_apply_single_post_layout', array( 'post' ) ) ) ) {

        $layout = get_post_meta( $post->ID, '_greenlight_layout', true );

        if ( empty( $layout ) || $layout == 'default' ) {

            $layout = get_theme_mod( 'layout-post', $types['post']['default'] );

        }

    } else if ( is_page() ) {

        $layout = get_post_meta( $post->ID, '_greenlight_layout', true );

        if ( empty( $layout ) || $layout == 'default' ) {

            $layout = get_theme_mod( 'layout-page', $types['page']['default'] );

        }

    } else {

        $layout = get_theme_mod( 'layout-default', $types['default']['default'] );

    }

    /**
	 * Filter current sidebar layout.
	 *
	 * @since 1.0.0
	 *
     * @param $types array Types of layouts
     * @param $post POST obj
     *
	 * @var string
	 */
    return apply_filters( 'greenlight_layout', $layout, $types, $post );

}

/**
 * Whether to display sidebar.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function greenlight_has_sidebar() {

    $has = true;

    if ( strpos( greenlight_get_layout(), 'sidebar' ) === false ) {

        $has = false;

    }

    if ( $has && ! is_active_sidebar( 'sidebar' ) ) {

        $has = false;

    }

    /**
	 * Filter whether to output sidebar.
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
    return (bool) apply_filters( 'greenlight_has_sidebar', $has );

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
 * as an "header thumbnail" above the content.
 *
 * Note: The "header thumbnail" is differentiated from the
 * standard "header image" in that the header thumbnail
 * displaying will make it so the standard featured image
 * doesn't display within the content. Alternatively, if the
 * user has selected for a standard header image to display
 * across the entire website, this will not effect the featured
 * image displaying and thus greenlight_has_header_thumb() will
 * return FALSE.
 *
 * @global WP_Post $post
 * @since 1.0.0
 *
 * @param int $post_id
 * @return bool
 */
function greenlight_has_header_thumb( $post_id = 0 ) {

    global $post;

    $has = false;

    if ( is_single() || is_page() ) {

        if ( ! $post_id && is_a( $post, 'WP_Post' ) ) {

            $post_id = $post->ID;

        }

        if ( has_post_thumbnail( $post_id ) && get_post_meta( $post_id, '_greenlight_apply_header_thumb', true ) ) {

            $has = true;

        }

    }

    /**
     * Filter whether current post has an
     * header thumbnail set.
     *
     * @since 1.0.0
     *
     * @var bool
     */
    return (bool) apply_filters( 'greenlight_has_header_thumb', $has, $post_id );

}

/**
 * Whether to display the standard header media.
 *
 * @since 1.0.0
 *
 * @param int $post_id
 * @return bool
 */
function greenlight_has_header_media() {

    $has = false;

    if ( ! greenlight_has_header_thumb() && has_header_image() ) { // header thumb (i.e. featured image set as header image) always overrides general header media

        if ( is_home() || is_archive() ) {

            $has = true;

        }

    }

    /**
     * Filter whether current post has an
     * header thumbnail set.
     *
     * @since 1.0.0
     *
     * @var bool
     */
    return (bool) apply_filters( 'greenlight_has_header_media', $has );

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
	return (bool) apply_filters( 'greenlight_has_custom_logo', $enabled );

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
function greenlight_do_top_bar() {

    $do = get_theme_mod( 'do_top_bar', 1 );

    /**
	 * Filter if top bar displays.
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
	return (bool) apply_filters( 'greenlight_do_top_bar', $do );

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
	return (bool) apply_filters( 'themeblvd_do_menu_search', true );

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
	 * Filter if primary menu theme location. Useful for
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
 * Theme location for top menu.
 *
 * @since 1.0.0
 *
 * @return string
 */
function greenlight_top_menu_location() {

    /**
	 * Filter if top menu theme location. Useful for
     * filtering in an alternate registed nav menu for different
     * scenarios, like special pages, mobile-specific, etc.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	return apply_filters( 'greenlight_topy_menu_location', 'top' );

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

/**
 * Determine if a color is considered "light" (subjective).
 *
 * Huge thank you to Oscar for providing this:
 * http://stackoverflow.com/questions/3015116/hex-code-brightness-php
 *
 * @since 2.0.0
 *
 * @param string $color Color hex to determine if light. Ex: #ffffff
 * @return bool $light Whether color is considered light.
 */
function greenlight_is_light_color( $color ) {

    $light = false;

	// Pop off '#' from start.
	$color = explode( '#', $color );
	$color = $color[1];

	// Break up the color in its RGB components
	$r = hexdec( substr( $color, 0, 2 ) );
	$g = hexdec( substr( $color, 2, 2 ) );
	$b = hexdec( substr( $color, 4, 2 ) );

	// Simple weighted average
	if ( $r + $g + $b > 382 ) {

	    $light = true;

    }

	return (bool) apply_filters( 'greenlight_is_light_color', $light, $color );
}

/**
 * Process any FontAwesome icons passed in as %icon%.
 *
 * @since 2.5.0
 *
 * @param string $str String to search
 * @return string $str Filtered original string
 */
function greenlight_do_fa( $str ) {

	preg_match_all( '/\%\%(.*?)\%\%/', $str, $icons );

	if ( ! empty( $icons[0] ) ) {

		$list = true;

		if ( substr_count( trim( $str ), "\n") ) {
			$list = false; // If text has more than one line, we won't make into an inline list
		}

		$total = count($icons[0]);

		if ( $list ) {
			$str = sprintf("<ul class=\"list-inline\">\n<li>%s</li>\n</ul>", $str);
		}

		foreach ( $icons[0] as $key => $val ) {

			$html = apply_filters('themeblvd_do_fa_html', '<i class="fa fa-fw fa-%s"></i>', $str);

			if ( $list && $key > 0 ) {
				$html = "<li>\n".$html;
			}

			$str = str_replace( $val, sprintf( $html, $icons[1][$key] ), $str );
		}
	}

	return $str;
}
