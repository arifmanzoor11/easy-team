<?php

// Add Documentation Page
// Add Documentation Submenu under "Our Team" Settings
function our_team_add_documentation_page() {
    add_submenu_page(
        'edit.php?post_type=our_team',  // Parent slug (links it under the "Our Team" menu)
        'Documentation',               // Page title
        'Documentation',               // Menu title
        'manage_options',              // Capability
        'our_team_documentation',      // Menu slug
        'our_team_documentation_page'  // Callback function
    );
}
add_action('admin_menu', 'our_team_add_documentation_page');
// Documentation Page Callback
function our_team_documentation_page() {
    ?>
    <div class="wrap">
        <h1>Plugin Documentation</h1>
        <p>Welcome to the documentation for the <strong>Our Team</strong> plugin. Below, you'll find information on how to use the plugin, including details about shortcodes and available settings.</p>
        
        <h2>Shortcode: <code>[our_team]</code></h2>
        <p>This shortcode allows you to display team members dynamically. Customize the output using the following attributes:</p>
        <ul>
            <li><strong>count</strong>: Specify the number of team members to display. Use <code>-1</code> to display all.<br>
                Example: <code>[our_team count="2"]</code></li>
            <li><strong>order</strong>: Set the order of team members. Accepts <code>asc</code> for ascending or <code>desc</code> for descending.<br>
                Example: <code>[our_team order="desc"]</code></li>
            <li><strong>orderby</strong>: Define the parameter to order by. Options include <code>title</code>, <code>date</code>, or <code>ID</code>.<br>
                Example: <code>[our_team orderby="date"]</code></li>
        </ul>

        <h3>Examples:</h3>
        <ul>
            <li>Display all team members in ascending order by title:<br>
                <code>[our_team count="-1" order="asc" orderby="title"]</code></li>
            <li>Show the 5 most recent team members:<br>
                <code>[our_team count="5" order="desc" orderby="date"]</code></li>
            <li>Display a single team member with ID-based sorting:<br>
                <code>[our_team count="1" orderby="ID"]</code></li>
        </ul>

        <h2>Settings</h2>
        <p>You can configure additional options for the plugin under the <strong>Settings</strong> tab in the "Our Team" menu.</p>

        <h3>Style Options</h3>
        <p>Select from the available styles to customize the appearance of team member listings. The following styles are available:</p>
        <ul>
            <li><strong>Style 1:</strong> Basic font with margins.</li>
            <li><strong>Style 2:</strong> Italic font style.</li>
            <li><strong>Style 3:</strong> Underlined font style.</li>
        </ul>

        <h2>Support</h2>
        <p>If you have any questions or issues, please contact the plugin developer for assistance.</p>
    </div>
    <?php
}
