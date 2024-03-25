<?php
require_once BC_SCHEDULE_PATH . '/src/database/schedule-manager.php';
require_once BC_SCHEDULE_PATH . '/src/database/volunteer-manager.php';
require_once BC_SCHEDULE_PATH . '/src/database/teams-manager.php';
require_once BC_SCHEDULE_PATH . '/src/database/roles-manager.php';

function render_schedule_admin_table() {
    global $wpdb;

    // Retrieve schedule from the database
    $schedule_manager = new BCS_Schedule_Manager();
    $all_schedule = $schedule_manager->get_schedule();
    $all_events = $all_schedule['events'];
    $all_schedule_roles = $all_schedule['schedule'];
    // $all_roles = $all_schedule['allRoles'];
    $all_volunteers_data = $all_schedule['allVolunteers'];
    // echo '<pre>';
    // var_dump($all_volunteers_data);
    // echo '</pre>';

    // Display volunteer in an HTML table
    echo '<div class="wrap">';
    echo '<h1>Manage schedule</h1>';
    ?>
    <div x-data="table()" x-init="init()">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full">
                    <thead class="bg-white">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Role</th>
                            <template x-for="event in events">
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    <div x-text="event.date"></div>
                                    <div x-text="event.name"></div>
                                </th>
                            </template>
                        </tr>
                    </thead>
                    <template x-for="group in Object.keys(schedule)" :key="group">
                        <tbody class="bg-white">
                            <tr class="border-t border-gray-200">
                                <th colspan="5" scope="colgroup" class="bg-gray-50 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3" x-text="group"></th>
                            </tr>
                            <!-- Row -->
                            <template x-for="role in Object.keys(schedule[group])" :key="role">
                            <!-- <template x-for="role in schedule[group]"> -->
                                <tr>
                                    <td x-text="role" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3"></td>
                                    <!-- Detail -->
                                    <template x-for="event in events">
                                        <td x-data-event-id="event.id" x-data-role="role">
                                            <!-- Selected Volunteer -->
                                            <div x-show="schedule[group][role][event.id]?.first_name  && schedule[group][role][event.id].edit == false ">
                                                <span x-text="schedule[group][role][event.id]?.first_name ? schedule[group][role][event.id].first_name : ''"></span>
                                                <button class="dashicons dashicons-edit" @click="schedule[group][role][event.id].edit = true;"></button>
                                                <!-- <button class="dashicons dashicons-edit" @click="console.log('Test')"></button> -->
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
                                                      class="dashicons dashicons-saved">
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
                }
            }
        }
    </script>
    <?php
}