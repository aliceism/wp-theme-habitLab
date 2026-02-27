<?php
if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>
<?php get_template_part('template-parts/front-page/hero'); ?>
<?php get_template_part('template-parts/front-page/philosophy'); ?>
<?php get_template_part('template-parts/front-page/system'); ?>
<?php get_template_part('template-parts/front-page/cta'); ?>
<?php
get_footer();
