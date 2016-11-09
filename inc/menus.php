<?php
/**
 * Custom menu functionality.
 *
 * @package Greenlight
 * @since 1.0.0
 */

/**
 * Add icon classes to social menu links.
 *
 * @filter nav_menu_link_attributes
 * @since 1.0.0
 */
function greenlight_social_menu_link_attribute( $atts, $item, $args ) {

    if ( $args->theme_location != 'social' ) {

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
        'youtube-play'      => array( 'youtube.com', 'youtu.be' )
    ));

    $icon = 'link';

    foreach ( $icons as $key => $urls ) {

        foreach ( $urls as $url ) {

            if ( strpos( $atts['href'], $url ) !== false ) {
                $icon = $key;
                break;
            }

        }

        if ( $icon != 'link' ) {
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
