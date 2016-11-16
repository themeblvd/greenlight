<?php
/**
 * Searchform template.
 *
 * @package Greenlight
 * @since 1.0.0
 */
?>


<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="searchform">

    <div class="search-wrap">

        <input type="search" class="search-input" name="s" placeholder="<?php esc_attr_e( 'Search the site...', 'greenlight' ); ?>" />

        <button class="search-submit btn-primary" type="submit">
			<i class="fa fa-search"></i>
		</button>

    </div>

</form>
