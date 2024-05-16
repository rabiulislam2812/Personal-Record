<?php
namespace Devweb\PersonalRecord;

class Edit_Record {

    private $table_name;
    public function __construct() {

        global $wpdb;
        $this->table_name = $wpdb->prefix . 'dev_web_personal_record';

    }

    // Query data for edit record
    function personal_record_edit_record() {
        global $wpdb;

        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $data = $wpdb->get_row("SELECT * FROM $this->table_name WHERE id = $id");
        if (!$data) {
            echo '<div class="error"><p>Data not found!</p></div>';
            return;
        }
        if (isset($_POST['submit'])) {
            if (!wp_verify_nonce($_POST['_wpnonce'], 'edit_data_nonce')) {
                die('Security check');
            }
            $name = sanitize_text_field($_POST['name']);
            $email = sanitize_text_field($_POST['email']);
            $wpdb->update($this->table_name, array('name' => $name, 'email' => $email), array('id' => $id));
            echo '<div class="updated"><p>Record updated successfully!</p></div>';
            $data = $wpdb->get_row("SELECT * FROM $this->table_name WHERE id = $id");

        }
        ?>

        <!-- Edit record form -->
        <div class="wrap">
            <h2>Edit Record</h2>
            <form method="post">
                <?php wp_nonce_field('edit_data_nonce'); ?>
                <input type="hidden" name="id" value="<?php echo $data->id; ?>">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label for="name">Name</label></th>
                            <td><input type="text" name="name" id="name" class="regular-text" value="<?php echo $data->name; ?>"
                                    required></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="email">Email</label></th>
                            <td><input type="email" name="email" id="email" class="regular-text"
                                    value="<?php echo $data->email; ?>" required></td>
                        </tr>
                        <tr>
                            <th>
                                <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary"
                                        value="Update Record"></p>

                            </th>
                            </p>
                            <td>
                                <?php
                                if (isset($_POST['submit'])) {
                                    if (wp_verify_nonce($_POST['_wpnonce'], 'edit_data_nonce')) {
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