<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('Zourney_Customize')) {

    class Zourney_Customize {


        public function __construct() {
            add_action('customize_register', array($this, 'customize_register'));
        }

        /**
         * @param $wp_customize WP_Customize_Manager
         */
        public function customize_register($wp_customize) {

            /**
             * Theme options.
             */

            $this->init_zourney_blog($wp_customize);

            $this->init_zourney_social($wp_customize);

            do_action('zourney_customize_register', $wp_customize);
        }


        /**
         * @param $wp_customize WP_Customize_Manager
         *
         * @return void
         */
        public function init_zourney_blog($wp_customize) {

            $wp_customize->add_section('zourney_blog_archive', array(
                'title' => esc_html__('Blog', 'zourney'),
            ));

            // =========================================
            // Select Style
            // =========================================

            $wp_customize->add_setting('zourney_options_blog_style', array(
                'type'              => 'option',
                'default'           => 'standard',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('zourney_options_blog_style', array(
                'section' => 'zourney_blog_archive',
                'label'   => esc_html__('Blog style', 'zourney'),
                'type'    => 'select',
                'choices' => array(
                    'standard' => esc_html__('Blog Standard', 'zourney'),
                    'grid'     => esc_html__('Blog Grid', 'zourney'),
                    'list'     => esc_html__('Blog List', 'zourney'),
                    'overlay'  => esc_html__('Blog Overlay', 'zourney'),
                ),
            ));

            $wp_customize->add_setting('zourney_options_back_to_top', array(
                'type'              => 'option',
                'default'           => true,
                'sanitize_callback' => 'zourney_sanitize_checkbox',
            ));

            $wp_customize->add_control( 'zourney_options_back_to_top', array(
                'label'      => esc_html__( 'Display Back To Top', 'zourney' ),
                'section'    => 'title_tagline',
                'type'       => 'checkbox',
                'priority'        => '100'
            ) );
        }

        /**
         * @param $wp_customize WP_Customize_Manager
         *
         * @return void
         */
        public function init_zourney_social($wp_customize) {

            $wp_customize->add_section('zourney_social', array(
                'title' => esc_html__('Socials', 'zourney'),
            ));
            $wp_customize->add_setting('zourney_options_social_share', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('zourney_options_social_share', array(
                'type'    => 'checkbox',
                'section' => 'zourney_social',
                'label'   => esc_html__('Show Social Share', 'zourney'),
            ));
            $wp_customize->add_setting('zourney_options_social_share_facebook', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('zourney_options_social_share_facebook', array(
                'type'    => 'checkbox',
                'section' => 'zourney_social',
                'label'   => esc_html__('Share on Facebook', 'zourney'),
            ));
            $wp_customize->add_setting('zourney_options_social_share_twitter', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('zourney_options_social_share_twitter', array(
                'type'    => 'checkbox',
                'section' => 'zourney_social',
                'label'   => esc_html__('Share on Twitter', 'zourney'),
            ));

            $wp_customize->add_setting('zourney_options_social_share_linkedin', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('zourney_options_social_share_linkedin', array(
                'type'    => 'checkbox',
                'section' => 'zourney_social',
                'label'   => esc_html__('Share on Linkedin', 'zourney'),
            ));
            $wp_customize->add_setting('zourney_options_social_share_google-plus', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('zourney_options_social_share_google-plus', array(
                'type'    => 'checkbox',
                'section' => 'zourney_social',
                'label'   => esc_html__('Share on Google+', 'zourney'),
            ));

            $wp_customize->add_setting('zourney_options_social_share_pinterest', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('zourney_options_social_share_pinterest', array(
                'type'    => 'checkbox',
                'section' => 'zourney_social',
                'label'   => esc_html__('Share on Pinterest', 'zourney'),
            ));
        }

    }
}
return new Zourney_Customize();
