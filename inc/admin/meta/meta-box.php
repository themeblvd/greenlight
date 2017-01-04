<?php
/**
 * Greenlight meta box system.
 *
 * @package Greenlight
 * @since 1.0.0
 */

/**
 * Adds meta boxes through WP's built-in add_meta_box
 * functionality.
 *
 * @package Greenlight
 * @since 1.0.0
 */
class Greenlight_Meta_Box {

	/**
	 * Arguments to pass to add_meta_box().
	 *
	 * @since 1.0.0
	 * @access private
	 * @var array
	 */
	private $args;

	/**
	 * Settings for meta box.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var array
	 */
	private $settings;

	/**
	 * Constructor. Hook in meta box to start the process.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Setup array for meta box.
	 * @param array $settings Settings for meta box.
	 * @return void
	 */
	public function __construct( $args, $settings ) {

		$this->settings = $settings;

		if ( ! $this->settings || ! is_array( $this->settings ) ) {

        	return;

		}

		$this->args = wp_parse_args( $args, array(
			'post_type' => array( 'post' ),   // array of post types to display meta box.
			'title'     => '',              // Title of meta box.
			'context'   => 'normal',        // normal, advanced, or side.
			'priority'  => 'default',       // high, low, default.
		));

		add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
		add_action( 'add_meta_boxes', array( $this, 'add' ) );
		add_action( 'save_post', array( $this, 'save' ) );

	}

	/**
	 * Enqueue assets needed for meta box.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function assets() {

		$screen = get_current_screen();
		$suffix = SCRIPT_DEBUG ? '' : '.min';

		if ( 'post' === $screen->base && in_array( $screen->post_type, $this->args['post_type'], true ) ) {

			$rtl = is_rtl() ? '-rtl' : '';

			wp_enqueue_style(
				'greenlight-meta-box',
				esc_url( get_template_directory_uri() . "/assets/css/meta-box{$rtl}.css" ),
				array(),
				GREENLIGHT_VERSION
			);

			wp_enqueue_script(
				'greenlight-meta-box',
				esc_url( get_template_directory_uri() . "/assets/js/meta-box{$suffix}.js" ),
				array( 'jquery' ),
				GREENLIGHT_VERSION
			);

		}

	}

	/**
	 * Add meta box by calling add_meta_box().
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function add() {

		foreach ( $this->args['post_type'] as $type ) {

			add_meta_box(
		        $this->args['id'],
				$this->args['title'],
				array( $this, 'display' ),
				$type,
				$this->args['context'],
				$this->args['priority']
		    );

		}

	}

	/**
	 * Display meta box. This is the callback function
	 * passed into add_meta_box().
	 *
	 * @global $post
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function display() {

		global $post;

		printf( '<div class="greenlight-meta-box %s">', $this->args['context'] ); // WPCS: XSS ok, sanitization ok.

		wp_nonce_field( 'greenlight_save_meta_box', 'greenlight_meta_box' );

		foreach ( $this->settings as $key => $setting ) {

			$key = sanitize_key( $key );

			$val = get_post_meta( $post->ID, $key, true );

			if ( '' === $val && ! empty( $setting['default'] ) ) {

				$val = $setting['default'];

			}

			$val = call_user_func( $setting['sanitize_callback'], $val );

			printf( '<div class="setting type-%s">', $setting['type'] ); // WPCS: XSS ok, sanitization ok.

			if ( ! empty( $setting['label'] ) && 'checkbox' !== $setting['type'] ) {

				printf( '<label for="%s" class="title">%s</label>', $key, $setting['label'] ); // WPCS: XSS ok, sanitization ok.

			}

			echo '<div class="control">';

			switch ( $setting['type'] ) {

				case 'text' :

					printf( '<input name="%1$s" class="greenlight-text" type="text" id="%1$s" value="%2$s">', $key, $val ); // WPCS: XSS ok, sanitization ok.

					break;

				case 'select' :

					printf( '<select name="%1$s" class="greenlight-select" id="%1$s">', $key ); // WPCS: XSS ok, sanitization ok.

					foreach ( $setting['choices'] as $choice => $name ) {

						$selected = $val === $choice ? 'selected' : '';

						printf( '<option value="%s" %s>%s</option>', $choice, $selected, $name ); // WPCS: XSS ok, sanitization ok.

					}

					echo '</select>';

					break;

				case 'checkbox' :

					$checked = 1 === $val ? 'checked' : '';

					printf( '<label for="%s" class="checkbox-label">', $key ); // WPCS: XSS ok, sanitization ok.
					printf( '<input name="%1$s" class="greenlight-checkbox" type="checkbox" id="%1$s" value="%2$s" %3$s> %4$s', $key, $val, $checked, $setting['description'] ); // WPCS: XSS ok, sanitization ok.
					echo '</label>';

					break;

				case 'radio-image' :

					if ( ! empty( $setting['choices'] ) ) {

						echo '<div class="greenlight-radio-images">';

						foreach ( $setting['choices'] as $choice_id => $choice ) {

							$checked = '';

							if ( $val === $choice_id ) {

								$checked = 'checked';

							}

							printf( '<input type="radio" id="%1$s-%2$s" name="%1$s" value="%2$s" %3$s />', $key, $choice_id, $checked ); // WPCS: XSS ok, sanitization ok.

							$class = '';

							if ( $val === $choice_id ) {

								$class = 'active';

							}

							printf( '<label for="%s" class="%s">', $key, $class ); // WPCS: XSS ok, sanitization ok.
							printf( '<span class="screen-reader-text">%s</span>', $choice['label'] ); // WPCS: XSS ok, sanitization ok.
							printf( '<img src="%s" alt="%s" data-choice="%s" />', $choice['img'], $choice['label'], $choice_id ); // WPCS: XSS ok, sanitization ok.
							echo '</label>';

						}

						echo '</div><!-- .greenlight-radio-images -->';

					}
			}

			echo '</div><!-- .control -->';

			if ( ! empty( $setting['description'] ) && 'checkbox' !== $setting['type'] ) {

				printf( '<div class="description">%s</div>', $setting['description'] ); // WPCS: XSS ok, sanitization ok.

			}

			echo '</div><!-- .setting -->';

		}

		echo '</div><!-- .greenlight-meta-box -->';

	}

	/**
	 * Save data for meta box.
	 *
	 * @global array $_POST
	 * @since 1.0.0
	 * @access public
	 *
	 * @param int $post_id ID of current post being saved.
	 * @return void
	 */
	public function save( $post_id ) {

		global $_POST; // WPCS: input var okay.

		if ( ! isset( $_POST['greenlight_meta_box'] ) || ! wp_verify_nonce( wp_unslash( $_POST['greenlight_meta_box'] ), 'greenlight_save_meta_box' ) ) { // WPCS: input var okay.

			return;

		}

		if ( empty( $this->settings ) ) {

			return;

		}

		$settings = $this->settings;

		foreach ( $settings as $key => $setting ) {

			if ( empty( $setting['sanitize_callback'] ) ) {

				continue;

			}

			$key = sanitize_key( $key );

			$val = '';

			if ( isset( $_POST[ $key ] ) ) { // WPCS: input var okay.

				$val = wp_unslash( $_POST[ $key ] ); // WPCS: input var okay.

			}

			$val = call_user_func( $setting['sanitize_callback'], $val );

			update_post_meta( $post_id, $key, $val );

		}

	}

}
