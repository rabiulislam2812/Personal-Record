<?php
/*
Plugin Name: Personal Record
Description: A plugin to manage personal recrod with custom database table.
Version: 1.0
Author: Rabiul Islam
Author URI: //rabiulislam.net
Text Domain: dev-web
Domain Path: /languages
*/


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


require_once (plugin_dir_path(__FILE__) . 'vendor/autoload.php');

class Dev_web_Personal_Record {
    private $table_name;
    private $dwpr_ver = '1.0';
    public function __construct() {

        global $wpdb;
        $this->table_name = $wpdb->prefix . 'dev_web_personal_record';

        // Plugin activation hook
        register_activation_hook(__FILE__, [$this, 'create_personal_record_table']);

        add_action('init', [$this, 'init']);


        // Update create_personal_record_table table based on plugin version
        $dwpr_ver = get_option('dwpr_ver');
        if ($dwpr_ver != $this->dwpr_ver) {
            $this->create_personal_record_table();
            update_option('dwpr_ver', $this->dwpr_ver);
        }

    }

    function init() {

        // Add menu item to admin dashboard
        add_action('admin_menu', [$this, 'personal_record_admin_menu']);

        // Add new record page
        add_action('admin_menu', [$this, 'personal_record_add_new_record_submenu_page']);

        // Edit record page
        add_action('admin_menu', [$this, 'personal_record_edit_record_submenu_page']);

        // Delete record page
        add_action('admin_menu', [$this, 'personal_record_delete_record_submenu_page']);

        add_action('admin_enqueue_scripts', [$this, 'dev_web_enqueue_styles']);

    }

    // Enque custom style
    public function dev_web_enqueue_styles() {
        wp_enqueue_style('dev-web-record-style', plugins_url('assets/css/style.css', __FILE__));
    }

    // Create record table
    function create_personal_record_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $this->table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        email varchar(100) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    // Personal record menu page
    function personal_record_admin_menu() {
        add_menu_page(__('Personal Record Plugin', 'dev-web'), __('Dev Web Personal Record', 'dev-web'), 'manage_options', 'personal-record', [$this, 'display_record_admin_page'], 'dashicons-info');
    }

    // Display all records
    function display_record_admin_page() {
        $display_data = new Devweb\PersonalRecord\Display_Record(); // Display_Record class initialization
        $display_data->personal_record_display_page(); // Method from Display_Record class
    }

    // Add new record submenu page
    function personal_record_add_new_record_submenu_page() {
        add_submenu_page('personal-record', __('Add New Record', 'dev-web'), __('Add New Record', 'dev-web'), 'manage_options', 'add-new-record', [$this, 'custom_database_add_new_data_page_content']);
    }

    // Add new record method
    function custom_database_add_new_data_page_content() {
        $add_new_data = new Devweb\PersonalRecord\Add_New_Record(); // Add_New_Record class initialization
        $add_new_data->personal_record_add_new_record(); // Method from Add_New_Record class
    }

    // Edit record submenu page
    function personal_record_edit_record_submenu_page() {
        add_submenu_page(' ', __('Edit Record', 'dev-web'), __('Edit Record', 'dev-web'), 'manage_options', 'edit-record', [$this, 'custom_database_edit_data_page_content']);
    }

    // Edit recrod method
    function custom_database_edit_data_page_content() {
        $edit_data = new Devweb\PersonalRecord\Edit_Record(); // Edit_Record class initialization
        $edit_data->personal_record_edit_record(); // Method from Edit_Record class
    }

    // Delete record submenu page
    function personal_record_delete_record_submenu_page() {
        add_submenu_page(' ', __('Delete Record', 'dev-web'), __('Delete Record', 'dev-web'), 'manage_options', 'delete-record', [$this, 'custom_database_delete_data_page_content']);
    }

    // Delete record method
    function custom_database_delete_data_page_content() {
        $delete_data = new Devweb\PersonalRecord\Delete_Record(); // Delete_Record class initialization
        $delete_data->personal_record_delete_record(); // Method from Delete_Record class

    }

}

new Dev_web_Personal_Record();