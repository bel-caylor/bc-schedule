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

    /**
     * Updates an existing team's information.
     *
     * @param string $group_name   The name of the group.
     * @param string $team_name    The name of the team to edit.
     * @param string $volunteers   The updated volunteer information.
     *
     * @return mixed|string        Returns 'success' if the update was successful,
     *                            'duplicate' if the team already exists,
     *                            'team not found' if the team doesn't exist,
     *                            or an error message.
     */
    public function edit_team( $group_name, $team_name, $volunteers ) {
        global $wpdb;

        // Check if the team exists.
        $existing_row = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $this->table_name WHERE group_name = %s AND name = %s",
                $group_name,
                $team_name
            )
        );

        if ( $existing_row ) {
            // Update the team's information.
            $result = $wpdb->update(
                $this->table_name,
                array(
                    'volunteers' => $volunteers,
                ),
                array(
                    'group_name' => $group_name,
                    'name'       => $team_name,
                )
            );

            if ( false !== $result ) {
                return 'success';
            } else {
                return 'error updating team';
            }
        } else {
            return 'team not found';
        }
    }


    public function get_teams() {
        global $wpdb;
        return $wpdb->get_results( "SELECT * FROM $this->table_name" );
    }

}

