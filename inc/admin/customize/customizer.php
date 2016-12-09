<?php
/**
 * Customizer Integration
 *
 * @package Greenlight
 * @since 1.0.0
 */

/**
 * Setup customizer functionality.
 *
 * @action after_setup_theme
 * @since 1.0.0
 */
function greenlight_customize_register( $wp_customize ) {

    /**
     * Enqueue assets.
     */
    add_action( 'customize_controls_enqueue_scripts', 'greenlight_customize_scripts' );

    /**
     * Register any custom controls.
     */
    $wp_customize->register_control_type( 'Greenlight_Customize_Control_Grouped' );
    $wp_customize->register_control_type( 'Greenlight_Customize_Control_Radio_Image' );

    /**
     * Top Bar
     */
    $wp_customize->add_section( 'top_bar', array(
        'title'     => esc_html__( 'Top Bar', 'greenlight' ),
        'priority'  => 20
    ));

    if ( $items = greenlight_get_top_bar_items() ) {

        $wp_customize->add_setting( 'do_top_bar', array(
            'default'           => 1,
            'sanitize_callback' => 'greenlight_sanitize_checkbox',
        ));

        $wp_customize->add_control( new Greenlight_Customize_Control_Grouped( $wp_customize, 'do_top_bar', array(
            'label'         => esc_html__( 'Display top bar.', 'greenlight' ),
            'section'       => 'top_bar',
            'type'          => 'checkbox',
            'group-type'    => 'toggle',
            'group-role'    => 'trigger'
        )));

        foreach ( $items as $key => $args ) {

            $key = sanitize_key( $key );

            $wp_customize->add_setting( $key, array(
                'default'           => ! empty( $args['default'] ) ? $args['default'] : '',
                'sanitize_callback' => ! empty( $args['sanitize_callback'] ) ? $args['sanitize_callback'] : 'greenlight_sanitize_checkbox'
            ));

            $wp_customize->add_control( new Greenlight_Customize_Control_Grouped( $wp_customize, $key, array(
                'label'             => ! empty( $args['label'] ) ? $args['label'] : '',
                'description'       => ! empty( $args['description'] ) ? $args['description'] : '',
                'section'           => ! empty( $args['section'] ) ? $args['section'] : 'top_bar',
                'type'              => ! empty( $args['type'] ) ? $args['type'] : 'checkbox',
                'group-type'        => 'toggle',
                'group-role'        => 'receiver',
                'group-trigger'     => 'do_top_bar'
            )));

        }

    }

    /**
     * Layouts
     */
    if ( $types = greenlight_get_layout_types() ) {

        $wp_customize->add_section( 'layout', array(
            'title'     => esc_html__( 'Layout', 'greenlight' ),
            'priority'  => 30
        ));

        foreach ( $types as $key => $args ) {

            $key = sanitize_key( 'layout-' . $key );

            $wp_customize->add_setting( $key, array(
                'default'           => ! empty( $args['default'] ) ? $args['default'] : null,
                'sanitize_callback' => 'sanitize_key',
            ));

            $wp_customize->add_control( new Greenlight_Customize_Control_Radio_Image( $wp_customize, $key, array(
                'label'         => ! empty( $args['label'] ) ? $args['label'] : '',
                'description'   => ! empty( $args['description'] ) ? $args['description'] : null,
                'section'       => ! empty( $args['section'] ) ? $args['section'] : 'layout',
                'priority'      => ! empty( $args['priority'] ) ? absint( $args['priority'] ) : null,
                'choices'       => greenlight_get_layouts()
            )));

        }

    }

    /**
     * Fonts
     */
    if ( $types = greenlight_get_font_types() ) {

        $wp_customize->add_section( 'fonts', array(
    		'title'       => __( 'Fonts', 'greenlight' ),
    		'priority'    => 50,
    	));

        foreach ( $types as $key => $args ) {

            $key = sanitize_key( $key );

            $wp_customize->add_setting( $key, array(
        		'default'           => ! empty( $args['default'] ) ? $args['default'] : null,
        		'sanitize_callback' => 'greenlight_sanitize_font'
        	));

            if ( $args['uppercase'] !== NULL ) {

                $wp_customize->add_setting( $key . '_uppercase', array(
            		'default'           => $args['uppercase'],
            		'sanitize_callback' => 'greenlight_sanitize_checkbox'
            	));

            }

            $fonts = greenlight_get_fonts();
            $font_names = array();

            foreach ( $fonts as $name ) {

                if ( $name == $args['default'] ) {
                    $name = sprintf( '%s (%s)', $name, esc_html( 'Default', 'greenlight' ) );
                }

                $font_names[] = $name;

            }

            $fonts = array_combine( $fonts, $font_names );

            $wp_customize->add_control( $key, array(
                'label'         => ! empty( $args['label'] ) ? $args['label'] : $name,
                'description'   => ! empty( $args['description'] ) ? $args['description'] : null,
                'section'       => ! empty( $args['section'] ) ? $args['section'] : 'fonts',
                'priority'      => ! empty( $args['priority'] ) ? absint( $args['priority'] ) : null,
                'type'          => ! empty( $args['type'] ) ? $args['type'] : 'select',
                'choices'       => $fonts
        	));

            if ( $args['uppercase'] !== NULL ) {

                $wp_customize->add_control( $key . '_uppercase', array(
                    'label'     => __( 'Display with uppercase letters?', 'greenlight' ),
                    'section'   => ! empty( $args['section'] ) ? $args['section'] : 'fonts',
                    'priority'  => ! empty( $args['priority'] ) ? absint( $args['priority'] ) : null,
                    'type'      => 'checkbox'
                ));

            }

        }

    }

    /**
     * Colors
     */
    if ( $types = greenlight_get_color_types() ) {

        $wp_customize->add_panel( 'colors', array(
            'title'     => esc_html__( 'Colors', 'greenlight' ),
            // 'description' => 'Get what you need.',
            'priority'  => 40
        ));

        $wp_customize->add_section( 'colors-top-bar', array(
            'title'     => esc_html__( 'Top Bar', 'greenlight' ),
            'panel'     => 'colors',
        ));

        $wp_customize->add_section( 'colors-header', array(
            'title'     => esc_html__( 'Header', 'greenlight' ),
            'panel'     => 'colors',
        ));

        $wp_customize->add_section( 'colors-buttons', array(
            'title'     => esc_html__( 'Buttons', 'greenlight' ),
            'panel'     => 'colors',
        ));

        $wp_customize->add_section( 'colors-content', array(
            'title'     => esc_html__( 'Content', 'greenlight' ),
            'panel'     => 'colors',
        ));

        $wp_customize->add_section( 'colors-footer', array(
            'title'     => esc_html__( 'Footer', 'greenlight' ),
            'panel'     => 'colors',
        ));

        foreach ( $types as $key => $args ) {

            $key = sanitize_key( $key );

            $wp_customize->add_setting( $key, array(
        		'default'           => ! empty( $args['default'] ) ? $args['default'] : null,
        		'sanitize_callback' => ! empty( $args['sanitize_callback'] ) ? $args['sanitize_callback'] : 'sanitize_hex_color',
                // @TODO 'transport'         => ! empty( $args['transport'] ) ? $args['transport'] : 'refresh'
        	));

            if ( ! empty( $args['type'] ) && $args['type'] == 'color' ) {

                $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, array(
                    'label'         => ! empty( $args['label'] ) ? $args['label'] : null,
                    'description'   => ! empty( $args['description'] ) ? $args['description'] : null,
                    'section'       => ! empty( $args['section'] ) ? $args['section'] : 'colors',
                    'priority'      => ! empty( $args['priority'] ) ? absint( $args['priority'] ) : null,
                )));

            } else {

                $wp_customize->add_control( $key, array(
                    'label'         => ! empty( $args['label'] ) ? $args['label'] : null,
                    'description'   => ! empty( $args['description'] ) ? $args['description'] : null,
                    'section'       => ! empty( $args['section'] ) ? $args['section'] : 'fonts',
                    'priority'      => ! empty( $args['priority'] ) ? absint( $args['priority'] ) : null,
                    'type'          => ! empty( $args['type'] ) ? $args['type'] : 'select',
                    'choices'       => ! empty( $args['choices'] ) ? $args['choices'] : array(),
                    'input_attrs'   => ! empty( $args['input_attrs'] ) ? $args['input_attrs'] : array()
            	));

            }

        }

    }

    /**
     * Header Media
     */

    if ( $options = greenlight_get_header_media_options() ) {

        foreach ( $options as $key => $args ) {

            $key = sanitize_key( $key );

            $wp_customize->add_setting( $key, array(
                'default'           => ! empty( $args['default'] ) ? $args['default'] : null,
                'sanitize_callback' => 'greenlight_sanitize_html'
            ));

            $wp_customize->add_control( $key, array(
                'label'         => ! empty( $args['label'] ) ? $args['label'] : null,
                'description'   => ! empty( $args['description'] ) ? $args['description'] : null,
                'section'       => ! empty( $args['section'] ) ? $args['section'] : 'header_image',
                'priority'      => ! empty( $args['priority'] ) ? absint( $args['priority'] ) : null,
                'type'          => ! empty( $args['type'] ) ? $args['type'] : 'select',
                'choices'       => ! empty( $args['choices'] ) ? $args['choices'] : array(),
                'input_attrs'   => ! empty( $args['input_attrs'] ) ? $args['input_attrs'] : array()
            ));

        }
    }

    /**
     * Add selective refresh, where relevent, to speed things up.
     */
    if ( isset( $wp_customize->selective_refresh ) ) { // backwards compat

        // Site Identity
        $wp_customize->selective_refresh->add_partial( 'custom_logo', array(
    		'selector'        => '.site-branding',
    		'render_callback' => 'greenlight_customize_partial_branding'
    	));

    }



}
add_action( 'customize_register', 'greenlight_customize_register' );

/**
 * Enqueue assets for customizer.
 *
 * @action customize_controls_enqueue_scripts -- added in greenlight_customize_register()
 * @since 1.0.0
 */
function greenlight_customize_scripts() {

    wp_enqueue_script( 'greenlight-customize-controls', esc_url( get_template_directory_uri() . '/assets/js/customize-controls.js' ), array( 'jquery', 'customize-controls' ), GREENLIGHT_VERSION );
    wp_enqueue_style( 'greenlight-customize-controls', esc_url( get_template_directory_uri() . '/assets/css/customize-controls.css' ), array(), GREENLIGHT_VERSION );

}

/**
 * Display site title or logo in the header on a
 * customizer selective refresh.
 *
 * @since 1.0.0
 */
function greenlight_customize_partial_branding() {

    ob_start();

    get_template_part( 'template-parts/site', 'branding' );

    return ob_get_clean();

}


/**
 * Top bar items to create options.
 *
 * @since 1.0.0
 *
 * @return array Top bar items.
 */
function greenlight_get_top_bar_items() {

    /**
     * Filter top bar items.
     *
     * @since 1.0.0
     *
     * @var array
     */
    return apply_filters( 'greenlight_top_bar_items', array(
        'top_text' => array(
            'label'             => esc_html__( 'Top Bar Text', 'greenlight' ),
            'description'       => sprintf( esc_html__( 'Use any %s icon like %s.', 'greenlight' ), '<a href="http://fontawesome.io/icons/" target="_blank">FontAwesome</a>', '<code>%%icon_name%%</code>' ),
            'default'           => '%%phone%% 1-800-555-5555 %%envelope%% admin@yoursite.com',
            'type'              => 'textarea',
            'sanitize_callback' => 'greenlight_sanitize_html'
        ),
        'do_top_menu' => array(
            'label'             => esc_html__( 'Display top bar menu.', 'greenlight' ),
            'description'       => esc_html__( 'Uses "Top Menu" menu location.', 'greenlight' ),
            'default'           => 0
        ),
        'do_top_social' => array(
            'label'             => esc_html__( 'Display social menu in top bar.', 'greenlight' ),
            'description'       => esc_html__( 'Uses "Social Menu" menu location.', 'greenlight' ),
            'default'           => 1
        )
    ));
}

/**
 * Font types to create options.
 *
 * @since 1.0.0
 *
 * @return array Font types.
 */
function greenlight_get_font_types() {

    /**
     * Filter font types.
     *
     * @since 1.0.0
     *
     * @var array
     */
    return apply_filters( 'greenlight_font_types', array(
        'primary_font' => array(
            'label'         => esc_html__( 'Primary', 'greenlight' ),
            'description'   => esc_html__( 'Paragraphs, lists, links, quotes, and tables.', 'greenlight' ),
            'default'       => 'Lato - Light',
            'uppercase'     => NULL, // option won't exist
            'selector'      => "body,\nbutton,\ninput,\nselect,\ntextarea"
		),
        'heading_font' => array(
            'label'         => esc_html__( 'Headings', 'greenlight' ),
            'description'   => esc_html__( 'Post titles and header tags.', 'greenlight' ),
            'default'       => 'Hind - Semi-Bold',
            'uppercase'     => 0,
            'selector'      => "h1,\nh2,\nh3,\nh4,\nh5,\nh6"
		),
        'small_heading_font' => array(
            'label'         => esc_html__( 'Small Headings', 'greenlight' ),
            'description'   => esc_html__( 'Small headings, post meta, buttons, widget titles, form labels, and table headers.', 'greenlight' ),
            'default'       => 'Lato - Black',
            'uppercase'     => 1,
            'selector'      => ".widget-title,\n.entry-meta,\nlabel,\ntable th,\n.btn"
		),
        'menu_font' => array(
            'label'         => esc_html__( 'Main Menu', 'greenlight' ),
            'description'   => esc_html__( 'Main menu top-level items.', 'greenlight' ),
            'default'       => 'Hind - Bold',
            'uppercase'     => 1,
            'selector'      => ".site-menu > ul > li > a"
		),
        'header_media_font' => array(
            'label'         => esc_html__( 'Header Media', 'greenlight' ),
            'description'   => esc_html__( 'Titles on top of header media.', 'greenlight' ),
            'default'       => 'Hind - Bold',
            'uppercase'     => 1,
            'selector'      => ".site-header-media .entry-title"
		),
    ));

}

/**
 * Font selection options.
 *
 * @since 1.0.0
 *
 * @return array $fonts Fonts availble to be selected.
 */
function greenlight_get_fonts() {

    /**
     * Filter font choices.
     *
     * @since 1.0.0
     *
     * @var array
     */
    $fonts = apply_filters( 'greenlight_fonts', array(
        'None',
        'Architects Daughter - Regular',
        'Asap - Regular',
        'Asap - Bold',
        'Cabin - Regular',
        'Cabin - Medium',
        'Cabin - Semi-Bold',
        'Cabin - Bold',
        'Droid Sans - Regular',
        'Droid Sans - Bold',
        'Droid Serif - Regular',
        'Droid Serif - Bold',
        'Hind - Light',
        'Hind - Regular',
        'Hind - Medium',
        'Hind - Semi-Bold',
        'Hind - Bold',
        'Josefin Sans - Light',
        'Josefin Sans - Regular',
        'Josefin Sans - Semi-Bold',
        'Lato - Light',
        'Lato - Regular',
        'Lato - Bold',
        'Lato - Black',
        'Merriweather - Light',
        'Merriweather - Regular',
        'Merriweather - Bold',
        'Merriweather - Black',
        'Merriweather Sans - Light',
        'Merriweather Sans - Regular',
        'Merriweather Sans - Bold',
        'Merriweather Sans - Extra-Bold',
        'Montserrat - Regular',
        'Montserrat - Bold',
        'Open Sans - Light',
        'Open Sans - Regular',
        'Open Sans - Semi-Bold',
        'Open Sans - Bold',
        'Oswald - Light',
        'Oswald - Regular',
        'Oswald - Bold',
        'Playfair Display - Regular',
        'Playfair Display - Bold',
        'Playfair Display - Black',
        'PT Sans - Regulars',
        'PT Sans - Bold',
        'PT Serif - Regular',
        'PT Serif - Bold',
        'Raleway - Light',
        'Raleway - Regular',
        'Raleway - Medium',
        'Roboto - Light',
        'Roboto - Regular',
        'Roboto - Medium',
        'Roboto Slab - Thin',
        'Roboto Slab - Light',
        'Roboto Slab - Regular',
        'Roboto Slab - Bold',
        'Source Sans Pro - Light',
        'Source Sans Pro - Regular',
        'Source Sans Pro - Semi-Bold',
        'Source Serif Pro - Regular',
        'Source Serif Pro - Semi-Bold',
        'Source Serif Pro - Bold',
        'Ubuntu - Light',
        'Ubuntu - Regular',
        'Ubuntu - Medium',
        'Ubuntu - Bold'
    ));

    $fonts = array_unique( $fonts );

    // sort( $fonts );

    return $fonts;

}

/**
 * Color types to create options.
 *
 * @since 1.0.0
 *
 * @return array Color types.
 */
function greenlight_get_color_types() {

    /**
     * Filter color types.
     *
     * @since 1.0.0
     *
     * @var array
     */
    return apply_filters( 'greenlight_color_types', array(

        /**
         * Header
         */
        'top_bar_color' => array(
            'label'             => esc_html__( 'Top Bar Background', 'greenlight' ),
            'section'           => 'colors-top-bar',
            'default'           => '#182e30',
            'type'              => 'color',
            'transport'         => 'postMessage'
		),
        'top_bar_text' => array(
            'label'             => esc_html__( 'Top Bar Text', 'greenlight' ),
            'section'           => 'colors-top-bar',
            'default'           => '#ffffff',
            'type'              => 'color',
            'transport'         => 'postMessage'
		),
        'header_color' => array(
            'label'             => esc_html__( 'Header Background', 'greenlight' ),
            'section'           => 'colors-header',
            'default'           => '#26393d',
            'type'              => 'color',
            'transport'         => 'postMessage'
		),
        'menu_text' => array(
            'label'             => esc_html__( 'Header Text', 'greenlight' ),
            'section'           => 'colors-header',
            'default'           => '#ffffff',
            'type'              => 'color',
            'transport'         => 'postMessage'
		),
        'menu_dropdown_color' => array(
            'label'             => esc_html__( 'Main Menu Dropdowns', 'greenlight' ),
            'section'           => 'colors-header',
            'default'           => '#59928c',
            'type'              => 'color',
            'transport'         => 'postMessage'
		),
        'menu_dropdown_text' => array(
            'label'             => esc_html__( 'Main Menu Dropdown Text', 'greenlight' ),
            'section'           => 'colors-header',
            'default'           => '#ffffff',
            'type'              => 'color',
            'transport'         => 'postMessage'
		),
        'header_opacity' => array(
            'label'             => esc_html__( 'Header Opacity', 'greenlight' ),
            'description'       => esc_html__( 'Applies when header image is applied to current page.', 'greenlight' ),
            'section'           => 'colors-header',
            'default'           => '40',
            'type'              => 'range',
            'input_attrs'       => array(
                'min'  => 0,
                'max'  => 100,
                'step' => 1,
            ),
            'transport'         => 'postMessage',
            'sanitize_callback' => 'greenlight_sanitize_range'
		),

        /**
         * Buttons
         */
        'btn_color' => array(
            'label'             => esc_html__( 'Button Background', 'greenlight' ),
            'section'           => 'colors-buttons',
            'default'           => '#26393d',
            'type'              => 'color'
		),
        'btn_text' => array(
            'label'             => esc_html__( 'Button Text', 'greenlight' ),
            'section'           => 'colors-buttons',
            'default'           => '#ffffff',
            'type'              => 'color'
		),
        'btn_hover_color' => array(
            'label'             => esc_html__( 'Button Hover Background', 'greenlight' ),
            'section'           => 'colors-buttons',
            'default'           => '#59928c',
            'type'              => 'color'
		),
        'btn_hover_text' => array(
            'label'             => esc_html__( 'Button Hover Text', 'greenlight' ),
            'section'           => 'colors-buttons',
            'default'           => '#ffffff',
            'type'              => 'color'
		),

        /**
         * Content
         */
        'heading_text' => array(
            'label'             => esc_html__( 'Heading Text', 'greenlight' ),
            'description'       => esc_html__( 'Post titles, widget titles, form labels, table headers and buttons.', 'greenlight' ),
            'section'           => 'colors-content',
            'default'           => '#353535',
            'type'              => 'color'
		),
        'primary_text' => array(
            'label'             => esc_html__( 'Primary Text', 'greenlight' ),
            'description'       => esc_html__( 'Paragraphs, lists, menu links, quotes and tables.', 'greenlight' ),
            'section'           => 'colors-content',
            'default'           => '#252525',
            'type'              => 'color'
		),
        'secondary_text' => array(
            'label'             => esc_html__( 'Secondary Text', 'greenlight' ),
            'description'       => esc_html__( 'Post bylines, comment counts, post footers and quote footers.', 'greenlight' ),
            'section'           => 'colors-content',
            'default'           => '#686868',
            'type'              => 'color'
		),
        'link_color' => array(
            'label'             => esc_html__( 'Links', 'greenlight' ),
            'section'           => 'colors-content',
            'default'           => '#1abc9c',
            'type'              => 'color'
		),
        'link_hover_color' => array(
            'label'             => esc_html__( 'Link Hover', 'greenlight' ),
            'section'           => 'colors-content',
            'default'           => '#16a085',
            'type'              => 'color'
		),
        'content_color' => array(
            'label'             => esc_html__( 'Content Background', 'greenlight' ),
            'section'           => 'colors-content',
            'default'           => '#ffffff',
            'type'              => 'color'
		),

        /**
         * Footer
         */
        'footer_color' => array(
            'label'             => esc_html__( 'Footer Background', 'greenlight' ),
            'section'           => 'colors-footer',
            'default'           => '#59928c',
            'type'              => 'color'
		),
        'footer_text' => array(
            'label'             => esc_html__( 'Footer Text', 'greenlight' ),
            'section'           => 'colors-footer',
            'default'           => '#ffffff',
            'type'              => 'color'
		),
        'info_color' => array(
            'label'             => esc_html__( 'Site Info Background', 'greenlight' ),
            'section'           => 'colors-footer',
            'default'           => '#26393d',
            'type'              => 'color'
		),
        'info_text' => array(
            'label'             => esc_html__( 'Site Info Text', 'greenlight' ),
            'section'           => 'colors-footer',
            'default'           => '#ffffff',
            'type'              => 'color'
		)
    ));

}

/**
 * Layouts types to create options.
 *
 * @since 1.0.0
 *
 * @return array Layout types.
 */
function greenlight_get_layout_types() {

    /**
     * Filter layout types.
     *
     * Note: Except for the "default", array keys match
     * post type IDs. If a post type key exists, an overriding
     * meta box will get added when editing that post type.
     *
     * @since 1.0.0
     *
     * @var array
     */
    return apply_filters( 'greenlight_layout_types', array(
        'default' => array(
            'label'         => esc_html__( 'Website Default', 'greenlight' ),
            'default'       => 'sidebar-right'
		),
        'page' => array(
            'label'         => esc_html__( 'Pages', 'greenlight' ),
            'default'       => 'sidebar-right'
		),
        'post' => array(
            'label'         => esc_html__( 'Blog Posts', 'greenlight' ),
            'default'       => 'narrow'
		)
    ));

}

/**
 * Available sidebar layouts.
 *
 * @since 1.0.0
 *
 * @param bool $def Whether to include default selection
 * @return array Sidebar layouts.
 */
function greenlight_get_layouts( $def = false ) {

    $layouts = array(
        'default' => array(
            'label' => esc_html__( 'Default', 'greenlight' ),
            'img'   => esc_url( get_template_directory_uri() . '/assets/svg/layout-default.svg' )
        ),
        'sidebar-right' => array(
            'label' => esc_html__( 'Sidebar Right', 'greenlight' ),
            'img'   => esc_url( get_template_directory_uri() . '/assets/svg/layout-sidebar-right.svg' )
        ),
        'sidebar-left' => array(
            'label' => esc_html__( 'Sidebar Left', 'greenlight' ),
            'img'   => esc_url( get_template_directory_uri() . '/assets/svg/layout-sidebar-left.svg' )
        ),
        'narrow' => array(
            'label' => esc_html__( 'Narrow', 'greenlight' ),
            'img'   => esc_url( get_template_directory_uri() . '/assets/svg/layout-narrow.svg' )
        ),
        'wide' => array(
            'label' => esc_html__( 'Wide', 'greenlight' ),
            'img'   => esc_url( get_template_directory_uri() . '/assets/svg/layout-wide.svg' )
        )
    );

    if ( ! $def ) {

        unset( $layouts['default'] );

    }

    /**
     * Filter sidebar layouts.
     *
     * @since 1.0.0
     *
     * @var array
     */
    return apply_filters( 'greenlight_layouts', $layouts, $def );

}

/**
 * Header media options.
 *
 * @since 1.0.0
 *
 * @return array Header media options.
 */
function greenlight_get_header_media_options() {

    /**
     * Filter header media options.
     *
     * @since 1.0.0
     *
     * @var array
     */
    return apply_filters( 'greenlight_header_media_options', array(
        'header_media_title' => array(
            'label'             => esc_html__( 'Header Image Title', 'greenlight' ),
            'default'           => '',
            'type'              => 'textarea',
            'sanitize_callback' => 'greenlight_sanitize_html'
		),
        'header_media_tagline' => array(
            'label'             => esc_html__( 'Header Image Tagline', 'greenlight' ),
            'default'           => '',
            'type'              => 'textarea',
            'sanitize_callback' => 'greenlight_sanitize_html'
		),
        'header_media_use_text_on_blog_only' => array(
            'label'             => esc_html__( 'Use custom text from above on blog page only.', 'greenlight' ),
            'description'       => esc_html__( 'Note: When this box is checked, the theme will generate titles to overlay on header images when relevent, like with archives, 404 pages, etc.', 'greenlight' ),
            'default'           => 1,
            'type'              => 'checkbox',
            'sanitize_callback' => 'greenlight_sanitize_checkbox'
		),
        'header_media_on_archives_only' => array(
            'label'             => esc_html__( 'Apply default header image to blog and archives only.', 'greenlight' ),
            'description'       => esc_html__( 'Note: You can override custom header images for individual pages and posts when configuring their featured images.', 'greenlight' ),
            'default'           => 1,
            'type'              => 'checkbox',
            'sanitize_callback' => 'greenlight_sanitize_checkbox'
		),
        'header_media_fs' => array(
            'label'             => esc_html__( 'Use full-screen parallax effect.', 'greenlight' ),
            'default'           => 1,
            'type'              => 'checkbox',
            'sanitize_callback' => 'greenlight_sanitize_checkbox'
		)
    ));

}
