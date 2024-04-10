<?php

// Callback function for adding new role
function bcs_save_new_role_callback($request) {
    global $wpdb;
    
    $event_name = $request->get_param('event_name');
    $group_name = $request->get_param('group_name');
    $role = $request->get_param('role');
    
    $db_manager = new BCS_Roles_Manager();
    $result = $db_manager->insert_role( $event_name, $group_name, $role );
    return $result;
}

