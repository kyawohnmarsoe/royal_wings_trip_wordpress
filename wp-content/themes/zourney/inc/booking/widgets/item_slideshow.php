<?php
/**
 * Add widget all-items to Elementor
 *
 * @since   1.3.13
 */

class Zourney_BABE_Elementor_Itemslideshow_Widget extends \Elementor\Widget_Base
{

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'babe-item-slideshow';
    }

    public function is_reload_preview_required()
    {
        return true;
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('Detail slideshow', 'zourney');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-slides';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
        return ['slideshow'];
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['book-everything-elements'];
    }

    public function get_style_depends()
    {
        return ['photoswipe', 'photoswipe-skin', 'magnific-popup'];
    }

    public function get_script_depends()
    {
        return ['zourney-ba-slideshow.js', 'slick', 'photoswipe', 'photoswipe-ui', 'magnific-popup'];
    }

    /**
     * Register widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     */
    protected function register_controls()
    {

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('General', 'zourney'),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'slideshow_style',
            [
                'label' => esc_html__('Choose Style', 'zourney'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'style-1',
                'options' => [
                    'style-1' => esc_html__('Style 1', 'zourney'),
                    'style-2' => esc_html__('Style 2', 'zourney'),
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     * Written in PHP and used to generate the final HTML.
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $class_overlay = '';
        ?>
        <div class="elementor-widget-inner <?php echo esc_attr($class_overlay); ?>">
            <?php
            $this->get_tab_title_html();
            include get_theme_file_path('template-parts/booking/single/slideshow/' . $settings['slideshow_style'].'.php');
            ?>
        </div>
        <?php
    }

    protected function get_tab_title_html()
    {
        ?>
        <div class="booking_tab_gallery">
            <div class="booking_tab_gallery_inner">
                <ul class="tablist_gallery">
                    <li>
                        <a class="tab-gallery js-gallery-popup" data-action="gallery" href="#">
                            <i class="zourney-icon-camera-alt"></i>
                            <span><?php esc_html_e('Gallery', 'zourney') ?></span>
                        </a>
                    </li>
                    <?php if (\Elementor\Plugin::instance()->editor->is_edit_mode()) {
                        $post_id = zourney_ba_get_default_single_id();
                    } else {
                        $post_id = get_the_ID();
                    }
                    $babe_post = get_post($post_id);

                    if (is_single() && $babe_post->post_type == BABE_Post_types::$booking_obj_post_type) {
                        $babe_post = BABE_Post_types::get_post($babe_post->ID);

                        $videolink = isset($babe_post['zourney_video_link']) ? $babe_post['zourney_video_link'] : false;

                        if ($videolink) { ?>
                            <li class="js-tab-popup">
                                <a class="tab-video" data-action="video" href="<?php echo esc_url($videolink); ?>"
                                   data-effect="mfp-zoom-in">
                                    <i class="zourney-icon-video"></i>
                                    <span><?php esc_html_e('Video', 'zourney') ?></span>
                                </a>
                            </li>
                        <?php }
                    } ?>
                </ul>
            </div>
        </div>
        <?php
    }

}
