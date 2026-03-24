<?php

if (! defined('ABSPATH')) {
    exit;
}

function habitlab_profile_resolve_redirect_target(): string
{
    $redirect = esc_url_raw(wp_unslash($_POST['redirect_to'] ?? ''));

    if (is_string($redirect) && $redirect !== '') {
        return $redirect;
    }

    return habitlab_get_profile_url();
}

function habitlab_profile_redirect_with_state(string $type, string $state, ?string $target = null): void
{
    $target_url = $target;

    if (! is_string($target_url) || $target_url === '') {
        $target_url = habitlab_profile_resolve_redirect_target();
    }

    $query_key = $type === 'error' ? 'hlp_error' : 'hlp_notice';
    $redirect_url = add_query_arg($query_key, sanitize_key($state), $target_url);

    wp_safe_redirect($redirect_url);
    exit;
}

function habitlab_profile_require_auth(): int
{
    if (is_user_logged_in()) {
        return get_current_user_id();
    }

    $redirect = habitlab_profile_resolve_redirect_target();
    wp_safe_redirect(wp_login_url($redirect));
    exit;
}

function habitlab_handle_profile_update(): void
{
    $user_id = habitlab_profile_require_auth();

    check_admin_referer('habitlab_profile_update');

    $display_name = sanitize_text_field(wp_unslash($_POST['display_name'] ?? ''));
    $first_name = sanitize_text_field(wp_unslash($_POST['first_name'] ?? ''));
    $last_name = sanitize_text_field(wp_unslash($_POST['last_name'] ?? ''));
    $user_email = sanitize_email(wp_unslash($_POST['user_email'] ?? ''));

    if ($user_email === '' || ! is_email($user_email)) {
        habitlab_profile_redirect_with_state('error', 'email-invalid');
    }

    $email_owner = email_exists($user_email);

    if (is_int($email_owner) && $email_owner > 0 && $email_owner !== $user_id) {
        habitlab_profile_redirect_with_state('error', 'email-exists');
    }

    $user_update = [
        'ID' => $user_id,
        'user_email' => $user_email,
        'display_name' => $display_name !== '' ? $display_name : $user_email,
    ];

    $updated = wp_update_user($user_update);

    if (is_wp_error($updated)) {
        habitlab_profile_redirect_with_state('error', 'profile-save-failed');
    }

    update_user_meta($user_id, 'first_name', $first_name);
    update_user_meta($user_id, 'last_name', $last_name);

    habitlab_profile_redirect_with_state('notice', 'profile-updated');
}
add_action('admin_post_habitlab_update_profile', 'habitlab_handle_profile_update');

function habitlab_handle_profile_password_update(): void
{
    $user_id = habitlab_profile_require_auth();

    check_admin_referer('habitlab_profile_password_update');

    $current_password = (string) wp_unslash($_POST['current_password'] ?? '');
    $new_password = (string) wp_unslash($_POST['new_password'] ?? '');
    $new_password_confirm = (string) wp_unslash($_POST['new_password_confirm'] ?? '');

    if ($current_password === '' || $new_password === '' || $new_password_confirm === '') {
        habitlab_profile_redirect_with_state('error', 'password-required');
    }

    if ($new_password !== $new_password_confirm) {
        habitlab_profile_redirect_with_state('error', 'password-mismatch');
    }

    if (strlen($new_password) < 8) {
        habitlab_profile_redirect_with_state('error', 'password-short');
    }

    $user = get_user_by('id', $user_id);

    if (! ($user instanceof WP_User)) {
        habitlab_profile_redirect_with_state('error', 'password-update-failed');
    }

    if (! wp_check_password($current_password, $user->user_pass, $user_id)) {
        habitlab_profile_redirect_with_state('error', 'password-current-invalid');
    }

    wp_set_password($new_password, $user_id);

    $fresh_user = get_user_by('id', $user_id);

    if ($fresh_user instanceof WP_User) {
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id, true);
        do_action('wp_login', $fresh_user->user_login, $fresh_user);
    }

    habitlab_profile_redirect_with_state('notice', 'password-updated');
}
add_action('admin_post_habitlab_update_password', 'habitlab_handle_profile_password_update');

function habitlab_handle_profile_unauthorized(): void
{
    $redirect = habitlab_profile_resolve_redirect_target();
    wp_safe_redirect(wp_login_url($redirect));
    exit;
}
add_action('admin_post_nopriv_habitlab_update_profile', 'habitlab_handle_profile_unauthorized');
add_action('admin_post_nopriv_habitlab_update_password', 'habitlab_handle_profile_unauthorized');
