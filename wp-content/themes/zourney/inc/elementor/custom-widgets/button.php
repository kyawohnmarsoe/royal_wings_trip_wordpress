<?php
// Button
use Elementor\Controls_Manager;

add_action( 'elementor/element/button/section_style/after_section_end', function ($element, $args ) {

    $element->update_control(
        'background_color',
        [
            'global' => [
                'default' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-button' => ' background-color: {{VALUE}};',
            ],
        ]
    );
}, 10, 2 );

add_action('elementor/element/button/section_style/before_section_end', function ($element, $args) {
    $element->add_control(
        'icon_button_size',
        [
            'label' => esc_html__('Icon Size', 'zourney'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 6,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-button .elementor-button-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'selected_icon[value]!' => '',
            ],
        ]
    );
    $element->add_control(
        'button_icon_color',
        [
            'label'     => esc_html__('Icon Color', 'zourney'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .elementor-button .elementor-button-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
            ],
            'condition' => [
                'selected_icon[value]!' => '',
            ],
        ]
    );
}, 10, 2);

add_action('elementor/element/button/section_button/after_section_start', function ($element, $args) {

    $element->add_control(
        'button_typo',
        [
            'label' => esc_html__( 'Typo', 'zourney' ),
            'type' => Controls_Manager::SELECT,
            'default' => '',
            'options' => [
                '' => esc_html__( 'Default', 'zourney' ),
                'border' => esc_html__( 'Border', 'zourney' ),
                'link' => esc_html__( 'Link', 'zourney' ),
            ],
            'prefix_class' => 'elementor-button-typo-',
        ]
    );

}, 10, 2);