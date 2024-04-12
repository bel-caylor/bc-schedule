<?php
require_once BC_SCHEDULE_PATH . '/src/database/manager/teams.php';
require_once BC_SCHEDULE_PATH . '/src/database/api/add_team_volunteer.php';
require_once BC_SCHEDULE_PATH . '/src/database/api/add_team_to_event.php';

function render_teams_page() {
    $teams_manager = new BCS_Teams_Manager();
    $all_teams_data = $teams_manager->get_team_page_data();
    ?>

    <div x-data="teams()" x-init="init()" class="wrap">
        <div class="wrap bcs input-area p-4 border border-gray-300 bg-white my-4">
            <h1>Add Team to Event Date</h1>
            <p x-show="error" x-text="error" class="text-red-600 font-bold"></p>
            <div class="flex flex-col gap-3">
                <label for="event-select" class="pr-2 font-bold">Select Event Type:</label>
                <select x-model="selectedEvent" id="event-select">
                    <option value="">Select</option>
                    <template x-for="eventType in Object.keys(teamsByEvent)">
                        <option :value="eventType" x-text="eventType"></option>
                    </template>
                </select>
                <template x-if="selectedEvent">
                    <div>
                        <label for="group-select" class="pr-2 font-bold">Select Group:</label>
                        <select x-model="selectedGroup" id="group-select">
                            <option value="">Select</option>
                            <template x-for="group in Object.keys(allTeams[selectedEvent])">
                                <option :value="group" x-text="group"></option>
                            </template>
                        </select>
                    </div>     
                </template>
                <template x-if="selectedGroup">
                    <div>
                        <label for="team-select" class="pr-2 font-bold">Select Team:</label>
                        <select x-model="selectedTeam" id="team-select">
                            <option value="">Select</option>
                            <template x-for="team in teamsByEvent[selectedEvent]">
                                <option :value="team.name" x-text="team.name"></option>
                            </template>
                        </select>
                    </div>     
                </template>
                <template x-if="selectedTeam">
                    <template x-for="event in filterDates">
                        <div>
                            <p class="font-bold text-lg">Select dates:</p>
                            <input type="checkbox" :id="event.date" :value="event.date" @click="toggleDate(event.date)">
                            <label :for="event.date" x-text="event.date" class="pb-1"></label>
                        </div>     
                    </template>
                </template>              
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
                selectedEvent: '',
                selectedGroup: '',
                selectedTeam: '',
                selectedDates: [],
                error: '',

                init() {
                    this.allRoles = allRoles;
                    this.allVolunteers = allVolunteers;
                    this.allTeams = allTeams;
                    this.teamsByEvent = teamsByEvent;
                    this.emptyEvents = emptyEvents;
                },

                get filterDates() {
                    return this.emptyEvents.filter(item => 
                        item.event_name === this.selectedEvent &&
                        item.group_name === this.selectedGroup
                    );
                },

                toggleDate(date) {
                    const index = this.selectedDates.indexOf(date);
                    if (index === -1) {
                        this.selectedDates.push(date);
                    } else {
                        this.selectedDates.splice(date, 1);
                    }
                },

                addTeamToEvent() {
                    this.error = '';
                    const data = {
                        team_name: this.selectedTeam,
                        event_name: this.selectedEvent,
                        group_name: this.selectedGroup,
                        dates: [...this.selectedDates],
                    };
                    console.log(data);
                    fetch('/wp-json/bcs/v1/add_team_to_event', {
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
                        //Rest input
                        this.error = 'Team added.';
                        this.selectedEvent = '';
                        this.selectedGroup = '';
                        this.selectedTeam = '';
                        this.selectedDates = [];
                    })
                    .catch(error => {
                        console.error('Error saving volunteer:', error);
                    });
                },

                disabledSubmit() {
                    return this.selectedEvent && this.selectedGroup && this.selectedTeam && this.selectedDates.length > 0 ? false : true;
                },

                get uniqueEventNames() {
                    return [...new Set(this.allRoles.map(obj => obj.event_name))];
                },

                saveTeamVolunteer(teamName, eventName, group, role, userID) {
                    this.error = '';
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
                        //Rest input
                        this.selectedUserIds = [];
                        this.selectedRoleId = '';
                    })
                    .catch(error => {
                        console.error('Error saving volunteer:', error);
                    });
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
