<?php

function BCS_form_submission_handler() {

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
}
add_action('init', 'BCS_form_submission_handler');
