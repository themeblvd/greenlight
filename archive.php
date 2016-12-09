<?php
/**
 * The template for displaying archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Greenlight
 * @since 1.0.0
 */
get_header(); ?>

<div id="primary" class="content-area archives">

	<main id="main" class="site-main" role="main">

		<?php
		/**
		 * @hooked greenlight_add_archive_info - 10
		 */
		do_action( 'greenlight_content_before' );
		?>

    	<?php if ( have_posts() ) : ?>

    		<?php while ( have_posts() ) : the_post(); ?>

    			<?php get_template_part( 'template-parts/content', get_post_format() ); ?>

    		<?php endwhile; ?>

    		<?php greenlight_paginate_links(); // wrapper for WP's paginate_links() ?>

    	<?php else : ?>

    		<?php get_template_part( 'template-parts/content', 'none' ); ?>

    	<?php endif; ?>

		<?php
		/**
		 * @hooked null
		 */
		do_action( 'greenlight_content_after' );
		?>

	</main><!-- #main -->

</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
