<?php

use Elementor\Controls_Manager;

/**
 * Add widget all-items to Elementor
 *
 * @since   1.3.13
 */
class Zourney_Elementor_BA_Archive_Booking_Gallery extends \Elementor\Widget_Base {
    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'babe-gallery-image';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('BA Archive Gallery Image', 'zourney');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-archive-posts';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['Booking', 'Archive', 'Gallery Image', 'Archive Gallery'];
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['book-everything-elements'];
    }

    public function get_style_depends() {
        return ['magnific-popup'];
    }

    public function get_script_depends() {
        return ['zourney-ba-archive-booking-gallery.js', 'isotope'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_gallery',
            [
                'label' => esc_html__('Image Gallery', 'zourney'),
            ]
        );
        $this->add_responsive_control(
            'columns',
            [
                'label'   => esc_html__('Columns', 'zourney'),
                'type'    => Controls_Manager::SELECT,
                'default' => 3,
                'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6],
            ]
        );
        $this->add_responsive_control(
            'gutter',
            [
                'label'      => esc_html__('Gutter', 'zourney'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .column-item' => 'padding-left: calc({{SIZE}}{{UNIT}} / 2); padding-right: calc({{SIZE}}{{UNIT}} / 2); padding-bottom: calc({{SIZE}}{{UNIT}})',
                    '{{WRAPPER}} .row'         => 'margin-left: calc({{SIZE}}{{UNIT}} / -2); margin-right: calc({{SIZE}}{{UNIT}} / -2);',
                ],
            ]
        );

        $this->end_controls_section();

    }


    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     */
    protected function render() {


        if (\Elementor\Plugin::instance()->editor->is_edit_mode()) {
            $taxonomy_ID = 56;
            $this->render_taxonomy_content($taxonomy_ID);

        }else{
            $object = get_queried_object();
            if(!empty( $object) && (isset($object->taxonomy) && Zourney_BA_Booking::check_taxonomy($object->taxonomy) )) {
                $this->render_taxonomy_content($object->term_id);
            }

        }

    }

    private function render_taxonomy_content($tax_ID){
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('row', 'class', 'row');
        if (!empty($settings['columns'])) {
            $this->add_render_attribute('row', 'data-elementor-columns', $settings['columns']);
        }

        if (!empty($settings['columns_tablet'])) {
            $this->add_render_attribute('row', 'data-elementor-columns-tablet', $settings['columns_tablet']);
        }
        if (!empty($settings['columns_mobile'])) {
            $this->add_render_attribute('row', 'data-elementor-columns-mobile', $settings['columns_mobile']);
        }

        $term_data = get_term_meta($tax_ID, 'zourney_location_gallery_image', true);
        $this->add_render_attribute( 'link', 'data-elementor-lightbox-slideshow', $this->get_id() );
        $this->add_render_attribute( 'wrapper', 'class', 'elementor-location-gallery-image' );
        if($term_data && !empty($term_data)){ ?>
            <div <?php echo zourney_elementor_get_render_attribute_string( 'wrapper', $this ); ?>>
                <div <?php echo zourney_elementor_get_render_attribute_string( 'row', $this ); ?>>
                    <?php foreach ($term_data as $attachment_id => $attachment_url){ ?>
                        <div class="column-item">
                            <a data-elementor-open-lightbox="yes" <?php echo zourney_elementor_get_render_attribute_string('link', $this); ?>
                               href="<?php echo esc_url($attachment_url); ?>">
                                <?php echo wp_get_attachment_image( $attachment_id, 'full'); ?>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php
        }
    }
}
