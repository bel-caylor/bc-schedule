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
            <div x-data="alpineForm()" x-init="init()">
                <h1 x-show="!selectedGroup && !selectedTeamID">Add/Edit Team</h1>
                <h1 x-show="selectedGroup  && !selectedTeamID">Add Team</h1>
                <h1 x-show="selectedTeamID">Edit Team</h1>
                <div class="flex my-2" x-show="!selectedTeamID">

                    <!-- Group select -->
                    <div>
                        <label for="group-select">Add NEW Team:</label>
                        <select id="group-select" x-model="selectedGroup" @change="displayTeamRoles()" name="group-select">
                            <option value="">Select Group</option>
                            <template x-for="group in uniqueGroups">
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
                            <template x-for="team in allTeams">
                                <option :value="team.id" x-text="teamSelectName(team.id)"></option>
                            </template>
                        </select>
                </div>

                <!-- Team Members -->
                <table class="table-admin my-6" x-show="teamName || selectedTeamID">
                    <thead><tr><th>Role</th><th>Selected Volunteer</th></tr></thead>
                    <tbody>
                        <template x-for="role in teamRoles">
                            <tr x-show="role.volunteers.length > 0">
                                <td class="" x-text="role.role"></td>
                                <td class="">
                                <select :id="role.roleID" :name="role.roleID" x-model="role.selectedVolunteer" @change="updateSelectedVolunteer(role.roleID, role.selectedVolunteer)" x-key="forceRerender">
                                    <option value="">Select Volunteer</option>
                                    <template x-for="volunteer in role.volunteers">
                                        <option :value="volunteer.id" x-text="volunteer.display_name"></option>
                                    </template>
                                </select>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <input type="hidden" name="selected_volunteers" :value="JSON.stringify(selectedVolunteers)">
                <input type="submit" name="add_team" value="Add Team" x-show="selectedVolunteers.length > 0">
            </div>


            <script>
                //* WP Data *//
                const roles = <?php echo json_encode($all_roles_data); ?>;
                const volunteers = <?php echo json_encode($all_volunteers_data); ?>;
                const teams = <?php echo json_encode($all_teams_data); ?>;

                function alpineForm() {
                    return {
                        selectedGroup: '',
                        selectedVolunteers: [],
                        selectedTeamID: '',
                        teamName: '',
                        teamRoles: [],
                        allRoles: [],
                        allTeams: [],
                        allVolunteers: [],
                        uniqueGroups: [],
                        forceRerender: false,

                        init() {
                            const allRoles = <?php echo json_encode($all_roles_data); ?>;
                            const volunteers = <?php echo json_encode($all_volunteers_data); ?>;
                            // console.log(volunteers);
                            this.allRoles = allRoles;
                            this.allVolunteers = volunteers;
                            this.allTeams = teams;
                            // Populate unique groups
                            this.uniqueGroups = [...new Set(volunteers.map(item => item.group_name))];
                        },

                        displayTeamRoles() {
                            const roles = this.allRoles.filter(item => item.group === this.selectedGroup);

                            // console.log(roles);
                            const teamRoles = [...new Set(roles.map(item => ({role: item.role, roleID: item.id})))];
                            
                            // Create data from table dropdowns
                            const roleObjects = teamRoles.map(role => ({
                                roleID: role.roleID,
                                role: role.role,
                                volunteers: this.findVolunteersForRole(role.role),
                                selectedVolunteer: '',
                            }));
                            this.teamRoles = roleObjects;

                            // Create selected volunteer data.
                            const selectedVolunteers = Object.fromEntries(
                                teamRoles.map(role => ([role.roleID, { role: role.role, volunteerID: '' }]))
                            );
                            this.selectedVolunteers = selectedVolunteers;
                        },

                        findVolunteersForRole(role) {
                            return this.allVolunteers.filter(item => item.group_name === this.selectedGroup && item.role === role);
                        },

                        teamSelectName(teamID) {
                            const team = this.allTeams.filter(item => item.id === teamID);
                            return team[0].group_name + ' - ' + team[0].name;
                        },

                        displaySelectTeam() {
                            const team = this.allTeams.filter(item => item.id === this.selectedTeamID);
                            this.selectedGroup = team[0].group_name;
                            this.displayTeamRoles();

                            var teamVolunteers = team[0].volunteers;
                            teamVolunteers = JSON.parse(teamVolunteers);

                            //Loop through teamRoles and selectedVolunteer
                            this.teamRoles.forEach(item => {
                                // console.log(item.roleID);
                                // Check if the role exists in the teamVolunteers object
                                if (teamVolunteers.hasOwnProperty(item.roleID)) {
                                    const volunteerID = teamVolunteers[item.roleID].volunteerID;
                                    this.$set(item, 'selectedVolunteer', volunteerID);
                                    // item.selectedVolunteer = volunteerID;
                                }
                            })

                            // Trigger re-render
                            this.forceRerender = !this.forceRerender;
                        },

                        updateSelectedVolunteer(roleID, selectedVolunteer) {
                            this.$set(this.selectedVolunteers[roleID], 'volunteerID', selectedVolunteer);
                            // this.selectedVolunteers[roleID].volunteerID = selectedVolunteer;
                        }
                    };
                }
            </script>
        </form>

    </div>
    <?php
}