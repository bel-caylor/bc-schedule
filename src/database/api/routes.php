<?php

// Register the custom endpoints
function my_custom_rest_endpoint() {
    register_rest_route('bcs/v1', '/add_role/', array(
        'methods' => 'POST',
        'callback' => 'bcs_save_new_role_callback',
        // 'permission_callback' => 'my_check_permissions',
    ));

    register_rest_route('bcs/v1', '/add_volunteer/', array(
        'methods' => 'POST',
        'callback' => 'bcs_add_volunteer_callback',
        // 'permission_callback' => 'my_check_permissions',
    ));

    register_rest_route('bcs/v1', '/add_event/', array(
        'methods' => 'POST',
        'callback' => 'bcs_save_new_event_callback',
        // 'permission_callback' => 'my_check_permissions',
    ));

    register_rest_route('bcs/v1', '/add_team_volunteer/', array(
        'methods' => 'POST',
        'callback' => 'bcs_add_team_volunteer_callback',
        // 'permission_callback' => 'my_check_permissions',
    ));

    register_rest_route('bcs/v1', '/delete_row/(?P<role_id>\d+)', array(
        'methods' => 'DELETE',
        'callback' => 'bcs_delete_row_callback',
        // 'permission_callback' => 'my_check_permissions',
    ));

    register_rest_route('bcs/v1', '/process-bcs-add-excluded-dates', array(
        'methods' => 'POST',
        'callback' => 'process_bcs_add_excluded_dates_callback',
        'permission_callback' => '__return_true', // Adjust permissions as needed
    ));

    register_rest_route('bcs/v1', '/save-volunteer-to-event-role', array(
        'methods' => 'POST',
        'callback' => 'process_bcs_save_volunteer_to_event_role',
        'permission_callback' => '__return_true', // Adjust permissions as needed
    ));

    register_rest_route('bcs/v1', '/users', array(
        'methods' => 'GET',
        'callback' => 'bcs_get_users',
        'permission_callback' => '__return_true', // Adjust permissions as needed
    ));
}
add_action('rest_api_init', 'my_custom_rest_endpoint');

// Optional: Permission callback to check user capabilities
function my_check_permissions() {
    // Implement your custom permission checks here
    // Return true if the user has the necessary capabilities
    // Return false if not
    return current_user_can('manage_options'); // Example: Only admins can delete roles
}