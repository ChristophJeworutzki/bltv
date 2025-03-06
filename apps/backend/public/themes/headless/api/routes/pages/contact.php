<?php
function rest_get_contact_page(WP_REST_Request $request) {

    $params = $request->get_params();
    $preview = isset($params['preview']) && $params['preview'] === 'true';

    $post = get_page_by_path('contact', OBJECT, 'page');

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
    ];
}

add_action('rest_api_init', function () {
    register_rest_route('v1/pages', '/contact', [
        'methods' => 'GET',
        'callback' => 'rest_get_contact_page'
    ]);
});
