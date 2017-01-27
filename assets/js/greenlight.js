jQuery(document).ready(function($) {

	"use strict";

    var $window = $(window),
		$header = $('#branding');

    // ---------------------------------------------------------
	// Site Search
	// ---------------------------------------------------------

    // Search toggle
    $('.header-search-toggle').on( 'click', function() {

        $header.addClass('search-animate-in');

        setTimeout( function() {

            $header.removeClass('search-animate-in').addClass('search-on').find('.search-input').focus();

        }, 200);

        return false;

    });

    $('.header-search .search-input').on( 'focusout', function() {

        $header.removeClass('search-on').addClass('search-animate-out');

        setTimeout( function() {

            $header.removeClass('search-animate-out');

        }, 200);

    });

	// ---------------------------------------------------------
	// Mobile Panel
	// ---------------------------------------------------------

	$('#top').find('.top-bar-text').clone().addClass('copy').appendTo( $('.site-header > .wrap') );
	$('#top').find('.social-menu').clone().addClass('copy').appendTo( $('.site-header > .wrap') );
	$('#branding').find('.top-bar-text > ul').removeClass('list-inline').addClass('list-unstyled');

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

	// ---------------------------------------------------------
	// Scroll To
	// ---------------------------------------------------------

	$('.greenlight-scroll-to').on( 'click', function(){

		var to = null,
			top = 0;

		if ( this.hash && this.hash != '#' ) {
			to = this.hash;
		} else {
			to = '#content';
		}

		top = $(to).offset().top;

		$('html, body').animate({
			scrollTop: top
		}, 800);

		return false;

	});

	// ---------------------------------------------------------
	// Parallax
	// ---------------------------------------------------------

	var $parallax = $('.greenlight-parallax .parallax-figure');

	$window.on( 'load', function() {

		$parallax.each( function() {

			var $el = $(this);

			greenlight_parallax( $el );

			$el.closest('.greenlight-parallax').addClass('on').find('.greenlight-loader').fadeOut();

		});

	});

	$window.on( 'scroll resize', function() {

		$parallax.each(function() {

			greenlight_parallax( $(this) );

		});

	});

	/**
	 * Apply parallax effect.
	 */
	function greenlight_parallax( $el ) {

		if ( $window.width() > 1100 && $window.height() > 500 ) {

			var $img				= $el.find('img'),
				img_height			= $img.height(),
				container_height	= ($el.height() > 0) ? $el.height() : 500,
				parallax_dist		= img_height - container_height,
				bottom				= $el.offset().top + container_height,
				top					= $el.offset().top,
				scroll_top			= $window.scrollTop(),
				window_height		= window.innerHeight,
				window_bottom		= scroll_top + window_height,
				percent_scrolled	= (window_bottom - top) / (container_height + window_height),
				parallax			= Math.round((parallax_dist * percent_scrolled));

			if ( (bottom > scroll_top) && (top < (scroll_top + window_height)) ) {

				$img.css('transform', "translate3D(-50%," + parallax + "px, 0)");

			}

		}

	}

});
