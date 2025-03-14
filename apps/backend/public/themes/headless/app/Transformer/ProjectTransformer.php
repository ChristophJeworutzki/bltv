<?php

namespace App\Transformer;

use League\Fractal;

class ProjectTransformer extends Fractal\TransformerAbstract {

    protected array $availableIncludes = [
        'preview',
        'gallery',
        'credits',
    ];

    public function transform($post) {
        return [
            'id'                    => (int) $post->ID,
            'title'                 => $post->post_title,
            'slug'                  => $post->post_name,
            'type'                  => $post->post_type,
            'client'                => get_field('client', $post->ID),
        ];
    }

    public function includePreview($post) {
        $preview = get_field('preview', $post->ID);
        return $this->primitive($preview);
    }

    public function includeGallery($post) {
        $gallery = get_field('gallery', $post->ID);
        return $this->primitive($gallery);
    }

    public function includeCredits($post) {
        $credits = get_field('credits', $post->ID);
        return $this->primitive($credits);
    }
}
