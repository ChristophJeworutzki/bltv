<?php

namespace App\Transformer;

use League\Fractal;

class ProjectTransformer extends Fractal\TransformerAbstract {

    protected array $availableIncludes = [
        'preview',
    ];

    public function transform($post) {
        return [
            'id'                    => (int) $post->ID,
            'title'                 => $post->post_title,
            'slug'                  => $post->post_name,
            'type'                  => $post->post_type,
        ];
    }

    public function includePreview($post) {
        $preview = get_field('preview', $post->ID);
        return $this->primitive($preview);
    }
}
