<?php
require_once BC_SCHEDULE_PATH . '/src/database/manager/teams.php';
require_once BC_SCHEDULE_PATH . '/src/database/api/add_team_volunteer.php';

function render_teams_page() {
    $teams_manager = new BCS_Teams_Manager();
    $all_teams_data = $teams_manager->get_team_page_data();
    ?>

    <div x-data="teams()" x-init="init()" class="wrap">
        <div class="wrap bcs input-area p-4 border border-gray-300 bg-white my-4">
            <h1>Add Team to Event Date</h1>
            <p x-show="error" x-text="error" class="text-red-600 font-bold"></p>
            <div class="flex flex-col gap-3">
                <div>
                    <!-- <label for="role-select" class="pr-2 font-bold">Select Group Type:</label>
                    <select id="role-select" x-model="selectedRoleId" name="role-select">
                        <option value="">Select</option>
                        <template x-for="role in allRoles">
                            <option :value="role.id" x-text="roleName(role.event_name, role.group_name, role.role)"></option>
                        </template>
                    </select> -->
                </div>
                <input  @click="addTeamToEvent()" type="submit" :disabled="disabledSubmit()" class="button max-w-28 !mx-auto !mt-3">
            </div>
        </div>
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
        const emptyEvents = <?php echo json_encode($all_teams_data["emptyEvents"]); ?>;

        function teams() {
            return {
                allRoles: [],
                allVolunteers: [],
                allTeams: [],
                teamsByEvent: {},
                emptyEvents: [],
                error: '',

                init() {
                    this.allRoles = allRoles;
                    this.allVolunteers = allVolunteers;
                    this.allTeams = allTeams;
                    this.teamsByEvent = teamsByEvent;
                    this.emptyEvents = emptyEvents;
                },

                addTeamToEvent() {

                },

                disabledSubmit() {

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
