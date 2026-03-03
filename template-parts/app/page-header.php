<?php
if (! defined('ABSPATH')) {
    exit;
}

$habitlab_kicker = isset($args['kicker']) ? (string) $args['kicker'] : '';
$habitlab_title = isset($args['title']) ? (string) $args['title'] : get_the_title();
$habitlab_subtitle = isset($args['subtitle']) ? (string) $args['subtitle'] : '';
?>
<header class="app-page-header">
    <?php if ($habitlab_kicker !== '') : ?>
        <p class="app-page-header__kicker"><?php echo esc_html($habitlab_kicker); ?></p>
    <?php endif; ?>

    <h1 class="app-page-header__title"><?php echo esc_html($habitlab_title); ?></h1>

    <?php if ($habitlab_subtitle !== '') : ?>
        <p class="app-page-header__subtitle"><?php echo esc_html($habitlab_subtitle); ?></p>
    <?php endif; ?>
</header>
