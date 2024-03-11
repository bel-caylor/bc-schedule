<?php

/*  
 * Display message based on query parameter message.
*/
function display_form_message() {
    if (isset($_GET['message'])) {
        if ($_GET['message'] === 'success') {
            echo '<p>New Role Added</p>';
        } elseif ($_GET['message'] === 'duplicate') {
            echo '<p>Combination already exists in the databse.</p>';
        }
    }
}