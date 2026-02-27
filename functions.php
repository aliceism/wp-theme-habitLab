<?php

if (! defined('ABSPATH')) {
    exit;
}

function habitlab_enqueue_assets(): void
{
    wp_enqueue_style(
        'habitlab-style',
        get_stylesheet_uri(),
        [],
        wp_get_theme()->get('Version')
    );

    wp_enqueue_style(
        'habitlab-main',
        get_template_directory_uri() . '/assets/css/main.css',
        ['habitlab-style'],
        wp_get_theme()->get('Version')
    );

    wp_enqueue_script(
        'habitlab-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('wp_enqueue_scripts', 'habitlab_enqueue_assets');

function habitlab_setup(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    register_nav_menus([
        'primary' => __('Primary Menu', 'habitlab'),
    ]);
}
add_action('after_setup_theme', 'habitlab_setup');
