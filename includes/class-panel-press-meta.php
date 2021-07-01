<?php
/**
 * The meta class.
 *
 * This is used to define the meta boxes for the plugin.
 *
 * @since      1.0.0
 * @package    Panel_Press
 * @subpackage Panel_Press/includes
 */
class Panel_Press_Meta {
	// private $config = '{"title":"Panel Press","description":"Meta boxes for panel press.","prefix":"panel_press_meta","domain":"panel-press","class_name":"Panel_Press_Meta","context":"advanced","priority":"default","cpt":"pp-comic","fields":[{"type":"media","label":"Collection Image","button-text":"Upload","return":"url","id":"panel_press_metacollection-image"}]}';
	private $config = [
		'screens' => 'pp-collection',
		'field' => 'pp-upload-image-field'
	];

	public function __construct() {
		$taxonomy = $this->config['screens'];
		add_action( "{$taxonomy}_add_form_fields", [ $this, 'add_meta_callback' ], 10, 2 );
		add_action( "created_{$taxonomy}_categories", [ $this, 'save_meta_callback' ] );
	}

	public function add_meta_callback() {
		echo '<div class="rwp-description">Meta boxes for panel press</div>';
		$this->fields_display();
	}

	private function fields_display()
		$term_meta = get_term_meta($term->term_id, 'term_image', true);
		
		?><div class="pp-form-field pp-term-group">
				<label for="">Upload and Image</label>
				<input type="text" name="pp-upload-image-field" id="pp-upload-image-field" value="">
				<input type="button" id="pp-upload-image-btn" class="button" value="Upload Image" />
		</div><?php
	}

	public function save_meta_callback( $term_id ) {
		if ( isset( $_POST[ 'pp-upload-image-field' ] ) ) {
			$sanitized = sanitize_text_field( $_POST[ 'pp-upload-image-field' ] );
			update_term_meta( $term_id, 'pp-collection-image', $sanitized, true );
		}
	}

	private function media_button( $field ) {
		printf(
			' <button class="button rwp-media-toggle" data-modal-button="%s" data-modal-title="%s" data-return="%s" id="%s_button" name="%s_button" type="button">%s</button>',
			isset( $field['modal-button'] ) ? $field['modal-button'] : __( 'Select this file', 'panel-press' ),
			isset( $field['modal-title'] ) ? $field['modal-title'] : __( 'Choose a file', 'panel-press' ),
			$field['return'],
			$field['id'], $field['id'],
			isset( $field['button-text'] ) ? $field['button-text'] : __( 'Upload', 'panel-press' )
		);
	}

	private function value( $field ) {
		global $post;
		if ( metadata_exists( 'post', $post->ID, $field['id'] ) ) {
			$value = get_post_meta( $post->ID, $field['id'], true );
		} else if ( isset( $field['default'] ) ) {
			$value = $field['default'];
		} else {
			return '';
		}
		return str_replace( '\u0027', "'", $value );
	}

}
new Panel_Press_Meta;