<?php

namespace App\Transformer;

use League\Fractal;
use MediaCloud\Plugin\Tools\Video\Driver\Mux\Models\MuxAsset;
use MediaCloud\Plugin\Tools\Video\Driver\Mux\Models\MuxRendition;
use App\Utils;

class VideoTransformer extends Fractal\TransformerAbstract {

    protected array $availableIncludes = [];

    public function transform($attachment) {

        if (!isset($attachment) || empty($attachment)) return null;

        if (!class_exists('MediaCloud\Plugin\Tools\Video\Driver\Mux\Models\MuxAsset')) {
            return $attachment;
        }

        $muxAsset = MuxAsset::assetForAttachment($attachment['id']);

        if (!$muxAsset) {
            return $attachment;
        }

        $muxRenditions = MuxRendition::renditionsForAsset($muxAsset->muxId);
        $playbackId = $muxAsset->__get('publicPlaybackID');
        $files = [];

        if ($muxRenditions) {
            foreach ($muxRenditions as $key => $muxRendition) {
                $pathParts = pathinfo($muxRendition->rendition);
                $filename = $pathParts['filename'];
                $extension = $pathParts['extension'];
                $files[$filename] = [
                    "name"      => $filename,
                    "extension" => $extension,
                    "height"    => $muxRendition->height,
                    "width"     => $muxRendition->width,
                    "bitrate"   => $muxRendition->bitrate,
                    "filesize"  => $muxRendition->filesize,
                    "url"       => "https://stream.mux.com/{$playbackId}/{$muxRendition->rendition}",
                ];
            }
        }

        return [
            'id'            => intval($attachment['id']),
            'playbackId'    => $playbackId,
            'title'         => $muxAsset->title,
            'width'         => intval($muxAsset->width),
            'height'        => intval($muxAsset->height),
            'status'        => $muxAsset->status,
            'duration'      => floatval($muxAsset->duration),
            'aspectRatio'   => $muxAsset->aspectRatio,
            'orientation'   => Utils\get_orientation($muxAsset->width, $muxAsset->height),
            'url'           => "https://stream.mux.com/{$playbackId}.m3u8",
            'caption'       => $attachment['caption'],
            'description'   => $attachment['description'],
            'files'         => $files,
            'thumbnail'     => get_the_post_thumbnail_url($attachment['id']),
            'poster'        => "https://image.mux.com/{$playbackId}/thumbnail.jpg?time=0",
            'meta'          => [
                'controls'  => get_field('controls', $attachment['id']),
            ],
        ];
    }
}
