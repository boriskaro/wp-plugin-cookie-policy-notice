<?php
/*
Plugin Name: Cookie Policy Notice
Plugin URI:  https://www.boriskaro.com/wordpress/cookie-policy-notice-plugin/
Description: WordPress plugin for cookie acceptance notice.
Version:     0.3.0
Author:      Boris Karo
Author URI:  https://www.boriskaro.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

define( 'COOKIE_POLICY_NOTICE_VERSION', '0.3.0' );

require_once(plugin_dir_path(__FILE__) . 'backend.php');
require_once(plugin_dir_path(__FILE__) . 'frontend.php');

register_activation_hook(__FILE__, 'create_plugin_database_table');

function create_plugin_database_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'bk_cookie_policy_notice';

    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            setting_name varchar(255) NOT NULL,
            setting_value text,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

add_action('wp_enqueue_scripts', 'cookie_policy_notice_enqueue_scripts');

function cookie_policy_notice_enqueue_scripts() {
    wp_enqueue_style('cookie-policy-notice', plugins_url('cookie-policy-notice.css', __FILE__));
    wp_enqueue_script('cookie-policy-notice', plugins_url('cookie-policy-notice.js', __FILE__));
}