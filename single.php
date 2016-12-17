<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Greenlight
 * @since 1.0.0
 */

get_header(); ?>

<div id="primary" class="content-area single">

	<main id="main" class="site-main" role="main">

		<?php
		/**
		 * Fires just before The Loop.
		 *
		 * @since 1.0.0
		 * @hooked greenlight_add_archive_info - 10
		 */
		do_action( 'greenlight_content_before' );
		?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', get_post_format() ); ?>

			<?php if ( comments_open() || get_comments_number() ) : ?>

				<?php comments_template(); ?>

			<?php endif; ?>

		<?php endwhile; ?>

		<?php
		/**
		 * Fires just after The Loop.
		 *
		 * @since 1.0.0
		 */
		do_action( 'greenlight_content_after' );
		?>

	</main><!-- #main -->

</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
