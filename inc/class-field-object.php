<?php
namespace CATCF\Fields;

/**
 * Class Field_Object
 * Check and define field object
 * @package CATCF\Fields
 */
class Field_Object {

	/**
	 * Field object
	 * @var null
	 */
	protected $obj = null;

	/**
	 * Field_Object constructor.
	 * @param $name
	 * @param $term_id
	 */
	public function __construct( $name, $term_id ) {
		$class_name = ucfirst( strtolower( $name ) );
		$class_name = __NAMESPACE__ . "\\{$class_name}";
		if ( class_exists( $class_name ) && is_a( $class_name, __NAMESPACE__ . '\\Field', true ) ) {
			$this->obj = new $class_name( $term_id, $name );
		}
	}

	/**
	 * Get field object
	 * @return null
	 */
	public function get_obj() {
		return $this->obj;
	}
}
