<?php
function page_custom_columns($columns) {
  unset($columns['author']);
  unset($columns['comments']);
  unset($columns['date']);
  return $columns;
}

function project_custom_columns($columns) {
  unset($columns['author']);
  unset($columns['comments']);
  unset($columns['date']);
  $columns['thumbnail'] =  '';
  $columns['client'] =  'Client';
  $order = array('thumbnail', 'title', 'client', 'talent');
  uksort($columns, function ($key1, $key2) use ($order) {
    return (array_search($key1, $order) > array_search($key2, $order));
  });
  return $columns;
}

function project_custom_column_values($column, $post_id) {
  switch ($column) {
    case 'thumbnail':
      $media = get_field('preview', $post_id);
      if ($media && $media['type'] === 'image' && isset($media['image']['id'])) {
        $thumbnail = wp_get_attachment_image_url($media['image']['id'], 'thumbnail');
      } else if ($media && $media['type'] === 'video' && isset($media['video']['id'])) {
        $thumbnail = get_the_post_thumbnail_url($media['video']['id'], 'thumbnail');
      }
      $div = '<div class="cc-thumbnail">';
      if (isset($thumbnail) && !empty($thumbnail)) $div .= '<img src="' . $thumbnail . '" />';
      $div .= '</div>';
      echo $div;
      break;
    case 'client':
      $client = get_field('client', $post_id);
      echo $client;
      break;
  }
}

// Add Filter
add_filter('manage_page_posts_columns', 'page_custom_columns');
add_filter('manage_project_posts_columns', 'project_custom_columns');
add_action('manage_project_posts_custom_column', 'project_custom_column_values', 10, 2);
