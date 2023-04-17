<?php

if (!defined('ABSPATH')) {
    exit;
}
use Elementor\Controls_Manager;

if (!class_exists('Zourney_Elementor_Section_Parallax')) :
    class Zourney_Elementor_Section_Parallax {
        public function __construct() {
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
            add_action('elementor/element/before_section_end', [$this, 'register_controls'], 10, 3);
            add_action( 'elementor/frontend/section/after_render', [ $this, 'after_render'], 10, 1 );
        }

        /**
         * @param $element
         */
        public function after_render($element) {
            $settings = $element->get_settings();
            if ($element->get_settings('section_parallax_on') == 'yes') {
                $type        = $settings['parallax_type'];
                $and_support = $settings['android_support'];
                $ios_support = $settings['ios_support'];
                $speed       = $settings['parallax_speed'];
                $options     = [
                    'type'        => '' .$type,
                    'speed'       => '' . $speed,
                    'keepImg'     => 'true',
                    'imgSize'     => 'cover',
                    'imgPosition' => '50% 0%',
                    'noAndroid' => $and_support,
                    'noIos' => $ios_support,
                ];
                ?>
                <div class="custom-elementor-parallax" data-id="<?php echo esc_attr($element->get_id()); ?>" data-settings="<?php echo esc_attr(json_encode($options)) ?>"></div>
            <?php }
        }

        /**
         * @param $element \Elementor\Controls_Stack
         * @param $section_id
         * @param $args
         */
        public function register_controls( $element, $section_id, $args ) {
            static $sections = [
                'section_background', /* Section */
            ];

            if ( ! in_array( $section_id, $sections ) ) {
                return;
            }

            $element->add_control(
                'granules_parallax_particles_notice',
                [
                    'raw' => esc_html__( 'NOTICE: Please note that using both Parallax & Particles together on the same section may have side effects - use with care!', 'zourney' ),
                    'type' => Controls_Manager::RAW_HTML,
                    'content_classes' => 'elementor-descriptor',
                ]
            );

            $element->add_control(
                'section_parallax_on',
                [
                    'label' => esc_html__( 'Enable Parallax', 'zourney' ),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => '',
                    'label_on' => 'Yes',
                    'label_off' => 'No',
                    'return_value' => 'yes',
                    'description' => esc_html__( 'Enable to access extra controls.', 'zourney' ),
                ]
            );

            $element->add_responsive_control(
                'parallax_type',
                [
                    'label' => esc_html__( 'Type', 'zourney' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'scroll',
                    'options' => [
                        'scroll' 			=> esc_html__( 'Scroll', 'zourney' ),
                        'scroll-opacity' 	=> esc_html__( 'Scroll + Opacity', 'zourney' ),
                        'opacity' 			=> esc_html__( 'Opacity', 'zourney' ),
                        'scale' 			=> esc_html__( 'Scale', 'zourney' ),
                        'scale-opacity' 	=> esc_html__( 'Scale + Opacity', 'zourney' ),
                    ],
                    'condition' => [
                        'section_parallax_on' => 'yes',
                    ],
                    'description' => esc_html__( 'Set the Parallax type needed - default is Scroll effect.', 'zourney' ),
                ]
            );

            $element->add_control(
                'granules_parallax_speed_notice',
                [
                    'raw' => esc_html__( 'NOTICE: Speed has some caveats - the higher the speed the greater the zoom on the image. Negative speed values will also switch the direction of the movement on scroll!', 'zourney' ),
                    'type' => Controls_Manager::RAW_HTML,
                    'content_classes' => 'elementor-descriptor',
                    'condition' => [
                        'section_parallax_on' => 'yes',
                    ],
                ]
            );

            $element->add_control(
                'parallax_speed',
                [
                    'label' => esc_html__( 'Speed', 'zourney' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 1.2,
                    'description' => esc_html__( 'This should be set between -1 to a max of 2 - Decimal points must be used for fine controls.', 'zourney' ),
                    'condition' => [
                        'section_parallax_on' => 'yes',
                    ],
                ]
            );

            $element->add_control(
                'granules_parallax_mobile_notice',
                [
                    'raw' => esc_html__( 'NOTICE: These options are untested and I would love to hear your feedback on them once you have tried them!', 'zourney' ),
                    'type' => Controls_Manager::RAW_HTML,
                    'content_classes' => 'elementor-descriptor',
                    'condition' => [
                        'section_parallax_on' => 'yes',
                    ],
                ]
            );

            $element->add_control(
                'android_support',
                [
                    'label' => esc_html__( 'Android Support', 'zourney' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'false',
                    'options' => [
                        'false' => esc_html__( 'Enable', 'zourney' ),
                        'true'  => esc_html__( 'Disable', 'zourney' ),
                    ],
                    'condition' => [
                        'section_parallax_on' => 'yes',
                    ],
                    'description' => esc_html__( 'Enable support on Android devices.', 'zourney' ),
                ]
            );

            $element->add_control(
                'ios_support',
                [
                    'label' => esc_html__( 'iOS Support', 'zourney' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'false',
                    'options' => [
                        'false' => esc_html__( 'Enable', 'zourney' ),
                        'true'  => esc_html__( 'Disable', 'zourney' ),
                    ],
                    'condition' => [
                        'section_parallax_on' => 'yes',
                    ],
                    'description' => esc_html__( 'Enable support on iOs devices.', 'zourney' ),
                ]
            );

        }

        public function enqueue_scripts() {
            wp_enqueue_script(
                'jarallax',
                get_theme_file_uri('assets/js/vendor/jarallax.js'),
                [
                    'jquery',
                ]
            );
        }
    }
endif;

return new Zourney_Elementor_Section_Parallax();
