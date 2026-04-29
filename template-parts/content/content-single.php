<?php
if (! defined('ABSPATH')) {
    exit;
}

$habitlab_post_id = (int) get_the_ID();
$habitlab_read_time = function_exists('habitlab_get_post_read_time')
    ? habitlab_get_post_read_time($habitlab_post_id)
    : 1;
$habitlab_category_label = function_exists('habitlab_get_primary_category_label')
    ? habitlab_get_primary_category_label($habitlab_post_id)
    : __('Article', 'habitlab');
$habitlab_category_link = function_exists('habitlab_get_primary_category_link')
    ? habitlab_get_primary_category_link($habitlab_post_id)
    : '';
$habitlab_content = apply_filters('the_content', (string) get_the_content());

$habitlab_related_args = [
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 3,
    'post__not_in' => [$habitlab_post_id],
    'ignore_sticky_posts' => 1,
];

$habitlab_category_ids = wp_get_post_categories($habitlab_post_id, ['fields' => 'ids']);

if (is_array($habitlab_category_ids) && $habitlab_category_ids !== []) {
    $habitlab_related_args['category__in'] = array_map('intval', $habitlab_category_ids);
}

$habitlab_related_query = new WP_Query($habitlab_related_args);
?>
<article <?php post_class('content-entry content-entry-single article-single'); ?>>
    <header class="article-single__header card">
        <p class="article-single__kicker">
            <?php if ($habitlab_category_link !== '') : ?>
                <a href="<?php echo esc_url($habitlab_category_link); ?>"><?php echo esc_html($habitlab_category_label); ?></a>
            <?php else : ?>
                <?php echo esc_html($habitlab_category_label); ?>
            <?php endif; ?>
        </p>
        <h1><?php the_title(); ?></h1>
        <p class="article-single__meta">
            <time datetime="<?php echo esc_attr(get_the_date('c', $habitlab_post_id)); ?>">
                <?php echo esc_html(get_the_date('M j, Y', $habitlab_post_id)); ?>
            </time>
            <span>&middot;</span>
            <span><?php echo esc_html(sprintf(__('%d min read', 'habitlab'), $habitlab_read_time)); ?></span>
            <span>&middot;</span>
            <span>
                <?php
                printf(
                    esc_html__('Updated %s', 'habitlab'),
                    esc_html(get_the_modified_date('M j, Y', $habitlab_post_id))
                );
                ?>
            </span>
        </p>
    </header>

    <?php if (has_post_thumbnail($habitlab_post_id)) : ?>
        <figure class="article-single__hero card">
            <?php
            echo get_the_post_thumbnail(
                $habitlab_post_id,
                'habitlab-article-hero',
                [
                    'class' => 'article-single__hero-image',
                    'loading' => 'eager',
                    'decoding' => 'async',
                    'fetchpriority' => 'high',
                ]
            );
            ?>
        </figure>
    <?php endif; ?>

    <div class="article-single__content card">
        <div class="content-entry__prose">
            <?php echo wp_kses_post($habitlab_content); ?>
        </div>
    </div>

    <?php if ($habitlab_related_query->have_posts()) : ?>
        <section class="article-single__related" aria-labelledby="related-articles-title">
            <header class="article-single__related-head">
                <p class="journal-kicker"><?php esc_html_e('Related', 'habitlab'); ?></p>
                <h2 id="related-articles-title"><?php esc_html_e('Read Next', 'habitlab'); ?></h2>
            </header>
            <div class="content-grid">
                <?php while ($habitlab_related_query->have_posts()) : ?>
                    <?php $habitlab_related_query->the_post(); ?>
                    <?php get_template_part('template-parts/content/content', 'excerpt'); ?>
                <?php endwhile; ?>
            </div>
        </section>
    <?php endif; ?>
</article>
<?php wp_reset_postdata(); ?>
