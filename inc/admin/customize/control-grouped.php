<?php
/**
 * Customizer Control: Grouped Controls
 *
 * @package Greenlight
 * @since 1.0.0
 */
if ( class_exists( 'WP_Customize_Control' ) ) {

    class Greenlight_Customize_Control_Grouped extends WP_Customize_Control {

        /**
         * The grouping type for this control.
         * Can be "toggle" or "select".
         *
         * @since 1.0.0
         * @access public
         * @var string
         */
        public $group_type = 'toggle';

        /**
         * The role of the control within the group.
         * Can be "trigger" or "receiver".
         *
         * @since 1.0.0
         * @access public
         * @var string
         */
        public $group_role = 'receiver';

        /**
         * If $group_role == "receiver" -- The trigger
         * option's setting ID for this group.
         *
         * @since 1.0.0
         * @access public
         * @var string
         */
        public $group_trigger = '';

        /**
         * Setup the custom control.
         *
         * @since 1.0.0
         * @access public
         * @return void
         */
        public function __construct( $manager, $id, $args = array() ) {

            parent::__construct( $manager, $id, $args );

            if ( ! empty( $args['group-type'] ) ) {

                $this->group_type = $args['group-type'];

            }

            if ( ! empty( $args['group-role'] ) ) {

                $this->group_role = $args['group-role'];

            }

            if ( $this->group_role == 'receiver' && ! empty( $args['group-trigger'] ) ) {

                $this->group_trigger = $args['group-trigger'];

            }

        }

        /**
         * Renders the control wrapper and calls $this->render_content()
         * for the internals.
         *
         * @since 1.0.0
         * @access protected
         * @return void
         */
        protected function render() {

            $id = str_replace( array( '[', ']' ), array( '-', '' ), $this->id );

            $trigger = '';

            if ( $this->group_role == 'receiver' && ! empty( $this->group_trigger ) ) {

                $trigger = 'customize-control-' . $this->group_trigger;

            }

            $class = array(
                'customize-control',
                'customize-control-' . $this->type,
                'greenlight-grouped-control',
                'group-' . $this->group_type,
                'group-' . $this->group_role
            );

            /**
        	 * Filter the CSS classes added to a grouped control.
        	 *
        	 * @since 1.0.0
        	 *
             * @param WP_Customize_Control $this Current control object.
             *
        	 * @var array
        	 */
            $class = apply_filters( 'greenlight_grouped_control_class', $class, $this );

            ?><li id="customize-control-<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( implode( ' ', $class ) ); ?>" data-group-trigger="<?php echo esc_attr( $trigger ); ?>">
                <?php $this->render_content(); ?>
            </li><?php

        }

    } // end class Greenlight_Customize_Control_Grouped

} // end if class_exists( 'WP_Customize_Control' )
