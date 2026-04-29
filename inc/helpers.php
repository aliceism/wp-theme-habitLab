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
    $articles_page = habitlab_get_page_by_slug('articles');

    if ($articles_page instanceof WP_Post) {
        $articles_link = get_permalink($articles_page);

        if (is_string($articles_link) && $articles_link !== '') {
            return $articles_link;
        }
    }

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

function habitlab_get_profile_url(): string
{
    $profile_page = habitlab_get_page_by_slug('profile');

    if ($profile_page instanceof WP_Post) {
        $profile_permalink = get_permalink($profile_page);

        if (is_string($profile_permalink) && $profile_permalink !== '') {
            return $profile_permalink;
        }
    }

    $profile_template_pages = get_pages([
        'post_status' => 'publish',
        'number' => 1,
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-profile.php',
    ]);

    if (is_array($profile_template_pages) && isset($profile_template_pages[0]) && $profile_template_pages[0] instanceof WP_Post) {
        $template_permalink = get_permalink($profile_template_pages[0]);

        if (is_string($template_permalink) && $template_permalink !== '') {
            return $template_permalink;
        }
    }

    return home_url('/profile');
}

function habitlab_is_profile_page_request(): bool
{
    if (! is_page()) {
        return false;
    }

    $queried_id = (int) get_queried_object_id();

    if ($queried_id > 0) {
        $template_slug = get_page_template_slug($queried_id);

        if (is_string($template_slug) && $template_slug === 'page-profile.php') {
            return true;
        }
    }

    $profile_page = habitlab_get_page_by_slug('profile');

    if ($profile_page instanceof WP_Post) {
        return (int) get_queried_object_id() === (int) $profile_page->ID;
    }

    return is_page('profile');
}

function habitlab_get_home_target_url(): string
{
    if (is_user_logged_in() && habitlab_get_page_by_slug('dashboard') instanceof WP_Post) {
        return habitlab_get_dashboard_url();
    }

    return home_url('/');
}

function habitlab_get_post_read_time(int $post_id, int $words_per_minute = 200): int
{
    $content = (string) get_post_field('post_content', $post_id);
    $content = trim(wp_strip_all_tags($content));

    if ($content === '') {
        return 1;
    }

    $tokens = preg_split('/\s+/u', $content);
    $words = is_array($tokens)
        ? count(array_filter($tokens, 'strlen'))
        : 0;
    $words_per_minute = max(120, $words_per_minute);

    return max(1, (int) ceil($words / $words_per_minute));
}

function habitlab_get_primary_category_term(int $post_id): ?WP_Term
{
    $terms = get_the_category($post_id);

    if (! is_array($terms)) {
        return null;
    }

    foreach ($terms as $term) {
        if ($term instanceof WP_Term) {
            return $term;
        }
    }

    return null;
}

function habitlab_get_primary_category_label(int $post_id): string
{
    $term = habitlab_get_primary_category_term($post_id);

    if ($term instanceof WP_Term) {
        return (string) $term->name;
    }

    return __('Article', 'habitlab');
}

function habitlab_get_primary_category_link(int $post_id): string
{
    $term = habitlab_get_primary_category_term($post_id);

    if (! ($term instanceof WP_Term)) {
        return '';
    }

    $term_link = get_term_link($term);

    if (is_wp_error($term_link) || ! is_string($term_link) || $term_link === '') {
        return '';
    }

    return $term_link;
}
