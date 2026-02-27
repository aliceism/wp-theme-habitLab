<?php

if (! defined('ABSPATH')) {
    exit;
}

function habitlab_enqueue_assets(): void
{
    $theme_version = wp_get_theme()->get('Version');

    wp_enqueue_style(
        'habitlab-style',
        get_stylesheet_uri(),
        [],
        $theme_version
    );

    wp_enqueue_style(
        'habitlab-main',
        get_template_directory_uri() . '/assets/css/main.css',
        ['habitlab-style'],
        $theme_version
    );

    wp_enqueue_script(
        'habitlab-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        $theme_version,
        true
    );
}
add_action('wp_enqueue_scripts', 'habitlab_enqueue_assets');
