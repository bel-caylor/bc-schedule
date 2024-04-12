<?php
require_once BC_SCHEDULE_PATH . '/src/admin/views/schedule.php';
require_once BC_SCHEDULE_PATH . '/src/admin/views/event.php';
require_once BC_SCHEDULE_PATH . '/src/admin/views/roles.php';
require_once BC_SCHEDULE_PATH . '/src/admin/views/volunteer.php';
require_once BC_SCHEDULE_PATH . '/src/admin/views/teams.php';
require_once BC_SCHEDULE_PATH . '/src/admin/views/exclude-dates.php';
require_once BC_SCHEDULE_PATH . '/src/admin/message.php';
require_once BC_SCHEDULE_PATH . '/src/database/manager/database.php';

// Add admin page to the menu
add_action('admin_menu', 'add_schedule_admin_page');

function add_schedule_admin_page() {
    // Add top-level menu page
    add_menu_page(
        'Schedule Settings', // Page Title
        'Schedule', // Menu Title
        'read', // Capability
        'volunteer-schedule', // Page slug
        'render_schedule_admin_page', // Callback to print HTML
        'dashicons-calendar', // Icon (optional)
        10 // Position (set to 1 for first section)
    );
}

// Admin page HTML callback
function render_schedule_admin_page() {
    $bcs_nonce = wp_create_nonce('bcs_nonce');
    echo '<input type="hidden" id="bcs_nonce" value="' . esc_attr($bcs_nonce) . '">';
    // Get the active tab from the $_GET parameter
    $default_tab = null;
    $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;

    // Check if the user is a subscriber
    $is_editor = current_user_can('edit_posts');

    ?>

    <!-- Our admin page content should all be inside .wrap -->
    <div class="wrap">
        <!-- Print the page title -->
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

        <!-- Here are our tabs -->
        <nav class="nav-tab-wrapper">
            <?php if ($is_editor) : ?>
                <!-- Show all tabs for editors -->
                <a href="?page=volunteer-schedule" class="nav-tab <?php if ($tab === null) : ?>nav-tab-active<?php endif; ?>">Schedule</a>
                <a href="?page=volunteer-schedule&tab=roles" class="nav-tab <?php if ($tab === 'roles') : ?>nav-tab-active<?php endif; ?>">Roles</a>
                <a href="?page=volunteer-schedule&tab=volunteers" class="nav-tab <?php if ($tab === 'volunteers') : ?>nav-tab-active<?php endif; ?>">Volunteers</a>
                <a href="?page=volunteer-schedule&tab=teams" class="nav-tab <?php if ($tab === 'teams') : ?>nav-tab-active<?php endif; ?>">Teams</a>
                <a href="?page=volunteer-schedule&tab=events" class="nav-tab <?php if ($tab === 'events') : ?>nav-tab-active<?php endif; ?>">Events</a>
                <a href="?page=volunteer-schedule&tab=exclude-dates" class="nav-tab <?php if ($tab === 'exclude-dates') : ?>nav-tab-active<?php endif; ?>">Exclude Dates</a>
            <?php else : ?>
                <!-- Show only the "Schedule" tab for non-editors -->
                <a href="?page=volunteer-schedule" class="nav-tab <?php if ($tab === null) : ?>nav-tab-active<?php endif; ?>">Schedule</a>
                <a href="?page=volunteer-schedule&tab=exclude-dates" class="nav-tab <?php if ($tab === 'exclude-dates') : ?>nav-tab-active<?php endif; ?>">Exclude Dates</a>
            <?php endif; ?>
        </nav>

        <div class="tab-content">
            <?php
            switch ($tab) {
                case 'roles':
                    if ($is_editor) {
                        display_form_message();
                        render_roles_page();
                    }
                    break;
                case 'volunteers':
                    if ($is_editor) {
                        display_form_message();
                        render_volunteer_page();
                    }
                    break;
                case 'teams':
                    if ($is_editor) {
                        display_form_message();
                        render_teams_page();
                    }
                    break;
                case 'events':
                    if ($is_editor) {
                        render_schedule_add_form();
                    }
                    break;
                case 'exclude-dates':
                    render_exclude_dates_form();
                    render_exclude_dates_table();
                    break;
                default:
                    render_schedule_admin_table();
                    break;
            }
            ?>
        </div>
    </div>
    <?php
}
