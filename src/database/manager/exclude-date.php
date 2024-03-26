<?php

class BCS_Exclude_Date_Manager {
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'bcs_exclude_dates';
    }

    public function insert_date( $user_id, $date ) {
        global $wpdb;

        $existing_row = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $this->table_name WHERE user_id = %s AND date = %s",
                $user_id,
                $date
            )
        );
        if (!$existing_row) {
            $result = $wpdb->insert(
                $this->table_name,
                array(
                    'user_id' => $user_id,
                    'date'    => $date,
                )
            );
        } else {
            return 'duplicate';
        }
        return $result;
    }

    public function get_users() {
        global $wpdb;
        return $wpdb->get_results( "SELECT ID, display_name FROM {$wpdb->prefix}users" );
    }

    public function get_exclude_dates() {
        global $wpdb;
        return $wpdb->get_results( "
            SELECT x.id, u.display_name, x.date 
            FROM {$wpdb->prefix}bcs_exclude_dates x
            JOIN {$wpdb->prefix}users u ON x.user_id = u.ID
            WHERE date >= CURDATE()
            ORDER BY date ASC;
        " );
    }
}

