<?php
/*Slideshow Style 2*/

if (\Elementor\Plugin::instance()->editor->is_edit_mode()) {
    $post_id = zourney_ba_get_default_single_id();
} else {
    $post_id = get_the_ID();
}
$booking_post = get_post($post_id);

if (is_single() && $booking_post->post_type == BABE_Post_types::$booking_obj_post_type) {
    $babe_post     = BABE_Post_types::get_post($booking_post->ID);
    $gallery_items = isset($babe_post['images']) ? $babe_post['images'] : array();
    ?>
    <div class="zourney-single-slideshow slideshow-style-2" data-layout="style-2">
        <div class="slideshow-tab-container">
            <?php
            if (isset($gallery_items) && !empty($gallery_items)):
                ?>
                <div class="tab-content active gallery">
                    <div class="booking_single_gallery" id="booking-single-gallery-thumbnail-preview">
                        <div class="inner zourney-carousel" data-popup-json="<?php echo esc_attr(zourney_ba_get_gallery_popup_json($gallery_items)); ?>">
                            <?php
                            if (isset($gallery_items) && !empty($gallery_items)) {
                                foreach ($gallery_items as $key => $gallery) { ?>
                                    <div class="gallery-wrap">
                                        <?php echo wp_get_attachment_image($gallery['image_id'], 'zourney-tour-detail-gallery'); ?>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                    </div>
                </div>
            <?php
            endif;
            ?>
        </div>
    </div>
    <?php
}
?>


