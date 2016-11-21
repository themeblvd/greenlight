<?php
/**
 * WordPress backwards compatibility.
 *
 * Prevents Greenlight from running on older WordPress versions since
 * this theme is not meant to be backward compatible beyond two
 * major versions and relies on many newer functions and markup.
 *
 * @package Greenlight
 * @since 1.0.0
 */

/**
 * Switch to the default theme immediately.
 *
 * @since 1.0.0
 */
function greenlight_switch_theme() {

	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );

	unset( $_GET['activated'] );

	add_action( 'admin_notices', 'greenlight_upgrade_notice' );

}
add_action( 'after_setup_theme', 'greenlight_switch_theme', 1 );

/**
 * Return the required WordPress version upgrade message.
 *
 * @since 1.0.0
 *
 * @return string
 */
function greenlight_get_wp_upgrade_message() {

	/**
	 * Filter the required WordPress version upgrade message.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	return (string) apply_filters( 'greenlight_required_wp_version_message',
		sprintf(
			__( 'Greenlight requires at least WordPress version %1$s. You are running version %2$s. Please upgrade and try again.', 'greenlight' ),
			GREENLIGHT_MIN_WP_VERSION,
			get_bloginfo( 'version' )
		)
	);

}

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to
 * activate Greenlight on older WordPress versions.
 *
 * @since 1.0.0
 */
function greenlight_upgrade_notice() {

	printf( '<div class="error"><p>%s</p></div>', greenlight_get_wp_upgrade_message() );

}

/**
 * Prevents the Customizer from being loaded on older WordPress versions.
 *
 * @action load-customize.php
 * @since  1.0.0
 */
function greenlight_customize() {

	wp_die( greenlight_get_wp_upgrade_message(), '', array( 'back_link' => true ) );

}
add_action( 'load-customize.php', 'greenlight_customize' );

/**
 * Prevents the Theme Preview from being loaded on older WordPress versions.
 *
 * @action template_redirect
 * @since  1.0.0
 */
function greenlight_preview() {

	if ( isset( $_GET['preview'] ) ) {

		wp_die( greenlight_get_wp_upgrade_message() );

	}

}
add_action( 'template_redirect', 'greenlight_preview' );
