<?php

use App\Transformer\VideoTransformer;
use App\Transformer\AudioTransformer;
use Spatie\Fractalistic\ArraySerializer;
use Spatie\Fractalistic\Fractal;

function transform_file($value, $post_id, $field) {

  if (empty($value) || !$field['return_format'] === 'array') {
    return $value;
  }

  if (wp_attachment_is('video', $value['id'])) {
    return Fractal::create()
      ->item($value, new VideoTransformer())
      ->serializeWith(new ArraySerializer())
      ->toArray();
  } else if (wp_attachment_is('audio', $value['id'])) {
    return Fractal::create()
      ->item($value, new AudioTransformer())
      ->serializeWith(new ArraySerializer())
      ->toArray();
  }

  return $value;
}

add_filter('acf/format_value/type=file', 'transform_file', 20, 3);
