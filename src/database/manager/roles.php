<?php

class BCS_Roles_Manager {
    private $table_name;
    private $schedule_table;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'bcs_roles';
        $this->schedule_table = $wpdb->prefix . 'bcs_schedule';
    }

    public function insert_role( $group, $role ) {
        global $wpdb;

        $existing_row = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $this->table_name WHERE group_name = %s AND role = %s",
                $group,
                $role
            )
        );
        if (!$existing_row) {
            $result = $wpdb->insert(
                $this->table_name,
                array(
                    'group_name' => $group,
                    'role'       => $role,
                )
            );

            $this->add_new_roles_to_schedule($wpdb->insert_id);

        } else {
            return 'duplicate';
        }
        return $result;
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
    }

    public function get_roles() {
        global $wpdb;
        return $wpdb->get_results( "SELECT * FROM $this->table_name" );
    }

    public function get_roles_data() {
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM $this->table_name", ARRAY_A);
    
        $roles_data = [];
        foreach ($results as $row) {
            $roles_data[] = [
                'id' => $row['id'],
                'group' => $row['group_name'],
                'role' => $row['role']
            ];
        }
    
        return $roles_data;
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

