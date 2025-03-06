<?php

function acf_advanced_link_button_sub_fields($sub_fields, $field, $value) {
  // Remove 'term' from the choices
  if (isset($sub_fields[0]['choices']['term'])) {
    unset($sub_fields[0]['choices']['term']);
  }

  return $sub_fields;
}

add_filter('acfe/fields/advanced_link/sub_fields', 'acf_advanced_link_button_sub_fields', 10, 3);


function acf_transform_advanced_link($value, $post_id, $field) {
  // First check if value is empty or not an array - this handles link deletion
  if (empty($value) || !is_array($value)) {
    return $value;
  }

  // Then check if it has the expected structure
  if (array_key_exists('url', $value)) {
    if (isset($value['type']) && $value['type'] !== 'url') {
      $value['url'] = parse_url($value['url'], PHP_URL_PATH);
    }
    if (isset($value['name'])) $value['name'] = html_entity_decode($value['name']);
    if (isset($value['title'])) $value['title'] = html_entity_decode($value['title']);

    // Add post type and slug when type is 'post'
    if (isset($value['type']) && $value['type'] === 'post' && isset($value['value'])) {
      $post_id = $value['value'];
      $post = get_post($post_id);

      if ($post) {
        $value['post_type'] = $post->post_type;
        $value['slug'] = $post->post_name;
      }
    }
  }

  return $value;
}

add_filter('acf/format_value/type=acfe_advanced_link', 'acf_transform_advanced_link', 20, 3);
