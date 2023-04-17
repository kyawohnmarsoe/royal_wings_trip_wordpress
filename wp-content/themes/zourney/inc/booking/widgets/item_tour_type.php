<?php
/**
 * Add widget Duration to Elementor
 *
 * @since   1.0.0
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Zourney_BABE_Elementor_Itemtourtype_Widget extends \Elementor\Widget_Base
{

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'babe-item-tour-type';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('Detail Tour Type', 'zourney');
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
        return ['type', 'tour'];
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['book-everything-elements'];
    }

    /**
     * Register widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     */
    protected function register_controls()
    {

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('General', 'zourney'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'zourney'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Tour Type', 'zourney')
            ]
        );

        $this->add_control(
            'taxonomy_slug',
            array(
                'label' => esc_html__('Ba Taxonomies', 'zourney'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'multiple' => true,
                'options' => $this->get_taxonomies_arr(),
                'label_block' => true,
            )
        );

        $this->end_controls_section();

        $this->add_control_style_wrapper();

        // Content
        $this->start_controls_section(
            'section_content_style',
            [
                'label' => esc_html__('Content', 'zourney'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_style',
            [
                'label' => esc_html__('Title', 'zourney'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'zourney'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .babe-section-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .babe-section-title',
            ]
        );

        $this->add_responsive_control(
            'content_spacing',
            [
                'label' => esc_html__('Spacing', 'zourney'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .babe-section-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'text_style',
            [
                'label' => esc_html__('Text', 'zourney'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Color', 'zourney'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item-meta-value' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .item-meta-value',
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Render widget output on the frontend.
     * Written in PHP and used to generate the final HTML.
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['taxonomy_slug'])) {
            return;
        }

        $taxonomy = BABE_Post_types::$attr_tax_pref . $settings['taxonomy_slug'];
        if (!taxonomy_exists($taxonomy)) {
            return;
        }

        if (\Elementor\Plugin::instance()->editor->is_edit_mode()) {
            $post_id = zourney_ba_get_default_single_id();
        } else {
            $post_id = get_the_ID();
        }

        $babe_post = get_post($post_id);


        if (is_single() && $babe_post->post_type == BABE_Post_types::$booking_obj_post_type) {
            ?>
            <div class="elementor-widget-inner">
                <div class="meta-field-inner">
                    <div class="item_info">
                        <?php
                        if (isset($settings['title']) && !empty($settings['title'])) {
                            echo '<div class="babe-section-title">' . esc_html($settings['title']) . '</div>';
                        }
                        echo '<div class="item-term item-meta-value">';
                        echo get_the_term_list($post_id, BABE_Post_types::$attr_tax_pref . $settings['taxonomy_slug'], '', ', ');
                        echo '</div>';
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }

    }

    private function render_icon($settings)
    {
        $migrated = isset($settings['__fa4_migrated']['duration_icon']);
        if (!empty($settings['duration_icon']['value'])) {
            ?>
            <div class="item_icon">
                <?php \Elementor\Icons_Manager::render_icon($settings['duration_icon'], ['aria-hidden' => 'true']); ?>
            </div>
            <?php
        }
    }

    protected function add_control_style_wrapper($condition = array())
    {
        $this->start_controls_section(
            'section_style_wrapper',
            [
                'label' => esc_html__('Wrapper', 'zourney'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,

            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label' => esc_html__('Padding', 'zourney'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_margin',
            [
                'label' => esc_html__('Margin', 'zourney'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wrapper_bg_color',
            [
                'label' => esc_html__('Background Color', 'zourney'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-inner' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'wrapper_border',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .elementor-widget-inner',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'wrapper_border_hover',
            [
                'label' => esc_html__('Border Hover Color', 'zourney'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-inner:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'wrapper_radius',
            [
                'label' => esc_html__('Border Radius', 'zourney'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrapper_box_shadow',
                'selector' => '{{WRAPPER}} .elementor-widget-inner',
            ]
        );

        $this->end_controls_section();
    }

    public static function get_taxonomies_arr()
    {
        $output = array();

        $taxonomies = get_terms(array(
            'taxonomy' => BABE_Post_types::$taxonomies_list_tax,
            'hide_empty' => false
        ));

        if (!is_wp_error($taxonomies) && !empty($taxonomies)) {
            foreach ($taxonomies as $tax_term) {
                $output[$tax_term->slug] = apply_filters('translate_text', $tax_term->name);
            }
        }

        return $output;

    }

}
