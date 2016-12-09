<?php
/**
* Displays the footer widget areas.
*
* @package Greenlight
* @since 1.0.0
*/
$count = 1;
?>

<?php if ( $sidebars = greenlight_get_active_footer_sidebars() ) : ?>

    <div class="footer-widget-area row columns-<?php echo count( $sidebars ); ?>">

        <?php foreach ( $sidebars as $sidebar ) : ?>

            <div <?php greenlight_footer_col_class( $count ); ?>>

                <?php dynamic_sidebar( $sidebar ); ?>

            </div>

            <?php $count++; ?>

        <?php endforeach; ?>

    </div>

<?php endif; ?>
