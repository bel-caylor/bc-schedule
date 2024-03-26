<?php
require_once BC_SCHEDULE_PATH . '/src/database/manager/roles.php';
require_once BC_SCHEDULE_PATH . '/src/database/api/delete_role.php';

function render_roles_add_form() {
    ?>
    <div class="wrap">
        <h1>Add New Role</h1>
        <form method="post" action="admin-post.php">
            <?php wp_nonce_field('bcs_nonce'); ?>
            <input type="hidden" name="action" value="add_role_action">
            <label for="group_name">Group Name:</label>
            <input type="text" id="group_name" name="group_name">
            <label for="role_name">Role Name:</label>
            <input type="text" id="role_name" name="role_name">
            <input type="submit" name="add_role" value="Add Role">
        </form>
    </div>
    <?php
}

function render_roles_admin_table() {
    global $wpdb;
    $table_roles = $wpdb->prefix . 'bcs_roles';

    // Retrieve roles from the database
    $roles_manager = new BCS_Roles_Manager();
    $all_roles = $roles_manager->get_roles();

    // Display roles in an HTML table
    echo '<div class="wrap">';
    echo '<h1>Manage Roles</h1>';
    echo '<table class="table-admin">';
    echo '<thead><tr><th>ID</th><th>Group</th><th>Role</th><th>Trash</th></tr></thead>';
    echo '<tbody>';
    foreach ($all_roles as $role) {
        echo '<tr id="row-' . esc_html($role->id) . '">';
        echo '<td>' . esc_html($role->id) . '</td>';
        echo '<td>' . esc_html($role->group_name) . '</td>';
        echo '<td>' . esc_html($role->role) . '</td>';
        echo '<td><i class="dashicons dashicons-trash" data-table="' . $table_roles . '" data-row-id="' . esc_html($role->id) . '"></i></td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}
