<?php
/**
 * The template for displaying the footer.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#footer-php
 *
 * @package Greenlight
 * @since 1.0.0
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

        <footer id="colophon" <?php greenlight_footer_class(); ?>>
			<div class="wrap clearfix">

                <?php
                /**
                 * @hooked greenlight_add_footer_widgets - 10
                 */
                do_action( 'greenlight_footer' );
                ?>

			</div><!-- .wrap -->
		</footer><!-- #colophon -->

        <?php
        /**
         * @hooked greenlight_add_footer_info - 10
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
