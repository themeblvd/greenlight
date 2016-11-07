<?php
/**
 * Template Hooks
 *
 * @package Greenlight
 * @since 1.0.0
 */

/**
 * Display site title or logo template in the header.
 *
 * @action greenlight_header
 * @since  1.0.0
 */
function greenlight_add_site_title() {

	get_template_part( 'template-parts/header/site', 'branding' );

}
add_action( 'greenlight_header', 'greenlight_add_site_title' );

/**
 * Display site menu template in the header.
 *
 * @action greenlight_header
 * @since  1.0.0
 */
function greenlight_add_site_menu() {

	get_template_part( 'template-parts/header/site', 'menu' );

}
add_action( 'greenlight_header', 'greenlight_add_site_menu', 20 );

/**
 * Display site menu within the menu template.
 *
 * @action greenlight_site_nav
 * @since  1.0.0
 */
function greenlight_add_site_nav() {

	if ( has_nav_menu( 'primary' ) ) {

		wp_nav_menu( apply_filters( 'greenlight_site_nav_args', array(
			'theme_location' => 'primary'
			// ... @TODO
		)));

	} else {

		wp_page_menu( apply_filters( 'greenlight_site_nav_fallback_args', array(
			'depth'     => 1, // Top-level only
			'show_home' => true,
		)));

	}

}
add_action( 'greenlight_site_nav', 'greenlight_add_site_nav' );
