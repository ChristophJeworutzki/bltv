<?php

use App\Transformer\ImageTransformer;
use Spatie\Fractalistic\ArraySerializer;
use Spatie\Fractalistic\Fractal;

function transform_image($value, $post_id, $field) {

  if ($field['return_format'] === 'id') {
    return $value;
  } else if ($value && $field['return_format'] === 'array') {
    if ($value['mime_type'] === "image/svg+xml") {
      return $value;
    } else {
      return Fractal::create()
        ->item($value, new ImageTransformer())
        ->serializeWith(new ArraySerializer())
        ->toArray();
    }
  } else {
    return $value;
  }
}

add_filter('acf/format_value/type=image', 'transform_image', 20, 3);
