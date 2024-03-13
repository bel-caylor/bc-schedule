<?php

class BCS_Roles_Manager {
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'BCS_roles';
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
        } else {
            return 'duplicate';
        }
        return $result;
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
}

