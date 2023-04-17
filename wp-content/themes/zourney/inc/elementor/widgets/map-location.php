<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if(!zourney_is_ba_booking_activated()){
    return;
}

class Zourney_Map_Location extends Elementor\Widget_Base
{

    public function get_name()
    {
        return 'zourney-map-location';
    }

    public function get_title()
    {
        return esc_html__('Zourney Map Location', 'zourney');
    }

    public function get_categories()
    {
        return array('zourney-addons');
    }

    public function get_icon()
    {
        return 'eicon-image-hotspot';
    }

    protected function register_controls()
    {

        $this->start_controls_section('map_location_image_section',
            [
                'label' => esc_html__('Image', 'zourney'),
            ]
        );

        $this->add_control('map_location_image',
            [
                'label' => esc_html__('Choose Image', 'zourney'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'label_block' => true
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'background_image', // Actually its `image_size`.
                'default' => 'full'
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section('map_location_icons_settings',
            [
                'label' => esc_html__('Location', 'zourney'),
            ]
        );
        $repeater = new Elementor\Repeater();

        $repeater->add_responsive_control('zourney_map_location_main_horizontal_position',
            [
                'label' => esc_html__('Horizontal Position', 'zourney'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'default' => [
                    'size' => 50,
                    'unit' => '%'
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.zourney-map-location-content' => 'left: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $repeater->add_responsive_control('zourney_map_location_main_vertical_position',
            [
                'label' => esc_html__('Vertical Position', 'zourney'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'default' => [
                    'size' => 50,
                    'unit' => '%'
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.zourney-map-location-content' => 'top: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $repeater->add_control('zourney_map_location_icon',
            [
                'label' => esc_html__('Icon', 'zourney'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-circle',
                    'library' => 'fa-solid',
                ],
            ]);

        $repeater->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Font Size', 'zourney'),
                'type' => Controls_Manager::SLIDER,
                'range' => [

                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .zourney-map-location-icon .icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_control('zourney_map_location_title',
            [
                'label' => esc_html__('Title', 'zourney'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]);

        $repeater->add_control(
            'taxonomy_slug',
            [
                'label' => esc_html__('Ba Taxonomies', 'zourney'),

                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_taxonomies_arr(),
                'label_block' => true,
            ]
        );


        $this->render_setting_taxonomy($repeater);


        $this->add_control('map_location_icons',
            [
                'label' => esc_html__('Location', 'zourney'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Icon', 'zourney'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_icon_social_style');

        $this->start_controls_tab(
            'tab_icon_social_normal',
            [
                'label' => esc_html__('Normal', 'zourney'),
            ]
        );

        $this->add_control(
            'color_icon_social',
            [
                'label' => esc_html__('Color', 'zourney'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .zourney-map-location-icon .icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_social_hover',
            [
                'label' => esc_html__('Hover', 'zourney'),
            ]
        );

        $this->add_control(
            'color_icon_social_hover',
            [
                'label' => esc_html__('Color', 'zourney'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .zourney-map-location-icon:hover .icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $image_src = $settings['map_location_image'];
        $image_src_size = Group_Control_Image_Size::get_attachment_image_src($image_src['id'], 'background_image', $settings);
        if (empty($image_src_size)) $image_src_size = $image_src['url'];
        ?>

        <div class="zourney-map-location-container">
            <img class="zourney-addons-map-location" alt="Background" src="<?php echo esc_url($image_src_size); ?>">
            <?php foreach ($settings['map_location_icons'] as $index => $item) { ?>
                <?php
                $class_item = 'elementor-repeater-item-' . $item['_id'];
                $tab_title_setting_key = $this->get_repeater_setting_key('tab_title', 'tabs', $index);
                $this->add_render_attribute($tab_title_setting_key, [
                    'class' => ['zourney-map-location-content', $class_item],
                ]);

                if (empty($taxonomy_id = $item[$item['taxonomy_slug'] . '_id'])) {
                    return;
                }

                $taxonomy = get_term_by('slug', $taxonomy_id, $this->get_taxonomy_name($item['taxonomy_slug']));
                if (!is_wp_error($taxonomy) && !empty($taxonomy)) {
                    if ($taxonomy->parent == 0 && $taxonomy->count == 0) {
                        $taxonomy->count = $this->get_count_tax_parent($taxonomy->term_id);
                    } ?>
                    <div <?php echo zourney_elementor_get_render_attribute_string($tab_title_setting_key, $this); ?>>
                        <div class="zourney-map-location-icon">
                            <?php if (!empty($item['zourney_map_location_title'])){ ?>
                                <span class="title"><?php printf('%s', $item['zourney_map_location_title']); ?></span>
                            <?php }else{ ?>
                                <span class="title"><?php printf('%s', $taxonomy->name); ?></span>
                            <?php } ?>

                            <a class="icon"
                               href="<?php echo esc_url(get_term_link($taxonomy->slug, $this->get_taxonomy_name($item['taxonomy_slug']))); ?>">
                                <span class="count"><?php echo esc_html($taxonomy->count); ?></span>
                                <?php Icons_Manager::render_icon($item['zourney_map_location_icon'], ['aria-hidden' => 'true']); ?>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>

        <?php
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

    private function render_setting_taxonomy($repeater)
    {

        $taxonomies = get_terms(array(
            'taxonomy' => BABE_Post_types::$taxonomies_list_tax,
            'hide_empty' => false
        ));

        if (!is_wp_error($taxonomies) && !empty($taxonomies)) {
            foreach ($taxonomies as $tax_term) {
                $repeater->add_control(
                    $tax_term->slug . '_id',
                    array(
                        'label' => esc_html__('Ba ', 'zourney') . $tax_term->name,
                        'type' => \Elementor\Controls_Manager::SELECT2,
                        'multiple' => false,
                        'options' => $this->get_taxonomy_arr($this->get_taxonomy_name($tax_term->slug)),
                        'label_block' => true,
                        'condition' => [
                            'taxonomy_slug' => $tax_term->slug,
                        ],
                    )
                );
            }
        }
    }

    private function get_taxonomy_name($taxonomy_slug)
    {

        $default_lang = BABE_Functions::get_default_language();
        $current_lang = BABE_Functions::get_current_language();
        if (BABE_Functions::is_wpml_active() && $current_lang !== $default_lang) {
            do_action('wpml_switch_language', $default_lang);
            $taxonomy = get_term_by('slug', $taxonomy_slug, BABE_Post_types::$taxonomies_list_tax);
            do_action('wpml_switch_language', $current_lang);
        } else {
            $taxonomy = get_term_by('slug', $taxonomy_slug, BABE_Post_types::$taxonomies_list_tax);
        }

        if (!is_wp_error($taxonomy) && !empty($taxonomy)) {
            return BABE_Post_types::$attr_tax_pref . $taxonomy->slug;
        }
        return false;
    }

    public static function get_taxonomy_arr($taxonomy_name)
    {
        $output = array();

        $taxonomies = get_terms(array(
            'taxonomy' => $taxonomy_name,
            'hide_empty' => false
        ));

        if (!is_wp_error($taxonomies) && !empty($taxonomies)) {
            foreach ($taxonomies as $tax_term) {
                $output[$tax_term->slug] = apply_filters('translate_text', $tax_term->name);
            }
        }

        return $output;
    }

    public function get_count_tax_parent($parent_id)
    {
        $settings = $this->get_settings_for_display();

        $parent = get_terms(array(
            'taxonomy' => BABE_Post_types::$attr_tax_pref . $settings['taxonomy_slug']->slug,
            'hide_empty' => false,
            'pad_counts' => true,
            'parent' => $parent_id
        ));
        $count = 0;

        if (!is_wp_error($parent) && !empty($parent)) {
            foreach ($parent as $item) {
                $count += $item->count;
            }
        }
        return $count;
    }

}

$widgets_manager->register(new Zourney_Map_Location());
