<?php
if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>
<section class="container content-archive">
    <header class="archive-header">
        <h1><?php the_archive_title(); ?></h1>
        <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
    </header>

    <?php if (have_posts()) : ?>
        <div class="post-grid">
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/card', 'post'); ?>
            <?php endwhile; ?>
        </div>
        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p><?php esc_html_e('No posts found.', 'habitlab'); ?></p>
    <?php endif; ?>
</section>
<?php
get_footer();
