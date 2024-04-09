<?php
require_once BC_SCHEDULE_PATH . '/src/database/form/add_volunteer.php';
require_once BC_SCHEDULE_PATH . '/src/database/form/add_team.php';
require_once BC_SCHEDULE_PATH . '/src/database/form/edit_team.php';
require_once BC_SCHEDULE_PATH . '/src/database/form/add_schedule.php';
require_once BC_SCHEDULE_PATH . '/src/database/form/add_excluded_dates.php';

function BCS_form_submission_handler() {

    //** Add volunteer **//
    if (isset($_POST['add_volunteer'])) {
        BCS_form_add_volunteer();
    }

    //** Add team **//
    if (isset($_POST['add_team'])) {
        BCS_form_add_team();
    }

    //** Edit team **//
    if (isset($_POST['edit_team'])) {
        BCS_form_edit_team();
    }

    //** Schedule team **//
    if (isset($_POST['add_schedule'])) {
        BCS_form_add_schedule();
    }

    //** Add Excluded Dates **//
    if (isset($_POST['exclude_date_for_user'])) {
        BCS_form_add_excluded_dates();
    }
}
add_action('init', 'bcs_form_submission_handler');

?>