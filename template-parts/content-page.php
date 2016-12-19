<?php
/**
 * The template part for displaying general content.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#content-slug-php
 *
 * @package Greenlight
 * @since 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/**
	 * Fires before inner content of page.
	 *
	 * @since 1.0.0
	 */
	do_action( 'greenlight_page_content_start' );
	?>

	<?php if ( ! greenlight_has_header_thumb() ) : ?>

		<?php get_template_part( 'template-parts/page', 'title' ); ?>

		<?php get_template_part( 'template-parts/page', 'thumbnail' ); ?>

	<?php endif; ?>

	<?php get_template_part( 'template-parts/page', 'content' ); ?>

	<?php
	/**
	 * Fires after inner content of page.
	 *
	 * @since 1.0.0
	 */
	do_action( 'greenlight_page_content_end' );
	?>

</article><!-- #post-## -->
