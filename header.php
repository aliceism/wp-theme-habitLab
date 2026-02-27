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
    <div class="container">
        <a class="site-brand" href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>

        <nav class="site-nav" aria-label="<?php esc_attr_e('Primary menu', 'habitlab'); ?>">
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
