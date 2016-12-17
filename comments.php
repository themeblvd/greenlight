<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#comments-php
 *
 * @package Greenlight
 * @since 1.0.0
 */

?>

<?php if ( greenlight_show_comments() ) : ?>

	<?php if ( post_password_required() ) : ?>

		<div id="comments" class="nopassword">

			<p><?php esc_html_e( 'This post is password protected. Enter the password to view any comments.', 'greenlight' ); ?></p>

		</div><!-- #comments  (end) -->

		<?php return; ?>

	<?php endif; ?>

	<div id="comments">

		<?php if ( have_comments() ) : ?>

			<!-- COMMENTS (start) -->

			<h2 id="comments-title">
				<?php
				printf(
					esc_html( _nx(
						'%1$d thought on %2$s',
						'%1$d thoughts on %2$s',
						get_comments_number(),
						'1. number of comments, 2. post title',
						'greenlight'
					)),
					esc_attr( number_format_i18n( get_comments_number() ) ),
					sprintf(
						'<span>&ldquo;%s&rdquo;</span>',
						get_the_title()
					)
				);
				?>
			</h2>

			<ol class="commentlist">
				<?php
				wp_list_comments( apply_filters( 'greenlight_comment_list', array(
					'avatar_size' 		=> 60,
					'style' 			=> 'ul',
					'type' 				=> 'all',
					'reply_text' 		=> esc_html__( 'Reply', 'greenlight' ),
					'login_text' 		=> esc_html__( 'Log in to Reply', 'greenlight' ),
					'callback' 			=> null,
					'reverse_top_level' => null,
					'reverse_children' 	=> false,
				)));
				?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>

				<nav id="comment-nav-below">

					<div class="nav-previous">
						<?php previous_comments_link( esc_html__( '&larr; Older Comments', 'greenlight' ) ); ?>
					</div>

					<div class="nav-next">
						<?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'greenlight' ) ); ?>
					</div>

				</nav>

			<?php endif; ?>

			<!-- COMMENTS (end) -->

		<?php endif; // End if has_comments(). ?>

		<?php if ( comments_open() ) : ?>

			<!-- COMMENT FORM (start) -->

			<div class="comment-form-wrapper">

				<div class="comment-form-inner">

					<?php comment_form(); ?>

				</div><!-- .comment-form-inner -->

			</div><!-- .comment-form-wrapper -->

			<!-- COMMENT FORM (end) -->

		<?php else : ?>

			<p class="nocomments">
				<?php esc_html_e( 'Comments are closed.', 'greenlight' ); ?>
			</p>

		<?php endif; ?>

	</div><!-- #comments -->

<?php endif; ?>
