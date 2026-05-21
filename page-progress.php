<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<?php if (have_posts()): ?>
    <?php while (have_posts()):
        the_post(); ?>
        <?php
        $habitlab_has_progress_shortcode =
            shortcode_exists('habit_tracker_progress');
        ?>
        <?php get_template_part('template-parts/app/shell', 'start'); ?>

        <?php
        get_template_part(
            'template-parts/app/page',
            'header',
            [
                'header_class' => 'habit-tracker-page-header',
                'kicker' => __('Growth Signals', 'habitlab'),
                'title' => get_the_title(),
                'subtitle' => __('Measure what compounds, review the pattern, and make consistency impossible to ignore.', 'habitlab'),
            ]
        );
        ?>

        <?php if ($habitlab_has_progress_shortcode): ?>
            <?php echo do_shortcode('[habit_tracker_progress]'); ?>
        <?php else: ?>
            <article class="card app-card app-card--accent">
                <p class="app-card__eyebrow"><?php esc_html_e('Progress Integration', 'habitlab'); ?></p>
                <h3><?php esc_html_e('Activate Habit Tracker progress shortcodes.', 'habitlab'); ?></h3>
                <p><?php esc_html_e('The progress template is ready. Enable the plugin implementation to render metrics, charts, habit/category breakdown and insights.', 'habitlab'); ?>
                </p>
            </article>
        <?php endif; ?>

        <?php get_template_part('template-parts/app/shell', 'end'); ?>
    <?php endwhile; ?>
<?php else: ?>
    <section class="section app-page">
        <div class="container">
            <?php get_template_part('template-parts/content/content', 'none'); ?>
        </div>
    </section>
<?php endif; ?>
<?php
get_footer();
