<?php

// Callback function for adding new team volunteer
function bcs_add_team_to_event_callback($request) {
    global $wpdb;

    $team_name = $request->get_param('team_name');
    $event_name = $request->get_param('event_name');
    $group_name = $request->get_param('group_name');
    $dates = $request->get_param('dates');

    //Return
    $team_manager = new BCS_Teams_Manager();
    $result = $team_manager->add_team_to_schedule($team_name, $event_name, $group_name, $dates);

    $response = new WP_REST_Response();
    if ($result) {
        $response = new WP_REST_Response(array('message' =>  'Teams added!'));
        $response->set_status(200);
        return $response;
    }
    $response->set_status(400);
    return $response;
}

