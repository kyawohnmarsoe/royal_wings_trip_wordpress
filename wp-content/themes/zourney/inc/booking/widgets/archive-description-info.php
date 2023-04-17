<?php

use Elementor\Controls_Manager;

/**
 * Add widget all-items to Elementor
 *
 * @since   1.3.13
 */
class Zourney_Elementor_BA_Archive_Booking_Description_Info extends \Elementor\Widget_Base {
    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'babe-description-info';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('BA Archive Description Info', 'zourney');
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['book-everything-elements'];
    }

    protected function register_controls() {

    }


    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     */
    protected function render() {

        if (\Elementor\Plugin::instance()->editor->is_edit_mode()) {
            echo esc_html__('BA Archive Description Info', 'zourney');
        } else {
            $object = get_queried_object();
            if (!empty($object) && (isset($object->taxonomy) && Zourney_BA_Booking::check_taxonomy($object->taxonomy))) {
                $this->render_taxonomy_content($object->term_id);
            }
        }
    }

    private function render_taxonomy_content($tax_ID) {
        $term_data = get_term_meta($tax_ID, 'zourney_description_info', true);
        if ($term_data && !empty($term_data)) {
            echo '<div class="elementor-widget-inner">';
            echo esc_html($term_data);
            echo '</div>';
        }
    }
}
