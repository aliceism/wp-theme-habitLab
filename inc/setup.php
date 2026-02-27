<?php

if (! defined('ABSPATH')) {
    exit;
}

function habitlab_setup(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    register_nav_menus([
        'primary' => __('Primary Menu', 'habitlab'),
    ]);
}
add_action('after_setup_theme', 'habitlab_setup');
