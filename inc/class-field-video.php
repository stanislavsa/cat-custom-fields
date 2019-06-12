<?php
/**
 * Video Field Class.
 *
 * @package CATCF\Fields
 */

namespace CATCF\Fields;

class Video extends Field {

	/**
	 * Video constructor.
	 * @param $term_id
	 * @param $term_meta
	 */
	public function __construct( $term_id, $term_meta ) {
		parent::__construct( $term_id, $term_meta );
	}

	/**
	 * Sanitize field
	 * @param $value
	 * @return string
	 */
	public function sanitize( $value ) {
		if (
			false === strpos( $value, 'youtube.com' )
			&& false === strpos( $value, 'youtu.be' )
			&& false === strpos( $value, 'vimeo.com' )
		) {
			$value = '';
		}
		return sanitize_text_field( $value );
	}

	/**
	 * Display field
	 * @return void
	 */
	public function display() {
		$meta_val = $this->get_value();
		$meta_key = $this->term_meta;
		$term_id = $this->term_id;
		include CAT_CF_DIR . '/templates/video.php';
	}
}
