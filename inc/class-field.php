<?php
/**
 * Abstract Field Class.
 *
 * @package CATCF\Fields
 */

namespace CATCF\Fields;

abstract class Field {

	/**
	 * Term id
	 * @var int
	 */
	protected $term_id = 0;
	/**
	 * Term meta slug
	 * @var string
	 */
	protected $term_meta = '';

	/**
	 * Field constructor.
	 * @param $term_id
	 * @param $term_meta
	 */
	public function __construct( $term_id, $term_meta ) {
		$this->term_id = $term_id;
		$this->term_meta = $term_meta;
	}

	/**
	 * Save term
	 * @return void
	 */
	public function save( $term_id ) {
		if ( ! current_user_can( 'edit_term', $term_id ) ) {
			return $term_id;
		}

		$wpnonce     = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
		$wpnonce_add = filter_input( INPUT_POST, '_wpnonce_add-tag', FILTER_SANITIZE_STRING );
		$action = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );

		if (
			! wp_verify_nonce( $wpnonce, "update-tag_$term_id" ) &&
			! wp_verify_nonce( $wpnonce_add, 'add-tag' )
		) {
			return;
		}

		if ( isset( $_POST[ 'cat-' . $this->term_meta ] ) ) {
			$value = $this->sanitize( $_POST[ 'cat-' . $this->term_meta ] );
		} else {
			return $term_id;
		}
		if ( $value ) {
			if ( 'add-tag' === $action ) {
				add_term_meta( $term_id, $this->term_meta, $value, true );
			} elseif ( 'editedtag' === $action ) {
				update_term_meta( $term_id, $this->term_meta, $value );
			}
		} else {
			delete_term_meta( $term_id, $this->term_meta );
		}
	}

	/**
	 * Sanitize field
	 * @param $term_id
	 * @return mixed
	 */
	abstract public function sanitize( $term_id );

	/**
	 * Get field value
	 * @return mixed
	 */
	public function get_value() {
		if ( $this->term_meta && $this->term_id ) {
			return get_term_meta( $this->term_id, $this->term_meta, true );
		}

		return '';
	}

	/**
	 * Display field
	 * @return void
	 */
	abstract public function display();
}
