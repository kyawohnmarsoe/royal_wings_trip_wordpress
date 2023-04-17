<?php
/**
 * BA Single Content
 *
 * @version 1.0.0
 */

if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
    $post_id = zourney_ba_get_default_single_id();
} else {
    $post_id = get_the_ID();
}
$main_post = get_post( $post_id );

if ( is_single() && $main_post->post_type == BABE_Post_types::$booking_obj_post_type) {
    if (!empty($main_post->post_content)){
        $this->title_render();
        echo '<div class="desc-p zourney-single-content">';
        echo wpautop($main_post->post_content);
        echo '<div class="link-holder">';
        echo '<a href="#"><span>' . esc_html__('View More', 'zourney') . '</span><i class="zourney-icon-arrow-long-right"></i></a>';
        echo '</div>';
        echo '</div>';
    }
}
