jQuery(document).ready(function($) {

    "use strict";

    var $controls = $('#customize-controls');

    // greenlight-grouped-control group-toggle group-trigger

    /**
     * Grouped Controls
     */

    // Toggle type recievers
    $controls.find('.greenlight-grouped-control.group-toggle.group-trigger').each( function() {

        var $control = $(this),
            $section = $control.closest('.control-section'),
            $input = $control.find('input'),
            id = $control.attr('id');

        $section.find('.greenlight-grouped-control.group-receiver').each( function(){

            var $control = $(this);

            if ( $input.is(':checked') ) {

                if ( $control.data('group-trigger') == id ) {
                    $control.show();
                }

            } else {

                if ( $control.data('group-trigger') == id ) {
                    $control.hide();
                }

            }

        });

    });

    $controls.find('.greenlight-grouped-control.group-toggle.group-trigger input').on( 'change', function() {

        var $input = $(this),
            $control = $input.closest('.customize-control'),
            $section = $control.closest('.control-section'),
            id = $control.attr('id');

        $section.find('.greenlight-grouped-control.group-receiver').each( function(){

            var $control = $(this);

            console.log( 'ID: ' + id );
            console.log( 'TRIGGER: ' + $control.data('group-trigger') );
            console.log( '----------' );

            if ( $input.is(':checked') ) {

                if ( $control.data('group-trigger') == id ) {
                    $control.show();
                }

            } else {

                if ( $control.data('group-trigger') == id ) {
                    $control.hide();
                }

            }

        });

    });

    /**
     * Radio Images
     */
    $controls.on( 'click', '.greenlight-radio-images input', function() {

        var $el = $(this);

        // Toggle "active" CSS class on <label>.
        $el.closest('.greenlight-radio-images').find('label').removeClass('active');
        $el.next('label').addClass('active');

        // Get the name of the setting.
        var setting = $el.attr( 'data-customize-setting-link' );

        // Get the value of the currently-checked radio input.
        var image = $el.val();

        // Add active class.
        $el.next('label').addClass('ui-state-active');

        // Set the new value.
        wp.customize( setting, function( obj ) {
            obj.set( image );
        });

    });

});
