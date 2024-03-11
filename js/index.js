jQuery(document).ready(function($) {
    // Attach a click event to your trash icon (assuming it has a specific class or ID)
    $('.dashicons-trash').on('click', function() {
        const roleId = $(this).data('role-id'); // Assuming you set a data attribute for the role ID
        const nonce = $('#my-nonce').val(); // Get the nonce value

        // Make the AJAX request
        $.ajax({
            url: myAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'delete_role',
                nonce: nonce,
                role_id: roleId
            },
            success: function(response) {
                // Handle success (e.g., remove the row from the table)
                console.log('Role deleted successfully');
            },
            error: function(error) {
                // Handle error
                console.error('Error deleting role');
            }
        });
    });
});