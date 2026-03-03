<?php

if (! defined('ABSPATH')) {
    exit;
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
    $page = get_page_by_path(trim($slug, '/'));

    if ($page instanceof WP_Post) {
        $page_link = get_permalink($page);

        if (is_string($page_link) && $page_link !== '') {
            return $page_link;
        }
    }

    return home_url('/' . trim($slug, '/'));
}
