<?php
/**
 * The template part for displaying the title
 * of archives, 404, and search results.
 *
 * @package Greenlight
 * @since 1.0.0
 */

?>

<div class="archive-info">

	<h1 class="archive-title"><?php greenlight_the_archive_title(); ?></h1>

	<?php if ( $desc = greenlight_the_archive_desc( false ) ) : ?>

		<div class="archive-description">

			<?php echo greenlight_kses( $desc ); // WPCS: XSS ok, sanitization ok. ?>

		</div><!-- archive-description -->

	<?php endif; ?>

</div><!-- .archive-title -->
