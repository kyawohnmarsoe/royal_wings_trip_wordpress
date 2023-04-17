<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor image gallery widget.
 *
 * Elementor widget that displays a set of images in an aligned grid.
 *
 * @since 1.0.0
 */
class Zourney_Elementor_Image_Gallery extends Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve image gallery widget name.
     *
     * @return string Widget name.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_name() {
        return 'zourney-image-gallery';
    }

    /**
     * Get widget title.
     *
     * Retrieve image gallery widget title.
     *
     * @return string Widget title.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_title() {
        return esc_html__('Zourney Image Gallery', 'zourney');
    }

    public function get_categories() {
        return ['zourney-addons'];
    }

    /**
     * Get widget icon.
     *
     * Retrieve image gallery widget icon.
     *
     * @return string Widget icon.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @return array Widget keywords.
     * @since  2.1.0
     * @access public
     *
     */
    public function get_keywords() {
        return ['image', 'photo', 'visual', 'gallery'];
    }

    /**
     * Register image gallery widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_gallery',
            [
                'label' => esc_html__('Gallery', 'zourney'),
            ]
        );

        $this->add_control(
            'wp_gallery',
            [
                'label'      => esc_html__('Add Images', 'zourney'),
                'type'       => Controls_Manager::GALLERY,
                'show_label' => false,
                'dynamic'    => [
                    'active' => true,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'thumbnail',
                'separator' => 'none',
                'default'   => 'zourney-gallery-image'
            ]
        );

        $this->add_control(
            'image_radius',
            [
                'label'      => esc_html__('Border Radius', 'zourney'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

    }

    /**
     * Render image gallery widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        if (!$settings['wp_gallery']) {
            return;
        }
        $this->add_render_attribute('row', 'class', 'gallery-grid');
        ?>
        <div class="elementor-zourney-image-gallery">
            <?php
            for ($i = 0; $i <= 2; $i++) {
                ?>
                <div <?php echo zourney_elementor_get_render_attribute_string('row', $this) ?>>
                    <?php
                    $this->add_render_attribute('link', 'data-elementor-lightbox-slideshow', $this->get_id());

                    foreach ($settings['wp_gallery'] as $items => $attachment) {
                        $image_url = Group_Control_Image_Size::get_attachment_image_src($attachment['id'], 'thumbnail', $settings);
                        ?>
                        <div class="item">
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(Elementor\Control_Media::get_image_alt($attachment)); ?>"/>
                        </div>
                        <?php
                    }

                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }

}

$widgets_manager->register(new Zourney_Elementor_Image_Gallery());





