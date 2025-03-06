<?php
function custom_custom_attachment_icons($icon, $mime = null, $post_id = null) {
    $placeholder = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
    if (strpos($mime, 'video') !== false) {
        $thumbnail = get_the_post_thumbnail_url($post_id, 'thumbnail');
        if (isset($thumbnail) && !empty($thumbnail)) {
            return $thumbnail;
        } else {
            return $placeholder;
        }
    } else {
        return $placeholder;
    }
}

add_filter('wp_mime_type_icon', 'custom_custom_attachment_icons', 10, 3);
