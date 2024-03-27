<?php

class BCS_Volunteers_Manager {
    private $volunteers;
    private $users;
    private $roles;

    public function __construct() {
        global $wpdb;
        $this->volunteers = $wpdb->prefix . 'bcs_volunteers';
        $this->users = $wpdb->prefix . 'users';
        $this->roles = $wpdb->prefix . 'bcs_roles';
    }

    public function insert_volunteer( $volunteer_id, $role_id ) {
        global $wpdb;

        $existing_row = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $this->volunteers WHERE role_id = %s AND wp_user_id = %s",
                $role_id ,
                $volunteer_id
            )
        );
        if (!$existing_row) {
            $result = $wpdb->insert(
                $this->volunteers,
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
                v.wp_user_id,
                u.display_name,
                r.group_name,
                r.role,
                v.id
            FROM
                $this->volunteers v
            JOIN
                $this->users u ON v.wp_user_id = u.ID
            JOIN
                $this->roles r ON v.role_id = r.id;

        " );
    }
}
