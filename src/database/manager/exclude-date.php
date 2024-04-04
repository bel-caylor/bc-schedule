<?php

class BCS_Exclude_Date_Manager {
    private $exclude_dates;
    private $schedule;

    public function __construct() {
        global $wpdb;
        $this->exclude_dates = $wpdb->prefix . 'bcs_exclude_dates';
        $this->schedule = $wpdb->prefix . 'bcs_schedule';
    }

    public function insert_date( $user_id, $date ) {
        global $wpdb;

        $existing_row = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $this->exclude_dates 
                WHERE user_id = %s AND date = %s",
                $user_id,
                $date
            )
        );
        if (!$existing_row) {
            $result = $wpdb->insert(
                $this->exclude_dates,
                array(
                    'user_id' => $user_id,
                    'date'    => $date,
                )
            );

            // Determine if the volunteer is already scheduled for the date and de
            $volunteer_ids = $wpdb->get_results( "
                SELECT v.id
                FROM {$wpdb->prefix}bcs_volunteers v
                WHERE v.wp_user_id = $user_id;
            " );
            $event  = $wpdb->get_results( "
                SELECT *
                FROM {$wpdb->prefix}bcs_events e
                WHERE DATE(e.date) = '$date';
            " );
            $result_ary = [];
            foreach ($volunteer_ids as $volunteer_id) {
                $result = $wpdb->update(
                    $this->schedule,
                    array(
                        'volunteer_id' => NULL,
                    ),
                    array(
                        'volunteer_id' => $volunteer_id->id,
                        'event_id' => $event[0]->id,
                        )
                    );
            }
            return true;
        } else {
            return 'duplicate';
        }
        return $result;
    }

    public function get_users() {
        global $wpdb;
        return $wpdb->get_results( "
            SELECT ID, display_name 
            FROM {$wpdb->prefix}users
            ORDER BY display_name ASC;
        " );
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

    public function get_event_dates() {
        global $wpdb;
        return $wpdb->get_results( "
            SELECT * FROM {$wpdb->prefix}bcs_events
            WHERE date >= CURDATE()
            ORDER BY date ASC;
        " );
    }
}

