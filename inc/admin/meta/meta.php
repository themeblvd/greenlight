<?php
/**
 * Meta Box implementation functions.
 *
 * @package Greenlight
 * @since 1.0.0
 */

/**
 * Add meta boxes.
 *
 * @since 1.0.0
 */
function greenlight_add_meta_boxes() {

    /**
     * Layout Meta Box
     */
    $GLOBALS['greenlight_layout_meta_box'] = new Greenlight_Meta_Box(

        /**
         * Filter arguments used to create
         * "Layout" meta box.
         *
         * @since 1.0.0
         *
         * @var array
         */
        apply_filters( 'greenlight_layout_meta_box_args', array(
            'id'        => 'greenlight-layout',
            'post_type' => array_merge( apply_filters( 'greenlight_apply_single_post_layout', array( 'post' ) ), array( 'page' ) ), // For more on greenlight_apply_single_post_layout filter, see greenlight_get_layout()
            'title'     => esc_html__( 'Layout', 'greenlight' ),
            'context'   => 'side',
            'priority'  => 'default'
        )),

        /**
         * Filter settings used in "Layout"
         * meta box.
         *
         * @since 1.0.0
         *
         * @var array
         */
        apply_filters( 'greenlight_layout_meta_box_settings', array(
            '_greenlight_layout' => array(
                'label'             => null,
                'description'       => esc_html__( 'Apply a custom sidebar layout to this post.', 'greenlight' ),
                'default'           => 'default',
                'type'              => 'radio-image',
                'choices'           => greenlight_get_layouts( true ), // Passing in TRUE adds "default" selection
                'sanitize_callback' => 'sanitize_key'
            )

        ))

    );

}
add_action( 'admin_init', 'greenlight_add_meta_boxes' );
