jQuery(document).ready(function($) {

    "use strict";

    var $controls = $('.greenlight-meta-box');

    /**
     * Radio Images
     */
    $controls.on( 'click', '.greenlight-radio-images img', function() {

        var $img = $(this);

        // Toggle "active" CSS class on <label>.
        $img.closest('.greenlight-radio-images').find('label').removeClass('active');
        $img.closest('label').addClass('active');

        // Set the new value.
        $img.closest('label').prev('input').prop('checked', true);

    });

    /**
     * Header thumbnail controls added to Featured
     * Image meta box.
     */
    $('#postimagediv .greenlight-trigger .greenlight-checkbox').on( 'click', function() {

        var $el = $(this);

        if ( $el.is(':checked') ) {

            $el.closest('.postbox').find('.greenlight-receiver').removeClass('greenlight-hide');

        } else {

            $el.closest('.postbox').find('.greenlight-receiver').addClass('greenlight-hide');

        }

    });

});
