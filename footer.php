<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#footer-php
 *
 * @package Greenlight
 * @since   1.0.0
 */
?>

                <?php
        		/**
        		 * @hooked
        		 */
        		do_action( 'greenlight_content_end' );
        		?>

            </div><!-- .wrap -->
        </div><!-- #content -->

        <?php
        /**
         * @hooked
         */
        do_action( 'greenlight_footer_before' );
        ?>

        <footer id="colophon" class="site-footer">
			<div class="wrap clearfix">

				<?php
        		/**
        		 * @hooked
        		 */
        		do_action( 'greenlight_footer' );
        		?>

			</div><!-- .wrap -->
		</footer><!-- #colophon -->

        <?php
        /**
         * @hooked
         */
        do_action( 'greenlight_footer_after' );
        ?>

    </div><!-- #container (end) -->
</div><!-- #wrapper (end) -->

<?php
/**
 * @hooked null
 */
do_action( 'greenlight_after' );
?>

<?php wp_footer(); ?>
</body>
</html>
