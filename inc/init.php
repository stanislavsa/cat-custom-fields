<?php
namespace CATCF;

use CATCF\Fields\Field_Object;

function init() {
	add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_textdomain' );
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\admin_enqueue_scripts' );

	add_action( 'category_add_form_fields', __NAMESPACE__ . '\\display', 30 );
	add_action( 'category_edit_form_fields', __NAMESPACE__ . '\\display', 30 );
	add_action( 'created_category', __NAMESPACE__ . '\\save' );
	add_action( 'edited_category', __NAMESPACE__ . '\\save' );

	add_filter( 'get_category', __NAMESPACE__ . '\\alter_category_description', 10, 2 );
}

/**
 * Load plugin textdomain.
 */
function load_textdomain() {
	load_plugin_textdomain( 'cat_cf', false, plugin_basename( dirname( __FILE__, 2 ) ) . '/languages' );
}

/**
 * Include scripts
 */
function admin_enqueue_scripts() {
	wp_enqueue_media();
	wp_enqueue_script( 'cat_cf_admin', CAT_CF_URI . 'assets/admin.js', array( 'jquery' ), false, true );
}

/**
 * Display fields
 * @param $term
 * @return void
 */
function display( $term ) {
	$term_id = isset( $term->term_id ) ? $term->term_id : 0;

	$fields = get_fields_objs( $term_id );

	ob_start();
	foreach ( $fields as $field ) {
		$field->display();
	}

	$fields_ouput = ob_get_clean();
	include_once CAT_CF_DIR . '/templates/template.php';
}

/**
 * Save term
 * @param $term_id
 * @return mixed
 */
function save( $term_id ) {
	$fields = get_fields_objs( $term_id );
	foreach ( $fields as $field ) {
		$field->save( $term_id );
	}
}

/**
 * Get fields objects
 * @param $term_id
 * @return array
 */
function get_fields_objs( $term_id ) {
	$fields = array(
		'image',
		'video',
	);
	$list = array();

	foreach ( $fields as $field ) {
		$field_obj = new Field_Object( $field, $term_id );
		if ( $field_obj->get_obj() ) {
			$list[] = $field_obj->get_obj();
		}
	}

	return $list;
}

/**
 * Add fields output on front end
 * @param $term
 * @param $taxonomy
 * @return mixed
 */
function alter_category_description( $term, $taxonomy ) {
	if ( is_admin() ) {
		return $term;
	}

	$fields = get_fields_objs( $term->term_id );
	if ( $fields ) {
		$extra = '';
		foreach ( $fields as $field ) {
			$val = $field->get_value();
			if ( $val ) {
				if ( false !== strpos( get_class( $field ), 'Image' ) ) {
					$extra .= '<img src="' . esc_attr( wp_get_attachment_url( $val ) ) . '" alt="" />';
				} elseif ( false !== strpos( get_class( $field ), 'Video' ) ) {
					$extra .= '<iframe src="' . esc_attr( $val ) . '" width="640" height="360" frameborder="0" allowfullscreen></iframe>';
				}
			}
		}

		if ( $extra ) {
			$extra .= '<br>';
			$term->description = $extra . $term->description;
		}
	}

	return $term;
}