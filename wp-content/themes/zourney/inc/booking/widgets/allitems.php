<?php

use Elementor\Controls_Manager;

/**
 * Add widget all-items to Elementor
 *
 * @since   1.3.13
 */
class Zourney_BABE_Elementor_Allitems_Widget extends \Elementor\Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        wp_enqueue_style('babe-admin-elementor-style', plugins_url("css/admin/babe-admin-elementor.css", BABE_PLUGIN));
    }

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'babe-all-items';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('All items', 'zourney');
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
        return ['item', 'items', 'all', 'products', 'product', 'book everything'];
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
        return ['zourney-elementor-ba-all-items', 'slick', 'magnific-popup', 'zourney-ba-items'];
    }

    /**
     * Register widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     */
    protected function register_controls() {

        // Get all terms of categories
        $categories = BABE_Post_types::get_categories_arr();

        $categories[0] = esc_html__('All', 'zourney');

        $item_titles = [0 => esc_html__('All', 'zourney')];

        $items = get_posts([
            'post_type'      => BABE_Post_types::$booking_obj_post_type,
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'cache_results'  => false,
            'orderby'        => 'title',
            'order'          => 'ASC',
        ]);
        if (!empty($items)) {
            foreach ($items as $item) {
                $item_titles[$item->ID] = get_the_title($item->ID);
            }
        }

        /////////////////////

        $this->start_controls_section(
            'babe_allitems',
            array(
                'label' => esc_html__('Content', 'zourney'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'category_ids',
            array(
                'label'   => esc_html__('Item Category', 'zourney'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => $categories,
                'default' => '0',
            )
        );

        $this->add_control(
            'taxonomy_slug',
            array(
                'label'       => esc_html__('Ba Taxonomies', 'zourney'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'multiple'    => true,
                'options'     => $this->get_taxonomies_arr(),
                'label_block' => true,
            )
        );

        $this->render_taxonomy_select();

        $this->add_control(
            'ids',
            array(
                'label'       => esc_html__('Items', 'zourney'),
                'description' => esc_html__('Show selected items only. Input item title to see suggestions', 'zourney'),
                'type'        => \Elementor\Controls_Manager::SELECT2,
                'multiple'    => true,
                'options'     => $item_titles,
                'label_block' => true
            )
        );

        $this->add_control(
            'per_page',
            array(
                'label'       => esc_html__('Per Page', 'zourney'),
                'description' => esc_html__('How much items per page to show (-1 to show all items)', 'zourney'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => '',
                'default'     => '12',
            )
        );

        $this->add_control(
            'sort',
            array(
                'label'       => esc_html__('Order By', 'zourney'),
                'description' => '',
                'type'        => \Elementor\Controls_Manager::SELECT,
                'options'     => array(
                    'rating'     => esc_html__('Rating', 'zourney'),
                    'price_from' => esc_html__('Price from', 'zourney'),
                ),
                'default'     => 'rating',
            )
        );

        $this->add_control(
            'sortby',
            array(
                'label'       => esc_html__('Order', 'zourney'),
                'description' => esc_html__('Designates the ascending or descending order. Default by DESC', 'zourney'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'options'     => array(
                    'ASC'  => esc_html__('Ascending', 'zourney'),
                    'DESC' => esc_html__('Descending', 'zourney'),
                ),
                'default'     => 'DESC',
            )
        );

        $this->add_control(
            'date_from',
            array(
                'label'          => esc_html__('Date from', 'zourney'),
                'description'    => esc_html__('Show items which are available from selected date.', 'zourney'),
                'type'           => \Elementor\Controls_Manager::DATE_TIME,
                'picker_options' => [
                    'dateFormat' => BABE_Settings::$settings['date_format'],
                    'enableTime' => false,
                ],
            )
        );

        $this->add_control(
            'date_to',
            array(
                'label'          => esc_html__('Date to', 'zourney'),
                'description'    => esc_html__('Show items which are available up to selected date.', 'zourney'),
                'type'           => \Elementor\Controls_Manager::DATE_TIME,
                'picker_options' => [
                    'dateFormat' => BABE_Settings::$settings['date_format'],
                    'enableTime' => false,
                ],
            )
        );

        $this->add_control(
            'classes',
            array(
                'label'       => esc_html__('Extra class name', 'zourney'),
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'zourney'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => '',
            )
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

        $this->add_control(
            'disable_fullwidth_button',
            [
                'label' => esc_html__('Disable Full Width Button', 'zourney'),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'disable-fullwidth-button-',
                 'selectors'  => [
                    '{{WRAPPER}}.disable-fullwidth-button-yes .babe_items .read-more-item.border-white' => 'display: inline-flex; padding-left: 50px; padding-right: 50px;',
                ],
                'condition' => [
                    'style' => '1',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_height',
            [
                'label'      => esc_html__('Height Item', 'zourney'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .babe_items.babe_items_1 .item_img' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .babe_items:not(.babe_items_1) .item_img img' => 'height: {{SIZE}}{{UNIT}}; width: 100%; object-fit: cover;',
                ],
            ]
        );
        $this->end_controls_section();


        $this->add_control_carousel();

    }


    protected function render_taxonomy_select() {
        $taxonomies_list = $this->get_taxonomies_arr();

        if ($taxonomies_list) {
            foreach ($taxonomies_list as $key => $name) {
                $taxonomies = $this->get_taxonomy_options($key);

                $this->add_control(
                    $key . '_ids',
                    array(
                        'label'       => $name,
                        'description' => esc_html__('Show selected category of taxonomy. Input item title to see suggestions', 'zourney'),
                        'type'        => \Elementor\Controls_Manager::SELECT2,
                        'multiple'    => true,
                        'options'     => $taxonomies,
                        'label_block' => true,
                        'condition'   => [
                            'taxonomy_slug' => $key,
                        ]
                    )
                );

            }
        }

    }

    protected function get_taxonomy_options($taxonomy_slug) {

        $taxonomy = get_term_by('slug', $taxonomy_slug, BABE_Post_types::$taxonomies_list_tax);
        $output   = array();
        if (!is_wp_error($taxonomy) && !empty($taxonomy)) {

            $taxonomies = get_terms(array(
                'taxonomy'   => BABE_Post_types::$attr_tax_pref . $taxonomy->slug,
                'hide_empty' => false
            ));

            if (!is_wp_error($taxonomies) && !empty($taxonomies)) {
                foreach ($taxonomies as $tax_term) {
                    $output[$tax_term->term_id] = $tax_term->name;
                }
            }
        }
        return $output;
    }

    public static function get_taxonomies_arr() {
        $output = array(0 => esc_html__('All', 'zourney'));

        $taxonomies = get_terms(array(
            'taxonomy'   => BABE_Post_types::$taxonomies_list_tax,
            'hide_empty' => false
        ));

        if (!is_wp_error($taxonomies) && !empty($taxonomies)) {
            foreach ($taxonomies as $tax_term) {
                $output[$tax_term->slug] = apply_filters('translate_text', $tax_term->name);
            }
        }

        return $output;

    }

    protected function add_control_carousel($condition = array()) {
        $this->start_controls_section(
            'section_carousel_options',
            [
                'label'     => esc_html__('Carousel Options', 'zourney'),
                'type'      => Controls_Manager::SECTION,
                'condition' => $condition,
            ]
        );

        $this->add_control(
            'enable_carousel',
            [
                'label' => esc_html__('Enable', 'zourney'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'navigation',
            [
                'label'     => esc_html__('Navigation', 'zourney'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'dots',
                'options'   => [
                    'both'   => esc_html__('Arrows and Dots', 'zourney'),
                    'arrows' => esc_html__('Arrows', 'zourney'),
                    'dots'   => esc_html__('Dots', 'zourney'),
                    'none'   => esc_html__('None', 'zourney'),
                ],
                'condition' => [
                    'enable_carousel' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label'     => esc_html__('Pause on Hover', 'zourney'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'condition' => [
                    'enable_carousel' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'     => esc_html__('Autoplay', 'zourney'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'condition' => [
                    'enable_carousel' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'     => esc_html__('Autoplay Speed', 'zourney'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5000,
                'condition' => [
                    'autoplay'        => 'yes',
                    'enable_carousel' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-slide-bg' => 'animation-duration: calc({{VALUE}}ms*1.2); transition-duration: calc({{VALUE}}ms)',
                ],
            ]
        );

        $this->add_control(
            'infinite',
            [
                'label'     => esc_html__('Infinite Loop', 'zourney'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'condition' => [
                    'enable_carousel' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'visibility',
            [
                'label'     => esc_html__('Visibility', 'zourney'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'no',
                'condition' => [
                    'enable_carousel' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'layout_carousel_center',
            [
                'label'     => esc_html__('Carousel Center', 'zourney'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'no',
                'condition' => [
                    'enable_carousel' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'carousel_arrows',
            [
                'label'      => esc_html__('Carousel Arrows', 'zourney'),
                'conditions' => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'enable_carousel',
                            'operator' => '==',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'none',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'dots',
                        ],
                    ],
                ],
            ]
        );

        //add icon next size
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Size', 'zourney'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow:before' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'carousel_width',
            [
                'label' => esc_html__('Width', 'zourney'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-slider button.slick-prev' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .slick-slider button.slick-next' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'carousel_height',
            [
                'label' => esc_html__('Height', 'zourney'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-slider button.slick-prev' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .slick-slider button.slick-next' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_border_radius',
            [
                'label' => esc_html__('Border Radius', 'zourney'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .slick-slider button.slick-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .slick-slider button.slick-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'color_button',
            [
                'label' => esc_html__('Color', 'zourney'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->start_controls_tabs('tabs_carousel_arrow_style');

        $this->start_controls_tab(
            'tab_carousel_arrow_normal',
            [
                'label' => esc_html__('Normal', 'zourney'),
            ]
        );

        $this->add_control(
            'carousel_arrow_color_icon',
            [
                'label' => esc_html__('Color icon', 'zourney'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .slick-slider button.slick-prev:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .slick-slider button.slick-next:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_arrow_color_border',
            [
                'label' => esc_html__('Color Border', 'zourney'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .slick-slider button.slick-prev span' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .slick-slider button.slick-next span' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_arrow_color_background',
            [
                'label' => esc_html__('Color background', 'zourney'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .slick-slider button.slick-prev, {{WRAPPER}} .slick-slider button.slick-prev:after' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .slick-slider button.slick-next, {{WRAPPER}} .slick-slider button.slick-prev:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_carousel_arrow_hover',
            [
                'label' => esc_html__('Hover', 'zourney'),
            ]
        );

        $this->add_control(
            'carousel_arrow_color_icon_hover',
            [
                'label' => esc_html__('Color icon', 'zourney'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .slick-slider button.slick-prev:hover:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .slick-slider button.slick-next:hover:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_arrow_color_border_hover',
            [
                'label' => esc_html__('Color Border', 'zourney'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .slick-slider button.slick-prev:hover' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .slick-slider button.slick-next:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_arrow_color_background_hover',
            [
                'label' => esc_html__('Color background', 'zourney'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .slick-slider button.slick-prev:hover:after' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .slick-slider button.slick-next:hover:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'next_heading',
            [
                'label' => esc_html__('Next button', 'zourney'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'next_vertical',
            [
                'label'       => esc_html__('Next Vertical', 'zourney'),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options'     => [
                    'top'    => [
                        'title' => esc_html__('Top', 'zourney'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'zourney'),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ]
            ]
        );

        $this->add_responsive_control(
            'next_vertical_value',
            [
                'type'       => Controls_Manager::SLIDER,
                'show_label' => false,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => -1000,
                        'max'  => 1000,
                        'step' => 1,
                    ],
                    '%'  => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .slick-next' => 'top: unset; bottom: unset; {{next_vertical.value}}: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'next_horizontal',
            [
                'label'       => esc_html__('Next Horizontal', 'zourney'),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options'     => [
                    'left'  => [
                        'title' => esc_html__('Left', 'zourney'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'zourney'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'defautl'     => 'right'
            ]
        );

        $this->add_responsive_control(
            'next_horizontal_value',
            [
                'type'       => Controls_Manager::SLIDER,
                'show_label' => false,
                'size_units' => ['px', 'em', '%'],
                'range'      => [
                    'px' => [
                        'min'  => -1000,
                        'max'  => 1000,
                        'step' => 1,
                    ],
                    '%'  => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => -45,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .slick-next' => 'left: unset; right: unset;{{next_horizontal.value}}: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'prev_heading',
            [
                'label'     => esc_html__('Prev button', 'zourney'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'prev_vertical',
            [
                'label'       => esc_html__('Prev Vertical', 'zourney'),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options'     => [
                    'top'    => [
                        'title' => esc_html__('Top', 'zourney'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'zourney'),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ]
            ]
        );

        $this->add_responsive_control(
            'prev_vertical_value',
            [
                'type'       => Controls_Manager::SLIDER,
                'show_label' => false,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => -1000,
                        'max'  => 1000,
                        'step' => 1,
                    ],
                    '%'  => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .slick-prev' => 'top: unset; bottom: unset; {{prev_vertical.value}}: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'prev_horizontal',
            [
                'label'       => esc_html__('Prev Horizontal', 'zourney'),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options'     => [
                    'left'  => [
                        'title' => esc_html__('Left', 'zourney'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'zourney'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'defautl'     => 'left'
            ]
        );

        $this->add_responsive_control(
            'prev_horizontal_value',
            [
                'type'       => Controls_Manager::SLIDER,
                'show_label' => false,
                'size_units' => ['px', 'em', '%'],
                'range'      => [
                    'px' => [
                        'min'  => -1000,
                        'max'  => 1000,
                        'step' => 1,
                    ],
                    '%'  => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => -45,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .slick-prev' => 'left: unset; right: unset; {{prev_horizontal.value}}: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function get_carousel_settings() {

        $settings = $this->get_settings_for_display();

        $breakpoints = \Elementor\Plugin::$instance->breakpoints->get_breakpoints();
        $tablet = isset($settings['column_tablet']) ? $settings['column_tablet'] : 2;
        return array(
            'navigation' => $settings['navigation'],
            'autoplayHoverPause' => $settings['pause_on_hover'] === 'yes' ? true : false,
            'autoplay' => $settings['autoplay'] === 'yes' ? true : false,
            'autoplaySpeed' => $settings['autoplay_speed'],
            'carousel_center'    => $settings['layout_carousel_center'] === 'yes' ? true : false,
            'items' => $settings['column'],
            'items_laptop' => isset($settings['column_laptop']) ? $settings['column_laptop'] : $settings['column'],
            'items_tablet_extra' => isset($settings['column_tablet_extra']) ? $settings['column_tablet_extra'] : $settings['column'],
            'items_tablet' => $tablet,
            'items_mobile_extra' => isset($settings['column_mobile_extra']) ? $settings['column_mobile_extra'] : $tablet,
            'items_mobile' => isset($settings['column_mobile']) ? $settings['column_mobile'] : 1,
            'loop' => $settings['infinite'] === 'yes' ? true : false,
            'breakpoint_laptop' => $breakpoints['laptop']->get_value(),
            'breakpoint_tablet_extra' => $breakpoints['tablet_extra']->get_value(),
            'breakpoint_tablet' => $breakpoints['tablet']->get_value(),
            'breakpoint_mobile_extra' => $breakpoints['mobile_extra']->get_value(),
            'breakpoint_mobile' => $breakpoints['mobile']->get_value(),
        );
    }

    /**
     * Create shortcode row
     *
     * @return string
     */
    public function create_shortcode() {

        $settings = $this->get_settings_for_display();

        $args_row = '';

        if ($settings['taxonomy_slug']) {
            $term_ids = $settings['taxonomy_slug'] . '_ids';
            if ($settings[$term_ids]) {
                $args_row .= ' term_ids="' . esc_attr(implode(',', $settings[$term_ids])) . '"';
            }
        }

        $args_row .= $settings['sort'] ? ' sort="' . esc_attr($settings['sort']) . '"' : '';
        $args_row .= $settings['sortby'] ? ' sortby="' . esc_attr($settings['sortby']) . '"' : '';

        $args_row .= absint($settings['category_ids']) ? ' category_ids="' . absint($settings['category_ids']) . '"' : '';

        $args_row .= !empty($settings['ids']) ? ' ids="' . esc_attr(implode(',', $settings['ids'])) . '"' : '';

        $args_row .= absint($settings['per_page']) ? ' per_page="' . intval($settings['per_page']) . '"' : '';

        $args_row .= $settings['date_from'] ? ' date_from="' . esc_attr($settings['date_from']) . '"' : '';

        $args_row .= $settings['date_to'] ? ' date_to="' . esc_attr($settings['date_to']) . '"' : '';

        ///////////////////////

        $args_row .= $settings['classes'] ? ' classes="' . esc_attr($settings['classes']) . '"' : '';


        return '[all-items' . $args_row . '][/all-items]';

    }

    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     */
    protected function render() {

        $settings = $this->get_settings_for_display();

        if ($settings['enable_carousel'] === 'yes') {
            if ($settings['visibility'] == 'yes') {
                $this->add_render_attribute('wrapper', 'class', 'zourney-carousel-visibility');
            }
            if ($settings['layout_carousel_center'] == 'yes') {
                $this->add_render_attribute('wrapper', 'class', 'zourney-carousel-center');
            }
            $this->add_render_attribute('wrapper', 'class', 'zourney-carousel-items');
            $carousel_settings = $this->get_carousel_settings();
            $this->add_render_attribute('wrapper', 'data-carousel', wp_json_encode($carousel_settings));
        } else {

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

        }

        add_filter('babe_shortcode_all_items_item_html', array($this, 'get_template_items'), 10, 3);
        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>' . do_shortcode($this->create_shortcode()) . '</div>';


    }

    public function get_template_items($content, $post, $babe_post) {
        $settings = $this->get_settings_for_display();
        ob_start();
        include get_theme_file_path('template-parts/booking/block/item-block-' . $settings['style'] . '.php');
        return ob_get_clean();
    }

}

