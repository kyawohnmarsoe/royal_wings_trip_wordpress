<?php
if (\Elementor\Plugin::instance()->editor->is_edit_mode()) {
    $post_id = zourney_ba_get_default_single_id();
} else {
    $post_id = get_the_ID();
}
$babe_post = BABE_Post_types::get_post($post_id);
if (!empty($babe_post) && isset($babe_post['faq']) && !empty($babe_post['faq'])) {
    $faqs_arr = BABE_Post_types::get_post_faq($babe_post);
    if (!empty($faqs_arr)) {
        $this->title_render();
        foreach ($faqs_arr as $faq) {
            ?>
            <div class="block_faq">
                <?php printf('<h4 class="block_faq_title">%s</h4>', $faq['post_title']); ?>
                <div class="block_faq_content">
                    <div class="content">
                        <?php echo wptexturize($faq['post_content']); ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
