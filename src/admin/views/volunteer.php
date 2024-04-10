<?php
require_once BC_SCHEDULE_PATH . '/src/database/manager/volunteer.php';
require_once BC_SCHEDULE_PATH . '/src/database/api/add_volunteer.php';
require_once BC_SCHEDULE_PATH . '/src/database/manager/roles.php';

function render_volunteer_page() {
    global $wpdb;
    $volunteer_manager = new BCS_Volunteers_Manager();
    $all_volunteer_page_data = $volunteer_manager->get_volunteer_page_data();
    $table_volunteer = $wpdb->prefix . 'bcs_volunteers';
    ?>
    <div x-data="volunteers()" x-init="init()" class="wrap">
        <div class="input-area p-4 border border-gray-300 bg-white my-4 !w-full">
            <h1 class="!pt-0 font-bold">Add Volunteer</h1>
            <div class="flex flex-col gap-4">
                <div class="flex">
                    <div class="mr-8">
                        <label for="role-select" class="pr-2 font-bold">Select Group Type:</label>
                        <select id="role-select" x-model="selectedRoleId" name="role-select">
                            <option value="">Select</option>
                            <template x-for="role in allRoles">
                                <option :value="role.id" x-text="roleName(role.event_name, role.group_name, role.role)"></option>
                            </template>
                        </select>
                    </div>
                    <button x-bind:disabled="disabledSubmit()" @click="saveVolunteer()" class="button max-w-28">Submit</button>
                </div>
                <div class="my-4" x-show="disabledUsers()" x-cloak>
                    <h2 for="volunteers" class="mr-4 font-bold">Select Volunteers:</h2>
                    <div class="columns">
                        <template x-for="user in allUsers">
                            <div class="flex py-2 items-center">
                                <input :id="user.ID" type="checkbox" @click="toggleUserID(user.ID)" :value="user.display_name" class="">
                                <label :for="user.ID" class="flex items-center !pl-0" x-text="user.display_name"></label>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <table class="table-admin table-auto bg-white border border-gray-300">
                <thead class="">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Group</th>
                        <th>Event</th>
                        <th>Trash</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="volunteer in allVolunteers">
                        <tr x-bind:id="'row-' + volunteer.id">
                            <td x-text="volunteer.id"></td>
                            <td x-text="volunteer.display_name"></td>
                            <td x-text="volunteer.role"></td>
                            <td x-text="volunteer.group_name"></td>
                            <td x-text="volunteer.event_name"></td>
                            <td><i x-bind:data-table="tableVolunteer" 
                                   x-bind:data-row-id="volunteer.id" 
                                   class="dashicons dashicons-trash"></i>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        //* WP Data *//
        const allRoles = <?php echo json_encode($all_volunteer_page_data["allRoles"]); ?>;
        const allUsers = <?php echo json_encode($all_volunteer_page_data["allUsers"]); ?>;
        const allVolunteers = <?php echo json_encode($all_volunteer_page_data["allVolunteers"]); ?>;
        const tableVolunteer = "<?php echo $table_volunteer; ?>";


        function volunteers() {
            return {
                allRoles: [],
                allUsers: [],
                allVolunteers: [],
                selectedRoleId: '',
                selectedUserIds: [],
                tableVolunteer: '',

                init() {
                    this.allRoles = allRoles;
                    this.allUsers = allUsers;
                    this.allVolunteers = allVolunteers;
                    this.tableVolunteer = tableVolunteer;
                },

                roleName(eventName, groupName, roleName) {
                    return eventName + " -- " + groupName + " -- " + roleName;
                },

                toggleUserID(userId) {
                    const index = this.selectedUserIds.indexOf(userId);
                    if (index === -1) {
                        this.selectedUserIds.push(userId);
                    } else {
                        this.selectedUserIds.splice(index, 1);
                    }
                },

                disabledUsers() {
                    return this.selectedRoleId ? true : false;
                },

                disabledSubmit() {
                    return this.selectedRoleId && this.selectedUserIds.length > 0 ? false : true;
                },

                saveVolunteer() {
                    //Loop through selectedUser and remove duplicates
                    for (const userId of this.selectedUserIds) {
                        const duplicate = this.allVolunteers.filter(
                            item => item.role_id === this.selectedRoleId 
                            && item.wp_user_id === userId 
                            );
                        if ( duplicate.length > 0 ) {
                            this.toggleUserID(userId)
                        }
                    }
                    if ( this.selectedUserIds ) {
                        const data = {
                            userIds: [...this.selectedUserIds],
                            role_id: this.selectedRoleId,
                        };
                        console.log(data);
                        fetch('/wp-json/bcs/v1/add_volunteer', {
                            method: 'POST',
                            headers: {
                            'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(data),
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log(data.allVolunteers);
                            this.allVolunteers = data.allVolunteers;
                        })
                        .catch(error => {
                            console.error('Error saving volunteer:', error);
                        });
                    }
                    //Rest input
                    this.selectedUserIds = [];
                    this.selectedRoleId = '';
                }   
            }
        }
    </script>

    <?php
}

function render_volunteer_add_form() {
    $volunteers_manager = new BCS_Roles_Manager();
    $all_roles_data = $volunteers_manager->get_roles_data();
    $users = get_users();
    ?>
    <div class="wrap bcs">
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
                    <div class="pl-2" x-show="selectedGroup" x-cloak>
                        <label for="role-select">Select a Role:</label>
                        <select id="role-select" x-model="selectedRoleId"  @change="setselectedRoleIdID()" name="role-select">
                            <option value="">All Roles</option>
                            <template x-for="role in filteredRoles">
                                <option :value="role" x-text="role"></option>
                            </template>
                        </select>
                    </div>
                </div>
                <div class="flex my-4" x-show="selectedRoleId" x-cloak>
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
                <input name="role-select-id" type="hidden" x-model="selectedRoleIdID">
                <input type="submit" name="add_volunteer" value="Add Volunteers" x-show="selectedRoleId">
            </div>


            <script>
                // const data = <?php echo json_encode($all_roles_data); ?>;
                function dropdown() {
                    return {
                        selectedGroup: '',
                        selectedRoleId: '',
                        selectedRoleIdID: '',
                        groups: [],
                        roles: '',
                        data: [],
                        filteredRoles: [],
                        // filteredGroups: [],

                        init() {
                            // Your data (replace with your actual data)
                            // const data = data;
                            this.data = <?php echo json_encode($all_roles_data); ?>;;
                            // Populate unique groups and roles
                            this.groups = [...new Set(this.data.map(item => item.group))];
                            this.roles = [...new Set(this.data.map(item => item.role))];

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

                        setselectedRoleIdID() {
                            // Find the row that matches selectedGroup and selectedRoleId
                            const matchingUser = this.data.find(item => item.group === this.selectedGroup && item.role === this.selectedRoleId);
                            this.selectedRoleIdID = matchingUser['id']
                            console.log(this.selectedRoleIdID);
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
    echo '<div class="wrap bcs">';
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
