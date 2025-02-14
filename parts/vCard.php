<?php
// vCard Download
function our_team_vcard_download() {
    if (isset($_GET['download_vcard'])) {
        $post_id = intval($_GET['download_vcard']);
        $post = get_post($post_id);

        if ($post && $post->post_type === 'our_team') {
            $job_title = get_post_meta($post_id, '_team_member_job_title', true);
            $email = get_post_meta($post_id, '_team_member_email', true);
            $phone = get_post_meta($post_id, '_team_member_phone', true);
            $featured_image_url = get_the_post_thumbnail_url($post_id, 'full');

            header('Content-Type: text/vcard');
            header('Content-Disposition: attachment; filename="team-member.vcf"');

            echo "BEGIN:VCARD\n";
            echo "VERSION:3.0\n";
            echo "FN:" . esc_html($post->post_title) . "\n";
            echo "TITLE:" . esc_html($job_title) . "\n";
            echo "EMAIL;TYPE=INTERNET:" . esc_html($email) . "\n";
            echo "TEL;TYPE=VOICE:" . esc_html($phone) . "\n";

            // Add featured image as a PHOTO field if it exists
            if ($featured_image_url) {
                $image_data = file_get_contents($featured_image_url);
                if ($image_data) {
                    $base64_image = base64_encode($image_data);
                    echo "PHOTO;ENCODING=b;TYPE=JPEG:" . $base64_image . "\n";
                }
            }

            echo "END:VCARD\n";
            exit;
        }
    }
}
add_action('init', 'our_team_vcard_download');