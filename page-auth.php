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
                $habitlab_auth_mode = $habitlab_is_join ? 'register' : 'login';
                $habitlab_dashboard_url = habitlab_get_dashboard_url();
                $habitlab_auth_raw_content = (string) get_post_field('post_content', get_the_ID());
                $habitlab_has_custom_content = trim($habitlab_auth_raw_content) !== '';
                $habitlab_login_url = habitlab_get_page_url_by_slug('login');
                $habitlab_join_url = habitlab_get_page_url_by_slug('join');
                $habitlab_register_action = admin_url('admin-post.php');
                $habitlab_has_login_shortcode = shortcode_exists('habit_tracker_login_form');
                $habitlab_has_register_shortcode = shortcode_exists('habit_tracker_register_form');
                $habitlab_login_form = wp_login_form([
                    'echo'           => false,
                    'redirect'       => $habitlab_dashboard_url,
                    'remember'       => true,
                    'label_username' => __('Email or username', 'habitlab'),
                    'label_password' => __('Password', 'habitlab'),
                    'label_remember' => __('Remember me', 'habitlab'),
                    'label_log_in'   => __('Login', 'habitlab'),
                    'id_form'        => 'habitlab-login-form',
                    'id_username'    => 'habitlab-login-username',
                    'id_password'    => 'habitlab-login-password',
                    'id_remember'    => 'habitlab-login-remember',
                    'id_submit'      => 'habitlab-login-submit',
                ]);
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('auth-wrap auth-wrap--' . $habitlab_auth_mode); ?>>
                    <header class="auth-header">
                        <p class="auth-kicker"><?php esc_html_e('HabitLab Access', 'habitlab'); ?></p>
                        <h1 class="auth-title"><?php the_title(); ?></h1>
                        <p class="auth-subtitle"><?php echo esc_html($habitlab_auth_subtitle); ?></p>
                    </header>

                    <div class="auth-content">
                        <?php if (is_user_logged_in()) : ?>
                            <div class="auth-state auth-state--logged-in">
                                <p><?php esc_html_e('You are already logged in. Continue to your dashboard.', 'habitlab'); ?></p>
                                <a class="btn btn-primary" href="<?php echo esc_url($habitlab_dashboard_url); ?>"><?php esc_html_e('Open Dashboard', 'habitlab'); ?></a>
                            </div>
                        <?php elseif ($habitlab_is_join && $habitlab_has_register_shortcode) : ?>
                            <?php echo do_shortcode('[habit_tracker_register_form]'); ?>
                        <?php elseif (! $habitlab_is_join && $habitlab_has_login_shortcode) : ?>
                            <?php echo do_shortcode('[habit_tracker_login_form]'); ?>
                        <?php elseif ($habitlab_has_custom_content) : ?>
                            <?php echo apply_filters('the_content', $habitlab_auth_raw_content); ?>
                        <?php elseif ($habitlab_is_join) : ?>
                            <?php if ((bool) get_option('users_can_register')) : ?>
                                <form class="habitlab-register-fallback" action="<?php echo esc_url($habitlab_register_action); ?>" method="post">
                                    <input type="hidden" name="action" value="habit_tracker_register_user">
                                    <input type="hidden" name="redirect_to" value="<?php echo esc_attr($habitlab_dashboard_url); ?>">
                                    <?php wp_nonce_field('habit_tracker_register_user'); ?>
                                    <p>
                                        <label for="habitlab-register-email"><?php esc_html_e('Email', 'habitlab'); ?></label>
                                        <input id="habitlab-register-email" name="user_email" type="email" required autocomplete="email">
                                    </p>
                                    <p>
                                        <label for="habitlab-register-password"><?php esc_html_e('Password', 'habitlab'); ?></label>
                                        <input id="habitlab-register-password" name="user_pass" type="password" required autocomplete="new-password">
                                    </p>
                                    <p>
                                        <label for="habitlab-register-password-confirm"><?php esc_html_e('Confirm password', 'habitlab'); ?></label>
                                        <input id="habitlab-register-password-confirm" name="user_pass_confirm" type="password" required autocomplete="new-password">
                                    </p>
                                    <p>
                                        <button type="submit" class="btn btn-primary"><?php esc_html_e('Create account', 'habitlab'); ?></button>
                                    </p>
                                </form>
                            <?php else : ?>
                                <div class="auth-state">
                                    <p><?php esc_html_e('Registration is currently disabled. Use login if you already have an account.', 'habitlab'); ?></p>
                                    <a class="btn btn-primary" href="<?php echo esc_url($habitlab_login_url); ?>"><?php esc_html_e('Go to Login', 'habitlab'); ?></a>
                                </div>
                            <?php endif; ?>
                        <?php else : ?>
                            <?php echo $habitlab_login_form; ?>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <?php get_template_part('template-parts/content/content', 'none'); ?>
        <?php endif; ?>
    </div>
</section>
<?php
get_footer();
