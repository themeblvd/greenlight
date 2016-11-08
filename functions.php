<?php
/**
 * Greenlight functions and definitions.
 *
 * Set up the theme and provide some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package Greenlight
 * @since   1.0.0
 */

/**
 * Greenlight theme version.
 *
 * @since 1.0.0
 *
 * @var string
 */
define( 'GREENLIGHT_VERSION', '1.0.0' );

/**
 * Minimum WordPress version required for Greenlight.
 *
 * @since 1.0.0
 *
 * @var string
 */
if ( ! defined( 'GREENLIGHT_MIN_WP_VERSION' ) ) {

	define( 'GREENLIGHT_MIN_WP_VERSION', '4.5' );

}

/**
 * Enforce the minimum WordPress version requirement.
 *
 * @since 1.0.0
 */
if ( version_compare( get_bloginfo( 'version' ), PRIMER_MIN_WP_VERSION, '<' ) ) {

	require_once get_template_directory() . '/inc/compat/wordpress.php';

}

/**
 * Load customizer integration.
 *
 * @since 1.0.0
 */
require_once get_template_directory() . '/inc/admin/customizer.php';

/**
 * Load custom helper functions for this theme.
 *
 * @since 1.0.0
 */
require_once get_template_directory() . '/inc/helpers.php';

/**
 * Load custom template tags for this theme.
 *
 * @since 1.0.0
 */
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * Load template parts.
 *
 * @since 1.0.0
 */
require_once get_template_directory() . '/inc/hooks.php';

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the 'after_setup_theme' hook at
 * priority 10, which runs before the init hook. The init hook is too late for
 * some features, such as indicating support for post thumbnails.
 *
 * @action after_setup_theme
 * @global array $greenlight_image_sizes
 * @since  1.0.0
 */
function greenlight_setup() {

	global $greenlight_image_sizes;

    /**
     * Load theme translations.
     *
     * @link  https://codex.wordpress.org/Function_Reference/load_theme_textdomain
     * @since 1.0.0
     */
    load_theme_textdomain( 'greenlight', get_template_directory() . '/lang' );

    /**
     * Filter registered image sizes.
     *
     * @since 1.0.0
     *
     * @var array
     */
	$greenlight_image_sizes = apply_filters( 'greenlight_image_sizes', array(
		/* // ... @TODO
        'greenlight-featured' => array(
			'width'  => 1600,
			'height' => 9999,
			'crop'   => false,
			'label'  => esc_html__( 'Featured', 'greenlight' ),
		)
        */
    ));

    foreach ( $greenlight_image_sizes as $name => &$args ) {

        if ( empty( $name ) || empty( $args['width'] ) || empty( $args['height'] ) ) {
			unset( $greenlight_image_sizes[$name] );
			continue;
		}

        $args['crop']  = ! empty( $args['crop'] ) ? $args['crop'] : false;
		$args['label'] = ! empty( $args['label'] ) ? $args['label'] : ucwords( str_replace( array( '-', '_' ), ' ', $name ) );

        add_image_size(
			sanitize_key( $name ),
			absint( $args['width'] ),
			absint( $args['height'] ),
			$args['crop']
		);
	}

    /**
	 * Add Greenlight's image sizes for selection in WordPress media manager.
	 *
	 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/image_size_names_choose
	 * @since 1.0.0
	 */
    if ( $greenlight_image_sizes ) {
		add_filter( 'image_size_names_choose', 'greenlight_image_size_names_choose' );
	}

    /**
	 * Enable support for Automatic Feed Links.
	 *
	 * @link https://codex.wordpress.org/Function_Reference/add_theme_support#Feed_Links
	 * @since 1.0.0
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for plugins and themes to manage the document title tag.
	 *
	 * @link https://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
	 * @since 1.0.0
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 * @since 1.0.0
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Enable support for customizer selective refresh
	 *
	 * https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
	 * @since 1.0.0
	 */
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Register custom Custom Navigation Menus.
	 *
	 * @link https://codex.wordpress.org/Function_Reference/register_nav_menus
	 * @since 1.0.0
	 */
	register_nav_menus(
		/**
		 * Filter registered nav menus.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		apply_filters( 'greenlight_nav_menus', array(
			'primary'   => esc_html__( 'Primary Menu', 'greenlight' ),
            'side'      => esc_html__( 'Side Menu', 'greenlight' ),
			'social'    => esc_html__( 'Social Menu', 'greenlight' ),
			'footer'    => esc_html__( 'Footer Menu', 'greenlight' ),
		))
	);

	/**
	 * Enable support for HTML5 markup.
	 *
	 * @link https://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
	 * @since 1.0.0
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption'
	));

	/**
	 * Enable support for Post Formats.
	 *
	 * @link https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Formats
	 * @since 1.0.0
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link'
	));

    /**
	 * Enable custom logo support. Requires WordPress 4.5.
	 *
	 * @link https://make.wordpress.org/core/2016/03/10/custom-logo/
	 * @since 1.0.0
	 */
    add_theme_support( 'custom-logo' );

	/**
	 * Add starter content (requires WordPress 4.7)
	 *
	 * @link @TODO
	 * @since 1.0.0
	 */
	add_theme_support( 'starter-content', array(
		/*
		'theme_mods' => array(
			'primary_font' => 'testing',
			'heading_font' => 'testing-2'
		)
		*/
	));

}
add_action( 'after_setup_theme', 'greenlight_setup' );

/**
 * Register image size labels.
 *
 * @filter image_size_names_choose
 * @since  1.0.0
 *
 * @param  array $sizes
 * @return array
 */
function greenlight_image_size_names_choose( $sizes ) {

    global $greenlight_image_sizes;

    $labels = array_combine(
		array_keys( $greenlight_image_sizes ),
		wp_list_pluck( $greenlight_image_sizes, 'label' )
	);

	return array_merge( $sizes, $labels );
}

/**
 * Sets the content width in pixels, based on the theme layout.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @action after_setup_theme
 * @global int $content_width
 * @since  1.0.0
 */
function greenlight_content_width() {

    // ... @TODO

    // $layout        = greenlight_get_layout();
	// $content_width = ( 'one-column-wide' === $layout ) ? 1068 : 688;

    /**
	 * Filter the content width in pixels.
	 *
	 * @since 1.0.0
	 *
	 * @param string $layout
	 *
	 * @var int
	 */
	// $GLOBALS['content_width'] = (int) apply_filters( 'greenlight_content_width', $content_width, $layout );

}
add_action( 'after_setup_theme', 'greenlight_content_width', 0 );

/**
 * Enable support for custom editor style. This is a default WordPress callback
 * that automatically includes editor-style.css, which is placed in the main
 * director of the theme.
 *
 * @link  https://developer.wordpress.org/reference/functions/add_editor_style/
 * @since 1.0.0
 */
add_action( 'admin_init', 'add_editor_style', 10, 0 );

/**
 * Register sidebar areas.
 *
 * @link  http://codex.wordpress.org/Function_Reference/register_sidebar
 * @action widgets_init
 * @since 1.0.0
 */
function greenlight_register_sidebars() {

    /**
	 * Filter registered widget areas.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	$sidebars = apply_filters( 'greenlight_sidebars', array(
		'sidebar' => array(
			'name'          => esc_html__( 'Sidebar', 'greenlight' ),
			'description'   => esc_html__( 'The primary sidebar appears across your site where you have an appropriate layout.', 'greenlight' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		),
		'footer-1' => array(
			'name'          => esc_html__( 'Footer 1', 'greenlight' ),
			'description'   => esc_html__( 'This sidebar is the optional first column of the footer widget area.', 'greenlight' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		),
		'footer-2' => array(
			'name'          => esc_html__( 'Footer 2', 'greenlight' ),
			'description'   => esc_html__( 'This sidebar is the optional second column of the footer widget area.', 'greenlight' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		),
		'footer-3' => array(
			'name'          => esc_html__( 'Footer 3', 'greenlight' ),
			'description'   => esc_html__( 'This sidebar is the optional third column of the footer widget area.', 'greenlight' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		),
        'footer-4' => array(
			'name'          => esc_html__( 'Footer 4', 'greenlight' ),
			'description'   => esc_html__( 'This sidebar is the optional fourth column of the footer widget area.', 'greenlight' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
    ));

	foreach ( $sidebars as $id => $args ) {
		register_sidebar( array_merge( array( 'id' => $id ), $args ) );
	}

}
add_action( 'widgets_init', 'greenlight_register_sidebars' );

/**
 * Enqueue theme scripts and styles.
 *
 * @link https://codex.wordpress.org/Function_Reference/wp_enqueue_style
 * @link https://codex.wordpress.org/Function_Reference/wp_enqueue_script
 * @link https://codex.wordpress.org/Function_Reference/wp_add_inline_style
 * @action wp_enqueue_scripts
 * @since 1.0.0
 */
function greenlight_scripts() {

	$stylesheet = get_stylesheet();
	$rtl = is_rtl() ? '-rtl' : '';
	$suffix = SCRIPT_DEBUG ? '' : '.min';

	// Add custom fonts, selected from the customizer.
	wp_enqueue_style( 'greenlight-fonts', esc_url( greenlight_get_fonts_url() ), array(), null );

	// Add grid system styles
	wp_enqueue_style( 'greenlight-grid', esc_url( get_template_directory_uri() . "/assets/css/grid{$rtl}{$suffix}.css" ), array(), GREENLIGHT_VERSION );

	// Add primary theme styles
    wp_enqueue_style( $stylesheet, esc_url( get_stylesheet_uri() ), false, defined( 'GREENLIGHT_CHILD_VERSION' ) ? GREENLIGHT_CHILD_VERSION : GREENLIGHT_VERSION );
	wp_style_add_data( $stylesheet, 'rtl', 'replace' );
	wp_add_inline_style( $stylesheet, greenlight_inline_style() );

    // wp_enqueue_script( 'greenlight-navigation', get_template_directory_uri() . "/assets/js/navigation{$suffix}.js", array( 'jquery' ), PRIMER_VERSION, true );
	// wp_enqueue_script( 'greenlight-skip-link-focus-fix', get_template_directory_uri() . "/assets/js/skip-link-focus-fix{$suffix}.js", array(), PRIMER_VERSION, true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

    /* // ... @TODO
    if ( greenlight_has_hero_image() ) {
		wp_add_inline_style(
			$stylesheet,
			sprintf(
				'%s { background-image: url(%s); }',
				greenlight_get_hero_image_selector(),
				esc_url( greenlight_get_hero_image() )
			)
		);
	}
    */
}
add_action( 'wp_enqueue_scripts', 'greenlight_scripts' );

/**
 * Generate inline CSS for theme's options.
 *
 * @since 1.0.0
 */
function greenlight_inline_style() {

	$css = "/* Greenlight CSS */\n";

	/**
	 * Fonts
	 */
	$types = greenlight_get_font_types();

	if ( $types ) {
		foreach ( $types as $key => $args ) {

			$font = get_theme_mod( $key, $args['default'] );

			if ( ! $font || $font == 'None' ) {
                continue;
            }

			$font = explode( ' - ', $font );

			$css .= $args['selector'] . " {\n";
			$css .= sprintf( "\tfont-family: \"%s\";\n", $font[0] );
			$css .= sprintf( "\tfont-weight: %s;\n", greenlight_get_font_weight( $font[1] ) );
			$css .= "}\n";

		}
	}

	/**
     * Filter inline CSS.
     *
     * @since 1.0.0
     *
     * @var str
     */
	return apply_filters( 'greenlight_inline_style', $css );
}

/**
 * Filter WP's custom-logo output to add retina 2x logo
 * image, if exists.
 *
 * @filter get_custom_logo
 * @since  1.0.0
 */
function greenlight_custom_logo( $html ) {

	$src = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );

	preg_match( "!^(.+?)(?:\.([^.]+))?$!", $src[0], $path );

	if ( greenlight_is_200( $path[1] . '@2x.' . $path[2] ) ) {
		$srcset = sprintf( '%s 1x, %s 2x', $src[0], $path[1] . '@2x.' . $path[2] );
	}

	if ( $srcset ) {
		$html = str_replace(
			'itemprop="logo"',
			sprintf( 'itemprop="logo" srcset="%s"', $srcset ),
			$html
		);
	}

	return $html;
}
add_filter( 'get_custom_logo', 'greenlight_custom_logo' );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @action wp
 * @global WP_Query $wp_query
 * @global WP_User  $authordata
 * @since  1.0.0
 */
function greenlight_setup_author() {

	global $wp_query, $authordata;

    if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$authordata = get_userdata( $wp_query->post->post_author );
	}

}
add_action( 'wp', 'greenlight_setup_author' );

/**
 * Reset the transient for the active categories check.
 *
 * @action create_category
 * @action edit_category
 * @action delete_category
 * @action save_post
 * @see    greenlight_has_active_categories()
 * @since  1.0.0
 */
function greenlight_has_active_categories_reset() {

	delete_transient( 'greenlight_has_active_categories' );

}
add_action( 'create_category', 'greenlight_has_active_categories_reset' );
add_action( 'edit_category',   'greenlight_has_active_categories_reset' );
add_action( 'delete_category', 'greenlight_has_active_categories_reset' );
add_action( 'save_post',       'greenlight_has_active_categories_reset' );
