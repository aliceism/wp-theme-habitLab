<?php
if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>
<?php get_template_part('template-parts/hero'); ?>
<?php get_template_part('template-parts/section', 'philosophy'); ?>
<?php get_template_part('template-parts/section', 'system'); ?>
<?php get_template_part('template-parts/section', 'dashboard-preview'); ?>
<?php get_template_part('template-parts/section', 'cta'); ?>
<?php
get_footer();
