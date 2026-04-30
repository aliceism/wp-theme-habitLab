<?php
$habitlab_insights_url = function_exists('habitlab_get_page_url_by_slug')
    ? habitlab_get_page_url_by_slug('insights')
    : home_url('/insights');
?>
<section class="hero" aria-labelledby="hero-title">
    <div class="container hero-content">
        <h1 id="hero-title" class="hero-title">
            <?php esc_html_e('YOU BECOME', 'habitlab'); ?>
            <span class="gradient-text"><?php esc_html_e('WHAT YOU REPEAT', 'habitlab'); ?></span>
        </h1>
        <p class="hero-subtitle"><?php esc_html_e('Build systems. Build momentum. Build yourself.', 'habitlab'); ?></p>
        <div class="hero-buttons">
            <a class="btn btn-primary" href="<?php echo esc_url(habitlab_get_page_url_by_slug('join')); ?>"><?php esc_html_e('Start Your HabitLab', 'habitlab'); ?></a>
            <a class="btn btn-ghost" href="<?php echo esc_url($habitlab_insights_url); ?>"><?php esc_html_e('Explore Insights', 'habitlab'); ?></a>
        </div>
    </div>
</section>
