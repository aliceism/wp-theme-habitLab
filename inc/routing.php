<?php

if (! defined('ABSPATH')) {
    exit;
}

function habitlab_redirect_logged_in_front_page(): void
{
    if (! (habitlab_get_page_by_slug('dashboard') instanceof WP_Post)) {
        return;
    }

    $request_path = wp_parse_url(home_url(add_query_arg([])), PHP_URL_PATH) ?: '/';
    $dashboard_path = wp_parse_url(habitlab_get_dashboard_url(), PHP_URL_PATH) ?: '/';

    if (
        is_admin() ||
        wp_doing_ajax() ||
        wp_doing_cron() ||
        ! is_user_logged_in() ||
        ! is_front_page() ||
        untrailingslashit($request_path) === untrailingslashit($dashboard_path)
    ) {
        return;
    }

    wp_safe_redirect(habitlab_get_dashboard_url());
    exit;
}
add_action('template_redirect', 'habitlab_redirect_logged_in_front_page');

function habitlab_redirect_admin_profile_to_frontend(): void
{
    if (! is_user_logged_in() || wp_doing_ajax()) {
        return;
    }

    global $pagenow;

    if (! is_string($pagenow) || $pagenow !== 'profile.php') {
        return;
    }

    $profile_url = habitlab_get_profile_url();
    $profile_path = wp_parse_url($profile_url, PHP_URL_PATH) ?: '';

    if (! is_string($profile_url) || $profile_url === '') {
        return;
    }

    if ($profile_path === '' || strpos($profile_path, '/wp-admin/profile.php') !== false) {
        return;
    }

    wp_safe_redirect($profile_url);
    exit;
}
add_action('admin_init', 'habitlab_redirect_admin_profile_to_frontend');

function habitlab_force_profile_template(string $template): string
{
    if (! habitlab_is_profile_page_request()) {
        return $template;
    }

    $profile_template = get_template_directory() . '/page-profile.php';

    if (! is_readable($profile_template)) {
        return $template;
    }

    return $profile_template;
}
add_filter('template_include', 'habitlab_force_profile_template', 20);
