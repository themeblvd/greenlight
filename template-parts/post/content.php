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
     * @hooked
     */
    do_action( 'greenlight_post_content_start' );
    ?>

    <?php if ( ! is_single() || ! greenlight_has_header_thumb() ) : ?>

        <?php get_template_part( 'template-parts/post/post', 'title' ); ?>

        <?php get_template_part( 'template-parts/post/post', 'thumbnail' ); ?>

	<?php endif; ?>

    <?php if ( is_single() ) : ?>

		<?php get_template_part( 'template-parts/post/post', 'content' ); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/post/post', 'excerpt' ); ?>

	<?php endif; ?>

    <!-- @TODO POST FOOTER -->

    <?php
    /**
     * @hooked
     */
    do_action( 'greenlight_post_content_end' );
    ?>

</article><!-- #post-## -->
