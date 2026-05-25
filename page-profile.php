<?php
/**
 * Template Name: Profile Page
 * Template Post Type: page
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php
        $habitlab_has_profile_shortcode =
            shortcode_exists('habit_tracker_profile');
        ?>
        <?php get_template_part('template-parts/app/shell', 'start'); ?>

        <?php
        get_template_part(
            'template-parts/app/page',
            'header',
            [
                'header_class' => 'habit-tracker-page-header',
                'kicker'   => __('Account', 'habitlab'),
                'title'    => get_the_title(),
                'subtitle' => __('Manage your identity, account details, and security settings in one place.', 'habitlab'),
            ]
        );
        ?>

        <?php if ($habitlab_has_profile_shortcode) : ?>
            <?php echo do_shortcode('[habit_tracker_profile]'); ?>
        <?php else : ?>
            <article class="card app-card app-card--accent">
                <p class="app-card__eyebrow"><?php esc_html_e('Profile Integration', 'habitlab'); ?></p>
                <h3><?php esc_html_e('Activate Habit Tracker profile shortcode.', 'habitlab'); ?></h3>
                <p><?php esc_html_e('The profile template is ready. Enable the plugin implementation to render account and security settings.', 'habitlab'); ?></p>
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
