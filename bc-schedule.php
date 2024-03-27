<?php
/*
 * 
 * Plugin Name: Schedule Manager
 * Description: Church Volunteer Schedule.
 * Version: 1.1.6
 * Author: Belinda Caylor
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

define( 'BC_SCHEDULE_PATH', plugin_dir_path( __FILE__ ) );
define( 'BC_SCHEDULE_URL', plugin_dir_url(__FILE__) );

require_once BC_SCHEDULE_PATH . '/src/database/api/routes.php';
require_once BC_SCHEDULE_PATH . 'admin-functions.php';

register_activation_hook(__FILE__, 'bc_schedule_create_tables');

function bc_schedule_create_tables() {
    require_once BC_SCHEDULE_PATH . '/src/database/table-setup.php';
}

/**
 * Enqueue scripts and styles for the admin area
 */
function bc_schedule_enqueue_admin_assets( $hook ) {
    // Enqueue the bundled JavaScript file
    wp_enqueue_script(
        'bc-schedule-admin-main',
        // BC_SCHEDULE_URL . 'dist/admin.js',
        BC_SCHEDULE_URL . 'dist/admin.min.js',
        array(),
        '1.0.0',
        true
    );

    // Enqueue the bundled CSS file
    $current_screen = get_current_screen();
    if ($current_screen->id === 'toplevel_page_volunteer-schedule') {
        wp_enqueue_style(
            'bc-schedule-admin-styles',
            // BC_SCHEDULE_URL . 'dist/stylesheet.css',
            BC_SCHEDULE_URL . 'dist/stylesheet.min.c43c4ed7d541ca047393.css',
            array(),
            '1.0.0'
        );
    }

    // Enqueue alpine.js
    wp_enqueue_script(
        'alpine-js', 
        'https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js', 
        // 'https://cdn.jsdelivr.net/npm/alpinejs@3.13.7/dist/alpine.min.js', 
        // array(), 
        null, 
        true
    );

}
add_action( 'admin_enqueue_scripts', 'bc_schedule_enqueue_admin_assets' );


/**
 * Enqueue scripts and styles for the front end
 */
function enqueue_bcs_frontend_scripts() {
    $bcs_frontend_data = array(
        'ajax_url' => admin_url('admin-ajax.php')
    );

    wp_enqueue_script('bcs-frontend', BC_SCHEDULE_URL . '/dist/frontend.js', array('jquery'), false, true);
    wp_localize_script('bcs-frontend', 'bcs_frontend_data', $bcs_frontend_data);
}
add_action('wp_enqueue_scripts', 'enqueue_bcs_frontend_scripts');