<?php
/**
 * Plugin Name: Category Custom Fields
 * Plugin URI:  https://github.com/
 * Description: Adds custom fields to 'category' taxonomy.
 * Author:      Stanislav Samoilenko
 * Author URI:  https://github.com/
 * Version:     1.0.0
 * Domain Path: /languages
 * Text Domain: cat_cf
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define plugin URL constant
 */
if ( ! defined( 'CAT_CF_URI' ) ) {
	define( 'CAT_CF_URI', plugin_dir_url( __FILE__ ) );
}

/**
 * Define plugin DIR constant
 */
if ( ! defined( 'CAT_CF_DIR' ) ) {
	define( 'CAT_CF_DIR', __DIR__ );
}

include_once __DIR__ . '/inc/init.php';
include_once __DIR__ . '/inc/class-field.php';
include_once __DIR__ . '/inc/class-field-image.php';
include_once __DIR__ . '/inc/class-field-video.php';
include_once __DIR__ . '/inc/class-field-object.php';

\CATCF\init();
