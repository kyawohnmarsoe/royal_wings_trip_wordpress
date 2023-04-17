<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class Zourney_Elementor_Login extends Elementor\Widget_Base{

    public function get_name() {
        return 'zourney-login';
    }
    public function get_title() {
        return esc_html__('Zourney Login', 'zourney');
    }
    public function get_icon() {
        return 'eicon-lock-user';
    }
    public function get_categories()
    {
        return array('zourney-addons');
    }

    public function get_style_depends() {
        return ['magnific-popup'];
    }

    public function get_script_depends() {
        return ['magnific-popup', 'zourney-elementor-login'];
    }

    protected function register_controls(){
        $this->start_controls_section(
            'login_content',
            [
                'label' => esc_html__('Content', 'zourney'),
            ]
        );

        $this->add_control(
            'layout_style',
            [
                'label' => esc_html__('Style', 'zourney'),
                'type' => Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => 'Style 1',
                    '2' => 'Style 2',
                ],
                'prefix_class' => 'style-',
            ]
        );

        $this->end_controls_section();

        $this -> start_controls_section(
            'login-style',
            [
                'label' => esc_html__('Icon','zourney'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'size',
            [
                'label' => esc_html__( 'Size', 'zourney' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .login-action > div > a i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__( 'Color', 'zourney' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-login-wrapper .login-action > div a i:not(:hover)' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-login-wrapper .login-action > div a:not(:hover):before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-login-wrapper .login-action > div a .login-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label'     => esc_html__( 'Color Hover', 'zourney' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-login-wrapper .login-action > div a i:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-login-wrapper .login-action > div a:hover:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-login-wrapper .login-action > div a:hover .login-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

    }
    protected function render(){
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute( 'wrapper', 'class', 'elementor-login-wrapper' );

        $account_link = wp_login_url();

        if ( zourney_is_ba_booking_activated() ) {
            $account_page = intval(BABE_Settings::$settings['my_account_page']);
            $account_link = get_the_permalink($account_page);
        }
        ?>
        <div <?php echo zourney_elementor_get_render_attribute_string('wrapper', $this);?>>
            <div class="login-action">
                <div class="site-header-account">
                    <?php if (!is_user_logged_in()) { ?>
                        <a class="group-button popup js-btn-register-popup" href="#zourney-login-form"><div class="login-icon"><i class="zourney-icon-login"></i></div><div class="login-title">Log In / Register</div></a>
                    <?php } else {
                        ?>
                        <a class="group-button login" href="<?php echo esc_url($account_link); ?>"> <?php echo get_avatar(get_the_author_meta('ID'), 30); ?> </a>
                        <div class="account-dropdown"></div>
                        <?php
                    } ?>
                </div>
            </div>
        </div>
        <?php
    }

}
$widgets_manager->register(new Zourney_Elementor_Login());
