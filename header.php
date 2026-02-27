<?php
if (! defined('ABSPATH')) {
    exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
    <div class="container site-header__inner">
        <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php esc_attr_e('HabitLab home', 'habitlab'); ?>">
            <span class="site-logo__base"><?php esc_html_e('HABIT', 'habitlab'); ?></span><span class="site-logo__accent"><?php esc_html_e('LAB', 'habitlab'); ?></span>
        </a>

        <button
            class="nav-toggle"
            type="button"
            data-nav-toggle
            aria-controls="site-navigation"
            aria-expanded="false"
            aria-label="<?php esc_attr_e('Toggle menu', 'habitlab'); ?>"
        >
            <span class="nav-toggle__line"></span>
            <span class="nav-toggle__line"></span>
            <span class="nav-toggle__line"></span>
        </button>

        <div class="site-nav-overlay" data-nav-overlay></div>

        <nav id="site-navigation" class="site-nav" aria-label="<?php esc_attr_e('Primary menu', 'habitlab'); ?>">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'fallback_cb'    => false,
                'menu_class'     => 'menu menu-primary',
            ]);
            ?>
            <ul class="menu menu-auth">
                <?php if (is_user_logged_in()) : ?>
                    <li><a href="<?php echo esc_url(home_url('/dashboard/')); ?>"><?php esc_html_e('Dashboard', 'habitlab'); ?></a></li>
                    <li><a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>"><?php esc_html_e('Logout', 'habitlab'); ?></a></li>
                <?php else : ?>
                    <li><a href="<?php echo esc_url(wp_login_url()); ?>"><?php esc_html_e('Login', 'habitlab'); ?></a></li>
                    <li><a href="<?php echo esc_url(wp_registration_url()); ?>"><?php esc_html_e('Join', 'habitlab'); ?></a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
<main id="primary" class="site-main">
