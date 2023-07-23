<?php
// If uninstall is not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Define the name of the table
global $wpdb;
$table_name = $wpdb->prefix . 'bk_cookie_policy_notice';

// Check to see if the table exists
if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name) {

    // If the table exists, drop it
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
}
?>