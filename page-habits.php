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
                'kicker'   => __('Habit Builder', 'habitlab'),
                'title'    => get_the_title(),
                'subtitle' => __('Design repeatable actions, remove friction, and keep your daily stack tight.', 'habitlab'),
            ]
        );
        ?>

        <div class="app-grid">
            <article class="card app-card">
                <p class="app-card__eyebrow"><?php esc_html_e('Current Stack', 'habitlab'); ?></p>
                <h3><?php esc_html_e('Build habits you can actually repeat.', 'habitlab'); ?></h3>
                <p><?php esc_html_e('This section is prepared for a dynamic habits list from the plugin. Keep the structure visible even before the data wiring is complete.', 'habitlab'); ?></p>
                <ul class="app-list">
                    <li><?php esc_html_e('One identity-based habit', 'habitlab'); ?></li>
                    <li><?php esc_html_e('One execution habit', 'habitlab'); ?></li>
                    <li><?php esc_html_e('One reset habit', 'habitlab'); ?></li>
                </ul>
            </article>

            <article class="card app-card">
                <p class="app-card__eyebrow"><?php esc_html_e('Design Rules', 'habitlab'); ?></p>
                <h3><?php esc_html_e('Lower friction before you ask for discipline.', 'habitlab'); ?></h3>
                <p><?php esc_html_e('The right habits page should make behavior obvious: what to do, when to do it, and how to mark it complete.', 'habitlab'); ?></p>
                <ul class="app-list">
                    <li><?php esc_html_e('Keep actions small enough to start immediately', 'habitlab'); ?></li>
                    <li><?php esc_html_e('Attach habits to clear cues and times', 'habitlab'); ?></li>
                    <li><?php esc_html_e('Track completion without extra mental load', 'habitlab'); ?></li>
                </ul>
            </article>
        </div>

        <article class="card app-card app-card--accent">
            <p class="app-card__eyebrow"><?php esc_html_e('Later Integration', 'habitlab'); ?></p>
            <h3><?php esc_html_e('This page is ready for habit CRUD flows.', 'habitlab'); ?></h3>
            <p><?php esc_html_e('When the plugin exposes create, edit, archive, and completion controls, they can land here without changing the theme structure.', 'habitlab'); ?></p>
            <a class="btn btn-ghost" href="<?php echo esc_url(habitlab_get_page_url_by_slug('progress')); ?>"><?php esc_html_e('View Progress', 'habitlab'); ?></a>
        </article>

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
