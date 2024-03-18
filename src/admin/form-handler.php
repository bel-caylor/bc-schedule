<?php

function BCS_form_submission_handler() {

    //** Add role **//
    if (isset($_POST['add_role'])) {
        $roles_manager = new BCS_Roles_Manager();
        // Verify the nonce
        check_admin_referer('bcs_nonce');
        // Sanitize and validate input
        $group_name = sanitize_text_field($_POST['group_name']);
        $role_name = sanitize_text_field($_POST['role_name']);

        // Insert data into your custom table (wp_BCS_roles) only if the combination doesn't exist
        $result = $roles_manager->insert_role( $group_name, $role_name );
        if ($result) {
            // Redirect to the specified page
            wp_safe_redirect(admin_url('admin.php?page=volunteer-schedule&tab=roles&message=success'));
            exit;
        } elseif ($result == 'duplicate'){
            // Combination already exists, handle accordingly (e.g., display an error message)
            wp_safe_redirect(admin_url('admin.php?page=volunteer-schedule&tab=roles&message=duplicate'));
            exit;
        } else {
            wp_safe_redirect(admin_url('admin.php?page=volunteer-schedule&tab=roles&message=duplicate'));
            exit;
        }
    }

    //** Add volunteer **//
    if (isset($_POST['add_volunteer'])) {
        $volunteers_manager = new BCS_Volunteers_Manager();
        // Verify the nonce
        check_admin_referer('bcs_nonce');

        // Sanitize and validate input
        $group_name = sanitize_text_field($_POST['group-select']);
        $role_id = sanitize_text_field($_POST['role-select-id']);
        $volunteers = isset($_POST['volunteers']) ? array_map('sanitize_text_field', $_POST['volunteers']) : [];

        // Loop through $volunteers
        foreach ($volunteers as $volunteer) {
            // var_dump($volunteer);
            // Insert data into your custom table (wp_BCS_volunteers) only if the combination doesn't exist
            $volunteers_manager->insert_volunteer( $volunteer, $role_id );
        }

        wp_safe_redirect(admin_url('admin.php?page=volunteer-schedule&tab=volunteers&message=success'));
        exit;
    }

    //** Add team **//
    if (isset($_POST['add_team'])) {
        $teams_manager = new BCS_Teams_Manager();
        $selected_volunteers_json = stripslashes($_POST['selected_volunteers']);
        // Verify the nonce
        check_admin_referer('bcs_nonce');

        // Sanitize and validate input
        $group_name = sanitize_text_field($_POST['group-select']);
        $team_name = sanitize_text_field($_POST['team']);
        $volunteers = sanitize_text_field($selected_volunteers_json);

        // Insert data into wp_bcs_teams only if the combination doesn't exist
        $result = $teams_manager->insert_team( $group_name, $team_name, $volunteers );
        if ($result) {
            // Redirect to the specified page
            wp_safe_redirect(admin_url('admin.php?page=volunteer-schedule&tab=teams&message=success'));
            exit;
        } elseif ($result == 'duplicate'){
            // Combination already exists, handle accordingly (e.g., display an error message)
            wp_safe_redirect(admin_url('admin.php?page=volunteer-schedule&tab=teams&message=duplicate'));
            exit;
        } else {
            wp_safe_redirect(admin_url('admin.php?page=volunteer-schedule&tab=teams&message=duplicate'));
            exit;
        }
    }

    //** Edit team **//
    if (isset($_POST['edit_team'])) {
        echo '<pre>';
        var_dump($_POST);
        echo '</pre>';
        $selected_volunteers_json = stripslashes($_POST['selected_volunteers']);
        // Verify the nonce
        check_admin_referer('bcs_nonce');
        
        // Sanitize and validate input
        $team_id = sanitize_text_field($_POST['team-select']);
        $group_name = sanitize_text_field($_POST['group-select']);
        $team_name = sanitize_text_field($_POST['team']);
        $volunteers = sanitize_text_field($selected_volunteers_json);
        
        //Delete team from table.
        // $db_manager = new BCS_db_Manager();
        // $db_manager->delete_row_from_tbl( $team_id , 'wp_bcs_teams');
        
        $teams_manager = new BCS_Teams_Manager();
        // Insert data into wp_bcs_teams only if the combination doesn't exist
        $result = $teams_manager->edit_team( $group_name, $team_name, $volunteers );
        if ($result) {
            // Redirect to the specified page
            wp_safe_redirect(admin_url('admin.php?page=volunteer-schedule&tab=teams&message=success'));
            exit;
        } elseif ($result == 'duplicate'){
            // Combination already exists, handle accordingly (e.g., display an error message)
            wp_safe_redirect(admin_url('admin.php?page=volunteer-schedule&tab=teams&message=duplicate'));
            exit;
        } else {
            wp_safe_redirect(admin_url('admin.php?page=volunteer-schedule&tab=teams&message=duplicate'));
            exit;
        }
    }
}
add_action('init', 'bcs_form_submission_handler');

?>