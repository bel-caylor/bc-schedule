<?php

function BCS_form_edit_team() {
    $selected_volunteers_json = stripslashes($_POST['selected_volunteers']);
    // Verify the nonce
    check_admin_referer('bcs_nonce');
    
    // Sanitize and validate input
    $team_id = sanitize_text_field($_POST['team-select']);
    $group_name = sanitize_text_field($_POST['group-select']);
    $team_name = sanitize_text_field($_POST['team']);
    $volunteers = sanitize_text_field($selected_volunteers_json);
    
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