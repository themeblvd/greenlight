<?php
/**
 * Custom menu functionality.
 *
 * @package Greenlight
 * @since 1.0.0
 */

/**
 * Add dropdown indicators to main menu.
 *
 * @filter walker_nav_menu_start_el
 * @since 1.0.0
 *
 * @param string $html Initial menu item like <a href="URL">Title</a>.
 * @param string $item Object for menu item post.
 * @param int    $depth Depth of the menu item, i.e 0 for top level, 1 for second level, etc.
 * @param array  $args Arguments for call to wp_nav_menu, NOT individiaul menu item.
 * @return string $item_output Modified menu item.
 */
function greenlight_primary_menu_icons( $html, $item, $depth, $args ) {

	if ( greenlight_primary_menu_location() !== $args->theme_location ) {

		return $html;

	}

	$parent = false;

	foreach ( $item->classes as $class ) {

		if ( 'menu-item-has-children' === $class ) {

			$parent = true;
			break;

		}
	}

	if ( $parent ) {

		if ( $depth > 0 ) {

			if ( is_rtl() ) {
				$icon = 'angle-left';
			} else {
				$icon = 'angle-right';
			}
		} else {

			$icon = 'angle-down';

		}

	    /**
	     * Filter the submenu indciator icon in main menu.
	     *
	     * @since 1.0.0
	     *
	     * @var str
	     */
		$icon = apply_filters( 'greenlight_sub_indicator', '<i class="sub-indicator fa fa-' . $icon . '"></i>', $item, $depth, $args );

		$html = str_replace( '</a>', $icon . '</a>', $html );

	}

	return $html;

}
add_filter( 'walker_nav_menu_start_el', 'greenlight_primary_menu_icons', 10, 4 );

/**
 * Add icon classes to social menu links.
 *
 * @filter nav_menu_link_attributes
 * @since 1.0.0
 *
 * @param array    $atts The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
 * @param WP_Post  $item The current menu item.
 * @param stdClass $args An object of wp_nav_menu() arguments.
 * @return array $atts The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
 */
function greenlight_social_menu_link_attribute( $atts, $item, $args ) {

	if ( 'social' !== $args->theme_location  ) {

		return $atts;

	}

	/**
	 * Filter the social networks to look for when
	 * building the social menu.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	$icons = apply_filters( 'greenlight_social_icons', array(
	    '500px'             => array( '500px.com' ),
	    'amazon'            => array( 'amazon.com', 'amazon.ca', 'amazon.fr', 'amazon.de', 'amazon.co.jp', 'amazon.co.uk' ),
	    'android'           => array( 'play.google.com' ),
	    'angellist'         => array( 'angel.co' ),
	    'bitbucket'         => array( 'bitbucket.org' ),
	    'behance'           => array( 'behance.net' ),
	    'buysellads'        => array( 'buysellads.com' ),
	    'codepen'           => array( 'codepen.io' ),
	    'delicious'         => array( 'del.icio.us' ),
	    'deviantart'        => array( 'deviantart.com' ),
	    'digg'              => array( 'digg.com' ),
	    'dribbble'          => array( 'dribbble.com' ),
	    'envelope'          => array( 'mailto:' ),
	    'etsy'              => array( 'etsy.com' ),
	    'facebook'          => array( 'facebook.com' ),
	    'flickr'            => array( 'flickr.com' ),
	    'foursquare'        => array( 'foursquare' ),
	    'github'            => array( 'github.com' ),
	    'google-plus'       => array( 'plus.google.com' ),
	    'gratipay'          => array( 'gratipay.com' ),
	    'houzz'             => array( 'houzz.com' ),
	    'imdb'              => array( 'imdb.com' ),
	    'instagram'         => array( 'instagram.com' ),
	    'jsfiddle'          => array( 'jsfiddle.net' ),
	    'lastfm'            => array( 'last.fm' ),
	    'leanpub'           => array( 'leanpub.com' ),
	    'linkedin'          => array( 'linkedin.com' ),
	    'meetup'            => array( 'meetup.com' ),
	    'paypal'            => array( 'paypal.com' ),
	    'pinterest'         => array( 'pinterest.com' ),
	    'reddit-alien'      => array( 'reddit.com' ),
	    'rss'               => array( '/feed', '?feed=' ),
	    'scribd'            => array( 'scribd.com' ),
	    'skype'             => array( 'skype.com' ),
	    'slack'             => array( 'slack.com' ),
	    'slideshare'        => array( 'slideshare.net' ),
	    'snapchat-ghost'    => array( 'snapchat.com' ),
	    'soundcloud'        => array( 'soundcloud.com' ),
	    'spotify'           => array( 'spotify.com' ),
	    'stack-exchange'    => array( 'stackexchange.com' ),
	    'stack-overflow'    => array( 'stackoverflow.com' ),
	    'stumbleupon'       => array( 'stumbleupon.com' ),
	    'tripadvisor'       => array( 'tripadvisor.com' ),
	    'tumblr'            => array( 'tumblr.com' ),
	    'twitch'            => array( 'twitch.tv' ),
	    'twitter'           => array( 'twitter.com' ),
	    'vimeo'             => array( 'vimeo.com' ),
	    'vine'              => array( 'vine.co' ),
	    'windows'           => array( 'microsoft.com', 'windows.com' ),
	    'wordpress'         => array( 'wordpress.org', 'wordpress.com' ),
	    'xing'              => array( 'xing.com' ),
	    'yahoo'             => array( 'yahoo.com' ),
	    'yelp'              => array( 'yelp.com' ),
		'youtube-play'      => array( 'youtube.com', 'youtu.be' ),
	));

	$icon = 'link';

	foreach ( $icons as $key => $urls ) {

		foreach ( $urls as $url ) {

			if ( strpos( $atts['href'], $url ) !== false ) {
				$icon = $key;
				break;
			}
		}

		if ( 'link' !== $icon ) {
			break;
		}
	}

	/**
	 * Filter class added to menu item.
	 *
	 * @since 1.0.0
	 *
	 * @var str
	 */
	$atts['class'] = apply_filters( 'greenlight_social_menu_link_class', 'fa fa-' . $icon, $atts, $icons );

	return $atts;

}
add_filter( 'nav_menu_link_attributes', 'greenlight_social_menu_link_attribute', 10, 3 );

/**
 * Add search icon to main menu.
 *
 * @filter wp_nav_menu_items
 * @since 1.0.0
 *
 * @param array    $items The HTML list content for the menu items.
 * @param stdClass $args An object containing wp_nav_menu() arguments.
 * @return array $items The HTML list content for the menu items.
 */
function greenlight_nav_search( $items, $args ) {

	if ( greenlight_primary_menu_location() !== $args->theme_location ) {

		return $items;

	}

	if ( ! greenlight_do_menu_search() ) {

		return $items;

	}

	$items .= '<li class="menu-item menu-item-search">';
	$items .= '<a href="#" class="header-search-toggle" title="' . esc_attr__( 'Search the site', 'greenlight' ) . '"><i class="fa fa-fw fa-search"></i></a>';
	$items .= '</li>';

	return $items;

}
add_filter( 'wp_nav_menu_items', 'greenlight_nav_search', 10, 2 );
