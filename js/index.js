jQuery(document).ready(function($) {
    // Attach a click event to your trash icon (assuming it has a specific class or ID)
    $('.dashicons-trash').on('click', function() {
        const rowID = $(this).data('row-id'); 
        console.log(rowID);
        const table = $(this).data('table'); 
        console.log(table);
        
        // Make the AJAX request
        var baseUrl = window.location.origin;
        $.ajax({
            url: '/wp-json/bcs/v1/delete_row/' + rowID,
            type: 'DELETE',
            data: {
                nonce: $('#bcs_nonce').val(),
                table: table,
                row: rowID
            },
            success: function(response) {
                // Handle success (e.g., remove the row from the table)
                console.log(response);
                console.log('Role deleted successfully');
                $(`#row-${rowID}`).remove();
            },
            error: function(error) {
                // Handle error
                console.error('Error deleting role');
            }
        });
    });
});
(() => {

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
                const allRoles = roles;
                const volunteers = volunteers;
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
})