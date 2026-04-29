<?php
if (! defined('ABSPATH')) {
    exit;
}

get_header();

$habitlab_query = new WP_Query([
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'ignore_sticky_posts' => 1,
]);
?>
<section class="section content-wrap content-archive">
    <div class="container">
        <header class="archive-header">
            <h1><?php esc_html_e('Articles', 'habitlab'); ?></h1>
            <div class="archive-description">
                <p><?php esc_html_e('All published insights, guides, and practical habit-building articles.', 'habitlab'); ?></p>
            </div>
        </header>

        <?php if ($habitlab_query->have_posts()) : ?>
            <div class="content-grid">
                <?php while ($habitlab_query->have_posts()) : ?>
                    <?php $habitlab_query->the_post(); ?>
                    <?php get_template_part('template-parts/content/content', 'excerpt'); ?>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <?php get_template_part('template-parts/content/content', 'none'); ?>
        <?php endif; ?>
    </div>
</section>
<?php
wp_reset_postdata();
get_footer();
