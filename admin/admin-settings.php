<?php
// Add Settings Page
function our_team_add_settings_page() {
    add_submenu_page(
        'edit.php?post_type=our_team', // Parent slug
        'Our Team Settings',          // Page title
        'Settings',                   // Menu title
        'manage_options',             // Capability
        'our_team_settings',          // Menu slug
        'our_team_settings_page'      // Callback function
    );
}
add_action('admin_menu', 'our_team_add_settings_page');

// Register Settings
function our_team_register_settings() {
    // Register settings for both tabs
    register_setting('our_team_settings_group', 'our_team_style_option');
    register_setting('our_team_settings_group', 'our_team_button_bg_color');
    register_setting('our_team_settings_group', 'our_team_button_text_color');
    register_setting('our_team_settings_group', 'our_team_button_padding');
    register_setting('our_team_settings_group', 'our_team_button_margin');
}
add_action('admin_init', 'our_team_register_settings');

// Settings Page Callback
function our_team_settings_page() {
    // Get the active tab
    $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'basic_settings';
    ?>
    <div class="wrap">
        <h1>Our Team Settings</h1>
        <h2 class="nav-tab-wrapper">
            <a href="?post_type=our_team&page=our_team_settings&tab=basic_settings" 
               class="nav-tab <?php echo $active_tab === 'basic_settings' ? 'nav-tab-active' : ''; ?>">Basic Settings</a>
            <a href="?post_type=our_team&page=our_team_settings&tab=button_settings" 
               class="nav-tab <?php echo $active_tab === 'button_settings' ? 'nav-tab-active' : ''; ?>">Button Settings</a>
        </h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('our_team_settings_group');

            // Render the active tab's content
            if ($active_tab === 'basic_settings') {
                ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Style Options</th>
                        <td>
                            <select name="our_team_style_option">
                                <option value="style1" <?php selected(get_option('our_team_style_option'), 'style1'); ?>>Style 1</option>
                                <option value="style2" <?php selected(get_option('our_team_style_option'), 'style2'); ?>>Style 2</option>
                                <option value="style3" <?php selected(get_option('our_team_style_option'), 'style3'); ?>>Style 3</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <?php
            } elseif ($active_tab === 'button_settings') {
                ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Button Background Color</th>
                        <td>
                            <input type="color" name="our_team_button_bg_color" 
                                   value="<?php echo esc_attr(get_option('our_team_button_bg_color', '#ffffff')); ?>" />
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Button Text Color</th>
                        <td>
                            <input type="color" name="our_team_button_text_color" 
                                   value="<?php echo esc_attr(get_option('our_team_button_text_color', '#000000')); ?>" />
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Button Padding</th>
                        <td>
                            <input type="text" name="our_team_button_padding" 
                                   value="<?php echo esc_attr(get_option('our_team_button_padding', '10px 20px')); ?>" 
                                   placeholder="e.g., 10px 20px" />
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Button Margin</th>
                        <td>
                            <input type="text" name="our_team_button_margin" 
                                   value="<?php echo esc_attr(get_option('our_team_button_margin', '10px')); ?>" 
                                   placeholder="e.g., 10px" />
                        </td>
                    </tr>
                </table>
                <?php
            }

            // Include hidden inputs for inactive tabs
            if ($active_tab !== 'basic_settings') {
                echo '<input type="hidden" name="our_team_style_option" value="' . esc_attr(get_option('our_team_style_option')) . '">';
            }
            if ($active_tab !== 'button_settings') {
                echo '<input type="hidden" name="our_team_button_bg_color" value="' . esc_attr(get_option('our_team_button_bg_color', '#ffffff')) . '">';
                echo '<input type="hidden" name="our_team_button_text_color" value="' . esc_attr(get_option('our_team_button_text_color', '#000000')) . '">';
                echo '<input type="hidden" name="our_team_button_padding" value="' . esc_attr(get_option('our_team_button_padding', '10px 20px')) . '">';
                echo '<input type="hidden" name="our_team_button_margin" value="' . esc_attr(get_option('our_team_button_margin', '10px')) . '">';
            }

            submit_button();
            ?>
        </form>
    </div>
    <?php
}
