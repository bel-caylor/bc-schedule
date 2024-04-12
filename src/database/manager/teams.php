<?php

class BCS_Teams_Manager {

    public function __construct() {
        global $wpdb;
        $this->team_table = $wpdb->prefix . 'bcs_teams';
    }

    public function insert_team_volunteer( $group_name, $team_name, $volunteers ) {
        global $wpdb;

        $existing_row = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $this->team_table WHERE group_name = %s AND name = %s",
                $group_name,
                $team_name
            )
        );
        if (!$existing_row) {
            $result = $wpdb->insert(
                $this->team_table,
                array(
                    'name'       => $team_name,
                    'group_name' => $group_name,
                    'volunteers' => $volunteers,
                )
            );
        } else {
            return 'duplicate';
        }
        return $result;
    }

    public function get_team_page_data() {

        //GET All Roles
        $roles_manager = new BCS_Roles_Manager();
        $data["allRoles"] = $roles_manager->get_all_roles();

        //Get Volunteers
        $volunteer_manager = new BCS_Volunteers_Manager();
        $data["allVolunteers"] = $volunteer_manager->get_volunteers();

        //Setup team table data
        // $data["teamTable"] = $this->get_team_table();

        //Get Teams
        $table_data = $this->get_team_table();
        $data["allTeams"] = $table_data['allTeams'];
        $data["allVolunteers"] = $table_data['allVolunteers'];
        $data["teamsByEvent"] = $this->get_teams_by_event();

        //Get Dates that need teams
        $data["emptyEvents"] = $this->get_empty_events_by_group();

        return $data;
    }

    public function get_team_table() {
        global $wpdb;
        //GET Event Types
        $events = $wpdb->get_results( "SELECT DISTINCT event_name FROM {$wpdb->prefix}bcs_roles;");
        foreach ($events as $event) {
            //GET Groups
            $groups = $wpdb->get_results( "SELECT DISTINCT group_name FROM {$wpdb->prefix}bcs_roles WHERE event_name = '$event->event_name';");
            $data["allTeams"][$event->event_name] = [];
            $data["allVolunteers"][$event->event_name] = [];
            foreach ($groups as $group) {

                //GET Roles by Group
                $roles_by_group = $wpdb->get_results( "SELECT id, group_name, role AS role_name FROM {$wpdb->prefix}bcs_roles 
                                                       WHERE event_name = '$event->event_name' AND group_name = '$group->group_name';
                ");
                $data["allTeams"][$event->event_name][$group->group_name] = [];
                $data["allVolunteers"][$event->event_name][$group->group_name] = [];

                foreach ($roles_by_group as $role) {
                    //GET Volunteers
                    $volunteers = $wpdb->get_results( "
                        SELECT v.wp_user_id, u.display_name, u.user_email, r.group_name, r.role, v.id,
                        COALESCE(m.meta_value, '') AS first_name
                        FROM {$wpdb->prefix}bcs_volunteers v
                        JOIN {$wpdb->prefix}users u ON v.wp_user_id = u.ID
                        JOIN {$wpdb->prefix}bcs_roles r ON v.role_id = r.id
                        LEFT JOIN {$wpdb->prefix}usermeta m ON u.ID = m.user_id AND m.meta_key = 'first_name'
                        WHERE v.role_id = '$role->id'; 
                        " );
                    foreach ($volunteers as $volunteer) {    
                        $data["allVolunteers"][$event->event_name][$group->group_name][$role->role_name][$volunteer->id] = $volunteer ? $volunteer : [];
                    }
                }

                //GET Teams
                $volunteer_data = array(
                    'wp_user_id' => '',
                    'display_name' => '',
                    'first_name' => '',
                    'edit' => true,
                    'selected_user_id' => '',
                );
                $teams = $wpdb->get_results ( "
                    SELECT DISTINCT name
                    FROM {$wpdb->prefix}bcs_teams
                    WHERE event_name = '$event->event_name' AND group_name = '$group->group_name'
                    ");
                if ($teams) {
                    foreach ($roles_by_group as $role) {
                        foreach ($teams as $team) {
                            $volunteer = $wpdb->get_results ( "
                                SELECT t.id AS team_id, t.name AS team_name, r.role AS role, t.wp_user_id, u.display_name,
                                COALESCE(m.meta_value, '') AS first_name
                                FROM {$wpdb->prefix}bcs_teams t
                                JOIN {$wpdb->prefix}bcs_roles r ON r.id = t.role_id
                                JOIN {$wpdb->prefix}users u ON t.wp_user_id = u.ID
                                LEFT JOIN {$wpdb->prefix}usermeta m ON u.ID = m.user_id AND m.meta_key = 'first_name'
                                WHERE t.event_name = '$event->event_name' AND t.group_name = '$group->group_name' 
                                AND t.name = '$team->name' AND t.role_id = '$role->id';
                            ");
                            if ($volunteer) {
                                $data["allTeams"][$event->event_name][$group->group_name][$role->role_name][$team->name] 
                                    = array(
                                        'wp_user_id' => $volunteer[0]->wp_user_id,
                                        'display_name' => $volunteer[0]->display_name,
                                        'first_name' => $volunteer[0]->first_name,
                                        'edit' => false,
                                        'selected_user_id' => '',
                                    );
                            } else {
                                $data["allTeams"][$event->event_name][$group->group_name][$role->role_name][$team->name] = $volunteer_data;
                            }
                        }
                    }
                } else {
                    $teams = $wpdb->get_results ( "
                        SELECT DISTINCT name
                        FROM {$wpdb->prefix}bcs_teams
                        WHERE event_name = '$event->event_name'
                    ");
                    foreach ($teams as $team) {
                        foreach ($roles_by_group as $role) {
                            $data["allTeams"][$event->event_name][$group->group_name][$role->role_name][$team->name] = $volunteer_data;
                        }
                    }
                }
            }
        }
        return $data;
    }

    public function get_teams_by_event() {
        global $wpdb;
        $events = $wpdb->get_results( "SELECT DISTINCT event_name FROM $this->team_table" );
        foreach ($events as $event) {
            $teams = $wpdb->get_results( "SELECT DISTINCT name FROM $this->team_table WHERE event_name = '$event->event_name'" );
            $data[$event->event_name] = $teams;
        }
        return $data;
    }

    public function get_empty_events_by_group() {
        global $wpdb;
        return $wpdb->get_results( "
            SELECT s.event_id, e.name AS event_name, r.group_name, e.date
            FROM {$wpdb->prefix}bcs_schedule s
            JOIN {$wpdb->prefix}bcs_roles r ON r.id = s.role_id
            JOIN {$wpdb->prefix}bcs_events e ON e.id = s.event_id
            GROUP BY s.event_id, r.group_name
            HAVING COUNT(DISTINCT s.volunteer_id) = 0;
        " );
    }
}

