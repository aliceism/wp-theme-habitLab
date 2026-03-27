<?php
if (! defined('ABSPATH')) {
    exit;
}

$items = isset($items) && is_array($items) ? $items : [];
$redirect = isset($redirect_url) && is_string($redirect_url) && $redirect_url !== ''
    ? $redirect_url
    : home_url('/');
$admin_post_url = isset($admin_post_url) && is_string($admin_post_url) && $admin_post_url !== ''
    ? $admin_post_url
    : admin_url('admin-post.php');
$remove_action = isset($remove_action) && is_string($remove_action) && $remove_action !== ''
    ? $remove_action
    : 'habit_tracker_remove_user_habit';
?>
<article class="card app-card habit-tracker-block habit-tracker-block--stack">
    <div class="habit-tracker-block__header">
        <p class="app-card__eyebrow"><?php esc_html_e('Dashboard Stack', 'habit-tracker'); ?></p>
        <h3><?php esc_html_e('Your Active Habits', 'habit-tracker'); ?></h3>
    </div>

    <?php if ($items === []) : ?>
        <p class="habit-tracker-empty-state"><?php esc_html_e('No habits in your dashboard yet. Add one from the shared list or create a custom habit.', 'habit-tracker'); ?></p>
    <?php else : ?>
        <ul class="habit-tracker-habits__stack">
            <?php foreach ($items as $item) : ?>
                <?php
                $stack_item_id = isset($item['id']) ? (int) $item['id'] : 0;
                $category_class = sanitize_key((string) ($item['category_class'] ?? 'life'));
                $habit_name = (string) ($item['name'] ?? '');
                ?>
                <li class="habit-tracker-stack-item habit-tracker-stack-item--<?php echo esc_attr($category_class); ?>">
                    <span class="habit-tracker-stack-item__name"><?php echo esc_html($habit_name); ?></span>

                    <?php if ($stack_item_id > 0) : ?>
                        <div class="habit-tracker-stack-item__controls">
                            <form class="habit-tracker-inline-form" method="post" action="<?php echo esc_url($admin_post_url); ?>">
                                <input type="hidden" name="action" value="<?php echo esc_attr($remove_action); ?>">
                                <input type="hidden" name="user_habit_id" value="<?php echo esc_attr((string) $stack_item_id); ?>">
                                <input type="hidden" name="redirect_to" value="<?php echo esc_url($redirect); ?>">
                                <?php wp_nonce_field($remove_action); ?>
                                <button
                                    type="submit"
                                    class="habit-tracker-stack-item__remove"
                                    aria-label="<?php esc_attr_e('Remove from dashboard stack', 'habit-tracker'); ?>"
                                    title="<?php esc_attr_e('Remove from dashboard stack', 'habit-tracker'); ?>"
                                >
                                    <span class="habit-tracker-stack-item__remove-glyph" aria-hidden="true"></span>
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</article>
