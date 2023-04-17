<?php
use Elementor\Controls_Manager;

add_action( 'elementor/element/counter/section_counter/before_section_end', function ($element, $args ) {

    $element->add_control(
        'position',
        [
            'label'        => __('Alignment', 'zourney'),
            'type'         => Controls_Manager::CHOOSE,
            'options'      => [
                'left' => [
                    'title' => __('Left', 'zourney'),
                    'icon'  => 'eicon-text-align-left',
                ],
                'center'     => [
                    'title' => __('Center', 'zourney'),
                    'icon'  => 'eicon-text-align-center',
                ],
                'right'   => [
                    'title' => __('Right', 'zourney'),
                    'icon'  => 'eicon-text-align-right',
                ]
            ],
            'toggle'       => false,
            'prefix_class' => 'elementor-position-',
            'default'      => 'center',
            'selectors'    => [
                '{{WRAPPER}} .elementor-counter' => 'text-align: {{VALUE}}',
            ],
        ]
    );

}, 10, 2 );
