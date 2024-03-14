<?php

class BCS_Volunteers_Manager {
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'bcs_volunteers';
    }

    public function insert_volunteer( $volunteer_id, $role_id ) {
        global $wpdb;

        $existing_row = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $this->table_name WHERE role_id = %s AND wp_user_id = %s",
                $role_id ,
                $volunteer_id
            )
        );
        if (!$existing_row) {
            $result = $wpdb->insert(
                $this->table_name,
                array(
                    'role_id'   => $role_id,
                    'wp_user_id'=> $volunteer_id,
                )
            );
        } else {
            return 'duplicate';
        }
        return $result;
    }

    public function get_volunteers() {
        global $wpdb;
        return $wpdb->get_results( "
            SELECT
                wp_BCS_volunteers.wp_user_id,
                wp_users.display_name,
                wp_BCS_roles.group_name,
                wp_BCS_roles.role,
                wp_BCS_volunteers.id
            FROM
                wp_BCS_volunteers
            JOIN
                wp_users ON wp_BCS_volunteers.wp_user_id = wp_users.ID
            JOIN
                wp_BCS_roles ON wp_BCS_volunteers.role_id = wp_BCS_roles.id;

        " );
    }
}
