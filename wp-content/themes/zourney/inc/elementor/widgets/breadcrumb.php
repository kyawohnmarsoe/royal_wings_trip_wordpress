<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Zourney_Elementor_Breadcrumb extends Elementor\Widget_Base {

    public function get_name() {
        return 'zourney-breadcrumb';
    }

    public function get_title() {
        return esc_html__('Zourney Breadcrumbs', 'zourney');
    }

    public function get_icon() {
        return 'eicon-product-breadcrumbs';
    }

    public function get_keywords() {
        return ['breadcrumbs'];
    }

    public function get_categories() {
        return array('zourney-addons');
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_product_rating_style',
            [
                'label' => esc_html__('Style Breadcrumbs', 'zourney'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'wc_style_warning',
            [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => esc_html__('The style of this widget is often affected by your theme and plugins. If you experience any such issue, try to switch to a basic theme and deactivate related plugins.', 'zourney'),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => esc_html__('Text Color', 'zourney'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .breadcrumb' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label'     => esc_html__('Link Color', 'zourney'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .breadcrumb a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'link_color_hover',
            [
                'label'     => esc_html__('Link Color Hover', 'zourney'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .breadcrumb a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'text_typography',
                'selector' => '{{WRAPPER}} .breadcrumb',
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label'     => esc_html__('Alignment', 'zourney'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__('Left', 'zourney'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'zourney'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'zourney'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .breadcrumb'    => 'text-align: {{VALUE}}',
                    '{{WRAPPER}} .zourney-title' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_product_rating_style_title',
            [
                'label' => esc_html__('Style Title', 'zourney'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_color_title',
            [
                'label'     => esc_html__('Title Color', 'zourney'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .zourney-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .zourney-title',
            ]
        );

        $this->add_control(
            'display_title',
            [
                'label'        => esc_html__('Hidden Title', 'zourney'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'prefix_class' => 'hidden-zourney-title-',
            ]
        );

        $this->add_control(
            'display_title_single',
            [
                'label'        => esc_html__('Hidden Title Single', 'zourney'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'prefix_class' => 'hidden-zourney-title-single-'
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => esc_html__('Margin', 'zourney'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .zourney-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();
    }

    protected function render() {
        ?>
        <div class="breadcrumb" typeof="BreadcrumbList" vocab="https://schema.org/">
            <h1 class="zourney-title">
                <?php
                if (is_page() || is_single()) {
                    the_title();
                } elseif (is_archive() && is_tax() && !is_category() && !is_tag()) {
                    $tax_object = get_queried_object();
                    echo esc_html($tax_object->name);
                } elseif (is_category()) {
                    single_cat_title();
                } elseif (is_home()) {
                    echo esc_html__('Our Blog', 'zourney');
                } elseif (is_post_type_archive()) {
                    $tax_object = get_queried_object();
                    echo esc_html($tax_object->label);
                } elseif (is_tag()) {
                    // Get tag information
                    $term_id  = get_query_var('tag_id');
                    $taxonomy = 'post_tag';
                    $args     = 'include=' . esc_attr($term_id);
                    $terms    = get_terms($taxonomy, $args);
                    // Display the tag name
                    if (isset($terms[0]->name)) {
                        echo esc_html($terms[0]->name);
                    }
                } elseif (is_day()) {
                    echo esc_html__('Day Archives', 'zourney');
                } elseif (is_month()) {
                    echo get_the_time('F') . esc_html__(' Archives', 'zourney');
                } elseif (is_year()) {
                    echo get_the_time('Y') . esc_html__(' Archives', 'zourney');
                } elseif (is_search()) {
                    esc_html_e('Search Results', 'zourney');
                } elseif (is_author()) {
                    global $author;
                    if (!empty($author)) {
                        $usermetadata = get_userdata($author);
                        echo esc_html__('Author', 'zourney') . ': ' . $usermetadata->display_name;
                    }
                }
                ?>
            </h1>
            <?php
            if (zourney_is_bcn_nav_activated()) {
                bcn_display();
            }
            ?>
        </div>
        <?php
    }
}

$widgets_manager->register(new Zourney_Elementor_Breadcrumb());
