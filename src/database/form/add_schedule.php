<?php

function BCS_form_add_schedule() {
    $event_date = sanitize_text_field($_POST['event-date']);
    $event_name = sanitize_text_field($_POST['event-name']);
    $group_name = sanitize_text_field($_POST['group-select']);
    
    $schedule_manager = new BCS_Schedule_Manager();
    // Insert data into wp_bcs_events & wp_bcs_scheule only if the combination doesn't exist
    $result = $schedule_manager->insert_schedule_date( $event_date, $event_name, $group_name );
    if ($result) {
        // Redirect to the specified page
        wp_safe_redirect(admin_url('admin.php?page=volunteer-schedule&tab=events&message=success'));
        exit;
    } elseif ($result == 'duplicate'){
        // Combination already exists, handle accordingly (e.g., display an error message)
        wp_safe_redirect(admin_url('admin.php?page=volunteer-schedule&tab=events&message=duplicate'));
        exit;
    } else {
        wp_safe_redirect(admin_url('admin.php?page=volunteer-schedule&tab=events&message=error'));
        exit;
    }
}