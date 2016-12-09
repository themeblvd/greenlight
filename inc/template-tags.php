<?php
/**
 * Template Tags
 *
 * @package Greenlight
 * @since 1.0.0
 */

/**
 * Display HTML class for site top bar.
 *
 * @since 1.0.0
 */
function greenlight_top_bar_class() {

    $class = array('site-top-bar');

    $items = greenlight_get_top_bar_items();

    if ( get_theme_mod( 'do_top_menu', $items['do_top_menu']['default'] ) ) {

        $class[] = 'has-top-menu';

    }

    if ( get_theme_mod( 'top_text', $items['top_text']['default'] ) ) {

        $class[] = 'has-top-text';

    }

    if ( get_theme_mod( 'do_top_social', $items['do_top_social']['default'] ) && has_nav_menu( 'social' ) ) {

        $class[] = 'has-top-social';

    }

    /**
	 * Filter the top bar class array.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	if ( $class = apply_filters( 'greenlight_top_bar_class', $class ) ) {

		$output = sprintf( 'class="%s"', esc_attr( implode(' ', $class) ) );

        /**
    	 * Filter the final output of the top bar class HTML.
    	 *
    	 * @since 1.0.0
    	 *
    	 * @var string
    	 */
        echo apply_filters( 'greenlight_top_bar_class_output', $output, $class );

    }
}

/**
 * Display HTML for top bar menu.
 *
 * @since 1.0.0
 */
function greenlight_the_top_menu() {

    $items = greenlight_get_top_bar_items();

    $html = '';

    if ( get_theme_mod( 'do_top_menu', $items['do_top_menu']['default'] ) ) {

        $html .= "<nav class=\"top-bar-menu\">\n";

        ob_start();

        if ( has_nav_menu( greenlight_top_menu_location() ) ) {

    		/**
    		 * Filter arguments used for main menu.
    		 *
    		 * @since 1.0.0
    		 *
    		 * @var array
    		 */
    		wp_nav_menu( apply_filters( 'greenlight_top_nav_args', array(
    			'theme_location'	=> greenlight_top_menu_location(),
    			'container'			=> 'ul',
    			'depth'     		=> 1 // Top-level only
    		)));

    	} else {

    		/**
    		 * Filter arguments used for main menu fallback.
    		 *
    		 * @since 1.0.0
    		 *
    		 * @var array
    		 */
    		wp_page_menu( apply_filters( 'greenlight_top_nav_fallback_args', array(
    			'container'			=> 'ul',
    			'depth'     		=> 1, // Top-level only
    			'show_home' 		=> false,
    			'before'			=> '',
    			'after'				=> ''
    		)));

    	}

        $html .= ob_get_clean();

        $html .= "</nav>\n";

    }

    /**
	 * Filter the top menu output.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	echo apply_filters( 'greenlight_the_top_menu', $html );

}

/**
 * Display HTML for top bar text.
 *
 * @since 1.0.0
 */
function greenlight_the_top_text() {

    $items = greenlight_get_top_bar_items();

    $html = '';

    if ( $text = get_theme_mod( 'top_text', $items['top_text']['default'] ) ) {

        $html .= sprintf( "<div class=\"top-bar-text\">%s</div>\n", greenlight_do_fa( $text ) );

    }

    /**
	 * Filter the top menu output.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	echo apply_filters( 'greenlight_the_top_text', $html );

}

/**
 * Display HTML for top bar social menu.
 *
 * @since 1.0.0
 */
function greenlight_the_top_social() {

    $items = greenlight_get_top_bar_items();

    $html = '';

    if ( get_theme_mod( 'do_top_social', $items['do_top_social']['default'] ) ) {

        ob_start();

        get_template_part( 'template-parts/social', 'menu' );

        $html .= ob_get_clean();

    }

    /**
	 * Filter the top menu output.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	echo apply_filters( 'greenlight_the_top_social', $html );

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

/**
 * Display toggle for the mobile main menu.
 *
 * @since 1.0.0
 */
function greenlight_the_site_menu_toggle() {

    $html  = "<a href=\"#\" class=\"site-menu-toggle hamburger\">\n";
    $html .= "\t<span class=\"wrap\">\n";
    $html .= "\t\t<span class=\"top\"></span>\n";
    $html .= "\t\t<span class=\"middle\"></span>\n";
    $html .= "\t\t<span class=\"bottom\"></span>\n";
    $html .= "\t</span>\n";
    $html .= "</a>";

    /**
	 * Filter the site description HTML.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	echo apply_filters( 'greenlight_the_site_menu_toggle', $html );

}

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

    if ( greenlight_do_menu_search() ) {

        $class[] = 'has-search';

    }

    /**
	 * Filter the header class array.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	if ( $class = apply_filters( 'greenlight_header_class', $class ) ) {

		$output = sprintf( 'class="%s"', esc_attr( implode(' ', $class) ) );

        /**
    	 * Filter the final output of the header class HTML.
    	 *
    	 * @since 1.0.0
    	 *
    	 * @var string
    	 */
        echo apply_filters( 'greenlight_header_class_output', $output, $class );

    }
}

/**
 * Display HTML class for site header media.
 *
 * @global $post WP_Post
 * @since 1.0.0
 */
function greenlight_header_media_class() {

    global $post;

    $class = array('site-header-media');

    if ( greenlight_has_header_thumb() ) {

        $fs = get_post_meta( $post->ID, '_greenlight_apply_header_thumb_fs', true );

    } else {

        $fs = get_theme_mod( 'header_media_fs', 0 );

    }

    if ( $fs ) {

        $class[] = 'fs';

        if ( ! wp_is_mobile() ) {

            $class[] = 'greenlight-parallax';

        }

    } else {

        $class[] = 'fw';

    }

    if ( greenlight_has_header_thumb() ) {

        $class[] = 'featured-image';

    }

    /**
	 * Filter whether header image gets shaded for
     * more readable text overlay.
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
    if ( apply_filters( 'greenlight_do_header_media_shade', true ) ) {

        $types = greenlight_get_color_types();
        $default = ! empty( $types['menu_text']['default'] ) ? $types['menu_text']['default'] : null;

        if ( greenlight_is_light_color( sanitize_hex_color( get_theme_mod( 'menu_text', $default ) ) ) ) {

            $class[] = 'darken';

        } else {

            $class[] = 'lighten';

        }

    }

    /**
	 * Filter the header media class array.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	if ( $class = apply_filters( 'greenlight_header_media_class', $class ) ) {

		$output = sprintf( 'class="%s"', esc_attr( implode(' ', $class) ) );

        /**
    	 * Filter the final output of the header class HTML.
    	 *
    	 * @since 1.0.0
    	 *
    	 * @var string
    	 */
        echo apply_filters( 'greenlight_header_media_class_output', $output, $class );

    }
}

/**
 * Display HTML class for site footer.
 *
 * @since 1.0.0
 */
function greenlight_footer_class() {

    $class = array( 'site-footer' );

    /**
	 * Filter the footer class array.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	if ( $class = apply_filters( 'greenlight_footer_class', $class ) ) {

		$output = sprintf( 'class="%s"', esc_attr( implode(' ', $class) ) );

        /**
    	 * Filter the final output of the footer class HTML.
    	 *
    	 * @since 1.0.0
    	 *
    	 * @var string
    	 */
        echo apply_filters( 'greenlight_footer_class_output', $output, $class );

    }
}

/**
 * Display HTML class for footer widget column.
 *
 * @since 1.0.0
 *
 * @param int $current Current column number being displayed
 */
function greenlight_footer_col_class( $current = 1 ) {

    $total = count( greenlight_get_active_footer_sidebars() );

    $class = array( 'footer-widget', 'column', 'col-md-' . strval( ( 12 / $total ) ) );

    /**
	 * Filter the footer column class array.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	if ( $class = apply_filters('greenlight_footer_col_class', $class, $total, $current ) ) {

		$output = sprintf( 'class="%s"', esc_attr( implode(' ', $class) ) );

        /**
    	 * Filter the final output of the footer column class HTML.
    	 *
    	 * @since 1.0.0
    	 *
    	 * @var string
    	 */
        echo apply_filters( 'greenlight_footer_col_class_output', $output, $class, $total, $current );

    }
}

/**
 * Display pagination.
 *
 * @link https://codex.wordpress.org/Function_Reference/paginate_links
 * @since 1.0.0
 *
 * @param bool $display Whether to display or return content.
 * @return string HTML content for output.
 */
function greenlight_paginate_links( $display = false ) {

    global $wp_query, $wp_rewrite;

	if ( $wp_query->max_num_pages < 2 ) {

		return;

    }

    $html = "";

	$paged = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args = array();
	$url_parts = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {

		wp_parse_str( $url_parts[1], $query_args );

    }

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

    /**
     * Filter arguments passed into WP's paginate_links().
     *
     * @since 1.0.0
     *
     * @var array
     */
    $links = paginate_links( apply_filters( 'greenlight_paginate_links_args', array(
        'base'          => $pagenum_link,
        'format'        => $format,
        'total'         => $wp_query->max_num_pages,
        'current'       => $paged,
        'mid_size'      => 3,
        'add_args'      => array_map( 'urlencode', $query_args ),
        'prev_next'     => false,
        'type'          => 'array'
        )));

    if ( $links ) {

        $html .= "<nav class=\"paging-nav\" role=\"navigation\">\n";
        $html .= sprintf( "\t<h2 class=\"screen-reader-text\">%s</h2>", esc_html__( 'Posts navigation', 'greenlight' ) );
        $html .= "\t<ol>\n";

        foreach ( $links as $link ) {

            $link = str_replace( 'page-numbers', 'btn btn-sm btn-light page-numbers', $link );
            $html .= sprintf( "\t\t<li>%s</li>\n", $link );

        }

        $html .= "\t</ol>\n";
        $html .= "</nav><!-- .paging-nav -->\n";

    }

    /**
     * Filter the final output of the post pagination.
     *
     * @since 1.0.0
     *
     * @var string
     */
    $html = apply_filters( 'greenlight_paginate_links', $html, $links );

    if ( $display ) {

        echo $html;

    } else {

        return $html;

    }

}

/**
 * Display page links.
 *
 * @link https://codex.wordpress.org/Function_Reference/wp_link_pages
 * @since 1.0.0
 *
 * @param bool $display Whether to display or return content.
 * @return string HTML content for output.
 */
function greenlight_link_pages( $display = true ) {

    $html = "";

    $links = wp_link_pages( array(
        'before'        => '<div class="page-links">',
        'after'         => '</div>',
        'link_before'   => '<span class="btn btn-light btn-sm">',
        'link_after'    => '</span>',
        'echo'          => false
	));

    if ( $links ) {

        // Find the <span> with a space before and designate that as the current
        $links = str_replace( ' <span class="btn btn-light btn-sm">', ' <span class="btn btn-light btn-sm current">', $links );

        $html = $links;

    }

    /**
     * Filter the final output of page links.
     *
     * @since 1.0.0
     *
     * @var string
     */
    $html = apply_filters( 'greenlight_link_pages', $html, $links );

    if ( $display ) {

        echo $html;

    } else {

        return $html;

    }

}

/**
 * Expand WP's the_archive_title() to account
 * for 404 and search results.
 *
 * @since 1.0.0
 *
 * @param bool $display Whether to display or return content.
 * @return string $title
 */
function greenlight_the_archive_title( $display = true ) {

    $title = '';

    if ( is_404() ) {

        $title = esc_html__( '404: Nothing Found', 'greenlight' );

    } else if ( is_search() ) {

        $title = sprintf( esc_html__( 'Search Results For: "%s"', 'greenlight' ), get_search_query() );

    } else {

        $title = get_the_archive_title();

    }

    /**
	 * Filter the title.
	 *
	 * @since 1.0.0
     *
	 * @var string
	 */
    $title = apply_filters( 'greenlight_archive_title', $title );

    if ( $display ) {

        echo $title;

    } else {

        return $title;

    }

}

/**
 * Display the description for an archive, if relevant.
 *
 * @since 1.0.0
 *
 * @param bool $display Whether to display or return content.
 * @return string $desc
 */
function greenlight_the_archive_desc( $display = true ) {

    $desc = '';

    if ( is_author() ) {

        $desc = get_the_author_meta( 'description' );

    } else if ( is_category() ) {

        $desc = category_description();

    } else if ( is_tag() ) {

        $desc = tag_description();

    } else if ( is_tax() ) {

        $desc = term_description();

    }

    /**
	 * Filter the title.
	 *
	 * @since 1.0.0
     *
	 * @var string
	 */
    $desc = apply_filters( 'greenlight_archive_desc', $desc );

    if ( $display ) {

        echo $desc;

    } else {

        return $desc;

    }

}
