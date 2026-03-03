<?php
if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php $habitlab_has_content = trim((string) get_post_field('post_content', get_the_ID())) !== ''; ?>
        <?php get_template_part('template-parts/app/shell', 'start'); ?>

        <?php
        get_template_part(
            'template-parts/app/page',
            'header',
            [
                'kicker'   => __('System Overview', 'habitlab'),
                'title'    => get_the_title(),
                'subtitle' => __('See the signals that matter, focus your next move, and keep the system visible.', 'habitlab'),
            ]
        );
        ?>

        <div class="app-section app-metrics-grid" aria-label="<?php esc_attr_e('Dashboard metrics', 'habitlab'); ?>">
            <article class="card app-card app-metric">
                <p class="app-metric__label"><?php esc_html_e('Current Streak', 'habitlab'); ?></p>
                <h2 class="app-metric__value"><?php esc_html_e('07 days', 'habitlab'); ?></h2>
                <p class="app-metric__meta"><?php esc_html_e('A visible rhythm builds trust in the system.', 'habitlab'); ?></p>
            </article>

            <article class="card app-card app-metric">
                <p class="app-metric__label"><?php esc_html_e('Weekly Consistency', 'habitlab'); ?></p>
                <h2 class="app-metric__value"><?php esc_html_e('84%', 'habitlab'); ?></h2>
                <p class="app-metric__meta"><?php esc_html_e('Progress becomes believable when repetition stays high.', 'habitlab'); ?></p>
            </article>

            <article class="card app-card app-metric">
                <p class="app-metric__label"><?php esc_html_e('Active Habits', 'habitlab'); ?></p>
                <h2 class="app-metric__value"><?php esc_html_e('03', 'habitlab'); ?></h2>
                <p class="app-metric__meta"><?php esc_html_e('Keep the stack small enough to sustain daily action.', 'habitlab'); ?></p>
            </article>
        </div>

        <div class="app-grid">
            <article class="card app-card">
                <p class="app-card__eyebrow"><?php esc_html_e('Today', 'habitlab'); ?></p>
                <h3><?php esc_html_e('Keep your system narrow and visible.', 'habitlab'); ?></h3>
                <p><?php esc_html_e('This page is ready for dashboard widgets from the plugin. For now, use it as the branded shell for stats, recent activity, and quick actions.', 'habitlab'); ?></p>
                <ul class="app-list">
                    <li><?php esc_html_e('Top priorities for the day', 'habitlab'); ?></li>
                    <li><?php esc_html_e('Recent check-ins and completed habits', 'habitlab'); ?></li>
                    <li><?php esc_html_e('A quick review prompt before the next session', 'habitlab'); ?></li>
                </ul>
            </article>

            <article class="card app-card app-card--accent">
                <p class="app-card__eyebrow"><?php esc_html_e('Next Integration', 'habitlab'); ?></p>
                <h3><?php esc_html_e('Connect real dashboard data here.', 'habitlab'); ?></h3>
                <p><?php esc_html_e('Drop plugin shortcodes or dynamic blocks into this page content when the data layer is ready. The theme shell is already in place.', 'habitlab'); ?></p>
                <a class="btn btn-ghost" href="<?php echo esc_url(habitlab_get_page_url_by_slug('habits')); ?>"><?php esc_html_e('Open Habits', 'habitlab'); ?></a>
            </article>
        </div>

        <?php if ($habitlab_has_content) : ?>
            <div class="card app-card app-content">
                <?php the_content(); ?>
            </div>
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
