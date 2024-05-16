<?php
namespace Devweb\PersonalRecord;

class Add_New_Record {

    private $table_name;
    public function __construct() {

        global $wpdb;
        $this->table_name = $wpdb->prefix . 'dev_web_personal_record';

    }

    // Create new record method
    function personal_record_add_new_record() {
        if (isset($_POST['submit'])) {
            if (!wp_verify_nonce($_POST['_wpnonce'], 'add_new_data_nonce')) {
                die('Security check');
            }
            global $wpdb;

            $name = sanitize_text_field($_POST['name']);
            $email = sanitize_text_field($_POST['email']);
            $wpdb->insert($this->table_name, array('name' => $name, 'email' => $email));
            echo '<div class="updated"><p>New Record added successfully!</p></div>';
        }
        ?>

        <!-- Add new record form -->
        <div class="wrap">
            <h1 class="wp-heading-inline">Add New Record</h1>
            <form method="post">
                <?php wp_nonce_field('add_new_data_nonce'); ?>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label for="name">Name</label></th>
                            <td><input type="text" name="name" id="name" class="regular-text" required></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="email">Email</label></th>
                            <td><input type="email" name="email" id="email" class="regular-text" required></td>
                        </tr>
                        <tr>
                            <th>
                                <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary"
                                        value="Add Record">

                            </th>
                            </p>
                            <td>
                                <?php
                                if (isset($_POST['submit'])) {
                                    if (wp_verify_nonce($_POST['_wpnonce'], 'add_new_data_nonce')) {
                                        echo '<a href="' . admin_url('admin.php?page=personal-record') . '" class="page-title-action">View Records</a>';
                                    }
                                }

                                ?>
                            </td>

                        </tr>
                    </tbody>
                </table>

            </form>
        </div>
        <?php
    }
}