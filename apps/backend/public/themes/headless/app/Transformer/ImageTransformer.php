<?php

namespace App\Transformer;

use League\Fractal;
use App\Utils;

class ImageTransformer extends Fractal\TransformerAbstract {

    protected array $availableIncludes = [];

    public function transform($attachment) {
        if (!isset($attachment) || empty($attachment)) return null;
        return [
            'id'                => $attachment['id'],
            'title'             => $attachment['title'],
            'width'             => $attachment['width'],
            'height'            => $attachment['height'],
            'type'              => $attachment['type'],
            'mimeType'          => $attachment['mime_type'],
            'url'               => $attachment['url'],
            'alt'               => $attachment['alt'],
            'caption'           => $attachment['caption'],
            'description'       => $attachment['description'],
            'aspectRatio'       => Utils\get_aspect_ratio($attachment['width'], $attachment['height']),
            'orientation'       => Utils\get_orientation($attachment['width'], $attachment['height']),
        ];
    }
}
