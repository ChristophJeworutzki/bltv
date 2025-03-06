<?php

function register_custom_post_types() {
    register_post_type('project', array(
        'label'               => __('Projects'),
        'description'         => __(''),
        'labels'              => array(
            'name'                => __('Projects'),
            'singular_name'       => __('Project'),
            'add_new'             => 'Add New Project',
            'add_new_item'        => 'Add New Project',
        ),
        'supports'            => array('title'),
        'taxonomies'          => array(''),
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => false,
        'menu_position'       => 21,
        'menu_icon'           => 'dashicons-category',
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => false,
        'rewrite'             => array(
            'slug'                => 'projects',
            'with_front'          => false,
        ),
    ));
}

add_action('init', 'register_custom_post_types');
