<?php
/**
 * Customizer Control: Radio Images
 *
 * @package Greenlight
 * @since 1.0.0
 */

if ( class_exists( 'WP_Customize_Control' ) ) {

	/**
	 * Radio Images
	 *
	 * @package Greenlight
	 * @since 1.0.0
	 */
	class Greenlight_Customize_Control_Radio_Image extends WP_Customize_Control {

		/**
		 * The type of customize control being rendered.
		 *
		 * @since 1.0.0
		 * @access public
		 * @var string
		 */
		public $type = 'radio-image';

		/**
		 * Add custom JSON parameters to use in the JS template.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function to_json() {

			parent::to_json();

			$this->json['choices'] = $this->choices;
			$this->json['link'] = $this->get_link();
			$this->json['value'] = $this->value();
			$this->json['id'] = $this->id;

		}

		/**
		 * Underscore JS template to handle the control's output.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function content_template() {
			?>

			<# if ( ! data.choices ) {
				return;
			} #>

			<# if ( data.label ) { #>
				<span class="customize-control-title">{{ data.label }}</span>
			<# } #>

			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>

			<div class="greenlight-radio-images">

				<# for ( key in data.choices ) { #>

					<input type="radio" value="{{ key }}" name="_customize-{{ data.type }}-{{ data.id }}" id="{{ data.id }}-{{ key }}" {{{ data.link }}} <# if ( key === data.value ) { #> checked="checked" <# } #> />

					<label for="{{ data.id }}-{{ key }}" <# if ( key === data.value ) { #> class="active" <# } #>>
						<span class="screen-reader-text">{{ data.choices[ key ]['label'] }}</span>
						<img src="{{ data.choices[ key ]['img'] }}" alt="{{ data.choices[ key ]['label'] }}" />
					</label>

				<# } #>

			</div><!-- .greenlight-radio-images -->

			<?php
		}

	} // End class Greenlight_Customize_Control_Radio_Image.

} // End if class_exists( 'WP_Customize_Control' ).
