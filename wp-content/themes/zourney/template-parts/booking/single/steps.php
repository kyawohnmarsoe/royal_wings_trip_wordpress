<?php
if (\Elementor\Plugin::instance()->editor->is_edit_mode()) {
    $post_id = zourney_ba_get_default_single_id();
} else {
    $post_id = get_the_ID();
}
$babe_post = BABE_Post_types::get_post($post_id);
$settings  = $this->get_settings_for_display();
if (!empty($babe_post) && isset($babe_post['steps']) && !empty($babe_post['steps'])) {
    $this->title_render(); ?>
    <div class="inner">
        <a class="zourney-toogle-step" href="#"><?php echo esc_html__('Expand All', 'zourney'); ?></a>
        <?php
        foreach ($babe_post['steps'] as $step) {
            if (isset($step['attraction']) && isset($step['title'])) {
                ?>
                <div class="block_step">
                    <div class="block_step_title collapse-title">
                        <span class="icon"></span>
                        <div class="step_title"><?php echo apply_filters('translate_text', $step['title']); ?> </div>
                    </div>
                    <div class="block_step_content collapse-body">
                        <div class="content">
                            <?php echo wpautop($step['attraction']); ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        } ?>
    </div>
    <?php
}

