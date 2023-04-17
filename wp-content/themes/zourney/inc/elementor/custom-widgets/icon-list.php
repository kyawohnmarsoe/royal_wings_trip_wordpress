<?php
//icon list
use Elementor\Controls_Manager;

add_action( 'elementor/element/icon-list/section_icon_style/before_section_end', function ($element, $args ) {
    $element->add_responsive_control(
        'rotate',
        [
            'label' => esc_html__( 'Rotate', 'zourney' ),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'deg' ],
            'default' => [
                'size' => 0,
                'unit' => 'deg',
            ],
            'tablet_default' => [
                'unit' => 'deg',
            ],
            'mobile_default' => [
                'unit' => 'deg',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-list-icon i, {{WRAPPER}} .elementor-icon-list-icon svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
            ],
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
},10,2);
