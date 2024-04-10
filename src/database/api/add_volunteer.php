<?php

// Callback function for adding new volunteer
function bcs_add_volunteer_callback($request) {
    global $wpdb;
    
    $user_ids = $request->get_param('userIds');
    $role_id = $request->get_param('role_id');

    $db_manager = new BCS_Volunteers_Manager();
    foreach( $user_ids as $user_id ) {
        $result = $db_manager->insert_volunteer( $user_id, $role_id );
    }
    if (!$result) {
        $data['allVolunteers'] = $db_manager->get_volunteers();
        $response = new WP_REST_Response(array('allVolunteers' =>  $data['allVolunteers']));
        $response->set_status(200);
        return $response;
    }
    $response = new WP_REST_Response();
    $response->set_status(400);
    return $response;
}

