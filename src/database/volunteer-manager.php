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
                "SELECT * FROM $this->table_name WHERE role_id = %s AND {$wpdb->prefix}user_id = %s",
                $role_id ,
                $volunteer_id
            )
        );
        if (!$existing_row) {
            $result = $wpdb->insert(
                $this->table_name,
                array(
                    'role_id'   => $role_id,
                    '{$wpdb->prefix}user_id'=> $volunteer_id,
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
                {$wpdb->prefix}BCS_volunteers.{$wpdb->prefix}user_id,
                {$wpdb->prefix}users.display_name,
                {$wpdb->prefix}BCS_roles.group_name,
                {$wpdb->prefix}BCS_roles.role,
                {$wpdb->prefix}BCS_volunteers.id
            FROM
                {$wpdb->prefix}BCS_volunteers
            JOIN
                {$wpdb->prefix}users ON {$wpdb->prefix}BCS_volunteers.{$wpdb->prefix}user_id = {$wpdb->prefix}users.ID
            JOIN
                {$wpdb->prefix}BCS_roles ON {$wpdb->prefix}BCS_volunteers.role_id = {$wpdb->prefix}BCS_roles.id;

        " );
    }
}
