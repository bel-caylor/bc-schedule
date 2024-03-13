<?php

// Register the custom endpoints
function my_custom_rest_endpoint() {
    register_rest_route('bcs/v1', '/delete_row/(?P<role_id>\d+)', array(
        'methods' => 'DELETE',
        'callback' => 'bcs_delete_row_callback',
        // 'permission_callback' => 'my_check_permissions',
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