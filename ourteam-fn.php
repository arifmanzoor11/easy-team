<?php
/*
Plugin Name: Easy Team Manager
Description: A plugin to manage the "Team" section using a custom post type.
Version: 2.1
Author: Arif M.
*/
// Frontend
include_once(plugin_dir_path(__FILE__) . 'parts/easy-team-shortcode.php');
include_once(plugin_dir_path(__FILE__) . 'parts/vCard.php');
include_once(plugin_dir_path(__FILE__) . 'parts/custom-post-type.php');

// Admin
include_once(plugin_dir_path(__FILE__) . 'admin/admin-settings.php');
include_once(plugin_dir_path(__FILE__) . 'admin/admin-documentation.php');

// Enqueue styles and scripts for admin and frontend
function our_team_enqueue_scripts() {
    // Frontend styles and scripts
    wp_enqueue_style('easyteam-css', plugins_url('assets/css/easy-team.css', __FILE__));
    wp_enqueue_script('easyteam-js', plugins_url('assets/js/easy-team.js', __FILE__), array('jquery'), '1.0.0', true);

    // Admin styles and scripts
    if (is_admin()) {
        // wp_enqueue_style('our-team-admin', plugins_url('css/admin.css', __FILE__));
        // wp_enqueue_script('our-team-admin', plugins_url('js/admin.js', __FILE__), array('jquery'), '1.0.0', true);
    }
}
add_action('admin_enqueue_scripts', 'our_team_enqueue_scripts'); // Admin panel
add_action('wp_enqueue_scripts', 'our_team_enqueue_scripts');    // Frontend
