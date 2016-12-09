<?php
/**
 * Displays the header image for a single post or page,
 * when pulled from the featured image.
 *
 * Note: When a user has selected for the featured
 * image on a specific single post or page to display
 * as the header image, this file is used. Alternatively,
 * if the standard header image setup in the customizer
 * is displaying, it will use header-media.php.
 *
 * @package Greenlight
 * @since 1.0.0
 */

global $post;

?>

<div id="header-media" <?php greenlight_header_media_class(); ?>>

    <header class="entry-header">

        <?php if ( has_post_format('quote') ) : ?>

            <div class="featured-quote header-media-quote">
                <?php themeblvd_content_quote(); ?>
            </div>

        <?php else : ?>

            <h1 class="entry-title"><?php the_title(); ?></h1>

            <?php if ( is_single() ) : // posts only ?>

                <?php get_template_part( 'template-parts/post', 'meta' ); ?>

            <?php endif; ?>

        <?php endif; ?>

    </header><!-- .entry-header -->

    <?php if ( get_post_meta( $post->ID, '_greenlight_apply_header_thumb_fs', true ) ) : ?>

        <figure class="parallax-figure">

            <?php greenlight_loader(); ?>

            <?php greenlight_scroll_to( '#content' ); ?>

            <?php the_post_thumbnail( 'full' ); ?>

        </figure><!-- .parallax-figure -->

    <?php else : ?>

        <?php the_post_thumbnail( 'full' ); ?>

    <?php endif; ?>

</div><!-- #header-media -->
