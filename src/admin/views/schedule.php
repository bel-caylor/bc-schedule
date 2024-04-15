<?php
require_once BC_SCHEDULE_PATH . '/src/database/manager/schedule.php';
require_once BC_SCHEDULE_PATH . '/src/database/manager/volunteer.php';
require_once BC_SCHEDULE_PATH . '/src/database/manager/teams.php';
require_once BC_SCHEDULE_PATH . '/src/database/manager/roles.php';
require_once BC_SCHEDULE_PATH . '/src/database/api/save_volunteer_to_event_role.php';

function render_schedule_admin_table() {
    global $wpdb;

    // Retrieve schedule from the database
    $schedule_manager = new BCS_Schedule_Manager();
    $all_schedule = $schedule_manager->get_schedule();
    $all_exclude_dates = $schedule_manager->get_exclude_dates_by_date();
    $all_events = $all_schedule['events'];
    // echo '<pre>';
    // var_dump($all_exclude_dates);
    // echo '</pre>';

    // Fetch capabilities of the logged-in user
    $current_user = wp_get_current_user();
    $current_user_capabilities = $current_user->allcaps;
    $is_subscriber = count(array_diff_key($current_user_capabilities, array('read' => true, 'level_0' => true, 'subscriber' => true))) === 0;
    $current_user_id = $current_user->ID;

    
    if ($all_events) {
        $all_schedule_roles = $all_schedule['schedule'];
        $all_volunteers_data = $all_schedule['allVolunteers'];
        $exclude_dates = $all_schedule['excludeDates'];
        // $exclude_dates_by_date = $all_exclude_dates;
        ?>
        <div class="wrap bcs">
            <h1 class="!font-bold flex gap-8 flex-col sm:flex-row"">Manage schedule</h1>
            <div x-data="table()" x-init="init()">
                <template x-for="eventName in Object.keys(schedule)">
                    <div>
                        <h2 x-text="eventName" class="font-bold text-xl py-2 px-4 sticky top-[30px] bg-blue-900 text-white border border-blue-900" style="width: fit-content"></h2>
                        <div class="md:-mx-8 -my-2">
                            <div class="inline-block max-w-full min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <div class="table-wrapper">
                                    <table class="table-auto bg-gray-300 border border-gray-300">
                                        <thead>
                                            <tr class="bg-blue-300 border-blue-300">
                                                <th scope="col" class="col-1 sticky top-0 left-0 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Role</th>
                                                <template x-for="event in events">
                                                    <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">
                                                        <div x-text="formatDate(event.date)"></div>
                                                    </th>
                                                </template>
                                            </tr>
                                        </thead>
                                        <template x-for="group in Object.keys(schedule[eventName])" :key="group">
                                            <tbody class="bg-white">
                                                <tr class="border-t border-gray-200 text-white bg-gray-100">
                                                    <th x-text="group" scope="colgroup" class="!text-black !bg-gray-300 col-1 sticky top-0 left-0 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3"></th>
                                                </tr>
                                                <!-- Row -->
                                                <template x-for="role in Object.keys(schedule[eventName][group])" :key="role">
                                                    <tr class="bg-gray-100 border border-gray-300">
                                                        <td x-text="role" class="!bg-gray-100 col-1 sticky top-0 left-0 whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3"></td>
                                                        <!-- Detail -->
                                                        <template x-for="event in events">
                                                            <td x-data-event-id="event.id" x-data-role="role" class="whitespace-nowrap">
                                                                <!-- Selected Volunteer -->
                                                                <div x-show="schedule[eventName][group][role][event.id]?.first_name  && schedule[eventName][group][role][event.id].edit == false ">
                                                                    <button x-bind:class="{'bg-purple-200': isDuplicateVolunteer( schedule[eventName][group][role][event.id]?.volunteer_id, event.id, role, schedule[eventName][group][role][event.id]?.wp_user_id, eventName ) }" 
                                                                            x-text="schedule[eventName][group][role][event.id]?.first_name ? schedule[eventName][group][role][event.id].first_name : ''"
                                                                            @click="schedule[eventName][group][role][event.id].edit = true;"
                                                                            class="!py-[2px] w-full bg-blue-100 hover:text-blue-700 hover:bg-white border border-gray-200 rounded-sm">
                                                                    </button>
                                                                    <!-- <span x-bind:class="{'bg-pink-50': isDuplicateVolunteer( schedule[eventName][group][role][event.id].volunteer_id, event.id, role, schedule[eventName][group][role][event.id].wp_user_id ) }" 
                                                                        x-text="schedule[eventName][group][role][event.id]?.first_name ? schedule[eventName][group][role][event.id].first_name : ''"></span>
                                                                    <button x-show="editCapability(schedule[eventName][group][role][event.id].wp_user_id)" class="dashicons dashicons-edit text-blue-400" @click="schedule[eventName][group][role][event.id].edit = true;"></button> -->
                                                                </div>
                                                                <!-- Voluteer Dropdown -->
                                                                <div x-show="!schedule[eventName][group][role][event.id]?.first_name || schedule[eventName][group][role][event.id].edit == true ">
                                                                    <template x-if="currentUserHasRole( group, role )">
                                                                        <div>
                                                                            <select x-model="schedule[eventName][group][role][event.id].selectedVolunteer" x-data-event-id="event.id" x-data-role="role" class="w-full"
                                                                                    x-on:change="saveVolunteer( schedule[eventName][group][role][event.id].schedule_id, schedule[eventName][group][role][event.id].selectedVolunteer, eventName, group, role, event.id )">
                                                                                <option value="">Select</option>
                                                                                <template x-if="allVolunteers[eventName][group] && allVolunteers[eventName][group][role]">
                                                                                    <template x-for="volunteer in Object.keys(allVolunteers[eventName][group][role])" :key="volunteer">
                                                                                        <option x-show="!((excludeDates[allVolunteers[eventName][group][role][volunteer].wp_user_id] || []).includes(event.date))" 
                                                                                            :value="volunteer" x-text="allVolunteers[eventName][group][role][volunteer].first_name" x-data-date="event.date" x-data-userid="volunteer.wp_user_id"></option>
                                                                                    </template>
                                                                                </template>
                                                                                <option value="None">None</option>
                                                                            </select>
                                                                        </div>
                                                                    </template>
                                                                </div>
                                                            </td>
                                                        </template>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </template>
                                        <tbody>
                                            <tr class="">
                                                <td class="font-semibold whitespace-nowrap bg-gray-200" style="vertical-align: top;">
                                                    Exclude
                                                </td>
                                                <template x-for="event in events">
                                                    <td class="whitespace-nowrap max-w-[60px] bg-gray-200" style="vertical-align: top;">
                                                        <div class="flex flex-wrap items-start">
                                                            <template x-if="excludeDatesbyDate[event.date.slice(0, 10)]"> 
                                                                <template x-for="name in excludeDatesbyDate[event.date.slice(0, 10)]">
                                                                    <div x-text="name" class="list-names mr-2 text-xs"></div>
                                                                </template>
                                                            </template>
                                                        </div>
                                                    </td>
                                                </template>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    
        <script>
            function table() {
                return {
                    events: [],
                    schedule: [],
                    allVolunteers: [],
                    excludeDates: [],
                    excludeDatesbyDate: [],
                    is_subscriber: <?php echo json_encode($is_subscriber); ?>,
                    current_user_id: <?php echo json_encode($current_user_id); ?>,
    
                    init () {
                        this.events = <?php echo json_encode($all_events); ?>;
                        this.schedule = <?php echo json_encode($all_schedule_roles); ?>;
                        this.allVolunteers = <?php echo json_encode($all_volunteers_data); ?>;
                        this.excludeDates = <?php echo json_encode($exclude_dates); ?>;
                        this.excludeDatesbyDate = <?php echo json_encode($all_exclude_dates["excludeDatesbyDate"]); ?>;
                    },
    
                    saveVolunteer( scheduleID, selectedVolunteer, eventName, group, role, eventID ) {
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
                                console.log(response);
                                console.error('Error saving volunteer:', response.statusText);
                                return;
                            }
                            // Handle successful response
                            console.log('Volunteer saved successfully!');
                            this.schedule[eventName][group][role][eventID].display_name = this.allVolunteers[eventName][group]?.[role]?.[selectedVolunteer]?.display_name ? this.allVolunteers[eventName][group][role][selectedVolunteer].display_name : '';
                            this.schedule[eventName][group][role][eventID].user_email = this.allVolunteers[eventName][group]?.[role]?.[selectedVolunteer]?.user_email ? this.allVolunteers[eventName][group][role][selectedVolunteer].user_email : '';
                            this.schedule[eventName][group][role][eventID].first_name = this.allVolunteers[eventName][group]?.[role]?.[selectedVolunteer]?.first_name ? this.allVolunteers[eventName][group][role][selectedVolunteer].first_name : '';
                            this.schedule[eventName][group][role][eventID].edit = this.allVolunteers[eventName][group]?.[role]?.[selectedVolunteer]?.display_name ? false : true; 
                            this.schedule[eventName][group][role][eventID].selectedVolunteer = ''; 
                        })
                        .catch(error => {
                            console.error('Error saving volunteer:', error);
                        });
                    },
    
                    isDuplicateVolunteer( volunteerID, eventID, roleInput, userIDInput, eventName ) {
                        var duplicate = false;
                        //Loop through Groups and Roles and return true if volunteerID is a duplicate.
                        // console.log('START ' + volunteerID + ' ' + eventID + ' ' + roleInput + ' ' + userIDInput );
                        for (const group in this.schedule[eventName]) {
                            for (const role in this.schedule[eventName][group]) {
                                if (roleInput !== role) {
                                    // console.log('eventID ' + eventID +' -- group ' + group + ' -- role ' + role + ' wp_user_id ' + this.schedule[eventName][group][role][eventID].wp_user_id);
                                        if (userIDInput == this.schedule[eventName][group][role][eventID].wp_user_id) {
                                            duplicate = true;
                                        }
                                }
                                // duplicate = true;
                            }
                        }
                        return duplicate; 
                    },

                    getEventLength() {
                        return this.events.length;
                    },

                    formatDate(dateString) {
                        const date = new Date(dateString);
                        const options = { month: 'short', day: 'numeric' };
                        return date.toLocaleDateString('en-US', options);
                    },

                    editCapability( userID ) {
                        if ( this.is_subscriber ) {
                            if ( userID == this.current_user_id ) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                        return true;
                    },

                    currentUserHasRole(group, role) {
                        if (this.is_subscriber) {
                            const volunteersForRole = this.allVolunteers[eventName][group][role]; // Object
                            if (typeof volunteersForRole === 'object' && volunteersForRole !== null) { // Check for valid object
                                for (const [volunteerId, volunteerInfo] of Object.entries(volunteersForRole)) {
                                    if (volunteerInfo.wp_user_id == this.current_user_id) {
                                        return true; // Found a match
                                        break;
                                    }
                                }
                            }
                            return false; // No match or invalid object
                        }
                        return true; // Default can be adjusted based on your logic
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
