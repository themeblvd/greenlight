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
    $font_types = greenlight_get_font_types();
    $fonts = greenlight_get_fonts();

    if ( $font_types && $fonts ) {

        $wp_customize->add_section( 'fonts', array(
    		'title' => __( 'Fonts', 'greenlight' ),
    		'priority' => 50,
    	));

        foreach ( $font_types as $key => $args ) {

            $key = sanitize_key( $key );

            $wp_customize->add_setting( $key, array(
        		'default'           => $args['default'],
        		'sanitize_callback' => 'greenlight_sanitize_font'
        	));

            $font_names = array();

            foreach ( $fonts as $name ) {

                if ( $name == $args['default'] ) {
                    $name = sprintf( '%s (%s)', $name, esc_html( 'Default', 'greenlight' ) );
                }

                $font_names[] = $name;
            }

            $fonts = array_combine( $fonts, $font_names );

            $wp_customize->add_control( $key, array(
        		'label'       => ! empty( $args['label'] ) ? $args['label'] : $name,
				'description' => ! empty( $args['description'] ) ? $args['description'] : null,
				'section'     => ! empty( $args['section'] ) ? $args['section'] : 'fonts',
				'priority'    => ! empty( $args['priority'] ) ? absint( $args['priority'] ) : null,
				'type'        => ! empty( $args['type'] ) ? $args['type'] : 'select',
				'choices'     => $fonts,
        	));

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
        'primary_font'          => array(
            'label'         => esc_html__( 'Primary', 'greenlight' ),
            'description'   => esc_html__( 'Paragraphs, lists, links, quotes, and tables.', 'greenlight' ),
            'default'       => 'Lato - Light',
            'selector'      => "body"
		),
        'heading_font'          => array(
            'label'         => esc_html__( 'Headings', 'greenlight' ),
            'description'   => esc_html__( 'Post titles and header tags.', 'greenlight' ),
            'default'       => 'Hind - Semi-Bold',
            'selector'      => "h1,\nh2,\nh3,\nh4,\nh5,\nh6"
		),
        'small_heading_font'    => array(
            'label'         => esc_html__( 'Small Headings', 'greenlight' ),
            'description'   => esc_html__( 'Small headings, widget titles, form labels, and table headers.', 'greenlight' ),
            'default'       => 'Lato - Bold',
            'selector'      => ".widget-title,\nlabel,\ttable th"
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

    return $fonts;

    return sort( array_unique( $fonts ) );

}

/**
 * Sanitize user font selection.
 *
 * @since 1.0.0
 *
 * @param str $font Selected font
 * @return str $font Selected font, if valid
 */
function greenlight_sanitize_font( $font ) {

    if ( ! in_array( $font, greenlight_get_fonts() ) ) {
        return '';
    }

    return $font;

}
