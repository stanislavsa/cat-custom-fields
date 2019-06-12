<?php
/**
 * Image Field Class.
 *
 * @package CATCF\Fields
 */

namespace CATCF\Fields;

class Image extends Field {

	/**
	 * Image constructor.
	 * @param $term_id
	 * @param $term_meta
	 */
	public function __construct( $term_id, $term_meta ) {
		parent::__construct( $term_id, $term_meta );
	}

	/**
	 * Sanitize field
	 * @param $value
	 * @return int
	 */
	public function sanitize( $value ) {
		return absint( $value );
	}

	/**
	 * Display field
	 * @return void
	 */
	public function display() {
		$meta_val = $this->get_value();
		$meta_key = $this->term_meta;
		$term_id = $this->term_id;
		include CAT_CF_DIR . '/templates/image.php';
	}
}
