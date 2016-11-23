<?php
/**
 * General custom santiization functions.
 *
 * @package Greenlight
 * @since 1.0.0
 */

/**
 * Sanitize HTML.
 *
 * @since 1.0.0
 *
 * @param string $input Inputted text and/or HTML.
 * @return string $output Cleaned text and/or HTML/
 */
function greenlight_sanitize_html( $input ) {

    global $allowedposttags;

    if ( current_user_can('unfiltered_html') ) {

    	$output = $input;

    } else {

        $output = wp_kses( $input, $allowedposttags );
		$output = htmlspecialchars_decode( $output );

    }

	$output = str_replace( "\r\n", "\n", $output );

    return $output;

}

/**
 * Sanitize user font selection.
 *
 * @since 1.0.0
 *
 * @param string $font Selected font.
 * @return string $font Selected font, if valid.
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
 * @param string $input Passed value.
 * @return string Sanitized value.
 */
function greenlight_sanitize_checkbox( $input ) {

    return ( 1 === absint( $input ) ) ? 1 : 0;

}

/**
 * Sanitize range value.
 *
 * @since 1.0.0
 *
 * @param string|int $input Passed value.
 * @return int Sanitized value.
 */
function greenlight_sanitize_range( $input ) {

    return intval( $input );

}
