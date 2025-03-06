<?php

use App\Transformer\MediaTransformer;
use Spatie\Fractalistic\ArraySerializer;
use Spatie\Fractalistic\Fractal;

function transform_gallery($value, $post_id, $field) {

  if (!isset($value) || empty($value)) {
    return $value;
  }

  if (is_array($value)) {
    return Fractal::create()
      ->collection($value, new MediaTransformer())
      ->serializeWith(new ArraySerializer())
      ->toArray();
  } else {
    return $value;
  }
}

add_filter('acf/format_value/type=gallery', 'transform_gallery', 20, 3);
