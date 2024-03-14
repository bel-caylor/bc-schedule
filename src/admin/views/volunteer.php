<?php

function render_volunteer_add_form() {
    $volunteers_manager = new BCS_Roles_Manager();
    $all_roles_data = $volunteers_manager->get_roles_data();
    $users = get_users();
    ?>
    <div class="wrap">
        <h1>Add New Volunteer</h1>
        <form method="post" action="admin-post.php">
            <?php wp_nonce_field('bcs_nonce'); ?>
            <input type="hidden" name="action" value="add_volunteer_action">

            <!-- Alpine.js app for dropdown boxes. -->
            <div x-data="dropdown()" x-init="init()">
                <div class="flex">
                    <!-- Group select -->
                    <div>
                        <label for="group-select">Select a Group:</label>
                        <select id="group-select" x-model="selectedGroup" @change="filterRoles()" name="group-select">
                            <option value="">All Groups</option>
                            <template x-for="group in filteredGroups">
                                <option :value="group" x-text="group"></option>
                            </template>
                        </select>
                    </div>
    
                    <!-- Role select -->
                    <div class="pl-2" x-show="selectedGroup">
                        <label for="role-select">Select a Role:</label>
                        <select id="role-select" x-model="selectedRole"  @change="setSelectedRoleID()" name="role-select">
                            <option value="">All Roles</option>
                            <template x-for="role in filteredRoles">
                                <option :value="role" x-text="role"></option>
                            </template>
                        </select>
                    </div>
                </div>
                <div class="flex my-4" x-show="selectedRole">
                    <h2 for="volunteers" class="mr-4">Select Volunteers:</h2>
                    <div class="columns-3">
                        <?php
                        foreach ($users as $user) {
                            // Display a checkbox for each user
                            echo '<label class="flex items-center !pl-0">';
                            echo '<input type="checkbox" name="volunteers[]" value="' . esc_attr($user->ID) . '" class="mr-2">';
                            echo esc_html($user->display_name);
                            echo '</label>';
                        }
                        ?>
                    </div>
                </div>
                <input name="role-select-id" type="hidden" x-model="selectedRoleID">
                <input type="submit" name="add_volunteer" value="Add Volunteers" x-show="selectedRole">
            </div>


            <script>
                const data = <?php echo json_encode($all_roles_data); ?>;
                function dropdown() {
                    return {
                        selectedGroup: '',
                        selectedRole: '',
                        selectedRoleID: '',
                        groups: [],
                        roles: '',
                        data: [],
                        filteredRoles: [],
                        // filteredGroups: [],

                        init() {
                            // Your data (replace with your actual data)
                            const data = <?php echo json_encode($all_roles_data); ?>;
                            this.data = data;
                            // Populate unique groups and roles
                            this.groups = [...new Set(data.map(item => item.group))];
                            this.roles = [...new Set(data.map(item => item.role))];

                            // Initialize filtered roles and groups
                            this.filteredRoles = this.roles;
                            this.filteredGroups = this.groups;
                        },

                        filterRoles() {
                            if (this.selectedGroup) {
                                this.filteredRoles = [...new Set(this.data.filter(item => item.group === this.selectedGroup).map(item => item.role))];
                            } else {
                                this.filteredRoles = this.roles;
                            }
                        },

                        setSelectedRoleID() {
                            // Find the row that matches selectedGroup and selectedRole
                            const matchingUser = data.find(item => item.group === this.selectedGroup && item.role === this.selectedRole);
                            this.selectedRoleID = matchingUser['id']
                            console.log(this.selectedRoleID);
                        }

                    };
                }
            </script>
        </form>

    </div>
    <?php
}

function render_volunteer_admin_table() {
    global $wpdb;
    $table_volunteer = $wpdb->prefix . 'bcs_volunteers';

    // // Retrieve volunteer from the database
    $volunteer_manager = new BCS_Volunteers_Manager();
    $all_volunteer = $volunteer_manager->get_volunteers();
    // echo '<pre>';
    // var_dump($all_volunteer);
    // echo '</pre>';

    // Display volunteer in an HTML table
    echo '<div class="wrap">';
    echo '<h1>Manage volunteers</h1>';
    echo '<table class="table-admin">';
    echo '<thead><tr><th>ID</th><th>Name</th><th>Group</th><th>Role</th><th>Trash</th></tr></thead>';
    echo '<tbody>';
    foreach ($all_volunteer as $volunteer) {
        echo '<tr id="row-' . esc_html($volunteer->id) . '">';
        echo '<td>' . esc_html($volunteer->id) . '</td>';
        echo '<td>' . esc_html($volunteer->display_name) . '</td>';
        echo '<td>' . esc_html($volunteer->group_name) . '</td>';
        echo '<td>' . esc_html($volunteer->role) . '</td>';
        echo '<td><i class="dashicons dashicons-trash" data-table="' . $table_volunteer . '" data-row-id="' . esc_html($volunteer->id) . '"></i></td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}
