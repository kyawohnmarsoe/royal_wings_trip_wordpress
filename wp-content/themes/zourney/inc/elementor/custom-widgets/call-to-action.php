<?php
use Elementor\Controls_Manager;

add_action('elementor/element/call-to-action/button_style/before_section_end', function ($element, $args) {

    $element->add_control(
        'padding_button_style',
        [
            'label' => esc_html__('Padding', 'zourney'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .elementor-cta__button.elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $element->add_control(
        'style_theme',
        [
            'type' => Controls_Manager::SWITCHER,
            'label' => esc_html__( 'Hover', 'zourney' ),
            'prefix_class'	=> 'style-hover-zourney-theme-'
        ]
    );

    $element->add_control(
        'show_decor',
        [
            'label' => esc_html__( 'Decor', 'zourney' ),
            'type' => Controls_Manager::SWITCHER,
            'prefix_class'  => 'show-decor-'
        ]
    );

    $element->add_control(
        'decor_color',
        [
            'label' => esc_html__( 'Decor Color', 'zourney' ),
            'type' => Controls_Manager::COLOR,
            'selectors'  => [
                '{{WRAPPER}} .elementor-icon-wrapper:before'  => 'background: {{VALUE}}'
            ],
            'condition' => [
                'show_decor!'  => ''
            ]
        ]
    );

}, 10, 2);

add_action('elementor/element/call-to-action/graphic_element_style/before_section_end', function ($element, $args) {

    $element->add_control(
        'show_decor_2',
        [
            'label' => esc_html__('Decor', 'zourney'),
            'type' => Controls_Manager::SWITCHER,
            'prefix_class' => 'show-decor-'
        ]
    );

    $element->add_control(
        'decor_color_2',
        [
            'label' => esc_html__('Decor Color', 'zourney'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-wrapper .elementor-icon i:after' => 'background: {{VALUE}}'
            ],
            'condition' => [
                'show_decor_2!' => ''
            ]
        ]
    );

}  , 10, 2);