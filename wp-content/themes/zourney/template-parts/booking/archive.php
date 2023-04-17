<?php

global $wp_query;
$settings = $this->get_settings_for_display();

if (!empty($settings['column_widescreen'])) {
    $this->add_render_attribute('wrapper', 'data-elementor-columns-widescreen', $settings['column_widescreen']);
}

if (!empty($settings['column'])) {
    $this->add_render_attribute('wrapper', 'data-elementor-columns', $settings['column']);
} else {
    $this->add_render_attribute('wrapper', 'data-elementor-columns', 5);
}

if (!empty($settings['column_laptop'])) {
    $this->add_render_attribute('wrapper', 'data-elementor-columns-laptop', $settings['column_laptop']);
}

if (!empty($settings['column_tablet_extra'])) {
    $this->add_render_attribute('wrapper', 'data-elementor-columns-tablet-extra', $settings['column_tablet_extra']);
}

if (!empty($settings['column_tablet'])) {
    $this->add_render_attribute('wrapper', 'data-elementor-columns-tablet', $settings['column_tablet']);
} else {
    $this->add_render_attribute('wrapper', 'data-elementor-columns-tablet', 2);
}

if (!empty($settings['column_mobile_extra'])) {
    $this->add_render_attribute('wrapper', 'data-elementor-columns-mobile-extra', $settings['column_mobile_extra']);
}

if (!empty($settings['column_mobile'])) {
    $this->add_render_attribute('wrapper', 'data-elementor-columns-mobile', $settings['column_mobile']);
} else {
    $this->add_render_attribute('wrapper', 'data-elementor-columns-mobile', 1);
}

$posts       = BABE_Post_types::get_posts();
$posts_pages = BABE_Post_types::$get_posts_pages;

?>
    <div <?php echo zourney_elementor_get_render_attribute_string('wrapper', $this); ?>>
        <div class="babe_shortcode_block sc_all_items">
            <div class="babe_shortcode_block_bg_inner">
                <div class="babe_shortcode_block_inner">
                    <?php
                    if(is_post_type_hierarchical('to_book') ){
                        while ( have_posts() ) : the_post();
                            $post = get_post( get_the_ID(), ARRAY_A);
                            $prices = BABE_Post_types::get_post_price_from( $post['ID'] );
                            $post = array_merge($post, $prices);
                            include get_theme_file_path('template-parts/booking/block/item-block-' . $settings['style'] . '.php');
                        endwhile;

                    }else{
                        foreach ($posts as $post) {
                            include get_theme_file_path('template-parts/booking/block/item-block-' . $settings['style'] . '.php');
                        }
                    }
                    ?>
                </div>
                <?php zourney_paging_nav(); ?>
            </div>
        </div>
    </div>
<?php
