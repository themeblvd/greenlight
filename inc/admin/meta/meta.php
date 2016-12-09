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

/**
 * Add custom options to "Featured Image"
 * meta box.
 *
 * @since 1.0.0
 *
 * @param string $html HTML used to display featured image meta box
 * @param int $post_id ID of post being edited
 * @param int $thumbnail_id ID of featured image, if already applied
 * @return string $html Modified HTML used to display featured image meta box
 */
function greenlight_post_thumbnail_html( $html, $post_id, $thumbnail_id ) {

    $a = get_post_meta( $post_id, '_greenlight_apply_header_thumb', true ) == 1 ? 'checked' : '';
    $b = get_post_meta( $post_id, '_greenlight_apply_header_thumb_fs', true ) == 1 ? 'checked' : '';

    $html .= '<p class="meta-options">';

    /**
     * Whether to apply the header thumbnail.
     */

    $html .= '<label for="_greenlight_apply_header_thumb" class="checkbox-label greenlight-trigger">';

    $html .= sprintf(
        '<input name="_greenlight_apply_header_thumb" class="greenlight-checkbox" type="checkbox" id="_greenlight_apply_header_thumb" %s> %s',
        $a,
        esc_html__( 'Use as header image.', 'greenlight' )
    );

    $html .= '</label><br />';

    /**
     * If header thumbnail is applied, whether to use
     * full-screen parallax effect.
     */

    $class = 'checkbox-label greenlight-receiver';

    if ( ! $a ) { // based on previous option

        $class .= ' greenlight-hide';

    }

    $html .= sprintf( '<label for="_greenlight_apply_header_thumb_fs" class="%s">', $class );

    $html .= sprintf(
        '<input name="_greenlight_apply_header_thumb_fs" class="greenlight-checkbox" type="checkbox" id="_greenlight_apply_fs_epic" %s> %s',
        $b,
        esc_html__( 'Use full-screen parallax effect.', 'greenlight' )
    );

    $html .= '</label>';
    $html .= '</p>';


    return $html;

}
add_filter( 'admin_post_thumbnail_html', 'greenlight_post_thumbnail_html', 10, 3 );

/**
 * Save custom options with "Featured Image"
 * meta box.
 *
 * @global $_POST
 * @since 1.0.0
 *
 * @param int $post_ID ID of current post being saved
 */
function greenlight_post_thumbnail_save( $post_id ) {

    global $_POST;

    $val = 0;

    if ( isset( $_POST['_greenlight_apply_header_thumb'] ) ) {

        $val = greenlight_sanitize_checkbox( $_POST['_greenlight_apply_header_thumb'] );

    }

    update_post_meta( $post_id, '_greenlight_apply_header_thumb', $val );

    $val = 0;

    if ( isset( $_POST['_greenlight_apply_header_thumb_fs'] ) ) {

        $val = greenlight_sanitize_checkbox( $_POST['_greenlight_apply_header_thumb_fs'] );

    }

    update_post_meta( $post_id, '_greenlight_apply_header_thumb_fs', $val );

}
add_action( 'save_post', 'greenlight_post_thumbnail_save' );
