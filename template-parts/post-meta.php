<?php
/**
 * Template part for displaying the post meta inside The Loop.
 *
 * @package Greenlight
 * @since 1.0.0
 */

?>

<div class="entry-meta">

	<i class="fa fa-clock-o"></i> <?php greenlight_the_time(); ?>

	<span class="sep">/</span>

	<i class="fa fa-user"></i> <?php greenlight_the_author(); ?>

	<span class="sep">/</span>

	<i class="fa fa-folder"></i> <?php greenlight_the_category(); ?>

	<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>

		<span class="sep">/</span>

		<i class="fa fa-comment"></i>

		<span class="comments">

			<?php
			comments_popup_link(
				'<span class="no-comments">' . esc_html__( 'Leave a Comment', 'greenlight' ) . '</span>',
				esc_html__( '1 Comment', 'greenlight' ) . '</span>',
				esc_html_x( '% Comments', 'number of comments', 'greenlight' ) . '</span>'
			);
			?>

		</span>

	<?php endif; ?>

</div><!-- .entry-meta -->
