<?php
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Globals',
        'menu_title' => 'Globals',
        'menu_slug' => 'globals',
        'capability' => 'edit_posts',
        'redirect' => false,
        'position' => 24,
        'icon_url' => 'dashicons-admin-settings',
    ));
}
