<?php

use Elementor\Controls_Manager;

class Zourney_BABE_Elementor_Taxonomies_Widget extends \Elementor\Widget_Base {
    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'babe-taxonomies';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Ba Taxonomies', 'zourney');
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
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['book-everything-elements'];
    }

    public function get_script_depends() {
        return ['zourney-ba-babe-taxonomies.js', 'slick'];
    }

    /**
     * Register widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     */
    protected function register_controls() {

        // Get all terms of categories

        $this->start_controls_section(
            'babe_taxonomies',
            array(
                'label' => esc_html__('Content', 'zourney'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
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

        $this->add_control(
            'enable_all_taxonomy',
            [
                'label' => esc_html__('Get all taxonomy', 'zourney'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->render_setting_taxonomy();


        $this->add_control(
            'orderby',
            [
                'label'     => esc_html__('Order by', 'zourney'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'id'    => esc_html__('ID', 'zourney'),
                    'count' => esc_html__('Count', 'zourney'),
                    'name'  => esc_html__('Name', 'zourney'),
                ],
                'default'   => 'name',
                'condition' => [
                    'enable_all_taxonomy!' => ''
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label'     => esc_html__('Order', 'zourney'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'asc',
                'options'   => [
                    'asc'  => esc_html__('ASC', 'zourney'),
                    'desc' => esc_html__('DESC', 'zourney'),
                ],
                'condition' => [
                    'enable_all_taxonomy!' => ''
                ],
            ]
        );


        $this->add_control(
            'hide_empty',
            [
                'label'     => esc_html__('Hide Empty', 'zourney'),
                'type'      => Controls_Manager::SWITCHER,
                'condition' => [
                    'enable_all_taxonomy!' => ''
                ],
            ]
        );

        $this->add_control(
            'pad_counts',
            [
                'label'     => esc_html__('Pad Count', 'zourney'),
                'type'      => Controls_Manager::SWITCHER,
                'condition' => [
                    'enable_all_taxonomy!' => ''
                ],
            ]
        );

        $this->add_control(
            'per_page',
            array(
                'label'       => esc_html__('Per Page', 'zourney'),
                'description' => esc_html__('How much items per page to show (-1 to show all items)', 'zourney'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => '',
                'default'     => '6',
                'condition'   => [
                    'enable_all_taxonomy!' => ''
                ],
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
                'options'         => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6],
            ]
        );

        $this->add_responsive_control(
            'item_height',
            [
                'label'      => esc_html__('Height Item', 'zourney'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .thumbnail-location' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'layout',
            [
                'label'   => esc_html__('Layout', 'zourney'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'layout-1' => esc_html__('Layout 1', 'zourney'),
                    'layout-2' => esc_html__('Layout 2', 'zourney'),
                    'layout-3' => esc_html__('Layout 3', 'zourney'),
                    'layout-4' => esc_html__('Layout 4', 'zourney'),
                ],
                'default' => 'layout-1'
            ]
        );

        $this->add_control(
            'layout_special',
            [
                'label'        => esc_html__('Layout Special', 'zourney'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'conditions'    => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'layout',
                            'operator' => '!==',
                            'value' => 'layout-2',
                        ],
                        [
                            'name' => 'layout',
                            'operator' => '!==',
                            'value' => 'layout-3',
                        ],
                    ],
                ],


                'prefix_class' => 'babe-taxonomies-special-',
            ]
        );

        $this->end_controls_section();

        $this->add_control_carousel();

    }


    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     */
    protected function render() {

        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('wrapper', 'class', 'row');
        $this->add_render_attribute('wrapper', 'class', $settings['layout']);

        if ($settings['enable_carousel'] === 'yes') {
            if ($settings['visibility'] == 'yes') {
                $this->add_render_attribute('wrapper', 'class', 'zourney-carousel-visibility');
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

        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';
        if (!empty($settings['taxonomy_slug'])) {


            $default_lang = BABE_Functions::get_default_language();
            $current_lang = BABE_Functions::get_current_language();
            if (BABE_Functions::is_wpml_active() && $current_lang !== $default_lang) {
                do_action('wpml_switch_language', $default_lang);
                $taxonomy = get_term_by('slug', $settings['taxonomy_slug'], BABE_Post_types::$taxonomies_list_tax);
                do_action('wpml_switch_language', $current_lang);
            } else {
                $taxonomy = get_term_by('slug', $settings['taxonomy_slug'], BABE_Post_types::$taxonomies_list_tax);
            }

            if (!is_wp_error($taxonomy) && !empty($taxonomy)) {

                if (empty($settings[$settings['taxonomy_slug'] . '_ids']) || $settings['enable_all_taxonomy']) {
                    $taxonomies = get_terms(array(
                        'taxonomy'   => BABE_Post_types::$attr_tax_pref . $taxonomy->slug,
                        'hide_empty' => $settings['hide_empty'],
                        'number'     => $settings['per_page'],
                        'orderby'    => $settings['orderby'],
                        'order'      => $settings['order'],
                    ));

                    if (!is_wp_error($taxonomies) && !empty($taxonomies)) {
                        foreach ($taxonomies as $taxonomy) {
                            $this->render_taxonomy_item($taxonomy);
                        }
                    }
                } else {
                    $taxonomies = $settings[$settings['taxonomy_slug'] . '_ids'];
                    foreach ($taxonomies as $taxonomy) {
                        $default_lang = BABE_Functions::get_default_language();
                        $current_lang = BABE_Functions::get_current_language();
                        if (BABE_Functions::is_wpml_active() && $current_lang !== $default_lang) {
                            do_action('wpml_switch_language', $default_lang);
                            $tax = get_term_by('slug', $taxonomy, BABE_Post_types::$attr_tax_pref . $settings['taxonomy_slug']);
                            do_action('wpml_switch_language', $current_lang);
                        } else {
                            $tax = get_term_by('slug', $taxonomy, BABE_Post_types::$attr_tax_pref . $settings['taxonomy_slug']);
                        }

                        if (!is_wp_error($tax) && !empty($tax)) {
                            $this->render_taxonomy_item($tax);
                        }
                    }
                }

            }
        }
        echo '</div>';

    }

    public function render_taxonomy_item($taxonomy) {

        $settings       = $this->get_settings_for_display();
        $image_location = get_term_meta($taxonomy->term_id, 'zourney_location_image', true);
        $icon_location  = get_term_meta($taxonomy->term_id, 'fa_class', true);
        $from_location  = get_term_meta($taxonomy->term_id, 'fa_from', true);

        $svg_id_1 = wp_unique_id('c-dashed-line');
        $svg_id_2 = wp_unique_id('myMask');

        if (empty($image_location)) {
            $image_location = Elementor\Utils::get_placeholder_image_src();
        }
        ?>
        <div class="column-item location-item">
            <div class="item-inner">
                <a class="title-location" href="<?php echo esc_url(get_term_link($taxonomy->slug, $taxonomy->taxonomy)); ?>">
                    <?php if ($settings['layout'] == 'layout-1' || ($settings['layout'] == 'layout-3')):
                        $svg_id_3 = wp_unique_id('c-dashed-line');
                        $svg_id_4 = wp_unique_id('myMask');
                        ?>
                        <div class="thumbnail-location">
                            <svg class="c-dashed-line c-dashed-line-1" width="212" height="145" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <path id="<?php echo esc_attr($svg_id_1); ?>" d="M3.24958 0.840291C-0.675149 17.4112 1.31934 51.388 40.6951 54.7275C89.9147 58.9019 69.4904 8.71087 44.113 28.3208C18.7355 47.9308 5.53351 82.6681 56.3275 125.294C96.9627 159.395 176.409 137.984 211.053 123.016"/>
                                </defs>
                                <mask id="<?php echo esc_attr($svg_id_2); ?>">
                                    <use class="c-dashed-line__dash" xlink:href="#<?php echo esc_attr($svg_id_1); ?>"/>
                                </mask>
                                <use class="c-dashed-line__path" xlink:href="#<?php echo esc_attr($svg_id_1); ?>" mask="url(#<?php echo esc_attr($svg_id_2); ?>)"/>
                                <path class="line-icon" d="M65.9998 112.478C65.0569 112.478 64.2855 113.284 64.2855 114.269C64.2855 115.254 65.0569 116.06 65.9998 116.06C66.9426 116.06 67.7141 115.254 67.7141 114.269C67.7141 113.284 66.9426 112.478 65.9998 112.478ZM65.9998 108C68.8026 108 71.9998 110.203 71.9998 114.403C71.9998 117.072 70.174 119.884 66.5226 122.812C66.214 123.063 65.7855 123.063 65.4769 122.812C61.8255 119.875 59.9998 117.072 59.9998 114.403C59.9998 110.203 63.1969 108 65.9998 108Z"/>
                            </svg>
                            <svg class="c-dashed-line c-dashed-line-2" width="213" height="90" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <path id="<?php echo esc_attr($svg_id_3); ?>" d="M1 27.6022C17.3333 8.93558 56.8 -18.3978 84 21.6022C118 71.6022 167 12.6023 212 88.6023"/>
                                </defs>
                                <mask id="<?php echo esc_attr($svg_id_4); ?>">
                                    <use class="c-dashed-line__dash" xlink:href="#<?php echo esc_attr($svg_id_3); ?>"/>
                                </mask>
                                <use class="c-dashed-line__path" xlink:href="#<?php echo esc_attr($svg_id_3); ?>" mask="url(#<?php echo esc_attr($svg_id_4); ?>)"/>
                                <path class="line-icon" d="M133.2197146747589,28.245636060714716 C132.2768146747589,28.245636060714716 131.50541467475892,29.051636060714728 131.50541467475892,30.036636060714727 C131.50541467475892,31.021636060714727 132.2768146747589,31.827636060714724 133.2197146747589,31.827636060714724 C134.1625146747589,31.827636060714724 134.9340146747589,31.021636060714727 134.9340146747589,30.036636060714727 C134.9340146747589,29.051636060714728 134.1625146747589,28.245636060714716 133.2197146747589,28.245636060714716 zM133.2197146747589,23.76763606071472 C136.0225146747589,23.76763606071472 139.2197146747589,25.970636060714725 139.2197146747589,30.170636060714727 C139.2197146747589,32.839636060714724 137.39391467475892,35.65163606071472 133.74251467475892,38.57963606071472 C133.4339146747589,38.830636060714724 133.00541467475892,38.830636060714724 132.6968146747589,38.57963606071472 C129.04541467475892,35.64263606071472 127.2197146747589,32.839636060714724 127.2197146747589,30.170636060714727 C127.2197146747589,25.970636060714725 130.4168146747589,23.76763606071472 133.2197146747589,23.76763606071472 z"/>
                            </svg>
                            <img src="<?php echo esc_url($image_location); ?>" alt="<?php echo esc_attr($taxonomy->name); ?>">
                        </div>
                    <?php endif; ?>
                    <?php if ($settings['layout'] == 'layout-4'): ?>
                        <div class="thumbnail-location">
                            <img src="<?php echo esc_url($image_location); ?>" alt="<?php echo esc_attr($taxonomy->name); ?>">
                        </div>
                    <?php endif; ?>
                    <div class="content-location">
                        <?php if ($settings['layout'] == 'layout-2' || ($settings['layout'] == 'layout-4')):?>
                            <div class="icon">
                                <i class="<?php echo esc_attr($icon_location); ?>"></i>
                            </div>
                        <?php endif; ?>
                        <span class="location-name"><?php echo esc_attr($taxonomy->name); ?></span>
                        <span class="location-count"><?php echo esc_attr($taxonomy->count) . '&nbsp;'; ?><?php echo 1 < $taxonomy->count ? esc_html__('Tours+', 'zourney') : esc_html__('Tour+', 'zourney'); ?></span>
                        <?php if ($settings['layout'] == 'layout-2' || ($settings['layout'] == 'layout-4')):?>
                            <span class="from">
                                <span><?php echo esc_html__('from', 'zourney') ?></span>
                                <span><?php echo esc_html($from_location); ?></span>
                            </span>
                        <?php endif; ?>
                    </div>
                    <?php if ($settings['layout'] == 'layout-2' && !empty($icon_location)): ?>
                        <svg class="c-dashed-line c-dashed-line-3" width="124" height="104" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <path id="<?php echo esc_attr($svg_id_1); ?>" d="M131.121 2.14949C114.213 0.12276 80.679 5.94452 81.8111 45.4454C83.2263 94.8215 130.787 68.8554 108.435 45.8569C86.0825 22.8583 50.0756 13.667 13.4636 68.9531C-15.8261 113.182 14.4265 189.699 33.2139 222.429"/>
                            </defs>
                            <mask id="<?php echo esc_attr($svg_id_2); ?>">
                                <use class="c-dashed-line__dash" xlink:href="#<?php echo esc_attr($svg_id_1); ?>"/>
                            </mask>
                            <use class="c-dashed-line__path" xlink:href="#<?php echo esc_attr($svg_id_1); ?>" mask="url(#<?php echo esc_attr($svg_id_2); ?>)"/>
                        </svg>
                    <?php endif; ?>

                </a>
            </div>
        </div>
        <?php
    }


    public static function get_taxonomies_arr() {
        $output = array();

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


    private function get_taxonomy_name($taxonomy_slug) {

        $taxonomy = get_term_by('slug', $taxonomy_slug, BABE_Post_types::$taxonomies_list_tax);
        if (!is_wp_error($taxonomy) && !empty($taxonomy)) {
            return BABE_Post_types::$attr_tax_pref . $taxonomy->slug;
        }
        return false;
    }

    private function render_setting_taxonomy() {
        $taxonomies = get_terms(array(
            'taxonomy'   => BABE_Post_types::$taxonomies_list_tax,
            'hide_empty' => false
        ));

        if (!is_wp_error($taxonomies) && !empty($taxonomies)) {
            foreach ($taxonomies as $tax_term) {
                $this->add_control(
                    $tax_term->slug . '_ids',
                    array(
                        'label'       => esc_html__('Ba ', 'zourney') . $tax_term->name,
                        'type'        => \Elementor\Controls_Manager::SELECT2,
                        'multiple'    => true,
                        'options'     => $this->get_taxonomy_arr($this->get_taxonomy_name($tax_term->slug)),
                        'label_block' => true,
                        'condition'   => [
                            'taxonomy_slug'        => $tax_term->slug,
                            '!enable_all_taxonomy' => ''
                        ],
                    )
                );
            }
        }
    }

    public static function get_taxonomy_arr($taxonomy_name) {
        $output = array();

        $taxonomies = get_terms(array(
            'taxonomy'   => $taxonomy_name,
            'hide_empty' => false
        ));

        if (!is_wp_error($taxonomies) && !empty($taxonomies)) {
            foreach ($taxonomies as $tax_term) {
                $output[$tax_term->slug] = apply_filters('translate_text', $tax_term->name);
            }
        }

        return $output;
    }

    protected function add_control_carousel() {
        $this->start_controls_section(
            'section_carousel_options',
            [
                'label' => esc_html__('Carousel Options', 'zourney'),
                'type'  => Controls_Manager::SECTION
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

        //Style arrow
        $this->add_control(
            'style_arrow',
            [
                'label'        => esc_html__('Style Arrow', 'zourney'),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    'style-1' => esc_html__('Style 1', 'zourney'),
                    'style-2' => esc_html__('Style 2', 'zourney')
                ],
                'default'      => 'style-1',
                'prefix_class' => 'arrow-'
            ]
        );

        //add icon next size
        $this->add_responsive_control(
            'icon_size',
            [
                'label'     => esc_html__('Size', 'zourney'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
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

        //add icon next color
        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'zourney'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow:before' => 'color: {{VALUE}};',
                ],
                'separator' => 'after'
            ]
        );

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
        $tablet      = isset($settings['column_tablet']) ? $settings['column_tablet'] : 2;
        return array(
            'navigation'              => $settings['navigation'],
            'autoplayHoverPause'      => $settings['pause_on_hover'] === 'yes' ? true : false,
            'autoplay'                => $settings['autoplay'] === 'yes' ? true : false,
            'autoplaySpeed'           => $settings['autoplay_speed'],
            'items'                   => $settings['column'],
            'items_laptop'            => isset($settings['column_laptop']) ? $settings['column_laptop'] : $settings['column'],
            'items_tablet_extra'      => isset($settings['column_tablet_extra']) ? $settings['column_tablet_extra'] : $settings['column'],
            'items_tablet'            => $tablet,
            'items_mobile_extra'      => isset($settings['column_mobile_extra']) ? $settings['column_mobile_extra'] : $tablet,
            'items_mobile'            => isset($settings['column_mobile']) ? $settings['column_mobile'] : 1,
            'loop'                    => $settings['infinite'] === 'yes' ? true : false,
            'breakpoint_laptop'       => $breakpoints['laptop']->get_value(),
            'breakpoint_tablet_extra' => $breakpoints['tablet_extra']->get_value(),
            'breakpoint_tablet'       => $breakpoints['tablet']->get_value(),
            'breakpoint_mobile_extra' => $breakpoints['mobile_extra']->get_value(),
            'breakpoint_mobile'       => $breakpoints['mobile']->get_value(),
        );
    }

}

