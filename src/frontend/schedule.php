<?php
/**
 * Render the schedule on the frontend
 */
function render_schedule_frontend() {
    global $wpdb;

    // Retrieve schedule from the database
    $schedule_manager = new BCS_Schedule_Manager();
    $all_schedule = $schedule_manager->get_schedule();
    $all_events = $all_schedule['events'];

    if ($all_events) {
        $all_schedule_roles = $all_schedule['schedule'];
        $all_volunteers_data = $all_schedule['allVolunteers'];
        $exclude_dates = $all_schedule['excludeDates'];

        ?>
        <div class="bcs-schedule">
            <div class="flex justify-between items-center">
                <h2>Upcoming Schedule</h2>
                <a href="/wp-admin/admin.php?page=volunteer-schedule" class="bg-blue-800 text-white rounded-md px-4 hover:bg-blue-500 hover:text-white">Edit Schedule</a>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead class="text-left">
                        <tr class="sticky top-0 left-0">
                            <th class="col-1 sticky top-0 left-0">Role</th>
                            <?php foreach ($all_events as $event) : ?>
                                <th>
                                    <div><?php echo date('M j', strtotime($event->date)); ?></div>
                                    <div><?php echo $event->name; ?></div>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_schedule_roles as $group => $group_roles) : ?>
                            <?php foreach ($group_roles as $role => $role_events) : ?>
                                <tr>
                                    <td class="col-1 sticky top-0 left-0 font-semibold"><?php echo $role; ?></td>
                                    <?php foreach ($all_events as $event) : ?>
                                        <td>
                                            <?php
                                            $volunteer = isset($role_events[$event->id]) ? $role_events[$event->id] : null;
                                            if ($volunteer) {
                                                echo $volunteer->first_name;
                                            }
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    } else {
        echo '<div class="bcs-schedule">No schedule available.</div>';
    }
}