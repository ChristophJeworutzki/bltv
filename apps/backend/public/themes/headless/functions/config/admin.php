<?php

/*
 |--------------------------------------------------------------------------
 | Admin
 |--------------------------------------------------------------------------
 */

/*  Update Permalink Structure */
update_option('permalink_structure', '/%postname%');

/*  Disable Gutenberg for posts */
add_filter('use_block_editor_for_post', '__return_false', 10);

/*  Disable Gutenberg for post types */
add_filter('use_block_editor_for_post_type', '__return_false', 10);

/* Inject Admin Scripts */
function custom_admin_scripts() {
  wp_enqueue_style('custom_admin_style', get_template_directory_uri(__FILE__) . '/assets/css/admin.css', [], filemtime(get_stylesheet_directory() . '/assets/css/admin.css'));
  wp_enqueue_script('custom_admin_script', get_template_directory_uri(__FILE__) . '/assets/js/admin.js', [], filemtime(get_stylesheet_directory() . '/assets/js/admin.js'));
}

/* Inject Login Scripts */
function custom_login_scripts() {
  wp_enqueue_style('custom_login_style', get_template_directory_uri(__FILE__) . '/assets/css/login.css', [], filemtime(get_stylesheet_directory() . '/assets/css/login.css'));
  wp_enqueue_script('custom_login_script', get_template_directory_uri(__FILE__) . '/assets/js/login.js', [], filemtime(get_stylesheet_directory() . '/assets/js/login.js'));
}

/* Disable Default Dashboard Widgets */
function disable_default_dashboard_widgets() {
  global $wp_meta_boxes;
  unset($wp_meta_boxes['settings_page_menu_editor']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_widget']);
}

/* Disable all the Nags & Notifications */
function remove_core_updates() {
  global $wp_version;
  return (object) array('last_checked' => time(), 'version_checked' => $wp_version);
}

/* Remove from Sidebar */
function remove_menu() {
  remove_menu_page('index.php');
  remove_menu_page('edit.php');
  remove_menu_page('edit-comments.php');
}

/* Remove from and add to Adminbar */
function custom_admin_bar_menu($wp_admin_bar) {
  $wp_admin_bar->remove_node('wp-logo');
  $wp_admin_bar->remove_node('site-name');
  $wp_admin_bar->remove_node('updates');
  $wp_admin_bar->remove_node('comments');
  $wp_admin_bar->remove_node('new-content');
  $wp_admin_bar->remove_node('view');
  $wp_admin_bar->remove_node('language');
  $args = array(
    'id'    => sanitize_title(get_bloginfo('name')),
    'title' => get_bloginfo('name'),
    'href'  => env('APP_URL'),
    'meta'  => [
      'target' => '_blank',
    ]
  );
  $wp_admin_bar->add_node($args);
}

/* Extend Upload Mime Types */
function extend_upload_mimes($mime_types) {
  $mime_types['svg'] = 'image/svg+xml';
  return $mime_types;
}

/* Force GD Editor */
function wp_image_editor_default_to_gd($editors) {
  $gd_editor = 'WP_Image_Editor_GD';
  $editors = array_diff($editors, array($gd_editor));
  array_unshift($editors, $gd_editor);
  return $editors;
}

/* Add Filters */
add_filter('pre_site_transient_update_core', 'remove_core_updates');
add_filter('pre_site_transient_update_plugins', 'remove_core_updates');
add_filter('pre_site_transient_update_themes', 'remove_core_updates');
add_filter('upload_mimes', 'extend_upload_mimes');
add_filter('wp_image_editors', 'wp_image_editor_default_to_gd');
add_filter('big_image_size_threshold', '__return_false');

/* Remove Filters */
remove_filter('the_title', 'wptexturize');

/* Add Actions */
add_action('admin_enqueue_scripts', 'custom_admin_scripts', 1);
add_action('login_enqueue_scripts', 'custom_login_scripts', 1);
add_action('admin_menu', 'remove_menu');
add_action('admin_bar_menu', 'custom_admin_bar_menu', 999);
add_action('wp_dashboard_setup', 'disable_default_dashboard_widgets', 999);

/* Remove Actions */
remove_action('welcome_panel', 'wp_welcome_panel');
remove_action('try_gutenberg_panel', 'wp_try_gutenberg_panel');
remove_action('wp_head', 'wp_generator');
