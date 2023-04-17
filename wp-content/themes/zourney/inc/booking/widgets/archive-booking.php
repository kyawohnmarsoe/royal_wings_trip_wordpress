<?php

/**
 * Add widget all-items to Elementor
 *
 * @since   1.3.13
 */
class Zourney_Elementor_BA_Archive_Booking extends \Elementor\Widget_Base {
    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'babe-archive-items';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('BA Archive', 'zourney');
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
        return ['Booking', 'Archive'];
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
        return ['magnific-popup', 'zourney-ba-items'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_query',
            [
                'label' => esc_html__('Settings', 'zourney'),
            ]
        );

        $this->add_control(
            'style',
            [
                'label'   => esc_html__('Style', 'zourney'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 1,
                'options' => [
                    1 => esc_html__('Style 1', 'zourney'),
                    2 => esc_html__('Style 2', 'zourney'),
                    3 => esc_html__('Style 3', 'zourney'),
                    4 => esc_html__('Style 4', 'zourney'),
                ],
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label'           => esc_html__('Columns', 'zourney'),
                'type'            => \Elementor\Controls_Manager::SELECT,
                'desktop_default' => 2,
                'tablet_default'  => 2,
                'mobile_default'  => 1,
                'options'         => [1 => 1, 2 => 2, 3 => 3, 4 => 4],
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
        include get_theme_file_path('template-parts/booking/archive.php');
    }

}
