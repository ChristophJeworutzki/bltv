<?php
function rest_get_index_page(WP_REST_Request $request) {

    $params = $request->get_params();
    $preview = isset($params['preview']) && $params['preview'] === 'true';

    $post = get_post(get_option('page_on_front'));

    if (!$post) return new WP_REST_Response(null, 404);

    if ($preview) {
        $autosave = wp_get_post_autosave($post->ID);
        if ($autosave) {
            $post = $autosave;
        }
    }

    return [
        'id'        => $post->ID,
        'title'     => $post->post_title,
        'slug'      => $post->post_name,
        'fields'    => get_fields($post->ID),
    ];
}

add_action('rest_api_init', function () {
    register_rest_route('v1/pages', '/index', [
        'methods' => 'GET',
        'callback' => 'rest_get_index_page'
    ]);
});
