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
$habitlab_excerpt = wp_trim_words((string) get_the_excerpt($habitlab_post_id), 24);
?>
<article <?php post_class('card card-post card--hover'); ?>>
    <a class="card-post__media" href="<?php the_permalink(); ?>">
        <?php if (has_post_thumbnail($habitlab_post_id)) : ?>
            <?php
            echo get_the_post_thumbnail(
                $habitlab_post_id,
                'habitlab-article-card',
                [
                    'class' => 'card-post__image',
                    'loading' => 'lazy',
                    'decoding' => 'async',
                ]
            );
            ?>
        <?php else : ?>
            <span class="card-post__fallback"><?php esc_html_e('HabitLab', 'habitlab'); ?></span>
        <?php endif; ?>
    </a>

    <div class="card-post__body">
        <p class="card-post__meta">
            <?php if ($habitlab_category_link !== '') : ?>
                <a href="<?php echo esc_url($habitlab_category_link); ?>"><?php echo esc_html($habitlab_category_label); ?></a>
            <?php else : ?>
                <span><?php echo esc_html($habitlab_category_label); ?></span>
            <?php endif; ?>
            <span>&middot;</span>
            <span><?php echo esc_html(sprintf(__('%d min read', 'habitlab'), $habitlab_read_time)); ?></span>
            <span>&middot;</span>
            <time datetime="<?php echo esc_attr(get_the_date('c', $habitlab_post_id)); ?>">
                <?php echo esc_html(get_the_date('M j, Y', $habitlab_post_id)); ?>
            </time>
        </p>

        <h2 class="card-post__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <p class="card-post__excerpt"><?php echo esc_html($habitlab_excerpt); ?></p>
    </div>
</article>
