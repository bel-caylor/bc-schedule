<?php

class BCS_Teams_Manager {
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'bcs_teams';
    }

    public function insert_team( $group_name, $team_name, $volunteers ) {
        global $wpdb;

        $existing_row = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $this->table_name WHERE group_name = %s AND name = %s",
                $group_name,
                $team_name
            )
        );
        if (!$existing_row) {
            $result = $wpdb->insert(
                $this->table_name,
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

    public function get_teams() {
        global $wpdb;
        return $wpdb->get_results( "SELECT * FROM $this->table_name" );
    }

}

