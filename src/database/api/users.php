<?php

function bcs_get_users() {
    
    $exclude_date_manager = new BCS_Exclude_Date_Manager();
    $result = $exclude_date_manager->get_users();
    
    // Return a response (success or error)
    if ( $result ) {
        return $result;
    } else {
        return new WP_Error('get_users_failed', 'Error retrieving users.', array('status' => 500));
    }
}

