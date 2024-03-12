<?php
require_once BC_SCHEDULE_PATH . '/src/database/roles-manager.php';

// Callback function for handling the delete_role request
function bcs_delete_role_callback($request) {
    // Check the nonce
    $nonce = $request->get_param('nonce');

    //TODO Nonce not working.
    $new_nonce = wp_create_nonce('bcs_roles_nonce');
    if (!wp_verify_nonce($nonce, 'bcs_roles_nonce')) {
        // return new WP_Error('invalid_nonce', 'Invalid nonce', array('status' => 403));
    }

    $role_id = $request->get_param('role_id');
    
    $roles_manager = new BCS_Roles_Manager();
    $result = $roles_manager->delete_role($role_id);

    // Return a response (success or error)
    if ( $result ) {
        return $new_nonce;
        return new WP_REST_Response(array('message' => 'Role deleted.'), 200);
    } else {
        return new WP_Error('role_deletion_failed', 'Error deleting role', array('status' => 500));
    }
}

