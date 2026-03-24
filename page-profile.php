<?php
/**
 * Template Name: Profile Page
 * Template Post Type: page
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php
        $habitlab_user = wp_get_current_user();
        $habitlab_user_id = get_current_user_id();
        $habitlab_is_logged_in = is_user_logged_in();
        $habitlab_profile_notice = sanitize_key((string) ($_GET['hlp_notice'] ?? ''));
        $habitlab_profile_error = sanitize_key((string) ($_GET['hlp_error'] ?? ''));
        $habitlab_login_url = habitlab_get_page_url_by_slug('login');
        $habitlab_first_name = $habitlab_is_logged_in ? (string) get_user_meta($habitlab_user_id, 'first_name', true) : '';
        $habitlab_last_name = $habitlab_is_logged_in ? (string) get_user_meta($habitlab_user_id, 'last_name', true) : '';
        $habitlab_display_name = $habitlab_is_logged_in ? (string) $habitlab_user->display_name : '';
        $habitlab_email = $habitlab_is_logged_in ? (string) $habitlab_user->user_email : '';
        $habitlab_registered = $habitlab_is_logged_in ? (string) $habitlab_user->user_registered : '';
        $habitlab_registered_label = $habitlab_registered !== ''
            ? wp_date(get_option('date_format'), strtotime($habitlab_registered))
            : '';
        $habitlab_role_key = $habitlab_is_logged_in && is_array($habitlab_user->roles) && isset($habitlab_user->roles[0])
            ? (string) $habitlab_user->roles[0]
            : '';
        $habitlab_roles = wp_roles();
        $habitlab_role_label = $habitlab_role_key !== '' && isset($habitlab_roles->role_names[$habitlab_role_key])
            ? translate_user_role($habitlab_roles->role_names[$habitlab_role_key])
            : __('Member', 'habitlab');
        $habitlab_messages = [
            'profile-updated' => ['type' => 'success', 'text' => __('Profile updated successfully.', 'habitlab')],
            'password-updated' => ['type' => 'success', 'text' => __('Password updated successfully.', 'habitlab')],
            'email-invalid' => ['type' => 'error', 'text' => __('Please enter a valid email address.', 'habitlab')],
            'email-exists' => ['type' => 'error', 'text' => __('This email is already used by another account.', 'habitlab')],
            'profile-save-failed' => ['type' => 'error', 'text' => __('Could not save profile changes. Please try again.', 'habitlab')],
            'password-required' => ['type' => 'error', 'text' => __('All password fields are required.', 'habitlab')],
            'password-mismatch' => ['type' => 'error', 'text' => __('New password and confirmation do not match.', 'habitlab')],
            'password-short' => ['type' => 'error', 'text' => __('New password must be at least 8 characters.', 'habitlab')],
            'password-current-invalid' => ['type' => 'error', 'text' => __('Current password is incorrect.', 'habitlab')],
            'password-update-failed' => ['type' => 'error', 'text' => __('Could not update password. Please try again.', 'habitlab')],
        ];
        $habitlab_feedback_key = $habitlab_profile_notice !== '' ? $habitlab_profile_notice : $habitlab_profile_error;
        $habitlab_feedback = $habitlab_feedback_key !== '' && isset($habitlab_messages[$habitlab_feedback_key])
            ? $habitlab_messages[$habitlab_feedback_key]
            : null;
        ?>
        <?php get_template_part('template-parts/app/shell', 'start'); ?>

        <?php
        get_template_part(
            'template-parts/app/page',
            'header',
            [
                'header_class' => 'habit-tracker-page-header',
                'kicker'   => __('Account', 'habitlab'),
                'title'    => get_the_title(),
                'subtitle' => __('Manage your identity, account details, and security settings in one place.', 'habitlab'),
            ]
        );
        ?>

        <?php if (! $habitlab_is_logged_in) : ?>
            <article class="card habit-tracker-block habit-tracker-block--shared habitlab-profile-card habitlab-profile-card--overview">
                <p class="app-card__eyebrow"><?php esc_html_e('Profile Access', 'habitlab'); ?></p>
                <h3><?php esc_html_e('Log In To Open Your Profile', 'habitlab'); ?></h3>
                <p><?php esc_html_e('You need an account to manage profile and security settings.', 'habitlab'); ?></p>
                <a class="btn btn-primary" href="<?php echo esc_url($habitlab_login_url); ?>"><?php esc_html_e('Login', 'habitlab'); ?></a>
            </article>
        <?php else : ?>
            <?php if (is_array($habitlab_feedback)) : ?>
                <p class="habitlab-profile-alert habitlab-profile-alert--<?php echo esc_attr((string) $habitlab_feedback['type']); ?>">
                    <?php echo esc_html((string) $habitlab_feedback['text']); ?>
                </p>
            <?php endif; ?>

            <div class="habitlab-profile-hybrid" aria-label="<?php esc_attr_e('Profile sections', 'habitlab'); ?>">
                <article class="card habit-tracker-block habitlab-profile-card habitlab-profile-card--overview habitlab-profile-hybrid__overview">
                    <div class="habitlab-profile-card__head">
                        <p class="app-card__eyebrow"><?php esc_html_e('Overview', 'habitlab'); ?></p>
                        <h3><?php esc_html_e('Account Snapshot', 'habitlab'); ?></h3>
                    </div>
                    <dl class="habitlab-profile-summary">
                        <div class="habitlab-profile-summary__row">
                            <dt><?php esc_html_e('Email', 'habitlab'); ?></dt>
                            <dd><?php echo esc_html($habitlab_email); ?></dd>
                        </div>
                        <div class="habitlab-profile-summary__row">
                            <dt><?php esc_html_e('Role', 'habitlab'); ?></dt>
                            <dd><?php echo esc_html($habitlab_role_label); ?></dd>
                        </div>
                        <div class="habitlab-profile-summary__row">
                            <dt><?php esc_html_e('Member since', 'habitlab'); ?></dt>
                            <dd><?php echo esc_html($habitlab_registered_label); ?></dd>
                        </div>
                    </dl>
                </article>

                <div class="habitlab-profile-hybrid__actions">
                    <div class="habitlab-profile-action-group">
                        <p class="habitlab-profile-action-hint"><?php esc_html_e('Update your account details', 'habitlab'); ?></p>
                        <button
                            type="button"
                            class="card habit-tracker-block habitlab-profile-action-btn habitlab-profile-action-btn--details"
                            data-modal-open="habitlab-profile-modal-details"
                            aria-haspopup="dialog"
                        >
                            <h3><?php esc_html_e('Profile', 'habitlab'); ?></h3>
                        </button>
                    </div>

                    <div class="habitlab-profile-action-group">
                        <p class="habitlab-profile-action-hint"><?php esc_html_e('Manage password and account access', 'habitlab'); ?></p>
                        <button
                            type="button"
                            class="card habit-tracker-block habitlab-profile-action-btn habitlab-profile-action-btn--password"
                            data-modal-open="habitlab-profile-modal-password"
                            aria-haspopup="dialog"
                        >
                            <h3><?php esc_html_e('Security', 'habitlab'); ?></h3>
                        </button>
                    </div>
                </div>
            </div>

            <div
                id="habitlab-profile-modal-details"
                class="system-modal habitlab-profile-modal"
                data-modal
                role="dialog"
                aria-modal="true"
                aria-labelledby="habitlab-profile-modal-details-title"
                hidden
            >
                <div class="system-modal__backdrop" data-modal-close></div>
                <div class="system-modal__dialog" role="document" tabindex="-1">
                    <button class="system-modal__close" type="button" data-modal-close>
                        <span aria-hidden="true">&times;</span>
                        <span class="screen-reader-text"><?php esc_html_e('Close', 'habitlab'); ?></span>
                    </button>

                    <p class="system-modal__eyebrow"><?php esc_html_e('Profile', 'habitlab'); ?></p>
                    <h3 id="habitlab-profile-modal-details-title"><?php esc_html_e('Update Account Details', 'habitlab'); ?></h3>

                    <div class="habitlab-profile-modal__body">
                        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="habitlab-profile-form">
                            <input type="hidden" name="action" value="habitlab_update_profile">
                            <input type="hidden" name="redirect_to" value="<?php echo esc_url(habitlab_get_profile_url()); ?>">
                            <?php wp_nonce_field('habitlab_profile_update'); ?>

                            <p>
                                <label for="habitlab-profile-display-name"><?php esc_html_e('Display name', 'habitlab'); ?></label>
                                <input
                                    id="habitlab-profile-display-name"
                                    type="text"
                                    name="display_name"
                                    value="<?php echo esc_attr($habitlab_display_name); ?>"
                                    autocomplete="name"
                                >
                            </p>
                            <p>
                                <label for="habitlab-profile-first-name"><?php esc_html_e('First name', 'habitlab'); ?></label>
                                <input
                                    id="habitlab-profile-first-name"
                                    type="text"
                                    name="first_name"
                                    value="<?php echo esc_attr($habitlab_first_name); ?>"
                                    autocomplete="given-name"
                                >
                            </p>
                            <p>
                                <label for="habitlab-profile-last-name"><?php esc_html_e('Last name', 'habitlab'); ?></label>
                                <input
                                    id="habitlab-profile-last-name"
                                    type="text"
                                    name="last_name"
                                    value="<?php echo esc_attr($habitlab_last_name); ?>"
                                    autocomplete="family-name"
                                >
                            </p>
                            <p>
                                <label for="habitlab-profile-email"><?php esc_html_e('Email', 'habitlab'); ?></label>
                                <input
                                    id="habitlab-profile-email"
                                    type="email"
                                    name="user_email"
                                    value="<?php echo esc_attr($habitlab_email); ?>"
                                    autocomplete="email"
                                    required
                                >
                            </p>
                            <p>
                                <button type="submit" class="btn btn-primary"><?php esc_html_e('Save Profile', 'habitlab'); ?></button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>

            <div
                id="habitlab-profile-modal-password"
                class="system-modal habitlab-profile-modal"
                data-modal
                role="dialog"
                aria-modal="true"
                aria-labelledby="habitlab-profile-modal-password-title"
                hidden
            >
                <div class="system-modal__backdrop" data-modal-close></div>
                <div class="system-modal__dialog" role="document" tabindex="-1">
                    <button class="system-modal__close" type="button" data-modal-close>
                        <span aria-hidden="true">&times;</span>
                        <span class="screen-reader-text"><?php esc_html_e('Close', 'habitlab'); ?></span>
                    </button>

                    <p class="system-modal__eyebrow"><?php esc_html_e('Security', 'habitlab'); ?></p>
                    <h3 id="habitlab-profile-modal-password-title"><?php esc_html_e('Change Password', 'habitlab'); ?></h3>

                    <div class="habitlab-profile-modal__body">
                        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="habitlab-profile-form habitlab-profile-form--password">
                            <input type="hidden" name="action" value="habitlab_update_password">
                            <input type="hidden" name="redirect_to" value="<?php echo esc_url(habitlab_get_profile_url()); ?>">
                            <?php wp_nonce_field('habitlab_profile_password_update'); ?>

                            <p>
                                <label for="habitlab-profile-current-password"><?php esc_html_e('Current password', 'habitlab'); ?></label>
                                <input
                                    id="habitlab-profile-current-password"
                                    type="password"
                                    name="current_password"
                                    autocomplete="current-password"
                                    required
                                >
                            </p>
                            <p>
                                <label for="habitlab-profile-new-password"><?php esc_html_e('New password', 'habitlab'); ?></label>
                                <input
                                    id="habitlab-profile-new-password"
                                    type="password"
                                    name="new_password"
                                    autocomplete="new-password"
                                    required
                                >
                            </p>
                            <p>
                                <label for="habitlab-profile-new-password-confirm"><?php esc_html_e('Confirm new password', 'habitlab'); ?></label>
                                <input
                                    id="habitlab-profile-new-password-confirm"
                                    type="password"
                                    name="new_password_confirm"
                                    autocomplete="new-password"
                                    required
                                >
                            </p>
                            <p>
                                <button type="submit" class="btn btn-primary"><?php esc_html_e('Update Password', 'habitlab'); ?></button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php get_template_part('template-parts/app/shell', 'end'); ?>
    <?php endwhile; ?>
<?php else : ?>
    <section class="section app-page">
        <div class="container">
            <?php get_template_part('template-parts/content/content', 'none'); ?>
        </div>
    </section>
<?php endif; ?>
<?php
get_footer();
