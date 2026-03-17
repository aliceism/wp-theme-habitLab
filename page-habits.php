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
            <?php echo do_shortcode('[habit_tracker_habits_stack]'); ?>
            <?php echo do_shortcode('[habit_tracker_habits_shared]'); ?>
        </div>

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
