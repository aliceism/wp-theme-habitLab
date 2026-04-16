<?php
if (! defined('ABSPATH')) {
    exit;
}

$week_chart = isset($week_chart) && is_array($week_chart) ? $week_chart : [];
$month_chart = isset($month_chart) && is_array($month_chart) ? $month_chart : [];
$habit_rows = isset($habit_rows) && is_array($habit_rows) ? $habit_rows : [];
$summary = isset($summary) && is_array($summary) ? $summary : [];
$category_stats = isset($category_stats) && is_array($category_stats) ? $category_stats : [];
$has_active_habits = ! empty($has_active_habits);
$include_root_wrapper = ! empty($include_root_wrapper);
$month_svg_points = isset($month_svg_points) ? (string) $month_svg_points : '';
$category_labels = HabitTracker\Domain\Rules\HabitRules::categoryLabels(true);

$week_rows = isset($week_chart['rows']) && is_array($week_chart['rows']) ? $week_chart['rows'] : [];
$week_max_completed = max(1, (int) ($week_chart['max_completed'] ?? 1));
$month_dates = isset($month_chart['dates']) && is_array($month_chart['dates']) ? $month_chart['dates'] : [];
$month_rows = isset($month_chart['rows']) && is_array($month_chart['rows']) ? $month_chart['rows'] : [];
$month_date_count = count($month_dates);
$month_start_label = $month_date_count > 0 ? wp_date('M j', strtotime((string) $month_dates[0])) : '';
$month_end_label = $month_date_count > 0 ? wp_date('M j', strtotime((string) $month_dates[$month_date_count - 1])) : '';
$month_total_completed = 0;
$month_total_active = 0;

foreach ($month_rows as $month_row) {
    $month_total_completed += (int) ($month_row['completed'] ?? 0);
    $month_total_active += (int) ($month_row['active'] ?? 0);
}
?>
<?php if ($include_root_wrapper) : ?>
<div class="habit-tracker-progress">
<?php endif; ?>

    <div class="habit-tracker-progress-charts">
        <article class="card app-card habit-tracker-progress-card habit-tracker-progress-card--chart">
            <p class="app-card__eyebrow"><?php esc_html_e('Weekly Chart', 'habit-tracker'); ?></p>
            <h3><?php esc_html_e('Completions Per Day', 'habit-tracker'); ?></h3>

            <?php if (! $has_active_habits || $week_rows === []) : ?>
                <p class="habit-tracker-empty-state"><?php esc_html_e('Add active habits to see weekly chart.', 'habit-tracker'); ?></p>
            <?php else : ?>
                <div class="habit-tracker-progress-week-chart" role="img" aria-label="<?php esc_attr_e('Weekly completion chart', 'habit-tracker'); ?>">
                    <?php foreach ($week_rows as $row) : ?>
                        <?php
                        $completed = (int) ($row['completed'] ?? 0);
                        $height = $completed > 0 ? round(($completed / $week_max_completed) * 100, 2) : 0;
                        $day_label = (string) ($row['day_label'] ?? '');
                        $bar_state_class = $completed > 0 ? 'is-filled' : 'is-empty';
                        ?>
                        <div class="habit-tracker-progress-week-col" style="--ht-week-bar-height: <?php echo esc_attr((string) $height); ?>%;">
                            <span class="habit-tracker-progress-week-col__track">
                                <span class="habit-tracker-progress-week-col__bar <?php echo esc_attr($bar_state_class); ?>">
                                    <span class="habit-tracker-progress-week-col__value"><?php echo esc_html((string) $completed); ?></span>
                                </span>
                            </span>
                            <span class="habit-tracker-progress-week-col__label"><?php echo esc_html($day_label); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </article>

        <article class="card app-card habit-tracker-progress-card habit-tracker-progress-card--chart">
            <p class="app-card__eyebrow"><?php esc_html_e('Monthly Chart', 'habit-tracker'); ?></p>
            <h3><?php esc_html_e('Daily Activity Rate', 'habit-tracker'); ?></h3>

            <?php if (! $has_active_habits || $month_date_count === 0 || $month_svg_points === '') : ?>
                <p class="habit-tracker-empty-state"><?php esc_html_e('Add active habits to see monthly trend.', 'habit-tracker'); ?></p>
            <?php else : ?>
                <div class="habit-tracker-progress-trend-chart" role="img" aria-label="<?php esc_attr_e('Monthly activity trend chart', 'habit-tracker'); ?>">
                    <svg viewBox="0 0 100 42" preserveAspectRatio="none" aria-hidden="true">
                        <line x1="0" y1="6" x2="100" y2="6"></line>
                        <line x1="0" y1="18" x2="100" y2="18"></line>
                        <line x1="0" y1="30" x2="100" y2="30"></line>
                        <polyline class="habit-tracker-progress-trend-path habit-tracker-progress-trend-path--month" points="<?php echo esc_attr($month_svg_points); ?>"></polyline>
                    </svg>
                </div>

                <div class="habit-tracker-progress-trend-meta">
                    <span><?php echo esc_html($month_start_label); ?></span>
                    <span>
                        <?php
                        printf(
                            esc_html__('%1$d checks / %2$d slots', 'habit-tracker'),
                            $month_total_completed,
                            $month_total_active
                        );
                        ?>
                    </span>
                    <span><?php echo esc_html($month_end_label); ?></span>
                </div>
            <?php endif; ?>
        </article>

        <article class="card app-card habit-tracker-progress-card habit-tracker-progress-card--chart habit-tracker-progress-card--full">
            <p class="app-card__eyebrow"><?php esc_html_e('Habit Chart', 'habit-tracker'); ?></p>
            <h3><?php esc_html_e('Weekly + Monthly Progress Per Habit', 'habit-tracker'); ?></h3>

            <?php if (! $has_active_habits || $habit_rows === []) : ?>
                <p class="habit-tracker-empty-state"><?php esc_html_e('Add habits to see individual habit chart rows.', 'habit-tracker'); ?></p>
            <?php else : ?>
                <div class="habit-tracker-progress-habit-chart-head" aria-hidden="true">
                    <span><?php esc_html_e('Habit', 'habit-tracker'); ?></span>
                    <span><?php esc_html_e('Weekly', 'habit-tracker'); ?></span>
                    <span><?php esc_html_e('Monthly', 'habit-tracker'); ?></span>
                </div>

                <ul class="habit-tracker-progress-habit-chart">
                    <?php foreach ($habit_rows as $row) : ?>
                        <?php
                        $category_key = sanitize_key((string) ($row['category'] ?? HabitTracker\Domain\Rules\HabitRules::CATEGORY_LIFE));
                        $category_label = (string) ($category_labels[$category_key] ?? ucfirst($category_key));
                        $name = (string) ($row['name'] ?? '');
                        $completed_week = (int) ($row['completed_week'] ?? 0);
                        $target_week = (int) ($row['target_week'] ?? 0);
                        $completed_month = (int) ($row['completed_month'] ?? 0);
                        $target_month = (int) ($row['target_month'] ?? 0);
                        $week_percent = (int) ($row['week_percent'] ?? 0);
                        $month_percent = (int) ($row['month_percent'] ?? 0);
                        ?>
                        <li class="habit-tracker-progress-habit-row habit-tracker-progress-habit-row--<?php echo esc_attr($category_key); ?>">
                            <div class="habit-tracker-progress-habit-row__head">
                                <span class="habit-tracker-progress-habit-row__name"><?php echo esc_html($name); ?></span>
                                <span class="habit-tracker-progress-habit-row__meta"><?php echo esc_html($category_label); ?></span>
                            </div>

                            <div class="habit-tracker-progress-habit-row__line habit-tracker-progress-habit-row__line--week">
                                <span class="habit-tracker-progress-habit-row__line-label"><?php esc_html_e('Week', 'habit-tracker'); ?></span>
                                <span class="habit-tracker-progress-bar">
                                    <span style="width: <?php echo esc_attr((string) $week_percent); ?>%;"></span>
                                </span>
                                <strong>
                                    <?php
                                    printf(
                                        esc_html__('%1$d/%2$d · %3$d%%', 'habit-tracker'),
                                        $completed_week,
                                        $target_week,
                                        $week_percent
                                    );
                                    ?>
                                </strong>
                            </div>

                            <div class="habit-tracker-progress-habit-row__line habit-tracker-progress-habit-row__line--month">
                                <span class="habit-tracker-progress-habit-row__line-label"><?php esc_html_e('Month', 'habit-tracker'); ?></span>
                                <span class="habit-tracker-progress-bar">
                                    <span style="width: <?php echo esc_attr((string) $month_percent); ?>%;"></span>
                                </span>
                                <strong>
                                    <?php
                                    printf(
                                        esc_html__('%1$d/%2$d · %3$d%%', 'habit-tracker'),
                                        $completed_month,
                                        $target_month,
                                        $month_percent
                                    );
                                    ?>
                                </strong>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </article>
    </div>

    <div class="habit-tracker-progress-sections">
        <article class="card app-card habit-tracker-progress-card habit-tracker-progress-card--breakdown">
            <p class="app-card__eyebrow"><?php esc_html_e('Category Breakdown', 'habit-tracker'); ?></p>
            <h3><?php esc_html_e('Weekly + Monthly Signals', 'habit-tracker'); ?></h3>

            <?php if (! $has_active_habits) : ?>
                <p class="habit-tracker-empty-state"><?php esc_html_e('No active habits in your dashboard stack yet.', 'habit-tracker'); ?></p>
            <?php else : ?>
                <ul class="habit-tracker-progress-list">
                    <?php foreach ($category_stats as $stat) : ?>
                        <?php if ((int) ($stat['active_habits'] ?? 0) <= 0) : ?>
                            <?php continue; ?>
                        <?php endif; ?>
                        <?php
                        $key = sanitize_key((string) ($stat['key'] ?? HabitTracker\Domain\Rules\HabitRules::CATEGORY_LIFE));
                        $label = (string) ($stat['label'] ?? '');
                        $active_habits = (int) ($stat['active_habits'] ?? 0);
                        $week_percent = (int) ($stat['week_percent'] ?? 0);
                        $month_percent = (int) ($stat['month_percent'] ?? 0);
                        $completed_week = (int) ($stat['completed_week'] ?? 0);
                        $target_week = (int) ($stat['target_week'] ?? 0);
                        $completed_month = (int) ($stat['completed_month'] ?? 0);
                        $target_month = (int) ($stat['target_month'] ?? 0);
                        $checked_today = (int) ($stat['checked_today'] ?? 0);
                        $today_target = (int) ($stat['today_target'] ?? 0);
                        $consistency_percent = (int) ($stat['consistency_percent'] ?? 0);
                        ?>
                        <li class="habit-tracker-progress-item habit-tracker-progress-item--<?php echo esc_attr($key); ?>">
                            <div class="habit-tracker-progress-item__head">
                                <span class="habit-tracker-progress-item__name"><?php echo esc_html($label); ?></span>
                                <span class="habit-tracker-progress-item__meta">
                                    <?php
                                    printf(
                                        esc_html(_n('%d habit', '%d habits', $active_habits, 'habit-tracker')),
                                        $active_habits
                                    );
                                    ?>
                                </span>
                            </div>

                            <div class="habit-tracker-progress-item__line">
                                <span><?php esc_html_e('Week', 'habit-tracker'); ?></span>
                                <span class="habit-tracker-progress-bar">
                                    <span style="width: <?php echo esc_attr((string) $week_percent); ?>%;"></span>
                                </span>
                                <strong>
                                    <?php
                                    printf(
                                        esc_html__('%1$d/%2$d', 'habit-tracker'),
                                        $completed_week,
                                        $target_week
                                    );
                                    ?>
                                </strong>
                            </div>

                            <div class="habit-tracker-progress-item__line">
                                <span><?php esc_html_e('Month', 'habit-tracker'); ?></span>
                                <span class="habit-tracker-progress-bar">
                                    <span style="width: <?php echo esc_attr((string) $month_percent); ?>%;"></span>
                                </span>
                                <strong>
                                    <?php
                                    printf(
                                        esc_html__('%1$d/%2$d', 'habit-tracker'),
                                        $completed_month,
                                        $target_month
                                    );
                                    ?>
                                </strong>
                            </div>

                            <div class="habit-tracker-progress-item__foot">
                                <span>
                                    <?php
                                    printf(
                                        esc_html__('Today: %1$d/%2$d', 'habit-tracker'),
                                        $checked_today,
                                        $today_target
                                    );
                                    ?>
                                </span>
                                <span>
                                    <?php
                                    printf(
                                        esc_html__('Consistency: %d%%', 'habit-tracker'),
                                        $consistency_percent
                                    );
                                    ?>
                                </span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </article>

        <div class="app-grid habit-tracker-progress-insights-grid">
            <article class="card app-card app-card--accent habit-tracker-progress-card habit-tracker-progress-card--insights">
                <p class="app-card__eyebrow"><?php esc_html_e('Insights', 'habit-tracker'); ?></p>
                <h3><?php esc_html_e('Category-driven review for this month.', 'habit-tracker'); ?></h3>

                <?php if (! $has_active_habits) : ?>
                    <p><?php esc_html_e('Build your stack first, then this page will surface category signals and trend comparisons automatically.', 'habit-tracker'); ?></p>
                <?php else : ?>
                    <ul class="app-list habit-tracker-progress-insights habit-tracker-progress-insights--category">
                        <li>
                            <?php
                            printf(
                                esc_html__('Monthly completion: %1$d/%2$d (%3$d%%)', 'habit-tracker'),
                                (int) ($summary['total_completed_month'] ?? 0),
                                (int) ($summary['total_target_month'] ?? 0),
                                (int) ($summary['total_percent'] ?? 0)
                            );
                            ?>
                        </li>
                        <li>
                            <?php
                            if (is_array($summary['best_category'] ?? null)) {
                                printf(
                                    esc_html__('Best category: %1$s (%2$d%%)', 'habit-tracker'),
                                    esc_html((string) ($summary['best_category']['label'] ?? '')),
                                    (int) ($summary['best_category']['month_percent'] ?? 0)
                                );
                            } else {
                                esc_html_e('Best category: not enough data yet.', 'habit-tracker');
                            }
                            ?>
                        </li>
                        <li>
                            <?php
                            if (is_array($summary['focus_category'] ?? null)) {
                                printf(
                                    esc_html__('Focus category: %1$s (%2$d%%)', 'habit-tracker'),
                                    esc_html((string) ($summary['focus_category']['label'] ?? '')),
                                    (int) ($summary['focus_category']['month_percent'] ?? 0)
                                );
                            } else {
                                esc_html_e('Focus category: not enough data yet.', 'habit-tracker');
                            }
                            ?>
                        </li>
                        <li>
                            <?php
                            if (is_array($summary['longest_streak_category'] ?? null)) {
                                printf(
                                    esc_html__('Longest category streak: %1$s (%2$d days)', 'habit-tracker'),
                                    esc_html((string) ($summary['longest_streak_category']['label'] ?? '')),
                                    (int) ($summary['longest_streak_category']['streak_days'] ?? 0)
                                );
                            } else {
                                esc_html_e('Longest category streak: no active streak yet.', 'habit-tracker');
                            }
                            ?>
                        </li>
                    </ul>
                <?php endif; ?>
            </article>

            <article class="card app-card app-card--accent habit-tracker-progress-card habit-tracker-progress-card--insights">
                <p class="app-card__eyebrow"><?php esc_html_e('Insights', 'habit-tracker'); ?></p>
                <h3><?php esc_html_e('Habit-driven review for this month.', 'habit-tracker'); ?></h3>

                <?php if (! $has_active_habits) : ?>
                    <p><?php esc_html_e('Add habits to unlock individual habit insights and priority signals.', 'habit-tracker'); ?></p>
                <?php else : ?>
                    <ul class="app-list habit-tracker-progress-insights habit-tracker-progress-insights--habit">
                        <li>
                            <?php
                            if (is_array($summary['best_habit'] ?? null)) {
                                printf(
                                    esc_html__('Top habit: %1$s (M %2$d%% · W %3$d%%)', 'habit-tracker'),
                                    esc_html((string) ($summary['best_habit']['name'] ?? '')),
                                    (int) ($summary['best_habit']['month_percent'] ?? 0),
                                    (int) ($summary['best_habit']['week_percent'] ?? 0)
                                );
                            } else {
                                esc_html_e('Top habit: not enough data yet.', 'habit-tracker');
                            }
                            ?>
                        </li>
                        <li>
                            <?php
                            if (is_array($summary['focus_habit'] ?? null)) {
                                printf(
                                    esc_html__('Focus habit: %1$s (M %2$d%% · W %3$d%%)', 'habit-tracker'),
                                    esc_html((string) ($summary['focus_habit']['name'] ?? '')),
                                    (int) ($summary['focus_habit']['month_percent'] ?? 0),
                                    (int) ($summary['focus_habit']['week_percent'] ?? 0)
                                );
                            } else {
                                esc_html_e('Focus habit: not enough data yet.', 'habit-tracker');
                            }
                            ?>
                        </li>
                        <li>
                            <?php
                            if (is_array($summary['weekly_leader_habit'] ?? null)) {
                                printf(
                                    esc_html__('Weekly leader: %1$s (W %2$d%%)', 'habit-tracker'),
                                    esc_html((string) ($summary['weekly_leader_habit']['name'] ?? '')),
                                    (int) ($summary['weekly_leader_habit']['week_percent'] ?? 0)
                                );
                            } else {
                                esc_html_e('Weekly leader: not enough data yet.', 'habit-tracker');
                            }
                            ?>
                        </li>
                    </ul>
                <?php endif; ?>
            </article>
        </div>
    </div>

<?php if ($include_root_wrapper) : ?>
</div>
<?php endif; ?>
