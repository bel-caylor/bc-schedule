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
require_once BC_SCHEDULE_PATH . '/src/database/api/routes.php';
require_once BC_SCHEDULE_PATH . 'admin-functions.php';

/**
 * Enqueue scripts and styles for the admin area
 */
function bc_schedule_enqueue_admin_assets( $hook ) {
    // Enqueue the bundled JavaScript file
    wp_enqueue_script(
        'bc-schedule-admin-main',
        plugin_dir_url( __FILE__ ) . 'dist/main.js',
        array(),
        filemtime( plugin_dir_path( __FILE__ ) . 'dist/main.js' ),
        true
    );

    // Enqueue alpine.js
    wp_enqueue_script(
        'alpine-js', 
        // 'https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js', 
        'https://cdn.jsdelivr.net/npm/alpinejs@3.13.7/dist/alpine.min.js', 
        // array(), 
        null, 
        true
    );

    // Enqueue the bundled CSS file
    wp_enqueue_style(
        'bc-schedule-admin-styles',
        plugin_dir_url( __FILE__ ) . 'dist/stylesheet.css',
        array(),
        filemtime( plugin_dir_path( __FILE__ ) . 'dist/stylesheet.css' )
    );
}
add_action( 'admin_enqueue_scripts', 'bc_schedule_enqueue_admin_assets' );
