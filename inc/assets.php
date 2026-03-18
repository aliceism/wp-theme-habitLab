<?php

if (! defined('ABSPATH')) {
    exit;
}

function habitlab_should_enqueue_habit_tracker_assets(): bool
{
    if (is_admin()) {
        return false;
    }

    if (is_page_template('page-habits.php') || is_page_template('page-dashboard.php')) {
        return true;
    }

    if (! is_singular()) {
        return false;
    }

    $post = get_post();

    if (! ($post instanceof \WP_Post)) {
        return false;
    }

    $content = (string) $post->post_content;
    $shortcodes = [
        'habit_tracker_habits',
        'habit_tracker_habits_notice',
        'habit_tracker_habits_stack',
        'habit_tracker_habits_shared',
        'habit_tracker_habits_custom',
        'habit_tracker_dashboard',
        'habit_tracker_dashboard_notice',
        'habit_tracker_dashboard_metrics',
        'habit_tracker_dashboard_panels',
    ];

    foreach ($shortcodes as $shortcode) {
        if (has_shortcode($content, $shortcode)) {
            return true;
        }
    }

    return false;
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

    if (! habitlab_should_enqueue_habit_tracker_assets()) {
        return;
    }

    $habit_tracker_style_path = get_template_directory() . '/assets/css/habit-tracker.css';
    $habit_tracker_version = is_readable($habit_tracker_style_path)
        ? (string) filemtime($habit_tracker_style_path)
        : $theme_version;

    // Reuse plugin frontend handle so the theme stylesheet takes precedence safely.
    wp_enqueue_style(
        'habit-tracker-frontend',
        get_template_directory_uri() . '/assets/css/habit-tracker.css',
        ['habitlab-main'],
        $habit_tracker_version
    );
}
add_action('wp_enqueue_scripts', 'habitlab_enqueue_assets');
