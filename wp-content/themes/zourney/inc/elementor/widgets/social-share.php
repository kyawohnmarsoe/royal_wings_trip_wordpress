<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Zourney_Elementor_Social_Share extends Elementor\Widget_Base {

    public function get_name() {
        return 'zourney-social-share';
    }

    public function get_title() {
        return esc_html__('Zourney Social Share', 'zourney');
    }

    public function get_icon() {
        return 'eicon-share';
    }

    public function get_categories() {
        return array('zourney-addons');
    }

    protected function register_controls() {
    }

    protected function render() {
        zourney_social_share();
    }
}

$widgets_manager->register(new Zourney_Elementor_Social_Share());
