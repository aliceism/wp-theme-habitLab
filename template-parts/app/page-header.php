<?php
if (! defined('ABSPATH')) {
    exit;
}

$habitlab_kicker = isset($args['kicker']) ? (string) $args['kicker'] : '';
$habitlab_title = isset($args['title']) ? (string) $args['title'] : get_the_title();
$habitlab_subtitle = isset($args['subtitle']) ? (string) $args['subtitle'] : '';
$habitlab_header_classes = ['app-page-header'];

if (isset($args['header_class']) && is_string($args['header_class'])) {
    $habitlab_extra_header_classes = preg_split('/\s+/', trim($args['header_class']));

    if (is_array($habitlab_extra_header_classes)) {
        foreach ($habitlab_extra_header_classes as $habitlab_extra_header_class) {
            $habitlab_extra_header_class = sanitize_html_class((string) $habitlab_extra_header_class);

            if ($habitlab_extra_header_class === '') {
                continue;
            }

            $habitlab_header_classes[] = $habitlab_extra_header_class;
        }
    }
}
?>
<header class="<?php echo esc_attr(implode(' ', array_unique($habitlab_header_classes))); ?>">
    <?php if ($habitlab_kicker !== '') : ?>
        <p class="app-page-header__kicker"><?php echo esc_html($habitlab_kicker); ?></p>
    <?php endif; ?>

    <h1 class="app-page-header__title"><?php echo esc_html($habitlab_title); ?></h1>

    <?php if ($habitlab_subtitle !== '') : ?>
        <p class="app-page-header__subtitle"><?php echo esc_html($habitlab_subtitle); ?></p>
    <?php endif; ?>
</header>
