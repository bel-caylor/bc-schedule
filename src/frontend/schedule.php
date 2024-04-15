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
    $exclude_events = $schedule_manager->get_exclude_dates_by_date();

    if ($all_events) {
        $all_schedule_roles = $all_schedule['schedule'];
        $exclude_dates = $all_schedule['excludeDates'];

        ?>
        <div class="bcs-schedule">
            <?php foreach ($all_schedule_roles as $event_type => $events) : ?>
                <h2><?php echo $event_type ?></h2>
                <div class="table-wrapper">
                    <table>
                        <thead class="text-left">
                            <tr class="sticky top-0 left-0">
                                <th class="col-1 sticky top-0 left-0">Role</th>
                                <?php foreach ($all_events as $event) : ?>
                                    <th>
                                        <div><?php echo date('M j', strtotime($event->date)); ?></div>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($events as $group => $group_roles) : ?>
                                <tr class="border-t border-gray-200 text-white bg-[#005878]">
                                    <th colspan="<?php echo (count($all_events) + 1); ?>" scope="colgroup" class="!text-white bg-[#005878] col-1 sticky top-0 left-0 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">
                                        <?php echo $group; ?>
                                    </th>
                                </tr>
                                <?php foreach ($group_roles as $role => $role_events) : ?>
                                    <tr class="bg-white">
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
                            <tr class="bg-gray-100">
                                <td class="col-1 sticky top-0 left-0 font-semibold">Exclude</td>
                                <?php foreach ($all_events as $event) : ?>
                                    <td class="max-w-20">
                                        <div class="flex flex-wrap">
                                            <?php
                                                $date = date("Y-m-d", strtotime($event->date));
                                                foreach  ($exclude_events['excludeDatesbyDate'][$date] as $name) :
                                                    echo '<div class="list-names text-xs pr-2">' . $name . '</div>';
                                                endforeach;
                                            ?>
                                        </div>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    } else {
        echo '<div class="bcs-schedule">No schedule available.</div>';
    }
}