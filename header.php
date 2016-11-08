<?php
/**
 * The template for displaying the header.
 *
 * @package Greenlight
 * @since   1.0.0
 */
?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
/**
 * @hooked null
 */
do_action( 'greenlight_before' );
?>

<div id="wrapper">
	<div id="container">

		<?php
		/**
		 * @hooked null
		 */
		do_action( 'greenlight_header_before' );
		?>

		<header id="branding" <?php greenlight_header_class(); ?> role="banner">
			<div class="wrap clearfix">

				<?php
				/**
				 * @hooked greenlight_add_site_title - 10
				 * @hooked greenlight_add_site_menu - 20
				 */
				do_action( 'greenlight_header' );
				?>

			</div><!-- .wrap -->
		</header><!-- #branding -->

		<?php
		/**
		 * @hooked
		 */
		do_action( 'greenlight_header_after' );
		?>

		<div id="content" class="site-content">
			<div class="wrap clearfix">

	            <?php
	    		/**
	    		 * @hooked
	    		 */
	    		do_action( 'greenlight_content_start' );
	    		?>
