<?php

function process_bcs_save_volunteer_to_event_role(WP_REST_Request $request) {
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true); // Decode JSON into an associative array

    // Access data from the decoded object
    $schedule_id = $data['schedule_id'];
    $volunteer_id = $data['volunteer_id'];

    $schedule_manager = new BCS_Schedule_Manager();

    $result = $schedule_manager->save_volunteer( $schedule_id, $volunteer_id );

    $response = new WP_REST_Response(array('message' => $processed));
    $response->set_status(200);
    return $response;
}