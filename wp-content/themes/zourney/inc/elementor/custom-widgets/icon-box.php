<?php
//icon list
use Elementor\Controls_Manager;

add_action( 'elementor/element/icon-box/section_style_icon/before_section_end', function ($element, $args ) {
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
                '{{WRAPPER}} .elementor-icon-box-icon .elementor-icon:after'  => 'background: {{VALUE}}'
            ],
            'condition' => [
                'show_decor!'  => ''
            ]
        ]
    );

    $element->add_control(
        'decor_horizontal',
        [
            'label' => esc_html__( 'Horizontal', 'zourney' ),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => -15,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-box-icon .elementor-icon:after' => 'left: {{SIZE}}{{UNIT}}',
            ],
            'condition' => [
                'show_decor!'  => ''
            ]
        ]
    );

    $element->add_control(
        'decor_vertical',
        [
            'label' => esc_html__( 'Vertical', 'zourney' ),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => -10,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-box-icon .elementor-icon:after' => 'top: {{SIZE}}{{UNIT}}',
            ],
            'condition' => [
                'show_decor!'  => ''
            ]
        ]
    );
},10,2);
