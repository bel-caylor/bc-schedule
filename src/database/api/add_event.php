<?php

// Callback function for adding new event date
function bcs_save_new_event_callback($request) {
    global $wpdb;
    
    $event_name = $request->get_param('event_name');
    $event_date = $request->get_param('event_date');
    
    $events_manager = new BCS_Events_Manager();
    $result = $events_manager->insert_event( $event_name, $event_date );

    $response = new WP_REST_Response();
    if ($result) {
        $response->set_status(200);
        return $response;
    }
    $response->set_status(400);
    return $response;
}

