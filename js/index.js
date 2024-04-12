jQuery(document).ready(function($) {
    // Attach a click event to your trash icon (assuming it has a specific class or ID)
    $('.dashicons-trash.jquery-delete').on('click', function() {
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
