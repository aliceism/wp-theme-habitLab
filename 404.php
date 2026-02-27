<?php
if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>
<section class="container error-404">
    <h1><?php esc_html_e('Page not found', 'habitlab'); ?></h1>
    <p><?php esc_html_e('The page you are looking for does not exist.', 'habitlab'); ?></p>
    <p><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Back to home', 'habitlab'); ?></a></p>
</section>
<?php
get_footer();
