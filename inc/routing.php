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
