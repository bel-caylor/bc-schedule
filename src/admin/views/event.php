<?php
require_once BC_SCHEDULE_PATH . '/src/database/manager/volunteer.php';
require_once BC_SCHEDULE_PATH . '/src/database/manager/teams.php';
require_once BC_SCHEDULE_PATH . '/src/database/manager/roles.php';

function render_schedule_add_form() {
    $volunteers_manager = new BCS_Roles_Manager();
    $all_roles_data = $volunteers_manager->get_roles_data();
    $teams_manager = new BCS_Teams_Manager();
    $all_teams_data = $teams_manager->get_teams();
    ?>
    <div class="wrap">
        <h1>Add New Date</h1>
        <form method="post" action="admin-post.php">
            <?php wp_nonce_field('bcs_nonce'); ?>
            <input type="hidden" name="action" value="add_volunteer_action">

            <!-- Alpine.js app for dropdown boxes. -->
            <div x-data="dropdown()" x-init="init()">
                <div class="flex">
                    <!-- Group select -->
                    <div>
                        <label for="event-date">Event Name</label>
                        <input type="date" name="event-date" id="event-date" x-model="date">
                        <label for="event-name">Select Date:</label>
                        <input type="text" name="event-name" id="event-name" value="Communion-Worship">

                        <label for="group-select">Select a Group:</label>
                        <select id="group-select" x-model="selectedGroup" @change="filterTeams()" name="group-select">
                            <option value="">Select Group</option>
                            <template x-for="group in groups">
                                <option :value="group" x-text="group"></option>
                            </template>
                        </select>
                    </div>
    
                </div>
                <div class="flex">
                    <!-- Team select -->
                    <div class="pl-2" x-show="selectedGroup">
                        <label for="team-select">Select a Team:</label>
                        <select id="team-select" x-model="selectedTeam" name="team-select">
                            <option value="">Select Team</option>
                            <template x-for="team in filteredTeams">
                                <option :value="team.id" x-text="team.name"></option>
                            </template>
                        </select>
                    </div>
                    <input type="submit" name="add_schedule" value="Add schedule" x-show="selectedTeam && date">
                </div>
            </div>


            <script>
                function dropdown() {
                    return {
                        date: '',
                        selectedGroup: '',
                        selectedTeam: '',
                        groups: [],
                        filteredTeams: [],
                        allTeams: [],
                        allRoles: [],

                        init() {
                            this.allRoles = <?php echo json_encode($all_roles_data); ?>;
                            this.allTeams = <?php echo json_encode($all_teams_data); ?>;
                            // Populate unique groups
                            this.groups = [...new Set(this.allRoles.map(item => item.group))];
                        },

                        filterTeams() {
                            this.filteredTeams = this.allTeams.filter(item => item.group_name == this.selectedGroup)
                        },

                    };
                }
            </script>
        </form>

    </div>
    <?php
}