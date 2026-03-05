<?php
if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('template-parts/app/shell', 'start'); ?>

        <?php
        get_template_part(
            'template-parts/app/page',
            'header',
            [
                'kicker'   => __('Habit Builder', 'habitlab'),
                'title'    => get_the_title(),
                'subtitle' => __('Design repeatable actions, remove friction, and keep your daily stack tight.', 'habitlab'),
            ]
        );
        ?>

        <?php echo do_shortcode('[habit_tracker_habits_notice]'); ?>

        <div class="app-grid">
            <article class="card app-card">
                <?php echo do_shortcode('[habit_tracker_habits_stack]'); ?>
            </article>

            <article class="card app-card">
                <?php echo do_shortcode('[habit_tracker_habits_shared]'); ?>
            </article>
        </div>

        <article class="card app-card app-card--accent">
            <?php echo do_shortcode('[habit_tracker_habits_custom]'); ?>
            <a class="btn btn-ghost" href="<?php echo esc_url(habitlab_get_page_url_by_slug('progress')); ?>"><?php esc_html_e('View Progress', 'habitlab'); ?></a>
        </article>

        <?php get_template_part('template-parts/app/shell', 'end'); ?>
    <?php endwhile; ?>
<?php else : ?>
    <section class="section app-page">
        <div class="container">
            <?php get_template_part('template-parts/content/content', 'none'); ?>
        </div>
    </section>
<?php endif; ?>
<?php
get_footer();
