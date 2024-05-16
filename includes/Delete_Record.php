<?php
namespace Devweb\PersonalRecord;

class Delete_Record {

    private $table_name;
    public function __construct() {

        global $wpdb;
        $this->table_name = $wpdb->prefix . 'dev_web_personal_record';

    }

    // Query data for delete record
    function personal_record_delete_record() {
        global $wpdb;

        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $data = $wpdb->get_row("SELECT * FROM $this->table_name WHERE id = $id");
        if (!$data) {
            echo '<div class="error"><p>Data not found!</p></div>';
            return;
        }
        if (isset($_POST['submit'])) {
            if (!wp_verify_nonce($_POST['_wpnonce'], 'delete_data_nonce')) {
                die('Security check');
            }
            $wpdb->delete($this->table_name, array('id' => $id));
            echo '<div class="updated"><p>Record deleted successfully!</p></div>';

        }
        ?>

        <!-- Show which record want to delete -->
        <div class="wrap">
            <h2>Delete Record</h2>
            <form method="post">
                <?php wp_nonce_field('delete_data_nonce'); ?>
                <input type="hidden" name="id" value="<?php echo $data->id; ?>">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">Name</th>
                            <td><?php echo $data->name; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <td><?php echo $data->email; ?></td>
                        </tr>
                        <tr>

                            <th>
                                <?php
                                if (!isset($_POST['submit'])) { ?>

                                    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary"
                                            value="Confirm Delete"></p>
                                <?php } else {

                                }

                                ?>
                                <!-- <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary"
                                        value="Confirm Delete"></p> -->

                            </th>
                            </p>
                            <td>
                                <?php
                                if (isset($_POST['submit'])) {
                                    if (wp_verify_nonce($_POST['_wpnonce'], 'delete_data_nonce')) {
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