<?php

function BCS_form_add_excluded_dates() {
    $exclude_date_manager = new BCS_Exclude_Date_Manager();
    // Verify the nonce
    check_admin_referer('bcs_nonce');
    // Sanitize and validate input
    $user_id = sanitize_text_field($_POST['user-select']);
    $dates = explode(',', sanitize_text_field($_POST['dates'])); // Explode comma-separated dates
    // echo $dates;
    // echo $user_select;

    // Insert data into your custom table (wp_BCS_roles) only if the combination doesn't exist
    foreach ($dates as $date) {
        $result = $exclude_date_manager->insert_date( $user_id, $date );
    }
    if ($result) {
        // Redirect to the specified page
        wp_safe_redirect(admin_url('admin.php?page=volunteer-schedule&tab=exclude-dates&message=success'));
        exit;
    } else {
        wp_safe_redirect(admin_url('admin.php?page=volunteer-schedule&tab=exclude-dates&message=duplicate'));
        exit;
    }
}