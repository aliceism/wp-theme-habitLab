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
                'kicker'   => __('Growth Signals', 'habitlab'),
                'title'    => get_the_title(),
                'subtitle' => __('Measure what compounds, review the pattern, and make consistency impossible to ignore.', 'habitlab'),
            ]
        );
        ?>

        <div class="app-section app-metrics-grid" aria-label="<?php esc_attr_e('Progress metrics', 'habitlab'); ?>">
            <article class="card app-card app-metric">
                <p class="app-metric__label"><?php esc_html_e('Longest Streak', 'habitlab'); ?></p>
                <h2 class="app-metric__value"><?php esc_html_e('21 days', 'habitlab'); ?></h2>
                <p class="app-metric__meta"><?php esc_html_e('Consistency becomes identity when the streak is visible.', 'habitlab'); ?></p>
            </article>

            <article class="card app-card app-metric">
                <p class="app-metric__label"><?php esc_html_e('Weekly Review', 'habitlab'); ?></p>
                <h2 class="app-metric__value"><?php esc_html_e('Ready', 'habitlab'); ?></h2>
                <p class="app-metric__meta"><?php esc_html_e('Use this block for short reviews, missed patterns, and next adjustments.', 'habitlab'); ?></p>
            </article>

            <article class="card app-card app-metric">
                <p class="app-metric__label"><?php esc_html_e('Completion Rate', 'habitlab'); ?></p>
                <h2 class="app-metric__value"><?php esc_html_e('88%', 'habitlab'); ?></h2>
                <p class="app-metric__meta"><?php esc_html_e('Visible proof keeps the system credible.', 'habitlab'); ?></p>
            </article>
        </div>

        <div class="app-grid">
            <article class="card app-card">
                <p class="app-card__eyebrow"><?php esc_html_e('Review Pattern', 'habitlab'); ?></p>
                <h3><?php esc_html_e('Track what repeats, not what feels impressive once.', 'habitlab'); ?></h3>
                <ul class="app-list">
                    <li><?php esc_html_e('Daily completion trends', 'habitlab'); ?></li>
                    <li><?php esc_html_e('Weekly consistency snapshots', 'habitlab'); ?></li>
                    <li><?php esc_html_e('Monthly pattern review prompts', 'habitlab'); ?></li>
                </ul>
            </article>

            <article class="card app-card app-card--accent">
                <p class="app-card__eyebrow"><?php esc_html_e('Proof Layer', 'habitlab'); ?></p>
                <h3><?php esc_html_e('This is the reporting shell for the plugin.', 'habitlab'); ?></h3>
                <p><?php esc_html_e('Charts, streak records, review modules, and completion summaries can plug into this page without changing the theme layout.', 'habitlab'); ?></p>
                <a class="btn btn-ghost" href="<?php echo esc_url(habitlab_get_page_url_by_slug('dashboard')); ?>"><?php esc_html_e('Back to Dashboard', 'habitlab'); ?></a>
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
