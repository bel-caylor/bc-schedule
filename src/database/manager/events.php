<?php

class BCS_Events_Manager {

    public function __construct() {
        global $wpdb;
        $this->events_table = $wpdb->prefix . 'bcs_events';
        $this->schedule_table = $wpdb->prefix . 'bcs_schedule';
    }

    public function insert_event( $event_name, $event_date ) {
        global $wpdb;

        $result = $wpdb->insert(
            $this->events_table,
            array(
                'name' => $event_name,
                'date' => $event_date,
            )
        );

        if ($result) {
            //Add roles to Event
            $roles = $this->get_roles($event_name);
            $event_id = $wpdb->insert_id;
            foreach ($roles as $role) {
                $result = $wpdb->insert(
                    $this->schedule_table,
                    array(
                        'event_id' => $event_id,
                        'role_id' => $role->id,
                        'volunteer_id' => NULL,
                    )
                );
            }
        }
        return $result;
    }

    public function get_roles($event) {
        global $wpdb;
        return $wpdb->get_results( "
            SELECT * FROM {$wpdb->prefix}bcs_roles
            WHERE event_name = '$event';
        ");
    }
}