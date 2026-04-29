<?php

if (! defined('ABSPATH')) {
    exit;
}

function habitlab_setup(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('habitlab-article-hero', 1280, 720, true);
    add_image_size('habitlab-article-card', 760, 428, true);
    add_image_size('habitlab-article-featured', 980, 620, true);

    register_nav_menus([
        'primary' => __('Primary Menu', 'habitlab'),
    ]);
}
add_action('after_setup_theme', 'habitlab_setup');
