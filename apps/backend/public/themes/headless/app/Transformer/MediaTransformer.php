<?php

namespace App\Transformer;

use League\Fractal;
use Spatie\Fractalistic\Fractal as SpatieFractal;
use Spatie\Fractalistic\ArraySerializer;
use App\Transformer\ImageTransformer;
use App\Transformer\AudioTransformer;
use App\Transformer\VideoTransformer;

class MediaTransformer extends Fractal\TransformerAbstract {

    protected array $availableIncludes = [];

    public function transform($attachment) {
        if (wp_attachment_is('video', $attachment['ID'])) {
            $media = ['type' => 'video'];
            $media['video'] = SpatieFractal::create()
                ->item($attachment, new VideoTransformer())
                ->serializeWith(new ArraySerializer())
                ->toArray();
        } else if (wp_attachment_is('audio', $attachment['ID'])) {
            $media = ['type' => 'audio'];
            $media['audio'] = SpatieFractal::create()
                ->item($attachment, new AudioTransformer())
                ->serializeWith(new ArraySerializer())
                ->toArray();
        } else if (wp_attachment_is('image', $attachment['ID'])) {
            $media = ['type' => 'image'];
            $media['image'] = SpatieFractal::create()
                ->item($attachment, new ImageTransformer())
                ->serializeWith(new ArraySerializer())
                ->toArray();
        } else {
            $media = ['type' => 'file'];
            $media['file'] = $attachment;
        }
        return $media;
    }
}
