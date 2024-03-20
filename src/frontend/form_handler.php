<?php
require_once BC_SCHEDULE_PATH . '/src/database/exclude-date-manager.php';
/**
 * Process the BCS form submission
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_action('init', 'bcs_create_custom_endpoint');

function bcs_create_custom_endpoint() {
  register_rest_route('bcs/v1', '/process-bcs-add-excluded-dates', array(
    'methods' => 'POST',
    'callback' => 'process_bcs_add_excluded_dates_callback',
    'permission_callback' => '__return_true', // Adjust permissions as needed
  ));
}

function process_bcs_add_excluded_dates_callback(WP_REST_Request $request) {
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true); // Decode JSON into an associative array
  
    // Access data from the decoded object
    $name = $data['name'];
    $email = $data['email'];
    $dates = $data['dates'];
  
    //  Check if user exists by email
    $user = get_user_by('email', $email);

    if ($user) {
        $user_id = $user->ID;
    } else {
        // Create user if not exists
        $user_data = array(
        'user_login' => $email, // Use email as username (adjust as needed)
        'user_email' => $email,
        'display_name' => $name,
        'user_nicename' => $name,
        'user_pass' => wp_generate_password(), // Generate random password
        );
        $user_id = wp_insert_user($user_data);

        if (is_wp_error($user_id)) {
            return new WP_REST_Response($user_id->get_error_messages(), 400); 
        }
    }

    // Save excluded dates
    $date_array = explode(',', $dates); // Convert comma-separated string to array
    $exclude_date_manager = new BCS_Exclude_Date_Manager();
    foreach ($date_array as $date) {
        $clean_date = sanitize_text_field(trim($date)); // Clean and sanitize each date
        $result = $exclude_date_manager->insert_date( $user_id, $clean_date );

        if (is_wp_error($result)) {
            return new WP_REST_Response($result->get_error_messages(), 400); 
        }
    }

    $response = new WP_REST_Response(array('message' => $processed));
    $response->set_status(200);
    return $response;
  }