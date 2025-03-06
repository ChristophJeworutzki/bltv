<?php


use Spatie\Fractalistic\Fractal;
use Spatie\Fractalistic\ArraySerializer;
use App\Transformer\ProjectTransformer;

function transform_post_object($value, $post_id, $field) {

  if (empty($value)) {
    return $value;
  }

  if ($field['return_format'] === 'object') {
    if (is_object($value)) {
      if ($value->post_type === 'project') {
        return Fractal::create()
          ->item($value, new ProjectTransformer())
          ->includePreview()
          ->serializeWith(new ArraySerializer())
          ->toArray();
      } else {
        return array(
          'id'        => $value->ID,
          'type'      => $value->post_type,
          'slug'      => $value->post_name,
          'title'     => get_the_title($value->ID),
        );
      }
    } else if (is_array($value)) {
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
    }
  } else {
    return $value;
  }
}

add_filter('acf/format_value/type=post_object', 'transform_post_object', 20, 3);
