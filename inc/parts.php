<?php
/**
 * Small bits and parts.
 *
 * @package Greenlight
 * @since 1.0.0
 */

/**
 * Get scroll to section button
 *
 * @since 1.0.0
 *
 * @param array $to Selector to jump to
 */
function greenlight_get_scroll_to( $to = '#content' ) {

    $html  = sprintf( "<a href=\"%s\" title=\"%s\" class=\"greenlight-scroll-to\">\n", esc_attr( $to ), esc_html__( 'Scroll to Content', 'greenlight' ) );
    $html .= "\t<i class=\"fa fa-chevron-down\"></i>\n";
    $html .= "</a>\n";

    /**
	 * Filter the link to scroll down to the content or
     * other custom section.
	 *
	 * @since 1.0.0
     *
	 * @var string
	 */
	return apply_filters( 'greenlight_scroll_to', $html, $to );

}

/**
 * Display scroll to section button
 *
 * @since 1.0.0
 *
 * @param array $to Selector to jump to
 */
function greenlight_scroll_to( $args = array() ) {

	echo greenlight_get_scroll_to( $args );

}

/**
 * Get loader
 *
 * @since 2.5.0
 *
 * @return string $output Final content to output
 */
function greenlight_get_loader() {

    $html  = "<div class=\"greenlight-loader\">\n";
    $html .= "\t<span class=\"icon-1\"></span>\n";
    $html .= "\t<span class=\"icon-2\"></span>\n";
    $html .= "\t<span class=\"icon-3\"></span>\n";
    $html .= "</div>\n";

    /**
	 * Filter the loader icon markup.
	 *
	 * @since 1.0.0
     *
	 * @var string
	 */
    return apply_filters( 'greenlight_loader', $html );

}

/**
 * Display loader
 *
 * @since 2.5.0
 */
function greenlight_loader() {

	echo greenlight_get_loader();

}
