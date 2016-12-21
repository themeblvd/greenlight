<?php
/**
 * Template Hooks
 *
 * @package Greenlight
 * @since 1.0.0
 */

/**
 * Display top bar above header.
 *
 * @action greenlight_header_before
 * @since 1.0.0
 */
function greenlight_add_top_bar() {

	get_template_part( 'template-parts/top', 'bar' );

}
add_action( 'greenlight_header_before', 'greenlight_add_top_bar' );

/**
 * Display site title or logo template in the header.
 *
 * @action greenlight_header
 * @since 1.0.0
 */
function greenlight_add_header_branding() {

	get_template_part( 'template-parts/header', 'branding' );

}
add_action( 'greenlight_header', 'greenlight_add_header_branding' );

/**
 * Display header search, displayed from icon added to
 * main navigation.
 *
 * @action greenlight_header
 * @since 1.0.0
 */
function greenlight_add_header_search() {

	get_template_part( 'template-parts/header', 'search' );

}
add_action( 'greenlight_header', 'greenlight_add_header_search', 20 );

/**
 * Display site menu template in the header.
 *
 * @action greenlight_header
 * @since 1.0.0
 */
function greenlight_add_header_menu() {

	get_template_part( 'template-parts/header', 'menu' );

}
add_action( 'greenlight_header', 'greenlight_add_header_menu', 30 );

/**
 * Display site menu within the menu template.
 *
 * @action greenlight_header_nav
 * @since 1.0.0
 */
function greenlight_add_header_nav() {

	if ( has_nav_menu( greenlight_primary_menu_location() ) ) {

		/**
		 * Filter arguments used for main menu.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		wp_nav_menu( apply_filters( 'greenlight_header_nav_args', array(
			'theme_location'	=> greenlight_primary_menu_location(),
			'container'			=> 'ul',
			'depth'     		=> 3,
		)));

	} else {

		/**
		 * Filter arguments used for main menu fallback.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		wp_page_menu( apply_filters( 'greenlight_header_nav_fallback_args', array(
			'container'			=> 'ul',
			'depth'     		=> 1, // Top-level only.
			'show_home' 		=> true,
			'before'			=> '',
			'after'				=> '',
		)));

	}

}
add_action( 'greenlight_header_nav', 'greenlight_add_header_nav' );

/**
 * Display social menu in footer.
 *
 * @action greenlight_site_info
 * @since 1.0.0
 */
function greenlight_add_social_menu() {

	get_template_part( 'template-parts/social', 'menu' );

}
add_action( 'greenlight_site_info', 'greenlight_add_social_menu' );

/**
 * Display header media or header thumbnail.
 *
 * @action greenlight_header_after
 * @since 1.0.0
 */
function greenlight_add_header_media() {

	if ( greenlight_has_header_thumb() || greenlight_has_header_media() ) {

		if ( have_posts() ) {
			while ( have_posts() ) {

				the_post();

				if ( greenlight_has_header_thumb() ) {

					get_template_part( 'template-parts/header', 'thumb' );

				} elseif ( greenlight_has_header_media() ) {

					get_template_part( 'template-parts/header', 'media' );

				}

				break; // 1st post only.

			}
		}

		rewind_posts();

	}

}
add_action( 'greenlight_header_after', 'greenlight_add_header_media' );

/**
 * Display title on archives, 404's,
 * and search results.
 *
 * @action greenlight_content_before
 * @since 1.0.0
 */
function greenlight_add_archive_info() {

	if ( is_archive() || is_404() || is_search() ) {

		get_template_part( 'template-parts/archive', 'info' );

	}

}
add_action( 'greenlight_content_before', 'greenlight_add_archive_info', 10 );

/**
 * Display widget area columns in footer.
 *
 * @action greenlight_footer
 * @since 1.0.0
 */
function greenlight_add_footer_widgets() {

	get_template_part( 'template-parts/footer', 'widgets' );

}
add_action( 'greenlight_footer', 'greenlight_add_footer_widgets' );

/**
 * Display site info after the footer.
 *
 * @action greenlight_after_footer
 * @since 1.0.0
 */
function greenlight_add_footer_info() {

	get_template_part( 'template-parts/footer', 'info' );

}
add_action( 'greenlight_footer_after', 'greenlight_add_footer_info' );

/**
 * Display social menu in footer.
 *
 * @action greenlight_site_info
 * @since 1.0.0
 */
function greenlight_add_footer_credit() {

	get_template_part( 'template-parts/footer', 'credit' );

}
add_action( 'greenlight_site_info', 'greenlight_add_footer_credit', 20 );

/**
 * Display social menu in footer.
 *
 * @action greenlight_site_info
 * @since  1.0.0
 */
function greenlight_add_footer_menu() {

	get_template_part( 'template-parts/footer', 'menu' );

}
add_action( 'greenlight_site_info', 'greenlight_add_footer_menu', 30 );
