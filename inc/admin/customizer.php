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

    /*
    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

    $wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector'        => '.site-branding',
        'render_callback' => 'greenlight_customize_partial_branding'
	));

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector'        => '.site-branding',
		'render_callback' => 'greenlight_customize_partial_branding'
	));
    */

    if ( isset( $wp_customize->selective_refresh ) ) { // backwards compat

        $wp_customize->selective_refresh->add_partial( 'custom_logo', array(
    		'selector'        => '.site-branding',
    		'render_callback' => 'greenlight_customize_partial_branding'
    	));

    }

    /**
     * Fonts
     */
    if ( $types = greenlight_get_font_types() ) {

        $wp_customize->add_section( 'fonts', array(
    		'title' => __( 'Fonts', 'greenlight' ),
    		'priority' => 50,
    	));

        foreach ( $types as $key => $args ) {

            $key = sanitize_key( $key );

            $wp_customize->add_setting( $key, array(
        		'default'           => $args['default'],
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

        foreach ( $types as $key => $args ) {

            $key = sanitize_key( $key );

            $wp_customize->add_setting( $key, array(
        		'default'           => $args['default'],
        		'sanitize_callback' => 'sanitize_hex_color'
        	));

            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, array(
                //'settings'      => $key,
                'label'         => ! empty( $args['label'] ) ? $args['label'] : null,
                'description'   => ! empty( $args['description'] ) ? $args['description'] : null,
                'section'       => ! empty( $args['section'] ) ? $args['section'] : 'colors',
                'priority'      => ! empty( $args['priority'] ) ? absint( $args['priority'] ) : null,
            )));

        }

    }

}
add_action( 'customize_register', 'greenlight_customize_register' );

/**
 * Display site title or logo in the header on a
 * customizer selective refresh.
 *
 * @since 1.0.0
 */
function greenlight_customize_partial_branding() {

    ob_start();

    get_template_part( 'template-parts/header/site', 'branding' );

    return ob_get_clean();
}

/**
 * Font types to create options.
 *
 * @since 1.0.0
 *
 * @return array Font types
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
            'description'   => esc_html__( 'Small headings, buttons, widget titles, form labels, and table headers.', 'greenlight' ),
            'default'       => 'Hind - Bold',
            'uppercase'     => 1,
            'selector'      => ".widget-title,\nlabel,\ntable th,\n.btn"
		),
        'menu_font' => array(
            'label'         => esc_html__( 'Main Menu', 'greenlight' ),
            'description'   => esc_html__( 'Main menu top-level items.', 'greenlight' ),
            'default'       => 'Hind - Bold',
            'uppercase'     => 1,
            'selector'      => ".site-menu > ul > li > a"
		)
    ));

}

/**
 * Font selection options.
 *
 * @since 1.0.0
 *
 * @return array Fonts availble to be selected
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

    sort( $fonts );

    return $fonts;

}

/**
 * Color types to create options.
 *
 * @since 1.0.0
 *
 * @return array Color types
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
        'primary_color' => array(
            'label'         => esc_html__( 'Primary', 'greenlight' ),
            'description'   => esc_html__( 'Header and site info.', 'greenlight' ),
            'default'       => '#26393d'
		),
        'secondary_color' => array(
            'label'         => esc_html__( 'Secondary', 'greenlight' ),
            'description'   => esc_html__( 'Main menu dropdowns and footer columns.', 'greenlight' ),
            'default'       => '#59928c'
		),
        'link_color' => array(
            'label'         => esc_html__( 'Links', 'greenlight' ),
            'description'   => esc_html__( 'Links in main content area.', 'greenlight' ),
            'default'       => '#1abc9c'
		),
        'link_hover_color' => array(
            'label'         => esc_html__( 'Link Hover', 'greenlight' ),
            'description'   => esc_html__( 'Links in main content area, when hovered or focused.', 'greenlight' ),
            'default'       => '#16a085'
		)
    ));

}

/**
 * Sanitize user font selection.
 *
 * @since 1.0.0
 *
 * @param string $font Selected font
 * @return string $font Selected font, if valid
 */
function greenlight_sanitize_font( $font ) {

    if ( ! in_array( $font, greenlight_get_fonts() ) ) {
        return '';
    }

    return $font;

}

/**
 * Sanitize checkbox.
 *
 * @since 1.0.0
 *
 * @param string $input Passed value
 * @return string $output Sanitized value
 */
function greenlight_sanitize_checkbox( $input ) {

    return ( 1 === absint( $input ) ) ? 1 : 0;

    return $input; // ...

}
