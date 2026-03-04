<?php

if (! defined('ABSPATH')) {
    exit;
}

function habitlab_get_page_by_slug(string $slug): ?WP_Post
{
    $page = get_page_by_path(trim($slug, '/'));

    return $page instanceof WP_Post ? $page : null;
}

function habitlab_get_blog_url(): string
{
    $posts_page_id = (int) get_option('page_for_posts');

    if ($posts_page_id > 0) {
        $posts_page_link = get_permalink($posts_page_id);

        if (is_string($posts_page_link) && $posts_page_link !== '') {
            return $posts_page_link;
        }
    }

    $archive_link = get_post_type_archive_link('post');

    if (is_string($archive_link) && $archive_link !== '') {
        return $archive_link;
    }

    return home_url('/');
}

function habitlab_get_page_url_by_slug(string $slug): string
{
    $page = habitlab_get_page_by_slug($slug);

    if ($page instanceof WP_Post) {
        $page_link = get_permalink($page);

        if (is_string($page_link) && $page_link !== '') {
            return $page_link;
        }
    }

    return home_url('/' . trim($slug, '/'));
}

function habitlab_get_dashboard_url(): string
{
    return habitlab_get_page_url_by_slug('dashboard');
}

function habitlab_get_home_target_url(): string
{
    if (is_user_logged_in() && habitlab_get_page_by_slug('dashboard') instanceof WP_Post) {
        return habitlab_get_dashboard_url();
    }

    return home_url('/');
}
