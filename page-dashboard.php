<?php
if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php
        $habitlab_has_dashboard_shortcodes =
            shortcode_exists('habit_tracker_dashboard');
        ?>
        <?php get_template_part('template-parts/app/shell', 'start'); ?>

        <?php
        get_template_part(
            'template-parts/app/page',
            'header',
            [
                'kicker'   => __('System Overview', 'habitlab'),
                'title'    => get_the_title(),
                'subtitle' => __('Track daily execution by category, keep checks visible, and maintain momentum.', 'habitlab'),
            ]
        );
        ?>

        <?php if ($habitlab_has_dashboard_shortcodes) : ?>
            <?php echo do_shortcode('[habit_tracker_dashboard]'); ?>
        <?php else : ?>
            <article class="card app-card app-card--accent">
                <p class="app-card__eyebrow"><?php esc_html_e('Dashboard Integration', 'habitlab'); ?></p>
                <h3><?php esc_html_e('Activate Habit Tracker dashboard shortcodes.', 'habitlab'); ?></h3>
                <p><?php esc_html_e('The dashboard template is ready. Enable the plugin implementation to render live metrics and category check panels.', 'habitlab'); ?></p>
                <a class="btn btn-ghost" href="<?php echo esc_url(habitlab_get_page_url_by_slug('habits')); ?>"><?php esc_html_e('Open Habits', 'habitlab'); ?></a>
            </article>
        <?php endif; ?>

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
