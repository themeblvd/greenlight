<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Greenlight
 * @since 1.0.0
 */

get_header(); ?>

<div id="primary" class="content-area index">

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

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', get_post_format() ); ?>

			<?php endwhile; ?>

			<?php greenlight_paginate_links(); // Wrapper for WP's paginate_links(). ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

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
