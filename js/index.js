jQuery(document).ready(function($) {
    // Attach a click event to your trash icon (assuming it has a specific class or ID)
    $('.dashicons-trash').on('click', function() {
        const roleId = $(this).data('role-id'); // Assuming you set a data attribute for the role ID
        console.log(roleId);
        
        // Make the AJAX request
        var baseUrl = window.location.origin;
        $.ajax({
            url: '/wp-json/bcs/v1/delete_role/' + roleId,
            type: 'DELETE',
            data: {
                nonce: $('#bcs_roles_nonce').val() // Pass the nonce value
            },
            success: function(response) {
                // Handle success (e.g., remove the row from the table)
                console.log(response);
                console.log('Role deleted successfully');
                $(`#role-${roleId}`).remove();
            },
            error: function(error) {
                // Handle error
                console.error('Error deleting role');
            }
        });
    });
});