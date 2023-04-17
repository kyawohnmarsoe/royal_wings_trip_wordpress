<?php
$babe_post = BABE_Post_types::get_post($post['ID']);
$image_srcs = wp_get_attachment_image_src(get_post_thumbnail_id($post['ID']), 'zourney-item');
$item_url = BABE_Functions::get_page_url_with_args($post['ID'], $_GET);
$price_old = $post['discount_price_from'] < $post['price_from'] ? '<span class="item_info_price_old">' . BABE_Currency::get_currency_price($post['price_from']) . '</span>' : '';
$discount     = $post['discount'] ? '<div class="item_info_price_discount">' . $post['discount'] . esc_html__('% OFF', 'zourney') . '</div>' : '';
$popular     = isset($babe_post['zourney_feature_item']) && $babe_post['zourney_feature_item'] ? '<div class="item_info_popular">' . esc_html__('Popular', 'zourney') . '</div>' : '';
$times_arr = BABE_Post_types::get_post_av_times($babe_post);
$total_rating = BABE_Rating::get_post_total_rating($post['ID']);
$total_votes = BABE_Rating::get_post_total_votes($post['ID']);
$address = isset($babe_post['address']) ? $babe_post['address'] : false;
?>
<div class="babe_items babe_items_3 column-item">
    <div class="babe_all_items_item_inner">
        <div class="item_img">
            <?php if (has_post_thumbnail($post['ID'])) {
                printf('%s', $popular);
                printf('%s', $discount);
            } ?>
            <?php echo has_post_thumbnail($post['ID']) ? '<a class="item-thumb" href="' . $item_url . '"><img src="' . $image_srcs[0] . '" alt="' . esc_attr($post['post_title']) . '"></a>' : ''; ?>
        </div>
        <div class="item_text">
            <?php if (!has_post_thumbnail($post['ID'])) {
                printf('%s', $popular);
                printf('%s', $discount);
            } ?>
            <?php if (!empty($address)) { ?>
                <div class="item-location">
                    <span><?php echo esc_html($address['address']); ?></span>
                </div>
            <?php } ?>
            <div class="item_title">
                <a href="<?php echo esc_url($item_url); ?>"><?php echo apply_filters('translate_text', $post['post_title']); ?></a>
            </div>
            <div class="item_head">
                <div class="item-meta">
                    <?php if (!empty($times_arr)) {
                        echo '<span class="item-days item-meta-value"><i class="zourney-icon-clock-time"></i><span>' . BABE_Post_types::get_post_duration($babe_post) . '</span></span>';
                    } ?>
                    <div class="rating">
                        <?php echo BABE_Rating::post_stars_rendering($post['ID']); ?>
                        <span class="rating-score"><?php echo round($total_rating, 2); ?></span>
                        <span class="rating-vote"><?php echo esc_html__('/5', 'zourney') ?></span>
                    </div>
                </div>
                <div class="item_info_price">
                    <label><?php echo esc_html__('From', 'zourney'); ?></label>
                    <span class="item_info_price_new"><?php echo BABE_Currency::get_currency_price($post['discount_price_from']); ?></span>
                    <?php printf('%s', $price_old); ?>
                </div>
            </div>
            <a class="read-more-item border-dark" href="<?php echo esc_url($item_url); ?>">
                <span><?php echo esc_html__('More Information', 'zourney'); ?></span><i
                        class="zourney-icon-arrow-long-right"></i>
            </a>
        </div>
    </div>
</div>


