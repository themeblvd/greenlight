<section class="no-results not-found">

    <header class="page-header">

    	<h1 class="page-title"><?php _e( 'Nothing Found', 'greenlight' ); ?></h1>

    </header><!-- .page-header -->

	<div class="page-content">

        <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

            <?php
            printf(
				esc_html_x( 'Ready to publish your first post? %s.', 'link to write a new post', 'greenlight' ),
				sprintf(
					'<a href="%s">%s</a>',
					esc_url( admin_url( 'post-new.php' ) ),
					esc_html__( 'Get started here', 'primer' )
				)
			);
            ?>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'greenlight' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'greenlight' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>

	</div><!-- .page-content -->

</section><!-- .no-results -->
