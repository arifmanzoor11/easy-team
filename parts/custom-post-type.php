<?php
// Register Custom Post Type for Our Team
function our_team_register_post_type() {
    $labels = array(
        'name'                  => 'Our Team',
        'singular_name'         => 'Team Member',
        'menu_name'             => 'Our Team',
        'name_admin_bar'        => 'Team Member',
        'add_new'               => 'Add New Member',
        'add_new_item'          => 'Add New Team Member',
        'edit_item'             => 'Edit Team Member',
        'new_item'              => 'New Team Member',
        'view_item'             => 'View Team Member',
        'all_items'             => 'All Team Members',
        'search_items'          => 'Search Team Members',
        'not_found'             => 'No Team Members Found',
        'not_found_in_trash'    => 'No Team Members Found in Trash',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'our-team'),
        'menu_icon'          => 'dashicons-groups',
        'supports'           => array('title', 'editor', 'thumbnail'),
        'show_in_rest'       => true, // Enable Gutenberg Editor
    );

    register_post_type('our_team', $args);
}
add_action('init', 'our_team_register_post_type');

// Add Custom Meta Boxes
function our_team_add_meta_boxes() {
    add_meta_box(
        'team_member_details',
        'Team Member Details',
        'our_team_meta_box_callback',
        'our_team',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'our_team_add_meta_boxes');

function our_team_meta_box_callback($post) {
    wp_nonce_field('save_team_member_details', 'team_member_nonce');

    $job_title = get_post_meta($post->ID, '_team_member_job_title', true);
    $email = get_post_meta($post->ID, '_team_member_email', true);
    $phone = get_post_meta($post->ID, '_team_member_phone', true);

    echo '<p><label for="team_member_job_title">Job Title:</label></p>';
    echo '<input type="text" id="team_member_job_title" name="team_member_job_title" value="' . esc_attr($job_title) . '" class="widefat" />';

    echo '<p><label for="team_member_email">Email:</label></p>';
    echo '<input type="email" id="team_member_email" name="team_member_email" value="' . esc_attr($email) . '" class="widefat" />';

    echo '<p><label for="team_member_phone">Phone:</label></p>';
    echo '<input type="tel" id="team_member_phone" name="team_member_phone" value="' . esc_attr($phone) . '" class="widefat" />';
}

// Save Meta Box Data
function our_team_save_meta_box_data($post_id) {
    if (!isset($_POST['team_member_nonce']) || !wp_verify_nonce($_POST['team_member_nonce'], 'save_team_member_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['team_member_job_title'])) {
        update_post_meta($post_id, '_team_member_job_title', sanitize_text_field($_POST['team_member_job_title']));
    }

    if (isset($_POST['team_member_email'])) {
        update_post_meta($post_id, '_team_member_email', sanitize_email($_POST['team_member_email']));
    }

    if (isset($_POST['team_member_phone'])) {
        update_post_meta($post_id, '_team_member_phone', sanitize_text_field($_POST['team_member_phone']));
    }
}
add_action('save_post', 'our_team_save_meta_box_data');
