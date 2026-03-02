<?php
$habitlab_system_items = [
    [
        'slug' => 'knowledge',
        'label' => esc_html__('Knowledge', 'habitlab'),
        'card_text' => esc_html__('Learn the principles that make habits stick.', 'habitlab'),
        'title_plain' => esc_html__('Build the right', 'habitlab'),
        'title_accent' => esc_html__('understanding.', 'habitlab'),
        'intro' => [
            esc_html__('Growth starts with clarity.', 'habitlab'),
            esc_html__('Before action, there must be structure.', 'habitlab'),
        ],
        'bullets' => [
            esc_html__('Identity shapes behavior.', 'habitlab'),
            esc_html__('Systems beat motivation.', 'habitlab'),
            esc_html__('Consistency compounds over time.', 'habitlab'),
        ],
        'aside_title' => esc_html__('Start Here', 'habitlab'),
        'aside_intro' => '',
        'aside_items' => [
            esc_html__('What you repeat defines you.', 'habitlab'),
            esc_html__('Small habits create large shifts.', 'habitlab'),
            esc_html__('Discipline is a design choice.', 'habitlab'),
        ],
        'cta' => esc_html__('Learn the principles. Then apply them.', 'habitlab'),
    ],
    [
        'slug' => 'practice',
        'label' => esc_html__('Practice', 'habitlab'),
        'card_text' => esc_html__('Apply small, repeatable actions every day.', 'habitlab'),
        'title_plain' => esc_html__('Turn insight', 'habitlab'),
        'title_accent' => esc_html__('into repetition.', 'habitlab'),
        'intro' => [
            esc_html__('Knowledge without execution is comfort.', 'habitlab'),
            esc_html__('Practice creates identity.', 'habitlab'),
        ],
        'bullets' => [
            esc_html__('Start small.', 'habitlab'),
            esc_html__('Track daily.', 'habitlab'),
            esc_html__('Remove friction.', 'habitlab'),
        ],
        'aside_title' => esc_html__('3 Starter Habits', 'habitlab'),
        'aside_intro' => '',
        'aside_items' => [
            esc_html__('7-8 hours of sleep', 'habitlab'),
            esc_html__('10 minutes of reading', 'habitlab'),
            esc_html__('30 minutes of exercise)', 'habitlab'),
        ],
        'cta' => esc_html__('Action builds momentum.', 'habitlab'),
    ],
    [
        'slug' => 'proof',
        'label' => esc_html__('Proof', 'habitlab'),
        'card_text' => esc_html__('Track wins and build evidence of your new identity.', 'habitlab'),
        'title_plain' => esc_html__('Make', 'habitlab'),
        'title_accent' => esc_html__('growth visible.', 'habitlab'),
        'intro' => [
            esc_html__('If you can’t measure it, you can’t improve it.', 'habitlab'),
            esc_html__('Visibility creates accountability.', 'habitlab'),
        ],
        'bullets' => [
            esc_html__('Track streaks.', 'habitlab'),
            esc_html__('Monitor weekly consistency.', 'habitlab'),
            esc_html__('Review monthly patterns.', 'habitlab'),
        ],
        'aside_title' => esc_html__('What We Measure', 'habitlab'),
        'aside_intro' => '',
        'aside_items' => [
            esc_html__('Consistency Streak', 'habitlab'),
            esc_html__('Weekly Completion Rate', 'habitlab'),
            esc_html__('Active Habits', 'habitlab'),
        ],
        'cta' => esc_html__('Proof turns effort into belief.', 'habitlab'),
    ],
];
?>

<section id="system" class="section section-system" aria-labelledby="system-title">
    <div class="container">
        <header>
            <h2 id="system-title"><?php esc_html_e('The HabitLab System', 'habitlab'); ?></h2>
            <p><?php esc_html_e('Three parts. One direction. Daily progress.', 'habitlab'); ?></p>
        </header>

        <div class="system-grid">
            <?php foreach ($habitlab_system_items as $habitlab_item): ?>
                <?php $habitlab_modal_id = $habitlab_item['slug'] . '-modal'; ?>
                <button
                    class="card card--hover system-card system-card--trigger system-card--<?php echo esc_attr($habitlab_item['slug']); ?>"
                    type="button" data-modal-open="<?php echo esc_attr($habitlab_modal_id); ?>" aria-haspopup="dialog"
                    aria-controls="<?php echo esc_attr($habitlab_modal_id); ?>" aria-expanded="false">
                    <h3><?php echo esc_html($habitlab_item['label']); ?></h3>
                    <p><?php echo esc_html($habitlab_item['card_text']); ?></p>
                </button>
            <?php endforeach; ?>
        </div>

        <?php foreach ($habitlab_system_items as $habitlab_item): ?>
            <?php
            $habitlab_modal_id = $habitlab_item['slug'] . '-modal';
            $habitlab_title_id = $habitlab_modal_id . '-title';
            $habitlab_intro_id = $habitlab_modal_id . '-intro';
            $habitlab_section_id = $habitlab_modal_id . '-section';
            ?>
            <div id="<?php echo esc_attr($habitlab_modal_id); ?>"
                class="system-modal system-modal--<?php echo esc_attr($habitlab_item['slug']); ?>" data-modal role="dialog"
                aria-modal="true" aria-labelledby="<?php echo esc_attr($habitlab_title_id); ?>"
                aria-describedby="<?php echo esc_attr($habitlab_intro_id); ?>" hidden>
                <div class="system-modal__backdrop" data-modal-close></div>

                <div class="system-modal__dialog" role="document" tabindex="-1">
                    <div class="system-modal__watermark" aria-hidden="true">
                        <?php echo esc_html(strtoupper($habitlab_item['label'])); ?></div>

                    <button class="system-modal__close" type="button" data-modal-close
                        aria-label="<?php echo esc_attr(sprintf(__('Close %s modal', 'habitlab'), strtolower($habitlab_item['label']))); ?>">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <p class="system-modal__eyebrow"><?php echo esc_html($habitlab_item['label']); ?></p>

                    <div class="system-modal__content">
                        <div class="system-modal__main">
                            <h3 id="<?php echo esc_attr($habitlab_title_id); ?>">
                                <?php echo esc_html($habitlab_item['title_plain']); ?>
                                <span class="gradient-text"><?php echo esc_html($habitlab_item['title_accent']); ?></span>
                            </h3>

                            <div id="<?php echo esc_attr($habitlab_intro_id); ?>" class="system-modal__intro">
                                <?php foreach ($habitlab_item['intro'] as $habitlab_intro_line): ?>
                                    <p><?php echo esc_html($habitlab_intro_line); ?></p>
                                <?php endforeach; ?>
                            </div>

                            <ul class="system-modal__bullets">
                                <?php foreach ($habitlab_item['bullets'] as $habitlab_bullet): ?>
                                    <li><?php echo esc_html($habitlab_bullet); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <aside class="system-modal__aside" aria-labelledby="<?php echo esc_attr($habitlab_section_id); ?>">
                            <div class="system-modal__aside-card">
                                <h4 id="<?php echo esc_attr($habitlab_section_id); ?>">
                                    <?php echo esc_html($habitlab_item['aside_title']); ?></h4>
                                <?php if ($habitlab_item['aside_intro'] !== ''): ?>
                                    <p class="system-modal__section-intro">
                                        <?php echo esc_html($habitlab_item['aside_intro']); ?></p>
                                <?php endif; ?>
                                <ul class="system-modal__ideas">
                                    <?php foreach ($habitlab_item['aside_items'] as $habitlab_aside_item): ?>
                                        <li><?php echo esc_html($habitlab_aside_item); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <p class="system-modal__cta"><?php echo esc_html($habitlab_item['cta']); ?></p>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
