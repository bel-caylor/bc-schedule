<?php
require_once BC_SCHEDULE_PATH . '/src/database/manager/teams.php';
require_once BC_SCHEDULE_PATH . '/src/database/api/add_team_volunteer.php';

function render_teams_page() {
    $teams_manager = new BCS_Teams_Manager();
    $all_teams_data = $teams_manager->get_team_page_data();
    ?>

    <div x-data="teams()" x-init="init()" class="wrap">
        <div class="py-6">
            <div class="flex gap-8 flex-col sm:flex-row">
                <!-- Event Tables -->
                <template x-for="eventName in Object.keys(allTeams)">
                    <div>
                        <h2 x-text="eventName" class="font-bold text-xl py-2 pl-4 sticky top-[30px] bg-blue-900 text-white border border-blue-900"></h2>
                        <table class="table-admin">
                            <thead class="sticky top-[60px] ">
                                <tr class="bg-blue-300 border-blue-300">
                                    <th>Role</th>
                                    <template x-for="team in teamsByEvent[eventName]">
                                        <th x-text="team.name"></th>
                                    </template>
                                </tr>
                            </thead>
                            <template x-for="group in Object.keys(allTeams[eventName])">
                                <tbody>
                                    <tr class="bg-blue-100">
                                        <td :colspan="teamsByEvent[eventName].length + 1" x-text="group" class="font-bold"></td>
                                    </tr>
                                    <template x-for="role in Object.keys(allTeams[eventName][group])">
                                        <tr class="bg-gray-100">
                                            <td x-text="role" class="!py-0"></td>
                                            <template x-for="team in Object.keys(allTeams[eventName][group][role])">
                                                <td class="!p-[2px]">
                                                    <template x-if="allTeams[eventName][group][role][team].edit == false">
                                                        <button x-text="allTeams[eventName][group][role][team].first_name"
                                                            @click="allTeams[eventName][group][role][team].edit = true;"
                                                            class="!py-[2px] w-full bg-blue-100 hover:text-blue-700 hover:bg-white border border-gray-200 rounded-sm">
                                                        </button>
                                                    </template>
                                                    <template x-if="allVolunteers[eventName][group][role] && allTeams[eventName][group][role][team].edit == true">
                                                        <select class="w-full" x-model="allTeams[eventName][group][role][team].selected_user_id" 
                                                                x-on:change="saveTeamVolunteer(team, eventName, group, role, allTeams[eventName][group][role][team].selected_user_id)">
                                                            <option value="">Select</option>
                                                            <template x-for="volunteerID in Object.keys(allVolunteers[eventName][group][role])">
                                                                <option :value="allVolunteers[eventName][group][role][volunteerID].wp_user_id" 
                                                                        x-text="allVolunteers[eventName][group][role][volunteerID].first_name"></option>
                                                                </option>
                                                            </template>
                                                        </select>
                                                    </template>
                                                </td>
                                            </template>
                                        </tr>
                                    </template>
                                </tbody>
                            </template>
                        </table>
                    </div>
                </template>
            </div> 
        </div>
    </div>

    <script>
        //* WP Data *//
        const allRoles = <?php echo json_encode($all_teams_data["allRoles"]); ?>;
        const allVolunteers = <?php echo json_encode($all_teams_data["allVolunteers"]); ?>;
        const allTeams = <?php echo json_encode($all_teams_data["allTeams"]); ?>;
        const teamsByEvent = <?php echo json_encode($all_teams_data["teamsByEvent"]); ?>;

        function teams() {
            return {
                allRoles: [],
                allVolunteers: [],
                allTeams: [],
                teamsByEvent: {},

                init() {
                    this.allRoles = allRoles;
                    this.allVolunteers = allVolunteers;
                    this.allTeams = allTeams;
                    this.teamsByEvent = teamsByEvent;
                },

                get uniqueEventNames() {
                    return [...new Set(this.allRoles.map(obj => obj.event_name))];
                },

                saveTeamVolunteer(teamName, eventName, group, role, userID) {
                    const data = {
                        team_name: teamName,
                        event_name: eventName,
                        group_name: group,
                        role: role,
                        user_id: userID,
                    };
                    console.log(data);
                    fetch('/wp-json/bcs/v1/add_team_volunteer', {
                        method: 'POST',
                        headers: {
                        'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data),
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                        this.allTeams[eventName][group][role][teamName].wp_user_id = data.user[0].id;
                        this.allTeams[eventName][group][role][teamName].display_name = data.user[0].display_name;
                        this.allTeams[eventName][group][role][teamName].first_name = data.user[0].first_name;
                        this.allTeams[eventName][group][role][teamName].edit = false;
                        this.allTeams[eventName][group][role][teamName].selected_user_id = '';
                    })
                    .catch(error => {
                        console.error('Error saving volunteer:', error);
                    });
                    //Rest input
                    this.selectedUserIds = [];
                    this.selectedRoleId = '';
                },

                getVolunteer(eventName, groupName, roleId, teamName) {
                    const team = this.allTeams.filter( obj => obj.event_name === eventName && obj.group_name === groupName && obj.name === teamName );
                    if ( team.length > 0 ) {
                        const volunteerId = team[0].volunteers[roleId].volunteerID;
                        const volunteer = this.allVolunteers.filter( obj => obj.id === volunteerId );
                        if ( volunteer.length > 0 ) {
                            return volunteer[0].display_name;
                            // return volunteer[0].id + '-' + volunteer[0].display_name + '-' + roleId;
                        }
                    } else {
                        
                        // return 'roleId' + roleId;
                    }
                },

            }
        }
    </script>
    <?php
}

function render_team_add_form() {
    $roles_manager = new BCS_Roles_Manager();
    $all_roles_data = $roles_manager->get_roles_data();
    $volunteers_manager = new BCS_Volunteers_Manager();
    $teams_manager = new BCS_Teams_Manager();
    $all_teams_data = $teams_manager->get_teams();
    $all_volunteers_data = $volunteers_manager->get_volunteers();
    $empty_events_by_group = $teams_manager->get_empty_events_by_group();
    ?>
    <div class="wrap bcs">
        <form method="post" action="admin-post.php">
            <?php wp_nonce_field('bcs_nonce'); ?>
            <!-- <input type="hidden" name="action" value="add_team_action"> -->

            <!-- Alpine.js app for dropdown boxes. -->
            <div x-data="alpineForm()" x-init="init()">
                <h1 x-show="!selectedGroup && !selectedTeamID">Add/Edit Team</h1>
                <h1 x-show="selectedGroup  && !selectedTeamID">Add Team</h1>
                <h1 x-show="selectedTeamID">Edit Team</h1>
                <div class="flex my-2" x-show="!selectedTeamID">

                    <!-- Group select -->
                    <div class="mb-2">
                        <label for="group-select">Group:</label>
                        <select id="group-select" x-model="selectedGroup" @change="displayTeamRoles()" name="group-select">
                            <option value="">Select Group</option>
                            <template x-for="group in uniqueGroups">
                                <option :value="group" x-text="group"></option>
                            </template>
                        </select>
                    </div>
                    <!-- Create new Team -->
                    <div class="pl-4 pb-2" x-show="selectedGroup">
                        <label for="team">New Team Name:</label>
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
                            <option :value="team.id" x-text="teamSelectName(team)"></option>
                        </template>
                    </select>
                    <div class="py-6">
                        <div class="flex gap-8 flex-col sm:flex-row">
                            <!-- Team Members -->
                            <table class="table-admin" x-show="teamName || selectedTeamID">
                                <thead>
                                    <tr>
                                        <th>Role</th>
                                        <th>Selected Volunteer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="role in teamRoles">
                                        <tr x-show="role.volunteers.length > 0">
                                            <td class="" x-text="role.role"></td>
                                            <td class="">
                                            <select :id="role.roleID" :name="role.roleID" x-model="role.selectedVolunteer" @change="updateSelectedVolunteer(role.roleID, role.selectedVolunteer)" :x-ref="`select_${role.roleID}`">
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
                            <!-- Empty Events -->
                            <template x-if="filterEmptyEvents(selectedGroup).length > 0">
                                <div class="pl-4 p-3 bg-white border border-gray-300">
                                    <h3 class="font-bold">Add Team to Dates:</h3>
                                    <template x-for="event in filterEmptyEvents(selectedGroup)">
                                        <div>
                                            <input type="checkbox" id="date-{event.date}" name="event.date" value="event.date">
                                            <label for="myCheckbox" x-text="event.date"></label>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            <div>
                                <input type="hidden" name="selected_volunteers" :value="JSON.stringify(selectedVolunteers)">
                                <input type="submit" :name="submitName" :value="submitText" x-show="Object.keys(selectedVolunteers).length > 0">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <script>
                //* WP Data *//
                const roles = <?php echo json_encode($all_roles_data); ?>;
                const volunteers = <?php echo json_encode($all_volunteers_data); ?>;
                const teams = <?php echo json_encode($all_teams_data); ?>;
                const emptyEvents = <?php echo json_encode($empty_events_by_group); ?>;

                function alpineForm() {
                    return {
                        selectedGroup: '',
                        selectedVolunteers: {},
                        selectedTeamID: '',
                        teamName: '',
                        teamRoles: [],
                        allRoles: [],
                        allTeams: [],
                        allVolunteers: [],
                        emptyEvents: [],
                        uniqueGroups: [],
                        submitText: 'Add Team',
                        submitName: 'add_team',

                        init() {
                            this.allRoles = roles;
                            this.allVolunteers = volunteers;
                            this.allTeams = teams;
                            this.emptyEvents = emptyEvents;
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

                        filterEmptyEvents(group) {
                            return this.emptyEvents.filter(item => item.group_name === group);
                        },

                        teamSelectName(team) {
                            return `${team.group_name} - ${team.name}`;
                        },

                        displaySelectTeam() {
                            this.submitText = "Save Team"
                            this.submitName = "edit_team"
                            const team = this.allTeams.find(item => item.id === this.selectedTeamID);
                            if (team) {
                                this.teamName = team.name;
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
                                    this.selectedVolunteers[item.roleID].volunteerID = teamVolunteers[item.roleID].volunteerID;
                                });
                            }

                            // Re-render select elements
                            this.$nextTick(() => {
                                this.teamRoles.forEach(item => {
                                    const selectElement = this.$refs[`select_${item.roleID}`];
                                    if (selectElement) {
                                        selectElement.value = item.selectedVolunteer;
                                    }
                                });
                            });
                        },

                        updateSelectedVolunteer(roleID, selectedVolunteer) {
                            this.selectedVolunteers[roleID] = { role: this.selectedVolunteers[roleID].role, volunteerID: selectedVolunteer };
                        }
                    }
                }
            </script>
            <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
        </form>

    </div>
<?php
}