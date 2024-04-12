<?php

class BCS_Roles_Manager {

    public function __construct() {
        global $wpdb;
        $this->roles_table = $wpdb->prefix . 'bcs_roles';
        $this->schedule_table = $wpdb->prefix . 'bcs_schedule';
    }

    public function get_roles_page_data() {
        global $wpdb;
        $data = [];

        //GET Event Names
        $data["allEventNames"] = $wpdb->get_results( "
            SELECT event_name FROM {$wpdb->prefix}bcs_roles
            GROUP BY event_name
        ");

        //GET Event Names
        $data["allGroups"] = $wpdb->get_results( "
            SELECT group_name FROM {$wpdb->prefix}bcs_roles
            GROUP BY group_name
        ");

        //GET Event Names
        $data["allRoles"] = $this->get_all_roles();

        return $data;
    }

    public function get_all_roles() {
        global $wpdb;
        return $wpdb->get_results( "
            SELECT * FROM {$wpdb->prefix}bcs_roles
            ORDER BY event_name ASC, group_name ASC;
        ");
    }

    public function insert_role( $event_name, $group_name, $role ) {
        global $wpdb;

        $result = $wpdb->insert(
            $this->roles_table,
            array(
                'event_name' => $event_name,
                'group_name' => $group_name,
                'role'       => $role,
            )
        );
        if ($result) {
            $result_schedule = $this->add_new_roles_to_schedule($wpdb->insert_id);
            if (!$result_schedule) {
                $data['allRoles'] = $this->get_all_roles();
                $response = new WP_REST_Response(array('allRoles' =>  $data['allRoles']));
                $response->set_status(200);
                return $response;
            }
        }
        $response = new WP_REST_Response();
        $response->set_status(400);
        return $response;
    }

    public function add_new_roles_to_schedule($role_id) {
        global $wpdb;

        $events = $wpdb->get_results( "
            SELECT * FROM {$wpdb->prefix}bcs_events
            WHERE date >= CURDATE();
        ");

        foreach ($events as $event) {
            $result = $wpdb->insert(
                $this->schedule_table,
                array(
                    'event_id'      => $event->id,
                    'role_id'       => $role_id,
                    'volunteer_id'  => NULL,
                    )
                );
        }
        return $wpdb->last_error;
    }

    public function get_roles_data() {
        global $wpdb;
        $results = $wpdb->get_results("
            SELECT * FROM $this->roles_table
        ", ARRAY_A);
    
        return $results;
    }

    public function delete_schedule_events($role_id) {
        global $wpdb;

        $sql = $wpdb->prepare("DELETE FROM {$wpdb->prefix}bcs_schedule
                                WHERE role_id = %d", $role_id);
        $wpdb->query($sql);

        // return $wpdb->last_error;
    }

    public function delete_volunteers($role_id) {
        global $wpdb;

        $sql = $wpdb->prepare("DELETE FROM {$wpdb->prefix}bcs_volunteers
                                WHERE role_id = %d", $role_id);
        $wpdb->query($sql);

        // return $wpdb->last_error;
    }    
}

