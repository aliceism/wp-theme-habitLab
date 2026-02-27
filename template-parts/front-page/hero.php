<section class="hero" aria-labelledby="hero-title">
    <div class="container hero-content">
        <h1 id="hero-title" class="hero-title">
            <?php esc_html_e('YOU BECOME', 'habitlab'); ?>
            <span class="gradient-text"><?php esc_html_e('WHAT YOU REPEAT', 'habitlab'); ?></span>
        </h1>
        <p class="hero-subtitle"><?php esc_html_e('Build systems. Build momentum. Build yourself.', 'habitlab'); ?></p>
        <div class="hero-buttons">
            <a class="btn btn-primary" href="<?php echo esc_url(wp_registration_url()); ?>"><?php esc_html_e('START THE EXPERIMENT', 'habitlab'); ?></a>
            <a class="btn btn-ghost" href="<?php echo esc_url(habitlab_get_blog_url()); ?>"><?php esc_html_e('JOIN THE MOVEMENT', 'habitlab'); ?></a>
        </div>
    </div>
    <div class="hero-watermark" aria-hidden="true"><?php esc_html_e('DISCIPLINE', 'habitlab'); ?></div>
</section>
