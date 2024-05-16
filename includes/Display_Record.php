<?php
namespace Devweb\PersonalRecord;

class Display_Record {

    private $table_name;
    public function __construct() {

        global $wpdb;
        $this->table_name = $wpdb->prefix . 'dev_web_personal_record';

    }

    // Load admin page
    function personal_record_display_page() {
        echo '<div class="wrap">';
        echo '<h2>All Records</h2>';
        echo '<a href="' . admin_url('admin.php?page=add-new-record') . '" class="button button-primary">Add New Record</a>';
        $this->personal_record_display_record();
        echo '</div>';
    }

    // Display record in table format
    function personal_record_display_record() {

        global $wpdb;
        $total_record = $wpdb->get_var("SELECT COUNT(*) FROM $this->table_name");
        $record = $wpdb->get_results("SELECT * FROM $this->table_name");
        echo '<div class="wrap">';
        echo '<table class="wp-list-table widefat fixed striped">';
        if ($total_record > 0) {
            echo '<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr></thead>';
            echo '<tbody>';
            foreach ($record as $row) {
                echo '<tr>';
                echo '<td>' . esc_html($row->id) . '</td>';
                echo '<td>' . esc_html($row->name) . '</td>';
                echo '<td>' . esc_html($row->email) . '</td>';
                echo '<td><a href="' . admin_url('admin.php?page=edit-record&id=' . $row->id) . '" class="button button-primary">Edit</a> <a href="' . admin_url('admin.php?page=delete-record&id=' . $row->id) . '" class="button button-secondary">Delete</a></td>';
                echo '</tr>';
            }
            echo '</tbody>
        </table>';
            //display total rows
            echo ($total_record > 1) ? '<p>' . __('Total Records: ', 'dev-web') . esc_html($total_record) . '</p>' : '<p>' . __('Total Record: ', 'dev-web') . esc_html($total_record) . '</p>';
        } else {
            echo '<h2> ' . __('No Record Found. Add a new record.', 'dev-web') . '</h2>';
        }
        echo '</div>';
    }
}

new Display_Record;