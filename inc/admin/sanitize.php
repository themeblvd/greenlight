<?php
/**
 * General custom santiization functions.
 *
 * @package Greenlight
 * @since 1.0.0
 */

function greenlight_kses( $input, $allowed = array() ) {

    global $allowedposttags;

    if ( ! $allowed ) {

        /**
         * Filter which HTML tags are allowed through
         * our standard usage of wp_kses().
         *
         * @since 1.0.0
         *
         * @var array
         */
        $allowed = apply_filters( 'greenlight_allowed_tags', $allowedposttags );

    }

    return wp_kses( $input, $allowed );

}

/**
 * Sanitize HTML.
 *
 * @since 1.0.0
 *
 * @param string $input Inputted text and/or HTML.
 * @return string $output Cleaned text and/or HTML/
 */
function greenlight_sanitize_html( $input ) {

    if ( current_user_can('unfiltered_html') ) {

    	$output = $input;

    } else {

        $output = greenlight_kses( $input, $allowedposttags );
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

    return ( absint( $input ) === 1 || $input === 'on' ) ? 1 : 0;

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
