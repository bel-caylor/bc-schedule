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
                    <button :disabled="disabledSubmit()" @click="saveVolunteer()" class="button max-w-28">Submit</button>
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
                                   class="dashicons dashicons-trash jquery-delete"></i>
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

                    // Loop through allUsers and uncheck checkboxes
                    this.allUsers.forEach(user => {
                        const checkbox = document.querySelector(`input[id="${user.ID}"]`);
                        if (checkbox) {
                            checkbox.checked = false;
                        }
                    });
                }   
            }
        }
    </script>

    <?php
}