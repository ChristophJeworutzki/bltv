<?php

function rest_get_globals(WP_REST_Request $request) {
  $globals = get_fields('options');
  return $globals;
}

add_action('rest_api_init', function () {
  register_rest_route('v1', '/globals', [
    'methods' => 'GET',
    'callback' => 'rest_get_globals'
  ]);
});
