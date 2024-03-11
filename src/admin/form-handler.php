<?php

function BCS_form_submission_handler() {
    $roles_manager = new BCS_Roles_Manager();
    // Check if the form is submitted
    if (isset($_POST['add_role'])) {
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
}
add_action('init', 'BCS_form_submission_handler');
