<?php

function BCS_form_add_volunteer() {
    $volunteers_manager = new BCS_Volunteers_Manager();
    // Verify the nonce
    check_admin_referer('bcs_nonce');
    // Sanitize and validate input
    $group_name = sanitize_text_field($_POST['group-select']);
    $role_id = sanitize_text_field($_POST['role-select-id']);
    $volunteers = isset($_POST['volunteers']) ? array_map('sanitize_text_field', $_POST['volunteers']) : [];

    // Loop through $volunteers
    foreach ($volunteers as $volunteer) {
        // Insert data into your custom table (wp_BCS_volunteers) only if the combination doesn't exist
        $result = $volunteers_manager->insert_volunteer( $volunteer, $role_id );
    }
    wp_safe_redirect(admin_url('admin.php?page=volunteer-schedule&tab=volunteers&message=success'));
    exit;
}