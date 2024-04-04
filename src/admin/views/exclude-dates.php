<?php

require_once BC_SCHEDULE_PATH . '/src/database/manager/exclude-date.php';
require_once BC_SCHEDULE_PATH . '/src/database/api/users.php';
require_once BC_SCHEDULE_PATH . '/src/database/api/exclude_date.php';

function render_exclude_dates_form() {
    ?>
    <div class="wrap bcs">
        <h1 class="!mb-4">Add Excluded Date for User</h1>
        <!-- Alpine.js app for dropdown boxes. -->
        <div x-data="form()" x-init="init()">
            <form method="post" action="admin-post.php">
                <?php wp_nonce_field('bcs_nonce'); ?>
                <input type="hidden" name="action" value="exclude_date_for_user">
                <div class="flex items-center">
                    <select id="user-select" x-model="selectedUserID" name="user-select" @change="clearExcludeDates()">
                        <option value="">Select volunteer</option>
                        <template x-for="user in users">
                            <option :value="user.ID" x-text="user.display_name"></option>
                        </template>
                    </select>
                    <label for="exclude_date" class="pl-4 pr-1">Add Exclude Date:</label>
                    <input x-model="selectedDate" type="date" id="exclude_date" name="exclude_date" @change="addDate()" 
                           onkeydown="return event.key === 'Tab' || event.key === 'Escape';" >
                    
                </div>
                <h2 x-show="excludedDates.length > 0" class="pt-4 pb-1 font-bold" x-cloak>Exclude Dates</h2>
                <template x-for="date in excludedDates">
                    <div class="py-2">
                        <span x-text="date"></span>
                        <button class="dashicons dashicons-remove text-blue-400" @click.prevent="removeDate()"></button>
                    </div>
                </template>
                <input name="dates" type="hidden" x-model="formattedExcludedDates()">
                <div class="pt-10" x-cloak>
                    <input x-show="selectedUserID && excludedDates.length > 0" type="submit" name="exclude_date_for_user" value="Add Exclude Date(s)">
                </div>

                <script>
                    function form() {
                        return {
                            selectedUserID: '',
                            users: [],
                            selectedDate: '',
                            excludedDates: [],

                            init() {
                                this.fetchUsers();
                            },

                            async fetchUsers() {
                                try {
                                    const response = await fetch('/wp-json/bcs/v1/users');
                                    const usersData = await response.json();
                                    this.users = usersData;
                                } catch (error) {
                                    console.error('Error fetching users:', error);
                                }
                            },

                            addDate() {
                                if (this.selectedDate) {
                                    this.excludedDates.push(this.selectedDate);
                                    this.selectedDate = ''; 
                                } else {
                                    // Handle the case where no date is selected, e.g., display a message
                                    console.warn('Please select a date to exclude.');
                                }
                            },

                            removeDate(index) {
                                // e.preventDefault();
                                this.excludedDates.splice(index, 1);
                            },

                            clearExcludeDates() {
                                this.excludedDates = [];
                            },

                            formattedExcludedDates() {
                                return this.excludedDates.join(', ')
                            },
                        };
                    }
                </script>

                <style>
                    [x-cloak] { 
                        display: none; 
                    }
                </style>
            </form>
        </div>
    </div>
    <?php
}

function render_exclude_dates_table() {
    global $wpdb;
    $wp_pre = $wpdb->prefix;

    // Retrieve roles from the database
    $exclude_date_manager = new BCS_Exclude_Date_Manager();
    $dates = $exclude_date_manager->get_exclude_dates();
    echo '<h2 class="text-lg font-bold">Excluded Dates for Volunteers</h2>';
    echo '<div id="exclude-dates-table">';
    echo '<table class="table-admin">';
    echo '<thead><tr><th>ID</th><th>Date <span class="sort-icon">&#x25B2;</span></th><th>Name <span class="sort-icon">&#x25B2;</span></th><th>Trash</th></tr></thead>';
    echo '<tbody>';
    foreach ($dates as $date) {
        echo '<tr id="row-' . esc_html($date->id) . '">';
        echo '<td>' . esc_html($date->id) . '</td>';
        echo '<td>' . esc_html($date->date) . '</td>';
        echo '<td>' . esc_html($date->display_name) . '</td>';
        echo '<td><i class="dashicons dashicons-trash" data-table="' . $wp_pre . 'bcs_exclude_dates" data-row-id="' . esc_html($date->id) . '"></i></td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
    echo '<script>
        const table = document.getElementById("exclude-dates-table");
        const tbody = table.getElementsByTagName("tbody")[0];
        const rows = Array.from(tbody.getElementsByTagName("tr"));

        const sortColumn = (columnIndex, isDate = false) => {
            rows.sort((a, b) => {
                const valueA = a.getElementsByTagName("td")[columnIndex].innerText.toLowerCase();
                const valueB = b.getElementsByTagName("td")[columnIndex].innerText.toLowerCase();
                if (isDate) {
                    const dateA = new Date(valueA);
                    const dateB = new Date(valueB);
                    return dateA - dateB;
                } else {
                    if (valueA < valueB) return -1;
                    if (valueA > valueB) return 1;
                    return 0;
                }
            });

            rows.forEach(row => tbody.appendChild(row));
        }

        const nameHeader = table.getElementsByTagName("th")[2];
        const dateHeader = table.getElementsByTagName("th")[1];

        nameHeader.style.cursor = "pointer";
        dateHeader.style.cursor = "pointer";

        nameHeader.addEventListener("click", () => sortColumn(2));
        dateHeader.addEventListener("click", () => sortColumn(1, true));
    </script>';
}