<?php

use App\Transformer\ProjectTransformer;
use Spatie\Fractalistic\ArraySerializer;
use Spatie\Fractalistic\Fractal;

function rest_get_projects(WP_REST_Request $request) {

    $posts = get_posts([
        'post_type' => 'project',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC'
    ]);

    return Fractal::create()
        ->collection($posts, new ProjectTransformer())
        ->includePreview()
        ->toArray();
}

function rest_get_project_by_slug(WP_REST_Request $request) {

    $params = $request->get_params();
    $preview = isset($params['preview']) && $params['preview'] === 'true';

    $post = get_page_by_path($params['slug'], OBJECT, 'project');

    if (!$post) return new WP_REST_Response(null, 404);

    if ($preview) {
        $autosave = wp_get_post_autosave($post->ID);
        if ($autosave) {
            $post = $autosave;
        }
    }

    return Fractal::create()
        ->item($post, new ProjectTransformer())
        ->includeGallery()
        ->includeCredits()
        ->serializeWith(new ArraySerializer())
        ->toArray();
}

add_action('rest_api_init', function () {
    register_rest_route('v1', '/projects', [
        'methods' => 'GET',
        'callback' => 'rest_get_projects'
    ]);
    register_rest_route('v1', '/projects/(?P<slug>[a-zA-Z0-9-]+)', [
        'methods' => 'GET',
        'callback' => 'rest_get_project_by_slug'
    ]);
});
