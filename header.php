<?php
if (! defined('ABSPATH')) {
    exit;
}

$habitlab_current_path = untrailingslashit(wp_parse_url(home_url(add_query_arg([])), PHP_URL_PATH) ?: '/');
$habitlab_user = wp_get_current_user();
$habitlab_is_logged_in = is_user_logged_in();
$habitlab_profile_url = $habitlab_is_logged_in ? get_edit_user_link() : '';

if (! is_string($habitlab_profile_url) || $habitlab_profile_url === '') {
    $habitlab_profile_url = home_url('/profile');
}

$habitlab_display_name = $habitlab_is_logged_in ? trim((string) $habitlab_user->display_name) : '';
$habitlab_fallback_name = $habitlab_is_logged_in ? trim((string) $habitlab_user->user_login) : '';
$habitlab_label_name = $habitlab_display_name !== '' ? $habitlab_display_name : $habitlab_fallback_name;
$habitlab_initials = 'HL';

if ($habitlab_label_name !== '') {
    $habitlab_name_parts = preg_split('/\s+/', $habitlab_label_name);
    $habitlab_initials = '';

    if (is_array($habitlab_name_parts)) {
        foreach (array_slice($habitlab_name_parts, 0, 2) as $habitlab_name_part) {
            $habitlab_initials .= function_exists('mb_substr')
                ? mb_strtoupper(mb_substr($habitlab_name_part, 0, 1))
                : strtoupper(substr($habitlab_name_part, 0, 1));
        }
    }

    if ($habitlab_initials === '') {
        $habitlab_initials = 'HL';
    }
}

$habitlab_app_links = [
    [
        'label'  => __('Dashboard', 'habitlab'),
        'url'    => home_url('/dashboard'),
        'active' => $habitlab_current_path === '/dashboard',
    ],
    [
        'label'  => __('Habits', 'habitlab'),
        'url'    => home_url('/habits'),
        'active' => $habitlab_current_path === '/habits',
    ],
    [
        'label'  => __('Progress', 'habitlab'),
        'url'    => home_url('/progress'),
        'active' => $habitlab_current_path === '/progress',
    ],
];
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
            <?php if ($habitlab_is_logged_in) : ?>
                <div class="app-nav-wrap">
                    <ul class="menu app-nav" aria-label="<?php esc_attr_e('HabitLab app navigation', 'habitlab'); ?>">
                        <?php foreach ($habitlab_app_links as $habitlab_app_link) : ?>
                            <li class="<?php echo $habitlab_app_link['active'] ? 'is-active' : ''; ?>">
                                <a href="<?php echo esc_url($habitlab_app_link['url']); ?>"><?php echo esc_html($habitlab_app_link['label']); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="user-menu" data-user-menu>
                        <button
                            class="user-menu__toggle"
                            type="button"
                            data-user-menu-toggle
                            aria-expanded="false"
                            aria-controls="user-menu-panel"
                            aria-label="<?php echo esc_attr(sprintf(__('Open account menu for %s', 'habitlab'), $habitlab_label_name)); ?>"
                        >
                            <span class="user-menu__avatar" aria-hidden="true"><?php echo esc_html($habitlab_initials); ?></span>
                        </button>

                        <div id="user-menu-panel" class="user-menu__panel" data-user-menu-panel>
                            <a href="<?php echo esc_url($habitlab_profile_url); ?>"><?php esc_html_e('Profile', 'habitlab'); ?></a>
                            <a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>"><?php esc_html_e('Logout', 'habitlab'); ?></a>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <ul class="menu menu-auth">
                    <li><a href="<?php echo esc_url(wp_login_url()); ?>"><?php esc_html_e('Login', 'habitlab'); ?></a></li>
                    <li><a class="btn btn-primary menu-auth__cta" href="<?php echo esc_url(wp_registration_url()); ?>"><?php esc_html_e('Join', 'habitlab'); ?></a></li>
                </ul>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main id="primary" class="site-main">
