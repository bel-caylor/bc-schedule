<?php

// Callback function for adding new team volunteer
function bcs_add_team_volunteer_callback($request) {
    global $wpdb;
    $team_name = $request->get_param('team_name');
    $event_name = $request->get_param('event_name');
    $group_name = $request->get_param('group_name');
    $role = $request->get_param('role');
    $user_id = $request->get_param('user_id');
    $team_table = $wpdb->prefix . 'bcs_teams';

    //Get role_id from $role
    $role_row = $wpdb->get_results( "
        SELECT id 
        FROM {$wpdb->prefix}bcs_roles 
        WHERE role= '$role'
        AND event_name= '$event_name'
        AND group_name= '$group_name'" 
    );

    //Check if team already has volunteer assigned.
    $role_id = $role_row[0]->id;
    $team_volunteer = $wpdb->get_results( "
        SELECT id 
        FROM {$wpdb->prefix}bcs_teams 
        WHERE name = '$team_name'
        AND event_name= '$event_name'
        AND group_name= '$group_name'
        AND role_id= '$role_id'" 
    );

    if ($team_volunteer) {
        //Update Row
        $team_row_id = $team_volunteer[0]->id;
        $result = $wpdb->update(
            $team_table,
            array(
                'wp_user_id' => $user_id,
            ),
            array(
                'id' => $team_row_id,
            )
        );
    } else {
        //Insert Row
        $team_manager = new BCS_Teams_Manager();
        $result = $wpdb->insert(
            $team_table,
            array(
                'name' => $team_name,
                'event_name' => $event_name,
                'group_name' => $group_name,
                'role_id' => $role_id,
                'wp_user_id' => $user_id,
            )
        );
    }

    //Return
    $response = new WP_REST_Response();
    if ($result) {
        $user = $wpdb->get_results( "
            SELECT u.id, u.display_name,
            m.meta_value AS first_name
            FROM {$wpdb->prefix}users u
            LEFT JOIN {$wpdb->prefix}usermeta m ON u.ID = m.user_id AND m.meta_key = 'first_name'
            WHERE u.id = '$user_id'" 
        );
        $response = new WP_REST_Response(array('user' =>  $user));
        $response->set_status(200);
        return $response;
    }
    $response->set_status(400);
    return $response;
}

