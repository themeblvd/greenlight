<?php
/**
 * Displays site-wide header image.
 *
 * Note: This file displays the header image that's
 * setup through the customizer. Alternatively, when a
 * user has selected for the featured image of a single
 * post or page to be used as the header image, that
 * is displayed with header-thumb.php.
 *
 * @package Greenlight
 * @since 1.0.0
 */

$title = get_theme_mod( 'header_media_title', get_bloginfo( 'blogname' ) ); // Set from Appearance > Customize > Blog Header Image.

if ( is_home() ) {

	$tagline = get_theme_mod( 'header_media_tagline', get_bloginfo( 'description' ) );

} else {

	$tagline = greenlight_the_archive_title( false );

}
?>

<div id="header-media" <?php greenlight_header_media_class(); ?>>

	<?php if ( $title || $tagline ) : ?>

		<header class="entry-header">

			<?php if ( $title ) : ?>

				<h1 class="entry-title"><?php echo greenlight_kses( $title ); // WPCS: XSS ok, sanitization ok. ?></h1>

			<?php endif; ?>

			<?php if ( $tagline ) : ?>

				<div class="entry-meta">

					<?php echo greenlight_kses( $tagline ); // WPCS: XSS ok, sanitization ok. ?>

				</div><!-- entry-meta -->

			<?php endif; ?>

		</header><!-- .entry-header -->

	<?php endif; ?>

	<?php if ( get_theme_mod( 'header_media_fs', 0 ) ) : ?>

		<figure class="parallax-figure">

			<?php greenlight_loader(); ?>

			<?php greenlight_scroll_to( '#content' ); ?>

			<?php the_header_image_tag(); ?>

		</figure><!-- .parallax-figure -->

	<?php else : ?>

		<?php the_header_image_tag(); ?>

	<?php endif; ?>

</div><!-- #header-media -->
