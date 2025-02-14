<?php
// Add Shortcode to Display Team Members with Selected Style
function our_team_shortcode($atts) {
    // Set default attributes and merge with user-defined attributes
    $atts = shortcode_atts(array(
        'count' => -1,            // Display all team members by default
        'order' => 'asc',         // Default order is ascending
        'orderby' => 'title',     // Default order by post title
        'columnswidth' => '25',   // Default column width
        'user_id' => '',          // Default user ID(s)
    ), $atts, 'our_team');

    // Fetch style options
    $style_option = get_option('our_team_style_option', 'style1'); // Fetch team title style option
    $button_bg_color = get_option('our_team_button_bg_color', '#ffffff'); // Button background color
    $button_text_color = get_option('our_team_button_text_color', '#000000'); // Button text color
    $button_padding = get_option('our_team_button_padding', '10px 20px'); // Button padding
    $button_margin = get_option('our_team_button_margin', '10px'); // Button margin

    // Define CSS for each title style option
    $styles = array(
        'style1' => 'font-size: 20px; font-weight: bold; margin: 10px; padding: 10px;',
        'style2' => 'font-style: italic; font-size: 18px; color: #2E86C1; background-color: #E8F8F5; padding: 10px; margin: 10px; border: 2px dashed #2E86C1; border-radius: 8px;',
        'style3' => 'text-decoration: underline; font-size: 16px; color: #239B56; font-family: "Courier New", Courier, monospace; margin: 15px; padding: 12px; background-color: #EAFAF1; border: 2px dotted #239B56; border-radius: 10px;',
    );

    // Prepare user IDs
    $user_ids = array_filter(array_map('trim', explode(',', $atts['user_id'])));

    // Set up WP_Query arguments
    $query_args = array(
        'post_type'      => 'our_team',
        'posts_per_page' => intval($atts['count']),
        'order'          => strtoupper($atts['order']) === 'DESC' ? 'DESC' : 'ASC',
        'orderby'        => !empty($user_ids) ? 'post__in' : (in_array($atts['orderby'], ['title', 'date', 'ID'], true) ? $atts['orderby'] : 'title'),
    );

    // Include the IDs if provided
    if (!empty($user_ids)) {
        $query_args['post__in'] = $user_ids;
    }

    // Include inline styles
    ?>
    <style>
        .downloadbtn {
            background-color: <?php echo esc_attr($button_bg_color); ?>;
            border: none;
            color: <?php echo esc_attr($button_text_color); ?>;
            padding: <?php echo esc_attr($button_padding); ?>;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: <?php echo esc_attr($button_margin); ?>;
            cursor: pointer;
        }
    </style>
    <?php

    // Fetch posts using WP_Query
    $query = new WP_Query($query_args);

    if ($query->have_posts()) {
        ob_start(); ?>
        
        <div class="easy-team">
            <div id="team-popup" class="team-modal" style="display:none;">
                <div class="team-modal-content">
                    <span class="close-modal">&times;</span>
                    <div id="modal-content-area"></div>
                </div>
            </div>
        <?php
        while ($query->have_posts()) {
            $query->the_post();
            // echo get_the_ID();
            // Fetch metadata
            $job_title = get_post_meta(get_the_ID(), '_team_member_job_title', true);
            $email = get_post_meta(get_the_ID(), '_team_member_email', true);
            $phone = get_post_meta(get_the_ID(), '_team_member_phone', true);
            $img = get_the_post_thumbnail_url(get_the_ID(), 'full');
            $content = get_the_content();
            $vcard_link = add_query_arg(array('download_vcard' => get_the_ID()), home_url()); ?>
            <div class="easy-team-member-<?php echo esc_attr($atts['columnswidth']); ?> easy-team-member">
                <div class="easy-member">
                    <a class="view-details-btn" style="cursor: pointer;" 
                        data-name="<?php echo esc_html(get_the_title()); ?>" 
                        data-job="<?php echo esc_attr($job_title); ?>" 
                        data-email="<?php echo esc_attr($email); ?>" 
                        data-phone="<?php echo esc_attr($phone); ?>" 
                        data-img="<?php echo esc_attr($img); ?>" 
                        data-content="<?php echo esc_attr($content); ?>" 
                        data-vcard="<?php echo esc_url($vcard_link); ?>">
                        <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"/>
                        <div class="content">
                            <h4 style="<?php echo esc_attr($styles[$style_option]); ?>">
                                <?php echo esc_html(get_the_title()); ?>
                            </h4>
                            <p style="margin: 0;"><?php echo esc_html($job_title); ?></p>
                        </div>
                    </a>
                </div>
            </div>
            <?php
        } ?>
        </div>
        <?php
        wp_reset_postdata();
        return ob_get_clean();
    } else {
        return '<p>No team members found.</p>';
    }
}

add_shortcode('our_team', 'our_team_shortcode');
