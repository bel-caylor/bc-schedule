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
                                            <div>Volunteer</div>
                                            <div x-text="schedule[group][role][event.id]?.first_name ? schedule[group][role][event.id].first_name : 'Not Assigned'"></div>
                                            <!-- <div x-text="schedule[group][role][event.id][first_name]"></div> -->
                                            <!-- <template x-if="schedule[group][role.role_name][event.id].first_name">
                                            </template> -->
                                            <!-- <template x-if="schedule[group][role.role][event.id].first_name">
                                                <div x-text="schedule[group][role.role][event.id].first_name"></div>
                                            </template> -->
                                            <!-- <select>
                                                <option value="">Select Volunteer</option>
                                                <template x-for="volunteer in Object.keys(schedule[allVolunteers][group][role])">
                                                    <option :value="volunteer.id" x-text="volunteer.display_name"></option>
                                                </template>
                                            </select> -->
                                        </td>
                                    </template>
                                    <!-- <template x-for="volunteer in Object.keys(schedule[group][role])" :key="volunteer">
                                        <td x-text="schedule[group][role][volunteer].first_name" x-data-schedule-id="schedule[group][role][volunteer].schedule_id"  class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3"></td> -->
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

                    // Add console.log to check data
                    // console.log("Checking schedule data:");
                    // for (const group in this.schedule) {
                    //     for (const role in this.schedule[group]) {
                    //         for (const event of this.events) {
                    //         const eventId = event.id;
                    //         const firstName = this.schedule[group][role]?.[eventId]?.first_name;
                    //         console.log(`group: ${group}, role: ${role}, event id: ${eventId}, first_name:`, firstName);
                    //         }
                    //     }
                    // }
                }

                // eventColName(event) {
                //     return event.data + '<br>' + event.name;
                // }
            }
        }
    </script>
    <?php
}
