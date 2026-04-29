<?php
if (! defined('ABSPATH')) {
    exit;
}

$habitlab_blog_url = function_exists('habitlab_get_blog_url')
    ? habitlab_get_blog_url()
    : home_url('/');
$habitlab_join_url = function_exists('habitlab_get_page_url_by_slug')
    ? habitlab_get_page_url_by_slug('join')
    : wp_login_url();

$habitlab_topic_slugs = ['habits', 'discipline', 'motivation', 'mindset', 'productivity', 'health'];
$habitlab_topic_categories = [];

foreach ($habitlab_topic_slugs as $habitlab_topic_slug) {
    $habitlab_term = get_category_by_slug($habitlab_topic_slug);

    if ($habitlab_term instanceof WP_Term && (int) $habitlab_term->count > 0) {
        $habitlab_topic_categories[] = $habitlab_term;
    }
}

if ($habitlab_topic_categories === []) {
    $habitlab_topic_categories = get_categories([
        'taxonomy' => 'category',
        'hide_empty' => true,
        'number' => 6,
        'orderby' => 'count',
        'order' => 'DESC',
    ]);
}

$habitlab_sticky_ids = get_option('sticky_posts');
$habitlab_sticky_ids = is_array($habitlab_sticky_ids)
    ? array_map('intval', $habitlab_sticky_ids)
    : [];

$habitlab_featured_query_args = [
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'ignore_sticky_posts' => 0,
];

if ($habitlab_sticky_ids !== []) {
    $habitlab_featured_query_args['post__in'] = $habitlab_sticky_ids;
}

$habitlab_featured_query = new WP_Query($habitlab_featured_query_args);
$habitlab_featured_post = $habitlab_featured_query->have_posts()
    ? $habitlab_featured_query->posts[0]
    : null;
$habitlab_featured_post_id = $habitlab_featured_post instanceof WP_Post
    ? (int) $habitlab_featured_post->ID
    : 0;

wp_reset_postdata();

$habitlab_latest_query = new WP_Query([
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 6,
    'post__not_in' => $habitlab_featured_post_id > 0 ? [$habitlab_featured_post_id] : [],
    'ignore_sticky_posts' => 1,
]);

$habitlab_latest_posts = $habitlab_latest_query->posts;
wp_reset_postdata();

$habitlab_guides_query = new WP_Query([
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 4,
    'post__not_in' => $habitlab_featured_post_id > 0 ? [$habitlab_featured_post_id] : [],
    'tag_slug__in' => ['guide', 'framework', 'checklist'],
    'ignore_sticky_posts' => 1,
]);

$habitlab_guide_posts = $habitlab_guides_query->posts;
wp_reset_postdata();

if ($habitlab_guide_posts === []) {
    $habitlab_fallback_guides_query = new WP_Query([
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 4,
        'post__not_in' => $habitlab_featured_post_id > 0 ? [$habitlab_featured_post_id] : [],
        'category_name' => 'habits,discipline,motivation,mindset',
        'ignore_sticky_posts' => 1,
    ]);

    $habitlab_guide_posts = $habitlab_fallback_guides_query->posts;
    wp_reset_postdata();
}

?>
<section id="journal-home" class="journal-home section" aria-labelledby="journal-home-title">
    <div class="container journal-home__inner">
        <div class="journal-home__copy">
            <p class="journal-kicker"><?php esc_html_e('HabitLab Insights', 'habitlab'); ?></p>
            <h1 id="journal-home-title" class="journal-home__title"><?php esc_html_e('Build Better Habits, One Day at a Time', 'habitlab'); ?></h1>
            <p class="journal-home__lead"><?php esc_html_e('Practical articles on discipline, motivation, and behavior change for real daily consistency.', 'habitlab'); ?></p>
            <div class="journal-home__actions">
                <a class="btn btn-primary" href="#journal-latest"><?php esc_html_e('Start Reading', 'habitlab'); ?></a>
                <a class="btn btn-ghost" href="<?php echo esc_url($habitlab_blog_url); ?>"><?php esc_html_e('View All Articles', 'habitlab'); ?></a>
            </div>
        </div>
        <aside class="journal-home__panel" aria-label="<?php esc_attr_e('What you will learn', 'habitlab'); ?>">
            <h2><?php esc_html_e('What You Will Find', 'habitlab'); ?></h2>
            <ul>
                <li><?php esc_html_e('Step-by-step guides for building sustainable habits.', 'habitlab'); ?></li>
                <li><?php esc_html_e('Simple frameworks to stay disciplined during busy weeks.', 'habitlab'); ?></li>
                <li><?php esc_html_e('Evidence-based ideas on focus, mindset, and recovery.', 'habitlab'); ?></li>
            </ul>
        </aside>
    </div>
</section>

<?php if ($habitlab_featured_post instanceof WP_Post) : ?>
    <?php
    $habitlab_featured_id = (int) $habitlab_featured_post->ID;
    $habitlab_featured_permalink = get_permalink($habitlab_featured_id);
    $habitlab_featured_excerpt = get_the_excerpt($habitlab_featured_id);
    $habitlab_featured_read_time = function_exists('habitlab_get_post_read_time')
        ? habitlab_get_post_read_time($habitlab_featured_id)
        : 1;
    ?>
    <section class="journal-featured section" aria-labelledby="journal-featured-title">
        <div class="container">
            <header class="journal-section-head">
                <p class="journal-kicker"><?php esc_html_e('Featured', 'habitlab'); ?></p>
                <h2 id="journal-featured-title"><?php esc_html_e('Start With This', 'habitlab'); ?></h2>
            </header>

            <article class="journal-featured__card card card--hover">
                <a class="journal-featured__media" href="<?php echo esc_url((string) $habitlab_featured_permalink); ?>">
                    <?php if (has_post_thumbnail($habitlab_featured_id)) : ?>
                        <?php
                        echo get_the_post_thumbnail(
                            $habitlab_featured_id,
                            'habitlab-article-featured',
                            [
                                'loading' => 'lazy',
                                'decoding' => 'async',
                            ]
                        );
                        ?>
                    <?php else : ?>
                        <span class="journal-thumb-fallback"><?php esc_html_e('Featured Article', 'habitlab'); ?></span>
                    <?php endif; ?>
                </a>
                <div class="journal-featured__content">
                    <p class="journal-featured__meta">
                        <span><?php echo esc_html(function_exists('habitlab_get_primary_category_label') ? habitlab_get_primary_category_label($habitlab_featured_id) : __('Article', 'habitlab')); ?></span>
                        <span>&middot;</span>
                        <span><?php echo esc_html(sprintf(__('%d min read', 'habitlab'), $habitlab_featured_read_time)); ?></span>
                        <span>&middot;</span>
                        <span><?php echo esc_html(get_the_date('M j, Y', $habitlab_featured_id)); ?></span>
                    </p>
                    <h3><a href="<?php echo esc_url((string) $habitlab_featured_permalink); ?>"><?php echo esc_html(get_the_title($habitlab_featured_id)); ?></a></h3>
                    <p><?php echo esc_html(wp_trim_words((string) $habitlab_featured_excerpt, 34)); ?></p>
                    <a class="btn btn-primary" href="<?php echo esc_url((string) $habitlab_featured_permalink); ?>"><?php esc_html_e('Read Article', 'habitlab'); ?></a>
                </div>
            </article>
        </div>
    </section>
<?php endif; ?>

<?php if (is_array($habitlab_topic_categories) && $habitlab_topic_categories !== []) : ?>
    <section class="journal-topics section" aria-labelledby="journal-topics-title">
        <div class="container">
            <header class="journal-section-head">
                <p class="journal-kicker"><?php esc_html_e('Topics', 'habitlab'); ?></p>
                <h2 id="journal-topics-title"><?php esc_html_e('Explore By Category', 'habitlab'); ?></h2>
            </header>

            <div class="journal-topics__grid">
                <?php foreach ($habitlab_topic_categories as $habitlab_index => $habitlab_term) : ?>
                    <?php
                    if (! ($habitlab_term instanceof WP_Term)) {
                        continue;
                    }

                    $habitlab_term_link = get_term_link($habitlab_term);

                    if (is_wp_error($habitlab_term_link)) {
                        continue;
                    }

                    $habitlab_accent_class = 'journal-topic-card--' . (($habitlab_index % 6) + 1);
                    ?>
                    <a class="journal-topic-card card card--hover <?php echo esc_attr($habitlab_accent_class); ?>" href="<?php echo esc_url((string) $habitlab_term_link); ?>">
                        <span class="journal-topic-card__name"><?php echo esc_html($habitlab_term->name); ?></span>
                        <span class="journal-topic-card__count">
                            <?php
                            printf(
                                esc_html(_n('%d article', '%d articles', (int) $habitlab_term->count, 'habitlab')),
                                (int) $habitlab_term->count
                            );
                            ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<section id="journal-latest" class="journal-latest section" aria-labelledby="journal-latest-title">
    <div class="container">
        <header class="journal-section-head">
            <p class="journal-kicker"><?php esc_html_e('Latest Articles', 'habitlab'); ?></p>
            <h2 id="journal-latest-title"><?php esc_html_e('Fresh Insights For Better Consistency', 'habitlab'); ?></h2>
        </header>

        <?php if (is_array($habitlab_latest_posts) && $habitlab_latest_posts !== []) : ?>
            <div class="journal-post-grid">
                <?php foreach ($habitlab_latest_posts as $habitlab_post) : ?>
                    <?php
                    if (! ($habitlab_post instanceof WP_Post)) {
                        continue;
                    }

                    $habitlab_post_id = (int) $habitlab_post->ID;
                    $habitlab_permalink = get_permalink($habitlab_post_id);
                    ?>
                    <article class="journal-post-card card card--hover">
                        <a class="journal-post-card__media" href="<?php echo esc_url((string) $habitlab_permalink); ?>">
                            <?php if (has_post_thumbnail($habitlab_post_id)) : ?>
                                <?php
                                echo get_the_post_thumbnail(
                                    $habitlab_post_id,
                                    'habitlab-article-card',
                                    [
                                        'loading' => 'lazy',
                                        'decoding' => 'async',
                                    ]
                                );
                                ?>
                            <?php else : ?>
                                <span class="journal-thumb-fallback"><?php esc_html_e('HabitLab', 'habitlab'); ?></span>
                            <?php endif; ?>
                        </a>
                        <div class="journal-post-card__body">
                            <p class="journal-post-card__meta">
                                <span><?php echo esc_html(function_exists('habitlab_get_primary_category_label') ? habitlab_get_primary_category_label($habitlab_post_id) : __('Article', 'habitlab')); ?></span>
                                <span>&middot;</span>
                                <span><?php echo esc_html(sprintf(__('%d min read', 'habitlab'), function_exists('habitlab_get_post_read_time') ? habitlab_get_post_read_time($habitlab_post_id) : 1)); ?></span>
                            </p>
                            <h3><a href="<?php echo esc_url((string) $habitlab_permalink); ?>"><?php echo esc_html(get_the_title($habitlab_post_id)); ?></a></h3>
                            <p><?php echo esc_html(wp_trim_words((string) get_the_excerpt($habitlab_post_id), 20)); ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p class="journal-empty"><?php esc_html_e('No articles published yet. Add your first post to start the journal.', 'habitlab'); ?></p>
        <?php endif; ?>
    </div>
</section>

<?php if (is_array($habitlab_guide_posts) && $habitlab_guide_posts !== []) : ?>
    <section class="journal-guides section" aria-labelledby="journal-guides-title">
        <div class="container">
            <header class="journal-section-head">
                <p class="journal-kicker"><?php esc_html_e('Practical Guides', 'habitlab'); ?></p>
                <h2 id="journal-guides-title"><?php esc_html_e('Actionable Frameworks You Can Use Today', 'habitlab'); ?></h2>
            </header>

            <div class="journal-guides__grid">
                <?php foreach ($habitlab_guide_posts as $habitlab_post) : ?>
                    <?php
                    if (! ($habitlab_post instanceof WP_Post)) {
                        continue;
                    }

                    $habitlab_post_id = (int) $habitlab_post->ID;
                    $habitlab_permalink = get_permalink($habitlab_post_id);
                    ?>
                    <article class="journal-guide-card card card--hover">
                        <p class="journal-guide-card__meta"><?php echo esc_html(function_exists('habitlab_get_primary_category_label') ? habitlab_get_primary_category_label($habitlab_post_id) : __('Article', 'habitlab')); ?></p>
                        <h3><a href="<?php echo esc_url((string) $habitlab_permalink); ?>"><?php echo esc_html(get_the_title($habitlab_post_id)); ?></a></h3>
                        <p><?php echo esc_html(wp_trim_words((string) get_the_excerpt($habitlab_post_id), 18)); ?></p>
                        <a class="journal-guide-card__link" href="<?php echo esc_url((string) $habitlab_permalink); ?>">
                            <?php esc_html_e('Read Guide', 'habitlab'); ?>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<section class="journal-cta section" aria-labelledby="journal-cta-title">
    <div class="container">
        <div class="journal-cta__card card">
            <p class="journal-kicker"><?php esc_html_e('Start Your Lab', 'habitlab'); ?></p>
            <h2 id="journal-cta-title"><?php esc_html_e('Turn Insight Into Daily Practice', 'habitlab'); ?></h2>
            <p><?php esc_html_e('Join HabitLab to build your stack, track check-ins, and turn these ideas into real momentum.', 'habitlab'); ?></p>
            <a class="btn btn-primary" href="<?php echo esc_url($habitlab_join_url); ?>"><?php esc_html_e('Join HabitLab', 'habitlab'); ?></a>
        </div>
    </div>
</section>
