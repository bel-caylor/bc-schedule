<?php
global $wpdb;

// Define table names
$table_roles = $wpdb->prefix . 'bcs_roles';
$table_volunteers = $wpdb->prefix . 'bcs_volunteers';
$table_events = $wpdb->prefix . 'bcs_events';
$table_schedule = $wpdb->prefix . 'bcs_schedule';
$table_teams = $wpdb->prefix . 'bcs_teams';
$table_exclude = $wpdb->prefix . 'bcs_exclude_dates';
$table_users = $wpdb->prefix . 'users';

// Create Roles table
$sql_roles = "CREATE TABLE $table_roles (
    id INT NOT NULL AUTO_INCREMENT,
    group_name VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
)";

// Create Volunteers table
$sql_volunteers = "CREATE TABLE $table_volunteers (
    id INT NOT NULL AUTO_INCREMENT,
    role_id INT NOT NULL,
    {$wpdb->prefix}user_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (role_id) REFERENCES $table_roles(id),
    FOREIGN KEY ({$wpdb->prefix}user_id) REFERENCES $table_users(ID)
) ENGINE=InnoDB";

// Create Teams table
$sql_teams = "CREATE TABLE $table_teams (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    group_name VARCHAR(255) NOT NULL,
    volunteers LONGTEXT NOT NULL,
    PRIMARY KEY (id)
)";

// Create Events table
$sql_events = "CREATE TABLE $table_events (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    date date NOT NULL,
    PRIMARY KEY (id)
)";

// Create Schedule table
$sql_schedule = "CREATE TABLE $table_schedule (
    id INT NOT NULL AUTO_INCREMENT,
    event_id INT NOT NULL,
    role_id INT NOT NULL,
    volunteer_id INT DEFAULT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (event_id) REFERENCES $table_events(id),
    FOREIGN KEY (role_id) REFERENCES $table_roles(id)
    -- FOREIGN KEY (volunteer_id) REFERENCES $table_volunteers(id)
) ENGINE=InnoDB";

// Create Excuted Dates table
$sql_exclude_dates = "CREATE TABLE $table_exclude (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    user_id bigint(20) UNSIGNED NOT NULL,
    date date NOT NULL,
    PRIMARY KEY  (id)
)";

// Execute SQL queries
require_once ABSPATH . 'wp-admin/includes/upgrade.php';
dbDelta($sql_roles);
dbDelta($sql_volunteers);
dbDelta($sql_teams);
dbDelta($sql_events);
dbDelta($sql_exclude_dates);
dbDelta($sql_schedule);