<?php
/*
 * 
 * Plugin Name: Schedule Manager
 * Description: Church Volunteer Schedule.
 * Version: 1.0
 * Author: Belinda Caylor
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

define( 'BC_SCHEDULE_PATH', plugin_dir_path( __FILE__ ) );

require_once BC_SCHEDULE_PATH . '/src/database/table-setup.php';
require_once BC_SCHEDULE_PATH . 'admin-functions.php';

/**
 * Registers the styles.
 */
// function enqueue_custom_admin_styles() {
//     wp_enqueue_style('admin-custom-css', get_template_directory_uri() . '/admin-style.css', array(), '1.0.0');
// }
// add_action('admin_enqueue_scripts', 'enqueue_custom_admin_styles');

$wpdb->show_errors();
