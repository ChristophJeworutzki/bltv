<?php


use Spatie\Fractalistic\Fractal;
use Spatie\Fractalistic\ArraySerializer;
use App\Transformer\ProjectTransformer;


function acf_transform_relationship($value, $post_id, $field) {

  if (empty($value)) {
    return $value;
  }

  if ($field['return_format'] === 'object') {
    if (is_array($value)) {
      $result = [];
      foreach ($value as $key => $post) {
        if ($post->post_type === 'project') {
          array_push(
            $result,
            Fractal::create()
              ->item($post, new ProjectTransformer())
              ->includePreview()
              ->serializeWith(new ArraySerializer())
              ->toArray()
          );
        } else {
          array_push($result, array(
            'id'        => $post->ID,
            'type'      => $post->post_type,
            'slug'      => $post->post_name,
            'title'     => get_the_title($post->ID),
          ));
        }
      };
      return $result;
    } else {
      return $value;
    }
  } else {
    return $value;
  }
}

add_filter('acf/format_value/type=relationship', 'acf_transform_relationship', 20, 3);
