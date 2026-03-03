<?php
/**
 * Template Name: Auth Page
 * Template Post Type: page
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>
<section class="section auth-page">
    <div class="container">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php
                $habitlab_auth_slug = (string) get_post_field('post_name', get_the_ID());
                $habitlab_is_join = $habitlab_auth_slug === 'join';
                $habitlab_auth_subtitle = $habitlab_is_join
                    ? __('Join the movement. Build systems that stick.', 'habitlab')
                    : __('Return to the lab.', 'habitlab');
                $habitlab_auth_switch_text = $habitlab_is_join
                    ? __('Already a member?', 'habitlab')
                    : __('New here?', 'habitlab');
                $habitlab_auth_switch_link_text = $habitlab_is_join
                    ? __('Login.', 'habitlab')
                    : __('Join the movement.', 'habitlab');
                $habitlab_auth_switch_url = $habitlab_is_join
                    ? habitlab_get_page_url_by_slug('login')
                    : habitlab_get_page_url_by_slug('join');
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('auth-wrap'); ?>>
                    <header class="auth-header">
                        <p class="auth-kicker"><?php esc_html_e('HabitLab Access', 'habitlab'); ?></p>
                        <h1 class="auth-title"><?php the_title(); ?></h1>
                        <p class="auth-subtitle"><?php echo esc_html($habitlab_auth_subtitle); ?></p>
                    </header>

                    <div class="auth-content">
                        <?php the_content(); ?>
                    </div>

                    <p class="auth-switch">
                        <span><?php echo esc_html($habitlab_auth_switch_text); ?></span>
                        <a href="<?php echo esc_url($habitlab_auth_switch_url); ?>"><?php echo esc_html($habitlab_auth_switch_link_text); ?></a>
                    </p>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <?php get_template_part('template-parts/content/content', 'none'); ?>
        <?php endif; ?>
    </div>
</section>
<?php
get_footer();
