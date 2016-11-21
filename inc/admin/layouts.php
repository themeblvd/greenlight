<?php
/**
 * Custom Layouts functionality.
 *
 * @package Greenlight
 * @since 1.0.0
 */
class Greenlight_Layouts {

    /**
	 * Array of custom layouts.
	 *
	 * @var array
	 */
	protected $layouts = array();

    /**
	 * Default layout key.
	 *
	 * @var string
	 */
	protected $default = 'two-column-default';

    /**
	 * Class constructor.
	 */
	public function __construct() {

        /**
		 * Filter the registered layouts.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		$this->layouts = apply_filters( 'greenlight_layouts', array(
			'one-column-wide'       => esc_html__( 'One Column: Wide', 'greenlight' ),
			'one-column-narrow'     => esc_html__( 'One Column: Narrow', 'greenlight' ),
			'two-column-default'    => esc_html__( 'Two Columns: Content | Sidebar', 'greenlight' ),
			'two-column-reversed'   => esc_html__( 'Two Columns: Sidebar | Content', 'greenlight' )
		));

        if ( ! $this->layouts ) {
			return;
		}

        /**
		 * Filter the default layout.
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		$default = apply_filters( 'greenlight_default_layout', $this->default );

        if ( ! array_key_exists( $default, $this->layouts ) ) {
            $this->default = $default;
        } else {
            $this->default = key( $this->layouts );
        }


    }

}

$GLOBALS['greenlight_layouts'] = new Primer_Customizer_Layouts;
