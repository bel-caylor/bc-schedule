<?php

class BCS_Volunteers_Manager {
    // private $volunteers;
    // private $users;
    // private $roles;

    public function __construct() {
        global $wpdb;
        $this->volunteers = $wpdb->prefix . 'bcs_volunteers';
        $this->users = $wpdb->prefix . 'users';
        $this->roles = $wpdb->prefix . 'bcs_roles';
    }

    public function insert_volunteer( $volunteer_id, $role_id ) {
        global $wpdb;

        $result = $wpdb->insert(
            $this->volunteers,
            array(
                'role_id'   => $role_id,
                'wp_user_id'=> $volunteer_id,
            )
        );
        
        return $result;
    }

    public function get_volunteer_page_data() {
        global $wpdb;
        $data = [];

        //GET All Roles
        $roles_manager = new BCS_Roles_Manager();
        $data["allRoles"] = $roles_manager->get_all_roles();

        //Get Users
        $data["allUsers"] = $this->get_users();

        //Get Volunteers
        $data["allVolunteers"] = $this->get_volunteers();

        return $data;
    }

    public function get_users() {
        global $wpdb;
        return $wpdb->get_results( "
            SELECT u.ID, u.display_name, 
            COALESCE(m.meta_value, '') AS last_name
            FROM {$wpdb->prefix}users u
            LEFT JOIN {$wpdb->prefix}usermeta m ON u.ID = m.user_id AND m.meta_key = 'last_name'
            ORDER BY last_name ASC;
        " );
    }

    public function get_volunteers() {
        global $wpdb;
        return $wpdb->get_results( "
            SELECT
                v.wp_user_id,
                u.display_name,
                r.event_name,
                r.group_name,
                r.role,
                v.role_id,
                v.id
            FROM
                $this->volunteers v
            JOIN
                $this->users u ON v.wp_user_id = u.ID
            JOIN
                $this->roles r ON v.role_id = r.id
            ORDER BY
                r.group_name ASC,
                r.role ASC;
        " );
    }
}
