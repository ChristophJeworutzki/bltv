<?php

namespace App\Transformer;

use League\Fractal;

class AudioTransformer extends Fractal\TransformerAbstract {

    protected array $availableIncludes = [];

    public function transform($attachment) {
        if (!isset($attachment) || empty($attachment)) return null;
        return [
            'id'                => $attachment['id'],
            'title'             => $attachment['title'],
            'type'              => $attachment['type'],
            'mimeType'          => $attachment['mime_type'],
            'url'               => $attachment['url'],
            'alt'               => $attachment['alt'],
            'caption'           => $attachment['caption'],
            'description'       => $attachment['description'],
            'meta'              => []
        ];
    }
}
