<?php

function transform_taxonomy($value, $post_id, $field) {


  if (empty($value)) {
    return $value;
  }

  if ($field['return_format'] === 'object') {
    if (is_object($value)) {
      return [
        'id'      => $value->term_id,
        'name'    => $value->name,
        'slug'    => $value->slug,
      ];
    } else if (is_array($value)) {
      return array_map(function ($item) {
        return [
          'id'      => $item->term_id,
          'name'    => $item->name,
          'slug'    => $item->slug,
        ];
      }, $value);
    }
  } else {
    return $value;
  }
}

add_filter('acf/format_value/type=taxonomy', 'transform_taxonomy', 20, 3);
