<?php
require_once BC_SCHEDULE_PATH . '/src/admin/views/roles.php';
require_once BC_SCHEDULE_PATH . '/src/admin/views/volunteer.php';
require_once BC_SCHEDULE_PATH . '/src/database/db-manager.php';
require_once BC_SCHEDULE_PATH . '/src/database/api/delete_role.php';
require_once BC_SCHEDULE_PATH . '/src/admin/message.php';

// Add admin page to the menu
add_action('admin_menu', 'add_schedule_admin_page');

function add_schedule_admin_page() {
    // Add top-level menu page
    add_menu_page(
        'Schedule Settings', // Page Title
        'Schedule', // Menu Title
        'edit_pages', // Capability
        'volunteer-schedule', // Page slug
        'render_schedule_admin_page', // Callback to print HTML
        'dashicons-calendar', // Icon (optional)
        10 // Position (set to 1 for first section)
    );
    $nonce = wp_create_nonce('bcs_nonce');
    echo '<input type="hidden" id="bcs_nonce" value="' . esc_attr($nonce) . '">';
}

// Admin page HTML callback
function render_schedule_admin_page() {
    // Check user capabilities
    if (!current_user_can('edit_pages')) {
        return;
    }
    
    // Get the active tab from the $_GET parameter
    $default_tab = null;
    $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
    ?>

<!-- Our admin page content should all be inside .wrap -->
<div class="wrap">
    <!-- Print the page title -->
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <!-- Here are our tabs -->
    <nav class="nav-tab-wrapper">
        <a href="?page=volunteer-schedule" class="nav-tab <?php if ($tab === null) : ?>nav-tab-active<?php endif; ?>">Schedule</a>
            <a href="?page=volunteer-schedule&tab=roles" class="nav-tab <?php if ($tab === 'roles') : ?>nav-tab-active<?php endif; ?>">Roles</a>
            <a href="?page=volunteer-schedule&tab=volunteers" class="nav-tab <?php if ($tab === 'volunteers') : ?>nav-tab-active<?php endif; ?>">Volunteers</a>
    </nav>
                
    <div class="tab-content">
                <?php
        switch ($tab) {
            case 'roles':
                display_form_message();
                render_roles_add_form();
                render_roles_admin_table();
                break;
            case 'volunteers':
                display_form_message();
                render_volunteer_add_form();
                render_volunteer_admin_table();
                break;
            default:
                echo 'Schedule'; // Put your HTML here
                break;
        }
        ?>
    </div>
</div>
<?php
}
