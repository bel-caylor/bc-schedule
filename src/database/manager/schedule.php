<?php

class BCS_Schedule_Manager {
    private $event_table;
    private $schedule_table;
    private $roles_table;
    private $teams_table;

    public function __construct() {
        global $wpdb;
        $this->event_table = $wpdb->prefix . 'bcs_events';
        $this->schedule_table = $wpdb->prefix . 'bcs_schedule';
        $this->roles_table = $wpdb->prefix . 'bcs_roles';
        $this->teams_table = $wpdb->prefix . 'bcs_teams';
        $this->teams_table = $wpdb->prefix . 'bcs_teams';
    }

    public function insert_schedule_date( $event_date, $event_name, $group_name, $team_id ) {
        global $wpdb;

        //Check for duplicate.
        $existing_event = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT id FROM $this->event_table WHERE name = %s AND date = %s",
                $event_name,
                $event_date
            )
        );
        if (!$existing_event) {
            //Add event date
            $insert_result = $wpdb->insert(
                $this->event_table,
                array(
                    'name' => $event_name,
                    'date' => $event_date,
                )
            );
            // Check if insert was successful (returns false on error)
            if (false !== $insert_result) {
                $event_id = $wpdb->insert_id;
            } else {
                echo "Failed to insert event: " . $wpdb->last_error;
            }

            // Add volunteers to event date.
            $team_volunteers = $wpdb->get_row(
                $wpdb->prepare(
                    "SELECT volunteers FROM $this->teams_table WHERE group_name = %s AND id = %s",
                    $group_name,
                    $team_id
                )
            );
            if ($team_volunteers) {
                $team_volunteers = json_decode($team_volunteers->volunteers);
            } else {
                return 'Select a team';
            }
            //Loop through $roles add line for each role to bcs_schedule table.
            //If there was a team selected add the volunteer_id.
            foreach ($team_volunteers as $key => $volunteer) {
                $volunteer_id = ($volunteer->volunteerID === '') ? NULL : $volunteer->volunteerID;

                //Get wp_user_id for $volunteer_id
                $user = $wpdb->get_row(
                    $wpdb->prepare(
                        "SELECT wp_user_id FROM {$wpdb->prefix}bcs_volunteers WHERE id = %s",
                        $volunteer_id
                    )
                );
                //Check exclude_dates to see if the volunteer is available.
                $available = $wpdb->get_row(
                    $wpdb->prepare(
                        "SELECT * FROM {$wpdb->prefix}bcs_exclude_dates WHERE date = %s AND user_id = %s",
                        $event_date,
                        $user->wp_user_id
                    )
                );
                if ($available) {
                    $volunteer_id = NULL;
                }

                $result = $wpdb->insert(
                    $this->schedule_table,
                    array(
                        'event_id'      => $event_id,
                        'role_id'       => $key,
                        'volunteer_id'  => $volunteer_id,
                        )
                    );
                }
            } else {
                $insert_result = $existing_event->id;
                //Loop through existing insert_result and role_id and add new role_id/volunteer_id if they don't exist.
            }
        return true;
    }
    
        
    public function get_schedule() {
        global $wpdb;
        $data = [];
        
        //GET Events
        $events = $wpdb->get_results( "
            SELECT * FROM {$wpdb->prefix}bcs_events
            WHERE date >= CURDATE()
            ORDER BY date ASC;
        ");
        $data["events"] = $events;

        //GET Groups
        $groups = $wpdb->get_results( "SELECT DISTINCT group_name FROM {$wpdb->prefix}bcs_roles;");
        foreach ($groups as $group) {

            //GET Roles by Group
            $roles_by_group = $wpdb->get_results( "
                SELECT id, group_name, role AS role_name FROM {$wpdb->prefix}bcs_roles WHERE group_name = '$group->group_name';
            ");
            $data["schedule"][$group->group_name] = [];
            $data["allVolunteers"][$group->group_name] = [];

            foreach ($roles_by_group as $role) {
                //Get Volunteers
                $volunteers = $wpdb->get_results( "
                    SELECT v.wp_user_id, u.display_name, u.user_email, r.group_name, r.role, v.id,
                    COALESCE(m.meta_value, '') AS first_name
                    FROM {$wpdb->prefix}bcs_volunteers v
                    JOIN {$wpdb->prefix}users u ON v.wp_user_id = u.ID
                    JOIN {$wpdb->prefix}bcs_roles r ON v.role_id = r.id
                    LEFT JOIN {$wpdb->prefix}usermeta m ON u.ID = m.user_id AND m.meta_key = 'first_name'
                    WHERE v.role_id = '$role->id'; 
                    " );
                // Handle potential empty results from the schedule query
                // $data["allVolunteers"][$group->group_name][$role->role_name] = $volunteers ? $volunteers : [];
                foreach ($volunteers as $volunteer) {    
                    $data["allVolunteers"][$group->group_name][$role->role_name][$volunteer->id] = $volunteer ? $volunteer : [];
                }

                //GET Schedule
                $schedule = $wpdb->get_results ( "
                    SELECT s.id AS schedule_id, s.event_id, s.volunteer_id, u.ID AS wp_user_id,
                    COALESCE(u.display_name, '') AS display_name,
                    COALESCE(u.user_email, '') AS user_email,
                    COALESCE(m.meta_value, '') AS first_name
                    FROM {$wpdb->prefix}bcs_schedule s
                    LEFT JOIN {$wpdb->prefix}bcs_volunteers v ON s.volunteer_id = v.id
                    LEFT JOIN {$wpdb->prefix}users u ON v.{$wpdb->prefix}user_id = u.ID
                    LEFT JOIN {$wpdb->prefix}usermeta m ON u.ID = m.user_id AND m.meta_key = 'first_name'
                    WHERE s.role_id = '$role->id'
                    ");
                foreach ($schedule as $schedule_row) {    
                    $data["schedule"][$group->group_name][$role->role_name][$schedule_row->event_id] = $schedule_row;
                    $data["schedule"][$group->group_name][$role->role_name][$schedule_row->event_id]->selectedVolunteer = '';
                    $data["schedule"][$group->group_name][$role->role_name][$schedule_row->event_id]->edit = false;
                }
            }
        }
        return $data;
    }

    public function save_volunteer( $schedule_id, $volunteer_id ) {
        global $wpdb;

        $result = $wpdb->update(
            $this->schedule_table,
            array(
                'volunteer_id' => $volunteer_id,
            ),
            array(
                'id' => $schedule_id,
            )
        );
    }
}