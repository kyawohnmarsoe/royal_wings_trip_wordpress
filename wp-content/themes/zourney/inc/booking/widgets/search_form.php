<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Zourney_BABE_Elementor_Searchform_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'babe-search-form';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('BA Search form', 'zourney');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-site-search';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['search'];
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['book-everything-elements'];
    }


    public function get_script_depends() {
        return ['zourney-ba-search-form.js'];
    }


    /**
     * Register widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     */
    protected function register_controls() {

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'taxonomy_slug',
            array(
                'label'       => esc_html__('Ba Taxonomies', 'zourney'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'multiple'    => true,
                'options'     => $this->get_taxonomies_arr(),
                'label_block' => true,
            )
        );

        $repeater->add_control(
            'taxonomy_title',
            [
                'label'       => esc_html__('Taxonomy Title', 'zourney'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__('Title Item', 'zourney'),
                'default'     => esc_html__('Title Item', 'zourney'),
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'taxonomy_subtitle',
            [
                'label'       => esc_html__('Taxonomy Sub Title', 'zourney'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__('Sub Title', 'zourney'),
                'default'     => esc_html__('Sub Title', 'zourney'),
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'taxonomy_icon',
            [
                'label' => esc_html__('Icon', 'zourney'),
                'type'  => \Elementor\Controls_Manager::ICONS,
            ]
        );


        // Get all terms of categories
        $this->start_controls_section(
            'babe_taxonomies',
            array(
                'label' => esc_html__('Content', 'zourney'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'style_arrow',
            [
                'label'        => esc_html__('Choose Layout', 'zourney'),
                'type'         => \Elementor\Controls_Manager::SELECT,
                'options'      => [
                    'style-1' => esc_html__('Horizontal', 'zourney'),
                    'style-2' => esc_html__('Vertical', 'zourney')
                ],
                'default'      => 'style-1',
                'prefix_class' => 'layout-'
            ]
        );

        $this->add_control(
            'sort',
            [
                'label'   => esc_html__('Filter by', 'zourney'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'title',
                'options' => [
                    'title'  => esc_html__('Title', 'zourney'),
                    'price'  => esc_html__('Price', 'zourney'),
                    'rating' => esc_html__('Rating', 'zourney'),
                ],
            ]
        );

        $this->add_control(
            'sort_by',
            [
                'label'   => esc_html__('Sort by', 'zourney'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'asc',
                'options' => [
                    'asc'  => esc_html__('ASC', 'zourney'),
                    'desc' => esc_html__('DESC', 'zourney'),
                ],
            ]
        );

        $this->add_control(
            'taxonomy_search',
            [
                'label'  => esc_html__('Taxonomy Search', 'zourney'),
                'type'   => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->end_controls_section();

        /// Date Config//
        $this->start_controls_section(
            'babe_date',
            array(
                'label' => esc_html__('Date', 'zourney'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'date',
            array(
                'label'     => esc_html__('Show Date', 'zourney'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_on'  => 'Show',
                'label_off' => 'Hide'
            )
        );

        $this->add_control(
            'date_title',
            array(
                'label'     => esc_html__('Date title', 'zourney'),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'default'   => esc_html__('When', 'zourney'),
                'condition' => [
                    'date' => 'yes',
                ]
            )
        );

        $this->add_control(
            'date_icon',
            [
                'label'     => esc_html__('Date Icon', 'zourney'),
                'type'      => \Elementor\Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'zourney-icon-calendar-alt',
                    'library' => 'zourney-icon',
                ],
                'condition' => [
                    'date' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();

        /// Guests Config//
        $this->start_controls_section(
            'babe_guests',
            array(
                'label' => esc_html__('Guests', 'zourney'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'guests',
            array(
                'label'     => esc_html__('Show Guests', 'zourney'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_on'  => 'Show',
                'label_off' => 'Hide'
            )
        );

        $this->add_control(
            'guests_title',
            array(
                'label'     => esc_html__('Guests title', 'zourney'),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'default'   => esc_html__('Guests', 'zourney'),
                'condition' => [
                    'guests' => 'yes',
                ]
            )
        );


        $this->add_control(
            'guests_icon',
            [
                'label'     => esc_html__('Guests Icon', 'zourney'),
                'type'      => \Elementor\Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'zourney-icon-user',
                    'library' => 'zourney-icon',
                ],
                'condition' => [
                    'guests' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();


        /// Search Config//
        $this->start_controls_section(
            'babe_search',
            array(
                'label' => esc_html__('Search button', 'zourney'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'search_title',
            array(
                'label'   => esc_html__('Search title', 'zourney'),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Search', 'zourney'),
            )
        );

        $this->end_controls_section();
    }


    protected function render() {

        $settings = $this->get_settings_for_display();

        $action = BABE_Settings::get_search_result_page_url();

        $count = 0;

        $search_tax = '';

        if (!empty($settings['taxonomy_search']) && is_array($settings['taxonomy_search'])) {
            foreach ($settings['taxonomy_search'] as $taxonomy_search) {
                if ($taxonomy_result = $this->show_taxonomy_search($taxonomy_search)) {
                    $search_tax .= $taxonomy_result;
                    $count++;
                }
            }
        }


        if ($date = $this->show_date()) {
            $count++;
        }


        if ($guest = $this->show_guest()) {
            $count++;
        }

        $search_title = ($settings['search_title'] && !empty($settings['search_title'])) ? $settings['search_title'] : esc_html__('Search', 'zourney');

        $sort_by = $settings['sort'] . '_' . $settings['sort_by'];

        $selected_terms = isset($_GET['terms']) ? (array)$_GET['terms'] : array();

        ?>

        <div id="zourney-search-box" class="babe-search-box">
            <form name="search_form" action="<?php echo esc_url($action); ?>" method="get" id="search_form" class="babe-search-form">
                <div class="search-form-inner">
                    <div class="input-group col-<?php echo esc_attr($count); ?>">
                        <?php
                        if (!empty($search_tax)) {
                            printf('%s', $search_tax);
                        }
                        if (!empty($date)) {
                            printf('<div class="field-search-group">%s</div>', $date);
                        }
                        if (!empty($guest)) {
                            printf('<div class="field-search-group">%s</div>', $guest);
                        }
                        ?>
                    </div>
                    <div class="submit">
                        <button name="submit" class="btn button btn-primary btn-search" value="1">
                            <?php echo esc_html($search_title); ?>
                        </button>
                    </div>
                    <input type="hidden" name="request_search_results" value="1">
                    <input type="hidden" name="search_results_sort_by" value="<?php echo esc_attr($sort_by); ?>">
                    <?php if ($selected_terms): ?>
                        <?php foreach ($selected_terms as $term): ?>
                            <input type="hidden" name="terms[<?php echo esc_attr($term); ?>]" value="<?php echo esc_attr($term); ?>">
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </form>
        </div>
        <?php

        return;

    }

    private function show_taxonomy_search($taxonomy_search) {

        $results = '';

        if ($taxonomy_search['taxonomy_slug']) {

            $title    = ($taxonomy_search['taxonomy_title'] && !empty($taxonomy_search['taxonomy_title'])) ? $taxonomy_search['taxonomy_title'] : esc_html__('Title Search', 'zourney');
            $subtitle = ($taxonomy_search['taxonomy_subtitle'] && !empty($taxonomy_search['taxonomy_subtitle'])) ? $taxonomy_search['taxonomy_subtitle'] : esc_html__('Choose', 'zourney');
            $icon     = ($taxonomy_search['taxonomy_icon'] && !empty($taxonomy_search['taxonomy_icon'])) ? $taxonomy_search['taxonomy_icon']['value'] : 'zourney-icon-tours';

            $taxonomy_name = $this->get_taxonomy_name($taxonomy_search['taxonomy_slug']);

            $selected = isset($_GET['add_ids_' . $taxonomy_name]) ? (int)$_GET['add_ids_' . $taxonomy_name] : 0;
            if ($selected) {
                $taxonomy_selected_arr[$selected] = $selected;
            }

            $taxonomy = get_taxonomy($taxonomy_name);

            if (!is_wp_error($taxonomy) && !empty($taxonomy)) {

                $selected_term_name = $subtitle;

                if ($selected) {

                    $selected_term = get_term_by('id', $selected, $taxonomy_name);
                    if (!empty($selected_term) && !is_wp_error($selected_term)) {
                        $selected_term_name = $selected_term->name;
                    }

                }

                $args    = array(
                    'taxonomy'            => $taxonomy_name,
                    'parent_term_id'      => 0,
                    'view'                => 'list', // 'select', 'multicheck' or 'list'
                    'add_count'           => '',
                    'option_all'          => 1,
                    'level'               => 0,
                    'option_all_value'    => 0,
                    'option_all_title'    => sprintf(esc_html__('All %s', 'zourney'), $title),
                    'id'                  => 'add_ids_list_' . $taxonomy_name,
                    'class'               => 'add_ids_list',
                    'class_item'          => 'term_item',
                    'class_item_selected' => 'term_item_selected',
                    'name'                => '',
                    'prefix_char'         => ' ',
                    'term_id_name'        => 'term_id',
                );
                $results .= '<div class="field-search-group ">';
                $results .= '<div class="field-group-inner locations-block"><div class="icon-search left-search"><i class="' . esc_attr($icon) . '"></i></div>';
                $results .= '<div class="field-search right-search">';
                if (!empty($title)) {
                    $results .= '<div class="field-title advanced-header">' . $title . '</div>';
                }
                $results .= '<div class="add_input_field is-active" data-tax="' . $taxonomy_name . '" tabindex="0">
                                        <div class="add_ids_title">
                                            <div class="add_ids_title_value">' . esc_html($selected_term_name) . '</div><i class="js-zourney-icon zourney-icon zourney-icon-arrow-down"></i>
                                            ' . BABE_Post_types::get_terms_children_hierarchy($args, array($selected)) . '
                                            <input type="hidden" class="input_select_input_value" name="add_ids_' . $taxonomy_name . '" value="' . esc_attr($selected) . '">
                                          </div>  	
                                        </div>';
                $results .= '</div>';
                $results .= '</div>';
                $results .= '</div>';

                return $results;
            }

        }

        return $results;

    }


    private function show_date() {
        $settings = $this->get_settings_for_display();

        $date_title = ($settings['date_title'] && !empty($settings['date_title'])) ? $settings['date_title'] : esc_html__('When', 'zourney');
        $date_icon  = ($settings['date_icon'] && !empty($settings['date_icon'])) ? $settings['date_icon']['value'] : 'zourney-icon zourney-icon-calendar';
        $date       = '';
        if ($settings['date']) {
            $date .= '<div class="field-group-inner date-block">';
            $date .= '<div class="icon-search left-search"><i class="' . esc_attr($date_icon) . '"></i></div>';
            $date .= '<div class="field-search right-search">';
            if (!empty($date_title)) {
                $date .= '<div class="field-title advanced-header">' . $date_title . '</div>';
            }

            $date
                  .= '<div class="search_date_wrapper"><span class="search-date search_date_wrapper_date_from" data-title="' . esc_html__('Date from', 'zourney') . '">
                            <label class="zourney-date-from" for="date_from"></label><input type="text" class="search_date" id="date_from" name="date_from" value="" placeholder="' . esc_html__('(Date)', 'zourney') . '">
                        </span></div><i class="js-zourney-icon zourney-icon zourney-icon-arrow-down"></i>';
            $date .= '</div>';
            $date .= '</div>';
        }

        return $date;
    }

    private function show_guest() {

        $settings          = $this->get_settings_for_display();
        $guest             = '';
        $output_guests_div = '';
        $total_guests      = 0;

        ///// guests selection
        $ages_arr = BABE_Post_types::get_ages_arr();

        if ($settings['guests']) {

            $guest_title = ($settings['guests_title'] && !empty($settings['guests_title'])) ? $settings['guests_title'] : esc_html__('Guests', 'zourney');
            $guest_icon  = ($settings['guests_icon'] && !empty($settings['guests_icon'])) ? $settings['guests_icon']['value'] : 'zourney-icon zourney-icon-people';

            if (!empty($ages_arr)) {

                foreach ($ages_arr as $age_term) {
                    $age_selected_value = isset($_GET['guests'][$age_term['age_id']]) ? absint($_GET['guests'][$age_term['age_id']]) : 0;

                    $output_guests_div .= ' <div class="input_select_field input_select_field_guests" data-name="guests[' . $age_term['age_id'] . ']">
                              <span class="select_guests_value">' . esc_html($age_selected_value) . '</span>
                              <span class="select_guests_title">' . esc_html($age_term['name']) . '</span>
                              <span class="search_guests_plus btn-search-guests-change btn btn-secondary-outlined" tabindex="0"><i class="fas fa-plus"></i></span>
                              <span class="search_guests_minus btn-search-guests-change btn btn-secondary-outlined" tabindex="0"><i class="fas fa-minus"></i></span>
                              <input type="hidden" class="select_guests_input_value" name="guests[' . $age_term['age_id'] . ']" value="' . esc_html($age_selected_value) . '">
                           </div>';
                }
            }

            if ($output_guests_div) {
                $guest .= '<div class="guest-block search_guests_field field-group-inner">';
                $guest .= '<div class="icon-search left-search"><i class="' . esc_attr($guest_icon) . '"></i></div>';
                $guest .= '<div class="field-search right-search">';
                if (!empty($guest_title)) {
                    $guest .= '<div class="field-title">' . $guest_title . '</div>';
                }
                $guest .= '<span class="search_guests_title_value search_guests_title">(' . esc_html($total_guests) . ')</span><i class="js-zourney-icon zourney-icon zourney-icon-arrow-down"></i>
                                        <div class="search_guests_select_wrapper close_by_apply_btn">
                                            ' . $output_guests_div . '
                                            <div class="search_guests_apply">
                                                <button class="btn button btn-primary search_apply_btn">' . esc_html__('Apply', 'zourney') . '</button>
                                            </div>
                                        </div>	
                                    </div>
                                </div>';
            }

        }

        return $guest;
    }


    public static function get_taxonomies_arr() {
        $output = array();

        $taxonomies = get_terms(array(
            'taxonomy'   => BABE_Post_types::$taxonomies_list_tax,
            'hide_empty' => false
        ));

        if (!is_wp_error($taxonomies) && !empty($taxonomies)) {
            foreach ($taxonomies as $tax_term) {
                $output[$tax_term->slug] = apply_filters('translate_text', $tax_term->name);
            }
        }

        return $output;

    }

    private function get_taxonomy_name($taxonomy_slug) {

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

}