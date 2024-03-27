<?php
require_once BC_SCHEDULE_PATH . '/src/database/manager/schedule.php';
require_once BC_SCHEDULE_PATH . '/src/database/manager/volunteer.php';
require_once BC_SCHEDULE_PATH . '/src/database/manager/teams.php';
require_once BC_SCHEDULE_PATH . '/src/database/manager/roles.php';

function render_schedule_admin_table() {
    global $wpdb;

    // Retrieve schedule from the database
    $schedule_manager = new BCS_Schedule_Manager();
    $all_schedule = $schedule_manager->get_schedule();
    $all_events = $all_schedule['events'];
    // echo '<pre>';
    // var_dump($all_events);
    // echo '</pre>';
    
    if ($all_events) {
        $all_schedule_roles = $all_schedule['schedule'];
        $all_volunteers_data = $all_schedule['allVolunteers'];
        ?>
        <div class="wrap bcs">
            <h1>Manage schedule</h1>
            <div x-data="table()" x-init="init()">
                <div class="bcs-px-4 sm:bcs-px-6 lg:bcs-px-8">
                    <div class="bcs-mt-8 bcs-flow-root">
                    <div class="-bcs-mx-4 -bcs-my-2 bcs-overflow-x-auto sm:-bcs-mx-6 lg:-bcs-mx-8">
                        <div class="bcs-inline-block bcs-min-w-full bcs-py-2 bcs-align-middle sm:bcs-px-6 lg:bcs-px-8">
                        <table class="bcs-min-w-full">
                            <thead class="bcs-bg-white">
                                <tr>
                                    <th scope="col" class="bcs-py-3.5 bcs-pl-4 bcs-pr-3 bcs-text-left bcs-text-sm bcs-font-semibold bcs-text-gray-900 sm:bcs-pl-3">Role</th>
                                    <template x-for="event in events">
                                        <th scope="col" class="bcs-px-3 bcs-py-3.5 bcs-text-left bcs-text-sm bcs-font-semibold bcs-text-gray-900">
                                            <div x-text="event.date"></div>
                                            <div x-text="event.name"></div>
                                        </th>
                                    </template>
                                </tr>
                            </thead>
                            <template x-for="group in Object.keys(schedule)" :key="group">
                                <tbody class="bcs-bg-white">
                                    <tr class="bcs-border-t bcs-border-gray-200">
                                        <th colspan="5" scope="colgroup" class="bcs-bg-gray-50 bcs-py-2 bcs-pl-4 bcs-pr-3 bcs-text-left bcs-text-sm bcs-font-semibold bcs-text-gray-900 sm:bcs-pl-3" x-text="group"></th>
                                    </tr>
                                    <!-- Row -->
                                    <template x-for="role in Object.keys(schedule[group])" :key="role">
                                    <!-- <template x-for="role in schedule[group]"> -->
                                        <tr>
                                            <td x-text="role" class="bcs-whitespace-nowrap bcs-py-4 bcs-pl-4 bcs-pr-3 bcs-text-sm bcs-font-medium bcs-text-gray-900 sm:pl-3"></td>
                                            <!-- Detail -->
                                            <template x-for="event in events">
                                                <td x-data-event-id="event.id" x-data-role="role">
                                                    <!-- Selected Volunteer -->
                                                    <div x-show="schedule[group][role][event.id]?.first_name  && schedule[group][role][event.id].edit == false ">
                                                        <span x-bind:class="{'bcs-bg-pink-50': isDuplicateVolunteer( schedule[group][role][event.id].volunteer_id, event.id, role, schedule[group][role][event.id].wp_user_id ) }" 
                                                            x-text="schedule[group][role][event.id]?.first_name ? schedule[group][role][event.id].first_name : ''"></span>
                                                        <button class="dashicons dashicons-edit bcs-text-blue-400" @click="schedule[group][role][event.id].edit = true;"></button>
                                                    </div>
                                                    <!-- Voluteer Dropdown -->
                                                    <div x-show="!schedule[group][role][event.id]?.first_name || schedule[group][role][event.id].edit == true ">
                                                        <select x-model="schedule[group][role][event.id].selectedVolunteer" x-data-event-id="event.id" x-data-role="role">
                                                            <option value="">Select Volunteer</option>
                                                            <template x-for="volunteer in Object.keys(allVolunteers[group][role])" :key="volunteer">
                                                            <option :value="volunteer" x-text="allVolunteers[group][role][volunteer].display_name"></option>
                                                            </template>
                                                        </select>
                                                        <span x-show="schedule[group][role][event.id]?.selectedVolunteer !== ''" 
                                                            @click="saveVolunteer( schedule[group][role][event.id].schedule_id, schedule[group][role][event.id].selectedVolunteer, group, role, event.id )" 
                                                            class="dashicons dashicons-saved bcs-text-blue-400">
                                                        </span>
                                                    </div>
    
                                                </td>
                                            </template>
                                        </tr>
                                    </template>
                                </tbody>
                            </template>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <script>
            function table() {
                return {
                    events: [],
                    schedule: [],
                    allVolunteers: [],
    
                    init () {
                        this.events = <?php echo json_encode($all_events); ?>;
                        this.schedule = <?php echo json_encode($all_schedule_roles); ?>;
                        this.allVolunteers = <?php echo json_encode($all_volunteers_data); ?>;
                    },
    
                    saveVolunteer( scheduleID, selectedVolunteer, group, role, eventID ) {
                        // Prepare data to send
                        const data = {
                            schedule_id: scheduleID,
                            volunteer_id: selectedVolunteer,
                        };
    
                        // Fetch API with error handling
                        fetch('/wp-json/bcs/v1/save-volunteer-to-event-role', {
                            method: 'POST',
                            headers: {
                            'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(data),
                        })
                        .then(response => {
                            if (!response.ok) {
                            console.error('Error saving volunteer:', response.statusText);
                            return;
                            }
                            // Handle successful response (e.g., update UI)
                            console.log('Volunteer saved successfully!');
                            this.schedule[group][role][eventID].display_name = this.allVolunteers[group][role][selectedVolunteer].display_name;
                            this.schedule[group][role][eventID].user_email = this.allVolunteers[group][role][selectedVolunteer].user_email;
                            this.schedule[group][role][eventID].first_name = this.allVolunteers[group][role][selectedVolunteer].first_name;
                            this.schedule[group][role][eventID].edit = false; 
    
                        })
                        .catch(error => {
                            console.error('Error saving volunteer:', error);
                        });
                    },
    
                    isDuplicateVolunteer( volunteerID, eventID, roleInput, userIDInput ) {
                        var duplicate = false;
                        //Loop through Groups and Roles and return true if volunteerID is a duplicate.
                        // console.log('START ' + volunteerID + ' ' + eventID + ' ' + roleInput + ' ' + userIDInput );
                        for (const group in this.schedule) {
                            for (const role in this.schedule[group]) {
                                if (roleInput !== role) {
                                    // console.log('eventID ' + eventID +' -- group ' + group + ' -- role ' + role + ' wp_user_id ' + this.schedule[group][role][eventID].wp_user_id);
                                        if (userIDInput == this.schedule[group][role][eventID].wp_user_id) {
                                            duplicate = true;
                                        }
                                }
                            }
                        }
                        // console.log('END' );
                        return duplicate; 
                    }
                }
            }
        </script>
        <?php
    } else {
        ?>
            <div class="wrap">
                <h1>Welcome to Your Team Schedule</h1>
                <p>Start by adding Roles, Volunteers, Teams and Events.</p>
            </div>
        <?php
    }

}
