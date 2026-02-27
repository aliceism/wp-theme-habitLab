<?php
if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>
<section class="section content-wrap content-reading">
    <div class="container">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/content/content', 'page'); ?>
            <?php endwhile; ?>
        <?php else : ?>
            <?php get_template_part('template-parts/content/content', 'none'); ?>
        <?php endif; ?>
    </div>
</section>
<?php
get_footer();
