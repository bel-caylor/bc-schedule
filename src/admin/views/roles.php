<?php
require_once BC_SCHEDULE_PATH . '/src/database/manager/roles.php';
require_once BC_SCHEDULE_PATH . '/src/database/api/delete_role.php';
require_once BC_SCHEDULE_PATH . '/src/database/api/add_role.php';

function render_roles_page() {
    $roles_manager = new BCS_Roles_Manager();
    $all_roles_page_data = $roles_manager->get_roles_page_data();
    global $wpdb;
    $table_roles = $wpdb->prefix . 'bcs_roles';
    ?>

    <div x-data="roles()" x-init="init()" class="wrap">
        <div class="input-area p-4 border border-gray-300 bg-white my-4">
            <h1 class="!pt-0">Add New Role</h1>
            <div class="flex flex-col gap-4">
                <div class="flex items-center">
                    <label for="eventName-select" class="pr-2">Event Type:</label>
                    <select id="eventName-select" x-model="selectedEventName" name="eventName-select">
                        <option value="">Select</option>
                        <template x-for="eventName in allEventNames">
                            <option :value="eventName.event_name" x-text="eventName.event_name"></option>
                        </template>
                        <option value="new">--Create New--</option>
                    </select>
                    <template x-if="selectedEventName == 'new'">
                        <div class="ml-4">
                            <label for="newEventName" class="pr-2">New Event Type:</label>
                            <input type="text" id="newEventName" name="newEventName" x-model="newEventName">
                        </div>
                    </template>
                </div>
                <div class="flex items-center">
                    <label for="group-select" class="pl-6 pr-2">Group:</label>
                    <select id="group-select" x-model="selectedGroup" name="group-select" x-bind:disabled="disabledGroup()">
                        <option value="">Select</option>
                        <template x-for="group in allGroups">
                            <option :value="group.group_name" x-text="group.group_name"></option>
                        </template>
                        <option value="new">--Create New--</option>
                    </select>
                    <template x-if="selectedGroup == 'new'">
                        <div class="ml-4">
                            <label for="newGroupName" class="pr-2">New Group Type:</label>
                            <input type="text" id="newGroupName" name="newGroupName" x-model="newGroupName">
                        </div>
                    </template>
                </div>
                <div class="flex flex-wrap justify-between">
                    <div>
                        <label for="role" class="pr-2">New Role Name:</label>
                        <input type="text" id="role" name="role" x-model="roleName" x-bind:disabled="disabledRoleName()">
                    </div>
                    <button @click="saveRole()" class="button">Submit</button>
                </div>
                <template x-if="roleDuplicate">
                    <p x-text="roleDuplicate" class="text-red-600 font-bold"></p>
                </template>
            </div>
        </div>
        <div>
            <table class="table-admin table-auto bg-white border border-gray-300">
                <thead class="">
                    <tr>
                        <th>ID</th>
                        <th>Event Name</th>
                        <th>Group Name</th>
                        <th>Role</th>
                        <th>Trash</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="role in allRoles">
                        <tr x-bind:id="'row-' + role.id">
                            <td x-text="role.id"></td>
                            <td x-text="role.event_name"></td>
                            <td x-text="role.group_name"></td>
                            <td x-text="role.role"></td>
                            <td><i x-bind:data-table="tableRole" 
                                   x-bind:data-row-id="role.id" 
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
        const allEvents = <?php echo json_encode($all_roles_page_data["allEventNames"]); ?>;
        const allGroups = <?php echo json_encode($all_roles_page_data["allGroups"]); ?>;
        const allRoles = <?php echo json_encode($all_roles_page_data["allRoles"]); ?>;
        const tableRole = "<?php echo $table_roles; ?>";

        function roles() {
            return {
                allEventNames: [],
                allGroups: [],
                allRoles: [],
                selectedEventName: '',
                newEventName: '',
                selectedGroup: '',
                newGroupName: '',
                roleName: '',
                roleDuplicate: '',
                tableRole: '',

                init() {
                    this.allEventNames = allEvents;
                    this.allGroups = allGroups;
                    this.allRoles = allRoles;
                    this.tableRole = tableRole;
                },

                disabledGroup() {
                    return !this.selectedEventName
                },

                disabledRoleName() {
                    return !this.selectedEventName || !this.selectedGroup;
                },

                saveRole() {
                    //Check for values
                    if ( this.selectedEventName === '' || this.selectedGroup === '' || this.roleName === '' ) {
                        return;
                    }

                    //See if role exists
                    const duplicate = this.allRoles.filter(
                        item => item.group_name === this.event_name 
                        && item.event_name === this.selectedGroup 
                        && item.role === this.role
                        );
                    if ( duplicate.length > 0 ) {
                        this.roleDuplicate = 'Role already exists.  Please add a different role name.';
                        this.roleName = '';
                        return;
                    }

                    // Prepare data to send
                    if ( this.selectedEventName == 'new' ) {
                        this.selectedEventName = this.newEventName;
                        this.allEventNames.push({event_name: this.newEventName});
                    }
                    if ( this.selectedGroup == 'new' ) {
                        this.selectedGroup = this.newGroupName;
                        this.allGroups.push({group_name: this.newGroupName});
                    }
                    const data = {
                        event_name: this.selectedEventName,
                        group_name: this.selectedGroup,
                        role: this.roleName,
                    };
                    // Fetch API with error handling
                    fetch('/wp-json/bcs/v1/add_role', {
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
                        this.allRoles = data.allRoles;
                    })
                    .catch(error => {
                        console.error('Error saving volunteer:', error);
                    });
                    this.selectedEventName = '';
                    this.newEventName = '';
                    this.selectedGroup = '';
                    this.newGroupName = '';
                    this.roleName = '';
                }
            }
        }
    </script>

    <?php
}
