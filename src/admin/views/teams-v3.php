<?php

function render_team_add_form() {
    $roles_manager = new BCS_Roles_Manager();
    $all_roles_data = $roles_manager->get_roles_data();
    $volunteers_manager = new BCS_Volunteers_Manager();
    $all_volunteers_data = $volunteers_manager->get_volunteers();
    $teams_manager = new BCS_Teams_Manager();
    $all_teams_data = $teams_manager->get_teams();
    ?>
    <div class="wrap">
        <form method="post" action="admin-post.php">
            <?php wp_nonce_field('bcs_nonce'); ?>
            <input type="hidden" name="action" value="add_team_action">

            <!-- Alpine.js app for dropdown boxes. -->
            <div x-data="alpineForm">
                <h1 x-show="!selectedGroup && !selectedTeamID">Add/Edit Team</h1>
                <h1 x-show="selectedGroup  && !selectedTeamID">Add Team</h1>
                <h1 x-show="selectedTeamID">Edit Team</h1>
                <div class="flex my-2" x-show="!selectedTeamID">

                    <!-- Group select -->
                    <div>
                        <label for="group-select">Add NEW Team:</label>
                        <select id="group-select" x-model="selectedGroup" @change="displayTeamRoles()" name="group-select">
                            <option value="">Select Group</option>
                            <template x-for="group in uniqueGroups" :key="group">
                                <option :value="group" x-text="group"></option>
                            </template>
                        </select>
                    </div>
                    <!-- Create new Team -->
                    <div class="pl-4" x-show="selectedGroup">
                        <label for="team">Create New Team:</label>
                        <input type="text" id="team" name="team" x-model="teamName">
                    </div>

                </div>
                <h2 class="font-bold mb-2" x-show="!selectedTeamID && !selectedGroup">OR</h2>

                <!-- Edit Existing Team -->
                <div x-show="!selectedGroup  || selectedTeamID">
                    <label for="team-select">Edit Existing Team:</label>
                    <select id="team-select" x-model="selectedTeamID" @change="displaySelectTeam()" name="team-select">
                        <option value="">Select Team</option>
                        <template x-for="team in allTeams" :key="team.id">
                            <option :value="team.id" x-text="teamSelectName(team)"></option>
                        </template>
                    </select>
                </div>

                <!-- Team Members -->
                <table class="table-admin my-6" x-show="teamName || selectedTeamID">
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th>Selected Volunteer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="role in teamRoles" :key="role.roleID">
                            <tr x-show="role.volunteers.length > 0">
                                <td class="" x-text="role.role"></td>
                                <td class="">
                                <select :id="role.roleID" :name="role.roleID" x-model="role.selectedVolunteer" @change="updateSelectedVolunteer(role.roleID, role.selectedVolunteer)">
                                    <option value="">Select Volunteer</option>
                                    <template x-for="volunteer in role.volunteers" :key="volunteer.id">
                                        <option :value="volunteer.id" x-text="volunteer.display_name"></option>
                                    </template>
                                </select>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <input type="hidden" name="selected_volunteers" :value="JSON.stringify(selectedVolunteers)">
                <input type="submit" name="add_team" value="Add Team" x-show="Object.keys(selectedVolunteers).length > 0">
            </div>

            <script>
                //* WP Data *//
                const roles = <?php echo json_encode($all_roles_data); ?>;
                const volunteers = <?php echo json_encode($all_volunteers_data); ?>;
                const teams = <?php echo json_encode($all_teams_data); ?>;

                Alpine.data('alpineForm', () => ({
                    selectedGroup: '',
                    selectedVolunteers: {},
                    selectedTeamID: '',
                    teamName: '',
                    teamRoles: [],
                    allRoles: [],
                    allTeams: [],
                    allVolunteers: [],
                    uniqueGroups: [],

                    init() {
                        this.allRoles = roles;
                        this.allVolunteers = volunteers;
                        this.allTeams = teams;
                        // Populate unique groups
                        this.uniqueGroups = [...new Set(volunteers.map(item => item.group_name))];
                    },

                    displayTeamRoles() {
                        const rolesToDisplay = this.allRoles.filter(item => item.group === this.selectedGroup);

                        // console.log(roles);
                        const teamRoles = [...new Set(rolesToDisplay.map(item => ({role: item.role, roleID: item.id})))];

                        // Create data from table dropdowns
                        this.teamRoles = teamRoles.map(role => ({
                            roleID: role.roleID,
                            role: role.role,
                            volunteers: this.findVolunteersForRole(role.role),
                            selectedVolunteer: '',
                        }));

                        // Create selected volunteer data.
                        this.selectedVolunteers = Object.fromEntries(
                            teamRoles.map(role => ([role.roleID, { role: role.role, volunteerID: '' }]))
                        );
                    },

                    findVolunteersForRole(role) {
                        return this.allVolunteers.filter(item => item.group_name === this.selectedGroup && item.role === role);
                    },

                    teamSelectName(team) {
                        return `${team.group_name} - ${team.name}`;
                    },

                    displaySelectTeam() {
                        const team = this.allTeams.find(item => item.id === this.selectedTeamID);
                        if (team) {
                            this.selectedGroup = team.group_name;
                            this.displayTeamRoles();

                            const teamVolunteers = JSON.parse(team.volunteers || '{}');

                            //Loop through teamRoles and selectedVolunteer
                            this.teamRoles.forEach(item => {
                                // Check if the role exists in the teamVolunteers object
                                if (teamVolunteers[item.roleID]) {
                                    const volunteerID = teamVolunteers[item.roleID].volunteerID;
                                    item.selectedVolunteer = volunteerID;
                                }
                            });
                        }
                    },

                    updateSelectedVolunteer(roleID, selectedVolunteer) {
                        this.selectedVolunteers[roleID] = { role: this.selectedVolunteers[roleID].role, volunteerID: selectedVolunteer };
                    }
                }));

                Alpine.start();
            </script>
            <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v3.13.7/dist/alpine.min.js" defer></script>
        </form>

    </div>
<?php
}