<?php
/**
 * Template part for displaying the post title inside The Loop.
 *
 * @package Greenlight
 * @since 1.0.0
 */
?>

<header class="entry-header">
    <div class="wrap">

        <?php
        /**
         * @hooked null
         */
        do_action( 'greenlight_post_title_before' );
        ?>

    	<?php if ( is_singular() ) : ?>

    		<h1 class="entry-title"><?php the_title(); ?></h1>

    	<?php else : ?>

    		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

    	<?php endif; ?>

        <?php get_template_part( 'template-parts/post/post', 'meta' ); ?>

    	<?php
        /**
         * @hooked null
         */
        do_action( 'greenlight_post_title_after' );
        ?>

    </div><!-- .wrap -->
</header><!-- .entry-header -->
