<?php

/*
 |--------------------------------------------------------------------------
 | UI
 |--------------------------------------------------------------------------
 */

/* Admin Color Scheme */
function headless_admin_color_scheme() {
  $theme_dir = get_template_directory_uri();
  wp_admin_css_color(
    'headless',
    __('Headless'),
    $theme_dir . '/assets/css/headless.css',
    array('#1c2024', '#fff', '#3858e9', '#3858e9')
  );
}

add_action('admin_init', 'headless_admin_color_scheme');

/* Force Admin Color Scheme */
function update_user_option_admin_color($color_scheme) {
  $color_scheme = 'headless';
  return $color_scheme;
}

add_filter('get_user_option_admin_color', 'update_user_option_admin_color', 5);
remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');
