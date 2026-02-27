<?php

if (! defined('ABSPATH')) {
    exit;
}

$habitlab_includes = [
    'inc/setup.php',
    'inc/assets.php',
    'inc/helpers.php',
];

foreach ($habitlab_includes as $habitlab_file) {
    $habitlab_path = get_template_directory() . '/' . $habitlab_file;

    if (file_exists($habitlab_path)) {
        require_once $habitlab_path;
    }
}
