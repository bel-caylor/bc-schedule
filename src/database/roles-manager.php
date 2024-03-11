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

    public function delete_role( $role_id ) {
        global $wpdb;
        $wpdb->delete( $this->table_name, array( 'id' => $role_id ) );
    }
}

// Example usage:
// $roles_manager = new BCS_Roles_Manager();
// $roles_manager->create_table();
// $roles_manager->insert_role( 'Admins', 'Administrator' );
// $roles_manager->insert_role( 'Editors', 'Editor' );

// // Get all roles
// $all_roles = $roles_manager->get_roles();
// foreach ( $all_roles as $role ) {
//     echo "Role ID: {$role->id}, Group Name: {$role->group_name}, Role: {$role->role}<br>";
// }
// ?>
