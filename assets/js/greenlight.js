jQuery(document).ready(function($) {

	"use strict";

    var $header = $('#branding');

    // ---------------------------------------------------------
	// Site Search
	// ---------------------------------------------------------

    // Search toggle
    $('.site-search-toggle').on( 'click', function() {

        $header.addClass('search-animate-in');

        setTimeout( function() {

            $header.removeClass('search-animate-in').addClass('search-on').find('.search-input').focus();

        }, 200);

        return false;

    });

    $('.site-search .search-input').on( 'focusout', function() {

        $header.removeClass('search-on').addClass('search-animate-out');

        setTimeout( function() {

            $header.removeClass('search-animate-out');

        }, 200);

    });

    // ---------------------------------------------------------
	// Navigation
	// ---------------------------------------------------------

    // Mobile toggle
    $('.site-menu-toggle').on( 'click', function() {

        var $el = $(this);

        if ( $el.hasClass('close') ) { // closing menu

            $el.removeClass('close');
            $header.removeClass('mobile-menu-on').addClass('mobile-menu-animate-out');

            setTimeout( function() {

				$header.removeClass('mobile-menu-animate-out');

			}, 200);

        } else { // opening menu

            $el.addClass('close');
            $header.addClass('mobile-menu-animate-in');

            setTimeout( function() {

				$header.removeClass('mobile-menu-animate-in');
                $header.addClass('mobile-menu-on');

			}, 200);

        }

        return false;

    });

    // No-click menu items
	$('li.no-click').find('a:first').on( 'click', function(){
		return false;
	});

	$('a.no-click').on( 'click', function(){
		return false;
	});

});
