<?php

// Callback function for handling the delete_role request
function bcs_delete_row_callback($request) {
    // Check the nonce
    $nonce = $request->get_param('nonce');

    //TODO Nonce not working.
    $new_nonce = wp_create_nonce('bcs_nonce');
    if (!wp_verify_nonce($nonce, 'bcs_nonce')) {
        // return new WP_Error('invalid_nonce', 'Invalid nonce', array('status' => 403));
    }
    
    $row_id = $request->get_param('row');
    $table = $request->get_param('table');
    
    $db_manager = new BCS_db_Manager();
    $result = $db_manager->delete_row_from_tbl( $row_id, $table );
    return $result;
    
    // Return a response (success or error)
    if ( $result ) {
        return new WP_REST_Response(array('message' => 'Role deleted.'), 200);
    } else {
        return new WP_Error('role_deletion_failed', 'Error deleting role', array('status' => 500));
    }
}

