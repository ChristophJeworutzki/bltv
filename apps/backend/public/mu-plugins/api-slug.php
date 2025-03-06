<?php

/**
 * Plugin Name: Force REST API Slug
 * Description: Change the REST API slug to 'api'.
 */

add_filter('rest_url_prefix', function ($slug) {
  return 'api';
});
