<?php
require_once BC_SCHEDULE_PATH . '/src/database/manager/volunteer.php';
require_once BC_SCHEDULE_PATH . '/src/database/manager/teams.php';
require_once BC_SCHEDULE_PATH . '/src/database/manager/roles.php';
require_once BC_SCHEDULE_PATH . '/src/database/manager/events.php';
require_once BC_SCHEDULE_PATH . '/src/database/api/add_event.php';

function render_schedule_add_form() {
    $roles_manager = new BCS_Roles_Manager();
    $all_roles_data = $roles_manager->get_roles_data();
    ?>
    <div class="wrap bcs input-area p-4 border border-gray-300 bg-white my-4">
        <h1>Add New Event Date</h1>
        <?php wp_nonce_field('bcs_nonce'); ?>
        <input type="hidden" name="action" value="add_volunteer_action">

        <!-- Alpine.js app for Add Events. -->
        <div x-data="event()" x-init="init()">
            <div class="flex flex-col gap-3">
                <div>
                    <label for="event-date">Select Date:</label>
                    <input type="date" name="event-date" id="event-date" x-model="date">
                </div>
                <div>
                    <label for="event-name">Select Event Type:</label>
                    <select id="event-select" x-model="selectedEvent" name="event-select">
                        <option value="">Select Event</option>
                        <template x-for="event in uniqueEventNames">
                            <option :value="event" x-text="event"></option>
                        </template>
                    </select>
                </div>
                <input  @click="saveEvent()" type="submit" :disabled="disabledSubmit()" class="button max-w-28 !mx-auto !mt-3">
            </div>

        </div>


        <script>
            function event() {
                return {
                    date: '',
                    selectedEvent: '',
                    allRoles: [],

                    init() {
                        this.allRoles = <?php echo json_encode($all_roles_data); ?>;
                    },

                    saveEvent() {
                        //Check for values
                        if ( this.selectedEvent === '' || this.date === '' ) {
                            return;
                        }
                        const data = {
                            event_name: this.selectedEvent,
                            event_date: this.date,
                        };
                        console.log(data);
                        fetch('/wp-json/bcs/v1/add_event', {
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
                            //Rest input
                            this.selectedEvent = '';
                            this.date = '';
                        })
                        .catch(error => {
                            console.error('Error saving event:', error);
                        });
                    },
                    
                    get uniqueEventNames() {
                        return [...new Set(this.allRoles.map(obj => obj.event_name))];
                    },

                    disabledSubmit() {
                        return this.date != '' && this.selectedEvent != '' ? false : true;
                    },

                };
            }
        </script>
    </div>
    <?php
}

function render_events_table() {
    global $wpdb;
    $wp_pre = $wpdb->prefix;

    // Retrieve roles from the database
    $exclude_date_manager = new BCS_Exclude_Date_Manager();
    $dates = $exclude_date_manager->get_exclude_dates();
    echo '<h2 class="text-lg font-bold">Excluded Dates for Volunteers</h2>';
    echo '<table class="table-admin">';
    echo '<thead><tr><th>ID</th><th>Date</th><th>Name</th><th>Trash</th></tr></thead>';
    echo '<tbody>';
    foreach ($dates as $date) {
        echo '<tr id="row-' . esc_html($date->id) . '">';
        echo '<td>' . esc_html($date->id) . '</td>';
        echo '<td>' . esc_html($date->date) . '</td>';
        echo '<td>' . esc_html($date->display_name) . '</td>';
        echo '<td><i class="dashicons dashicons-trash" data-table="' . $wp_pre . 'bcs_exclude_dates" data-row-id="' . esc_html($date->id) . '"></i></td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}