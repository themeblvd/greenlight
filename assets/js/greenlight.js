jQuery(document).ready(function($) {

	"use strict";

    // ---------------------------------------------------------
	// Navigation
	// ---------------------------------------------------------

    // Mobile toggle
    $('.site-menu-toggle').on( 'click', function() {

        var $el = $(this),
            $menu = $('.site-menu-container');

        if ( $el.hasClass('close') ) { // closing menu

            $el.removeClass('close');
            $menu.removeClass('open').addClass('animate-out');

            setTimeout( function() {

				$menu.removeClass('animate-out');
                $menu.addClass('closed');

			}, 200);

        } else { // opening menu

            $el.addClass('close');
            $menu.removeClass('closed').addClass('animate-in');

            setTimeout( function() {

				$menu.removeClass('animate-in');
                $menu.addClass('open');

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

})(jQuery);
