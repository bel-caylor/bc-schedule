<?php
global $wpdb;

// Define table names
$table_roles = $wpdb->prefix . 'bcs_roles';
$table_volunteers = $wpdb->prefix . 'bcs_volunteers';
$table_events = $wpdb->prefix . 'bcs_events';
$table_schedule = $wpdb->prefix . 'bcs_schedule';
$table_teams = $wpdb->prefix . 'bcs_teams';

// Create Roles table
$sql_roles = "CREATE TABLE $table_roles (
    id INT NOT NULL AUTO_INCREMENT,
    group_name VARCHAR(255),
    role VARCHAR(255),
    PRIMARY KEY (id)
)";

// Create Volunteers table
$sql_volunteers = "CREATE TABLE $table_volunteers (
    id INT NOT NULL AUTO_INCREMENT,
    role_id INT,
    wp_user_id INT,
    PRIMARY KEY (id),
    FOREIGN KEY (role_id) REFERENCES $table_roles(id),
    FOREIGN KEY (wp_user_id) REFERENCES wp_users(ID)
)";

// Create Teams table
$sql_teams = "CREATE TABLE $table_teams (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255),
    group_name VARCHAR(255),
    volunteers LONGTEXT,
    PRIMARY KEY (id)
)";

// Create Events table
$sql_events = "CREATE TABLE $table_events (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255),
    type VARCHAR(255),
    PRIMARY KEY (id)
)";

// Create Schedule table
$sql_schedule = "CREATE TABLE $table_schedule (
    event_id INT,
    role_id INT,
    volunteer_id INT,
    FOREIGN KEY (event_id) REFERENCES $table_events(id),
    FOREIGN KEY (role_id) REFERENCES $table_roles(id),
    FOREIGN KEY (volunteer_id) REFERENCES $table_volunteers(id)
)";

// Execute SQL queries
require_once ABSPATH . 'wp-admin/includes/upgrade.php';
dbDelta($sql_roles);
dbDelta($sql_volunteers);
dbDelta($sql_events);
dbDelta($sql_schedule);
dbDelta($sql_teams);
