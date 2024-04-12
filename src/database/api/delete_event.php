<?php

// Callback function for handling the delete_role request
function bcs_delete_event_callback($request) {
    global $wpdb;
    
    $event_id = $request->get_param('event_id');
    
    $events_manager = new BCS_Events_Manager();
    $result = $events_manager->delete_event($event_id);
    
    // Return a response (success or error)
    if ( $result ) {
        return new WP_REST_Response(array('message' => 'Event deleted.', 'data' => $result), 200);
    } else {
        return new WP_Error('role_deletion_failed', 'Error deleting event', array('status' => 500));
    }
}

