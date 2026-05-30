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
        $habitlab_has_habits_shortcode =
            shortcode_exists('habit_tracker_habits');
        ?>
        <?php get_template_part('template-parts/app/shell', 'start'); ?>

        <?php
        get_template_part(
            'template-parts/app/page',
            'header',
            [
                'header_class' => 'habit-tracker-page-header',
                'kicker' => __('Habit Builder', 'habitlab'),
                'title' => get_the_title(),
                'subtitle' => __('Design repeatable actions, remove friction, and keep your daily stack tight.', 'habitlab'),
            ]
        );
        ?>


        <?php if ($habitlab_has_habits_shortcode): ?>
            <?php if (is_user_logged_in()): ?>
                <?php echo do_shortcode('[habit_tracker_habits_notice]'); ?>

                <div class="app-grid">
                    <?php echo do_shortcode('[habit_tracker_habits_stack]'); ?>
                    <?php echo do_shortcode('[habit_tracker_habits_shared]'); ?>
                </div>
            <?php else: ?>
                <?php echo do_shortcode('[habit_tracker_habits]'); ?>
            <?php endif; ?>
        <?php else: ?>
            <article class="card app-card app-card--accent">
                <p class="app-card__eyebrow"><?php esc_html_e('Habits Integration', 'habitlab'); ?></p>
                <h3><?php esc_html_e('Activate Habit Tracker habits shortcodes.', 'habitlab'); ?></h3>
                <p><?php esc_html_e('The habits template is ready. Enable the plugin implementation to render habit stack and habit library.', 'habitlab'); ?>
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
