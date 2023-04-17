<?php

use Elementor\Controls_Manager;

class Zourney_BABE_Elementor_TaxonomyItem_Widget extends \Elementor\Widget_Base {
    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'taxonomy-item';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Ba Taxonomy Item', 'zourney');

    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-post-info';
    }


    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['book-everything-elements'];
    }

    /**
     * Register widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     */
    protected function register_controls() {

        // Get all terms of categories
        $this->start_controls_section(
            'babe_taxonomy_item',
            [
                'label' => esc_html__('Content', 'zourney'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control('style',
            [
                'label'   => esc_html__('Style', 'zourney'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__('Style 1', 'zourney'),
                    '2' => esc_html__('Style 2', 'zourney'),
                ],
                'default' => '1'
            ]
        );

        $this->add_control(
            'taxonomy_slug',
            [
                'label' => esc_html__('Ba Taxonomies', 'zourney'),

                'type'        => \Elementor\Controls_Manager::SELECT,
                'options'     => $this->get_taxonomies_arr(),
                'label_block' => true,
            ]
        );

        $this->render_setting_taxonomy();


        $this->add_control(
            'image',
            [
                'label'      => esc_html__('Choose Image', 'zourney'),
                'default'    => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'type'       => \Elementor\Controls_Manager::MEDIA,
                'show_label' => false,
                'condition'  => [
                    'style' => '1'
                ]
            ]
        );

        $this->add_control(
            'count_tour',
            [
                'label' => esc_html__('Enable count tour', 'zourney'),
                'type'  => \Elementor\Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'enable_text',
            [
                'label'     => esc_html__('Enable Custom Text', 'zourney'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'condition' => [
                    'style' => '2'
                ]
            ]
        );

        $this->add_control(
            'custom_text',
            [
                'label'     => esc_html__('Custom Text', 'zourney'),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'default'   => 'From <strong>100$</strong>',
                'condition' => [
                    'enable_text!' => '',
                    'style'        => '2'
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_image_style',
            [
                'label'     => esc_html__('Image', 'zourney'),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'style' => '1'
                ],
            ]
        );

        $this->add_control(
            'img_location_radius',
            [
                'label'      => esc_html__('Border Radius', 'zourney'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .location-item .thumbnail-location'       => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .location-item .thumbnail-location img'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .location-item .thumbnail-location:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'img_overflow',
            [
                'label'     => esc_html__('Overflow', 'zourney'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'hidden',
                'options'   => [
                    ''       => esc_html__('Default', 'zourney'),
                    'hidden' => esc_html__('Hidden', 'zourney'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .location-item .thumbnail-location' => 'overflow: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'image_opacity',
            [
                'label'     => esc_html__('Opacity', 'zourney'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .location-item:not(:hover) .thumbnail-location:after' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'image_opacity_hover',
            [
                'label'     => esc_html__('Opacity Hover', 'zourney'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .zourney-location-item-1 .title-location:hover .thumbnail-location:after' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'image_background_overlay',
            [
                'label'     => esc_html__('Background Overlay', 'zourney'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .location-item  .thumbnail-location:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_wrap_style',
            [
                'label'     => esc_html__('Wrapper', 'zourney'),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'style' => '2'
                ]
            ]
        );

        $this->add_responsive_control(
            'wrap_padding',
            [
                'label'      => esc_html__('Padding', 'zourney'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .title-location' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_style',
            [
                'label'     => esc_html__('Icon', 'zourney'),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'style' => '2'
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'icon_typo',
                'selector' => '{{WRAPPER}} i',
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__('Color', 'zourney'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_color_hover',
            [
                'label'     => esc_html__('Color Hover', 'zourney'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title-location:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_style',
            [
                'label' => esc_html__('Content', 'zourney'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_heading',
            [
                'label' => esc_html__('Title', 'zourney'),
                'type'  => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'zourney'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .location-item .title-tours' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'Typography',
                'selector' => '{{WRAPPER}} .location-item .title-tours',
            ]
        );
        $this->add_responsive_control(
            'title_space',
            [
                'label'     => esc_html__('Spacing', 'zourney'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .location-item .title-tours' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'count_heading',
            [
                'label'     => esc_html__('Count', 'zourney'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'count_tour!' => '',
                ]
            ]

        );
        $this->add_control(
            'count_color',
            [
                'label'     => esc_html__('Color', 'zourney'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .location-item  .location-count' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'count_tour!' => '',
                ]
            ]
        );
        $this->add_control(
            'count_background_color',
            [
                'label'     => esc_html__('Background Color', 'zourney'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .location-item  .location-count' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'count_tour!' => '',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'      => 'count_typography',
                'label'     => esc_html__('Count Typography', 'zourney'),
                'selector'  => '{{WRAPPER}} .location-item  .location-count',
                'condition' => [
                    'count_tour!' => '',
                ]
            ]
        );

        $this->add_control(
            'custom_text_color',
            [
                'label'     => esc_html__('Custom Text Color', 'zourney'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .location-item .location-text' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'enable_text!' => ''
                ]
            ]
        );
        $this->add_control(
            'count_location_radius',
            [
                'label'      => esc_html__('Border Radius', 'zourney'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .location-item .location-count' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'      => 'custom_text_typography',
                'label'     => esc_html__('Custom Text Typography', 'zourney'),
                'selector'  => '{{WRAPPER}} .location-item  .location-text',
                'condition' => [
                    'enable_text!' => ''
                ]
            ]
        );

        $this->add_responsive_control(
            'count_padding',
            [
                'label'      => esc_html__('Padding', 'zourney'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .location-item  .location-count' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $settings = $this->get_settings_for_display();

        if (empty($taxonomy_id = $settings[$settings['taxonomy_slug'] . '_id'])) {
            return;
        }


        $this->add_render_attribute('wrapper', 'class', 'elementor-location-wrapper zourney-location-item zourney-location-item-' . $settings['style']);

        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';

        $taxonomy = get_term_by('slug', $taxonomy_id, $this->get_taxonomy_name($settings['taxonomy_slug']));
        if (!is_wp_error($taxonomy) && !empty($taxonomy)) {
            if ($taxonomy->parent == 0 && $taxonomy->count == 0) {
                $taxonomy->count = $this->get_count_tax_parent($taxonomy->term_id);
            }

            $this->render_taxonomy_item($taxonomy);
        }
        echo '</div>';

    }

    public function render_taxonomy_item($taxonomy) { ?>
        <?php $settings = $this->get_settings_for_display(); ?>
        <?php

        if (!empty($settings['image']['url'])) {
            $image_location = $settings['image']['url'];
        } elseif (empty($image_location = get_term_meta($taxonomy->term_id, 'zourney_location_image', true))) {
            $image_location = Elementor\Utils::get_placeholder_image_src();
        }
        ?>
        <div class="location-item">
            <a class="title-location" href="<?php echo esc_url(get_term_link($taxonomy->slug, $this->get_taxonomy_name($settings['taxonomy_slug']))); ?>">
                <?php if ($settings['style'] == '1'): ?>
                    <div class="thumbnail-location">
                        <img src="<?php echo esc_url($image_location); ?>" alt="<?php echo esc_attr($taxonomy->name); ?>">
                    </div>
                <?php endif; ?>
                <div class="content-location">
                    <?php if ($settings['style'] == '2') {
                        $fa_class = get_term_meta($taxonomy->term_id, 'fa_class', true);
                        if (!empty($fa_class)) {
                            echo '<i class="' . esc_attr($fa_class) . '"></i>';
                        }

                    } ?>
                    <h2 class="title-tours"><?php echo esc_attr($taxonomy->name); ?></h2>
                    <div class="taxonomy-infor">
                        <?php if ($settings['count_tour']): ?>
                            <div class="location-count"><?php echo esc_attr($taxonomy->count); ?>
                                &nbsp;<?php echo (1<$taxonomy->count)? esc_html__('Tours', 'zourney') : esc_html__('Tour', 'zourney'); ?></div>
                        <?php endif; ?>
                        <?php if ($settings['enable_text']):
                                printf('<div class="location-count">%s</div>', $settings['custom_text']);
                        endif; ?>
                    </div>

                </div>
            </a>
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

    private function render_setting_taxonomy() {
        $taxonomies = get_terms(array(
            'taxonomy'   => BABE_Post_types::$taxonomies_list_tax,
            'hide_empty' => false
        ));

        if (!is_wp_error($taxonomies) && !empty($taxonomies)) {
            foreach ($taxonomies as $tax_term) {
                $this->add_control(
                    $tax_term->slug . '_id',
                    array(
                        'label'       => esc_html__('Ba ', 'zourney') . $tax_term->name,
                        'type'        => \Elementor\Controls_Manager::SELECT2,
                        'multiple'    => false,
                        'options'     => $this->get_taxonomy_arr($this->get_taxonomy_name($tax_term->slug)),
                        'label_block' => true,
                        'condition'   => [
                            'taxonomy_slug' => $tax_term->slug,
                        ],
                    )
                );
            }
        }
    }

    private function get_taxonomy_name($taxonomy_slug) {

        $default_lang = BABE_Functions::get_default_language();
        $current_lang = BABE_Functions::get_current_language();
        if ( BABE_Functions::is_wpml_active() && $current_lang !== $default_lang ){
            do_action( 'wpml_switch_language', $default_lang );
            $taxonomy = get_term_by( 'slug', $taxonomy_slug, BABE_Post_types::$taxonomies_list_tax );
            do_action( 'wpml_switch_language', $current_lang );
        }else{
            $taxonomy = get_term_by('slug', $taxonomy_slug, BABE_Post_types::$taxonomies_list_tax);
        }

        if (!is_wp_error($taxonomy) && !empty($taxonomy)) {
            return BABE_Post_types::$attr_tax_pref . $taxonomy->slug;
        }
        return false;
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

    public function get_count_tax_parent($parent_id) {
        $settings = $this->get_settings_for_display();

        $parent = get_terms(array(
            'taxonomy'   => BABE_Post_types::$attr_tax_pref . $settings['taxonomy_slug']->slug,
            'hide_empty' => false,
            'pad_counts' => true,
            'parent'     => $parent_id
        ));
        $count  = 0;

        if (!is_wp_error($parent) && !empty($parent)) {
            foreach ($parent as $item) {
                $count += $item->count;
            }
        }
        return $count;
    }


}

