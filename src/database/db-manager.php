<?php

class BCS_db_Manager {

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'BCS_volunteers';
    }

    public function delete_row_from_tbl( $row_id, $table_name ) {
        global $wpdb;
        $result = $wpdb->delete( $table_name, array( 'id' => $row_id ) );
        return $result;
        // return $wpdb->last_error;
    }

}