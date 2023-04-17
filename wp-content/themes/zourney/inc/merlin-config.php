<?php

class Zourney_Merlin_Config {

	private $config = [];
	private $wizard;

	public function __construct() {
		$this->init();
		add_action( 'merlin_import_files', [ $this, 'setup_ba_tour' ], 1 );
		add_action( 'merlin_import_files', [ $this, 'import_files' ], 10 );
		add_action( 'merlin_after_all_import', [ $this, 'after_import_setup' ], 10, 1 );
		add_filter( 'merlin_generate_child_functions_php', [ $this, 'render_child_functions_php' ] );

		add_action( 'admin_post_custom_setup_data', [ $this, 'custom_setup_data' ] );
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action('import_start', function () {
            add_filter('wxr_importer.pre_process.post_meta', [$this, 'fiximport_elementor'], 10, 1);
        });
	}

	public function fiximport_elementor($post_meta) {
        if ('_elementor_data' === $post_meta['key']) {
            $post_meta['value'] = wp_slash($post_meta['value']);
        }

        return $post_meta;
    }

	public function admin_scripts() {
		global $zourney_version;
		wp_enqueue_script( 'zourney-admin-script', get_template_directory_uri() . '/assets/js/admin/admin.js', array( 'jquery' ), $zourney_version, true );
	}

	private function init() {
		$this->wizard = new Merlin(
			$config = array(
				// Location / directory where Merlin WP is placed in your theme.
				'merlin_url'         => 'merlin',
				// The wp-admin page slug where Merlin WP loads.
				'parent_slug'        => 'themes.php',
				// The wp-admin parent page slug for the admin menu item.
				'capability'         => 'manage_options',
				// The capability required for this menu to be displayed to the user.
				'dev_mode'           => true,
				// Enable development mode for testing.
				'license_step'       => false,
				// EDD license activation step.
				'license_required'   => false,
				// Require the license activation step.
				'license_help_url'   => '',
				// URL for the 'license-tooltip'.
				'edd_remote_api_url' => '',
				'directory'          => 'inc/merlin',
				// EDD_Theme_Updater_Admin remote_api_url.
				'edd_item_name'      => '',
				// EDD_Theme_Updater_Admin item_name.
				'edd_theme_slug'     => '',
				// EDD_Theme_Updater_Admin item_slug.
			),
			$strings = array(
				'admin-menu'          => esc_html__( 'Theme Setup', 'zourney' ),

				/* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
				'title%s%s%s%s'       => esc_html__( '%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'zourney' ),
				'return-to-dashboard' => esc_html__( 'Return to the dashboard', 'zourney' ),
				'ignore'              => esc_html__( 'Disable this wizard', 'zourney' ),

				'btn-skip'                 => esc_html__( 'Skip', 'zourney' ),
				'btn-next'                 => esc_html__( 'Next', 'zourney' ),
				'btn-start'                => esc_html__( 'Start', 'zourney' ),
				'btn-no'                   => esc_html__( 'Cancel', 'zourney' ),
				'btn-plugins-install'      => esc_html__( 'Install', 'zourney' ),
				'btn-child-install'        => esc_html__( 'Install', 'zourney' ),
				'btn-content-install'      => esc_html__( 'Install', 'zourney' ),
				'btn-import'               => esc_html__( 'Import', 'zourney' ),
				'btn-license-activate'     => esc_html__( 'Activate', 'zourney' ),
				'btn-license-skip'         => esc_html__( 'Later', 'zourney' ),

				/* translators: Theme Name */
				'license-header%s'         => esc_html__( 'Activate %s', 'zourney' ),
				/* translators: Theme Name */
				'license-header-success%s' => esc_html__( '%s is Activated', 'zourney' ),
				/* translators: Theme Name */
				'license%s'                => esc_html__( 'Enter your license key to enable remote updates and theme support.', 'zourney' ),
				'license-label'            => esc_html__( 'License key', 'zourney' ),
				'license-success%s'        => esc_html__( 'The theme is already registered, so you can go to the next step!', 'zourney' ),
				'license-json-success%s'   => esc_html__( 'Your theme is activated! Remote updates and theme support are enabled.', 'zourney' ),
				'license-tooltip'          => esc_html__( 'Need help?', 'zourney' ),

				/* translators: Theme Name */
				'welcome-header%s'         => esc_html__( 'Welcome to %s', 'zourney' ),
				'welcome-header-success%s' => esc_html__( 'Hi. Welcome back', 'zourney' ),
				'welcome%s'                => esc_html__( 'This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.', 'zourney' ),
				'welcome-success%s'        => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'zourney' ),

				'child-header'         => esc_html__( 'Install Child Theme', 'zourney' ),
				'child-header-success' => esc_html__( 'You\'re good to go!', 'zourney' ),
				'child'                => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.', 'zourney' ),
				'child-success%s'      => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.', 'zourney' ),
				'child-action-link'    => esc_html__( 'Learn about child themes', 'zourney' ),
				'child-json-success%s' => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.', 'zourney' ),
				'child-json-already%s' => esc_html__( 'Awesome. Your child theme has been created and is now activated.', 'zourney' ),

				'plugins-header'         => esc_html__( 'Install Plugins', 'zourney' ),
				'plugins-header-success' => esc_html__( 'You\'re up to speed!', 'zourney' ),
				'plugins'                => esc_html__( 'Let\'s install some essential WordPress plugins to get your site up to speed.', 'zourney' ),
				'plugins-success%s'      => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'zourney' ),
				'plugins-action-link'    => esc_html__( 'Advanced', 'zourney' ),

				'import-header'      => esc_html__( 'Import Content', 'zourney' ),
				'import'             => esc_html__( 'Let\'s import content to your website, to help you get familiar with the theme.', 'zourney' ),
				'import-action-link' => esc_html__( 'Advanced', 'zourney' ),

				'ready-header'      => esc_html__( 'All done. Have fun!', 'zourney' ),

				/* translators: Theme Author */
				'ready%s'           => esc_html__( 'Your theme has been all set up. Enjoy your new theme by %s.', 'zourney' ),
				'ready-action-link' => esc_html__( 'Extras', 'zourney' ),
				'ready-big-button'  => esc_html__( 'View your website', 'zourney' ),
				'ready-link-1'      => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://wordpress.org/support/', esc_html__( 'Explore WordPress', 'zourney' ) ),
				'ready-link-2'      => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://themebeans.com/contact/', esc_html__( 'Get Theme Support', 'zourney' ) ),
				'ready-link-3'      => sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'customize.php' ), esc_html__( 'Start Customizing', 'zourney' ) ),
			)
		);

		add_action( 'widgets_init', [ $this, 'widgets_init' ] );
	}

	public function setup_ba_tour() {
		$check_oneclick = get_option( 'zourney_check_oneclick', [] );
		if ( zourney_is_ba_booking_activated() && ! isset( $check_oneclick['before_setup_ba'] ) ) {

			BABE_Install::setup_ages();
			BABE_Install::setup_tax_features();
			BABE_Install::setup_posts_places();
			BABE_Install::setup_posts_services();
			BABE_Install::setup_posts_faq();
			BABE_Install::setup_rules();
			BABE_Install::setup_categories();

            $this->register_locations();
            $this->register_types();
			$check_oneclick['before_setup_ba'] = true;
			
		}
		update_option( 'zourney_check_oneclick', $check_oneclick );
	}

	public function import_files(){
            return array(
            array(
                'import_file_name'           => 'home 1',
                'home'                       => 'home-1',
                'local_import_file'          => get_theme_file_path('/dummy-data/content.xml'),
                'homepage'                   => get_theme_file_path('/dummy-data/homepage/home-1.xml'),
                'local_import_widget_file'   => get_theme_file_path('/dummy-data/widgets.json'),
                'import_rev_slider_file_url' => 'http://source.wpopal.com/zourney/dummy_data/revsliders/home-1/slider.zip',
                'import_more_revslider_file_url' => [],
                'import_preview_image_url'   => get_theme_file_uri('/assets/images/oneclick/home_1.jpg'),
                'preview_url'                => 'https://demo2.wpopal.com/zourney/home-1',
            ),

            array(
                'import_file_name'           => 'home 2',
                'home'                       => 'home-2',
                'local_import_file'          => get_theme_file_path('/dummy-data/content.xml'),
                'homepage'                   => get_theme_file_path('/dummy-data/homepage/home-2.xml'),
                'local_import_widget_file'   => get_theme_file_path('/dummy-data/widgets.json'),
                'import_rev_slider_file_url' => 'http://source.wpopal.com/zourney/dummy_data/revsliders/home-2/slider.zip',
                'import_more_revslider_file_url' => [],
                'import_preview_image_url'   => get_theme_file_uri('/assets/images/oneclick/home_2.jpg'),
                'preview_url'                => 'https://demo2.wpopal.com/zourney/home-2',
            ),

            array(
                'import_file_name'           => 'home 3',
                'home'                       => 'home-3',
                'local_import_file'          => get_theme_file_path('/dummy-data/content.xml'),
                'homepage'                   => get_theme_file_path('/dummy-data/homepage/home-3.xml'),
                'local_import_widget_file'   => get_theme_file_path('/dummy-data/widgets.json'),
                'import_rev_slider_file_url' => 'http://source.wpopal.com/zourney/dummy_data/revsliders/home-3/slider.zip',
                'import_more_revslider_file_url' => [],
                'import_preview_image_url'   => get_theme_file_uri('/assets/images/oneclick/home_3.jpg'),
                'preview_url'                => 'https://demo2.wpopal.com/zourney/home-3',
            ),

            array(
                'import_file_name'           => 'home 4',
                'home'                       => 'home-4',
                'local_import_file'          => get_theme_file_path('/dummy-data/content.xml'),
                'homepage'                   => get_theme_file_path('/dummy-data/homepage/home-4.xml'),
                'local_import_widget_file'   => get_theme_file_path('/dummy-data/widgets.json'),
                'import_rev_slider_file_url' => 'http://source.wpopal.com/zourney/dummy_data/revsliders/home-4/slider.zip',
                'import_more_revslider_file_url' => [],
                'import_preview_image_url'   => get_theme_file_uri('/assets/images/oneclick/home_4.jpg'),
                'preview_url'                => 'https://demo2.wpopal.com/zourney/home-4',
            ),

            array(
                'import_file_name'           => 'home 5',
                'home'                       => 'home-5',
                'local_import_file'          => get_theme_file_path('/dummy-data/content.xml'),
                'homepage'                   => get_theme_file_path('/dummy-data/homepage/home-5.xml'),
                'local_import_widget_file'   => get_theme_file_path('/dummy-data/widgets.json'),
                'import_rev_slider_file_url' => 'http://source.wpopal.com/zourney/dummy_data/revsliders/home-5/slider.zip',
                'import_more_revslider_file_url' => [],
                'import_preview_image_url'   => get_theme_file_uri('/assets/images/oneclick/home_5.jpg'),
                'preview_url'                => 'https://demo2.wpopal.com/zourney/home-5',
            ),

            array(
                'import_file_name'           => 'home 6',
                'home'                       => 'home-6',
                'local_import_file'          => get_theme_file_path('/dummy-data/content.xml'),
                'homepage'                   => get_theme_file_path('/dummy-data/homepage/home-6.xml'),
                'local_import_widget_file'   => get_theme_file_path('/dummy-data/widgets.json'),
                
                'import_preview_image_url'   => get_theme_file_uri('/assets/images/oneclick/home_6.jpg'),
                'preview_url'                => 'https://demo2.wpopal.com/zourney/home-6',
            ),

            array(
                'import_file_name'           => 'home 7',
                'home'                       => 'home-7',
                'local_import_file'          => get_theme_file_path('/dummy-data/content.xml'),
                'homepage'                   => get_theme_file_path('/dummy-data/homepage/home-7.xml'),
                'local_import_widget_file'   => get_theme_file_path('/dummy-data/widgets.json'),
                'import_rev_slider_file_url' => 'http://source.wpopal.com/zourney/dummy_data/revsliders/home-7/slider-home7.zip',
                'import_more_revslider_file_url' => [],
                'import_preview_image_url'   => get_theme_file_uri('/assets/images/oneclick/home_7.jpg'),
                'preview_url'                => 'https://demo2.wpopal.com/zourney/home-7',
            ),
            );           
        }

	public function after_import_setup( $selected_import ) {
		$selected_import = ( $this->import_files() )[ $selected_import ];
		$check_oneclick  = get_option( 'zourney_check_oneclick', [] );

		$this->set_demo_menus();

		if (!isset($check_oneclick[$selected_import['home']])) {
            $this->wizard->importer->import(get_parent_theme_file_path('dummy-data/homepage/' . $selected_import['home'] . '.xml'));
            $check_oneclick[$selected_import['home']] = true;
        }

		// setup Home page
		$home = get_page_by_path( $selected_import['home'] );

		if ( $home ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $home->ID );
		}

		// Setup Options
		$options = $this->get_all_options();

		// Elementor
        if ( ! isset( $check_oneclick['elementor-options'] ) ) {
            $active_kit_id = Elementor\Plugin::$instance->kits_manager->get_active_id();
            update_post_meta( $active_kit_id, '_elementor_page_settings', $options['elementor'] );
            $check_oneclick['elementor-options'] = true;
        }

		// Options
        $theme_options = $options['options'];
        foreach ($theme_options as $key => $option) {
            update_option($key, $option);
        }

		$this->setup_header_footer( $selected_import['home'] );

		if ( ! isset( $check_oneclick['logo'] ) ) {
			set_theme_mod( 'custom_logo', $this->get_attachment( '_logo' ) );
			$check_oneclick['logo'] = true;
		}

		if ( ! isset( $check_oneclick['booking'] ) && zourney_is_ba_booking_activated() ) {
			$this->update_booking_hotel();
			$ba_settings = wp_parse_args( $options['babe'], get_option( 'babe_settings', [] ) );
			update_option( 'babe_settings', $ba_settings );
			$check_oneclick['booking'] = true;
		}

		update_option( 'zourney_check_oneclick', $check_oneclick );
	}

	private function get_attachment( $key ) {
		$params = array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => 1,
			'meta_key'       => $key,
		);
		$post   = get_posts( $params );
		if ( $post ) {
			return $post[0]->ID;
		}

		return 0;
	}

	public function render_child_functions_php() {
		$output
			= "<?php
/**
 * Theme functions and definitions.
 */
";

		return $output;
	}

	public function widgets_init() {
		require_once get_parent_theme_file_path( '/inc/merlin/includes/recent-post.php' );
		register_widget( 'Zourney_WP_Widget_Recent_Posts' );
	}

	private function setup_header_footer( $id ) {
        $this->reset_header_footer();
		$options = ( $this->get_all_header_footer() )[ $id ];

		foreach ( $options['header'] as $header_options ) {
			$header = get_page_by_path( $header_options['slug'], OBJECT, 'elementor_library' );
			if ( $header ) {
				update_post_meta( $header->ID, '_elementor_conditions', $header_options['conditions'] );
			}
		}

		foreach ( $options['footer'] as $footer_options ) {
			$footer = get_page_by_path( $footer_options['slug'], OBJECT, 'elementor_library' );
			if ( $footer ) {
				update_post_meta( $footer->ID, '_elementor_conditions', $footer_options['conditions'] );
			}
		}

		$cache = new ElementorPro\Modules\ThemeBuilder\Classes\Conditions_Cache();
		$cache->regenerate();
	}


	public function register_locations() {

	    global $zourney;

        $new_tax_slug = BABE_Post_types::$attr_tax_pref . $zourney->locations;
        $name = esc_html__('Booking Locations', 'zourney');

        if(!taxonomy_exists( $new_tax_slug )){
            //// Locations insert term
            $inserted_term = wp_insert_term($name,   // the term
                BABE_Post_types::$taxonomies_list_tax, // the taxonomy
                array(
                    'description' => $name,
                    'slug'        => $zourney->locations,
                )
            );

            if (!is_wp_error($inserted_term)){
                BABE_Post_types::init_taxonomies_list();
                update_term_meta($inserted_term['term_id'], 'gmap_active', 0);
                update_term_meta($inserted_term['term_id'], 'select_mode', 'multi_checkbox');
                update_term_meta($inserted_term['term_id'], 'frontend_style', 'col_3');
            }

            $labels = array(
                'name'              => $name,
                'singular_name'     => $name,
                'search_items'      => sprintf(__( 'Search %s', 'zourney' ), $name),
                'all_items'         => sprintf(__( 'All %s', 'zourney' ), $name),
                'parent_item'       => sprintf(__( 'Parent %s', 'zourney' ), $name),
                'parent_item_colon' => sprintf(__( 'Parent %s:', 'zourney' ), $name),
                'edit_item'         => sprintf(__( 'Edit %s', 'zourney' ), $name),
                'update_itm'        => sprintf(__( 'Update %s', 'zourney' ), $name),
                'add_new_item'      => sprintf(__( 'Add New %s', 'zourney' ), $name),
                'new_item_name'     => sprintf(__( 'New %s', 'zourney' ), $name),
                'menu_name'         => sprintf(__( '%s', 'zourney' ), $name),
            );

            register_taxonomy( $new_tax_slug, BABE_Post_types::$booking_obj_post_type, array(
                'labels'            => $labels,
                'hierarchical'      => true,
                'query_var'         => $new_tax_slug,
                'public'            => true,
                'show_ui'           => true,
                'show_in_nav_menus'   => true,
                'show_admin_column' => true,
                'show_in_menu' => true,
                'show_in_rest' => true,
            ) );
        }
    }
    
        //// register tax Types
    public function register_types() {

	    global $zourney;
        $name = esc_html__('Booking Types', 'zourney');
        $new_tax_slug = BABE_Post_types::$attr_tax_pref .$zourney->types;

        //// Types insert term
        if(!taxonomy_exists( $new_tax_slug )){
            //// Locations insert term
            $inserted_term = wp_insert_term($name,   // the term
                BABE_Post_types::$taxonomies_list_tax, // the taxonomy
                array(
                    'description' => $name,
                    'slug'        => $zourney->types,
                )
            );

            if (!is_wp_error($inserted_term)){
                BABE_Post_types::init_taxonomies_list();
                update_term_meta($inserted_term['term_id'], 'gmap_active', 0);
                update_term_meta($inserted_term['term_id'], 'select_mode', 'multi_checkbox');
                update_term_meta($inserted_term['term_id'], 'frontend_style', 'col_3');
            }

            $labels = array(
                'name'              => $name,
                'singular_name'     => $name,
                'search_items'      => sprintf(__( 'Search %s', 'zourney' ), $name),
                'all_items'         => sprintf(__( 'All %s', 'zourney' ), $name),
                'parent_item'       => sprintf(__( 'Parent %s', 'zourney' ), $name),
                'parent_item_colon' => sprintf(__( 'Parent %s:', 'zourney' ), $name),
                'edit_item'         => sprintf(__( 'Edit %s', 'zourney' ), $name),
                'update_itm'        => sprintf(__( 'Update %s', 'zourney' ), $name),
                'add_new_item'      => sprintf(__( 'Add New %s', 'zourney' ), $name),
                'new_item_name'     => sprintf(__( 'New %s', 'zourney' ), $name),
                'menu_name'         => sprintf(__( '%s', 'zourney' ), $name),
            );

            register_taxonomy( $new_tax_slug, BABE_Post_types::$booking_obj_post_type, array(
                'labels'            => $labels,
                'hierarchical'      => true,
                'query_var'         => $new_tax_slug,
                'public'            => true,
                'show_ui'           => true,
                'show_in_nav_menus'   => true,
                'show_admin_column' => true,
                'show_in_menu' => true,
                'show_in_rest' => true,
            ) );
        }

    }

	public function update_booking_hotel() {
		$params = array(
			'posts_per_page' => - 1,
			'post_type'      => BABE_Post_types::$booking_obj_post_type,
		);
		$query  = new WP_Query( $params );
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ):
				$query->the_post();
				$this->add_start_date( get_the_ID() );
				$this->add_end_date( get_the_ID() );
				$this->add_rate_tour( get_the_ID() );
			endwhile;
		}
	}

	public function add_rate_tour( $post_id ) {

		$category_slug = 'tour';

		$price_arr = array( 0 => rand( 100, 200 ) );
		$rules     = BABE_Booking_Rules::get_rule_by_cat_slug( $category_slug );
		if ( $rules && isset( $rules['ages'] ) ) {
			$ages = BABE_Post_types::get_ages_arr();
			$i    = 1;
			foreach ( $ages as $age_arr ) {
				$price_arr[ $age_arr['age_id'] ] = $i <= 2 ? floatval( $price_arr[0] - $i * 10 ) : floatval( 0 );
				$i ++;
			}

			unset( $price_arr[0] );

		}

		$days_arr      = BABE_Calendar_functions::get_week_days_arr();
		$rate_days_arr = array();
		foreach ( $days_arr as $day_num => $day_title ) {
			$rate_days_arr[ $day_num ] = $day_num;
		}

		//// create and save rates
		$rate_arr = array(
			'post_id'             => $post_id,
			'cat_slug'            => $category_slug,
			'apply_days'          => $rate_days_arr,
			'start_days'          => $rate_days_arr,
			'_price_general'      => $price_arr,
			'_price_from'         => '',
			'_prices_conditional' => array(),
			'_rate_min_booking'   => '',
			'_rate_max_booking'   => '',
			'_rate_title'         => esc_html__( 'Default Price', 'zourney' ),
			'_rate_date_from'     => '',
			'_rate_date_to'       => '',
		);

		BABE_Prices::save_rate( $rate_arr );

		BABE_CMB2_admin::update_booking_obj_post( $post_id, [], (object) array() );
	}

	private function add_start_date( $post_id ) {
		$date_from_obj = new DateTime( '-3 days' );
		update_post_meta( $post_id, 'start_date', BABE_Calendar_functions::date_from_sql( $date_from_obj->format( 'Y-m-d' ) ) );
	}

	private function add_end_date( $post_id ) {
		$date_to_obj = new DateTime( '+1 year' );
		update_post_meta( $post_id, 'end_date', BABE_Calendar_functions::date_from_sql( $date_to_obj->format( 'Y-m-d' ) ) );
	}

	private function get_all_header_footer() {
		return [
			'home-1' => [
				'header' => [
					[
						'slug'       => 'header-1',
						'conditions' => [ 'include/general' ],
					]
				],
				'footer' => [
					[
						'slug'       => 'footer',
						'conditions' => [ 'include/general' ],
					]
				]
			],
			'home-2' => [
				'header' => [
					[
						'slug'       => 'header-1',
						'conditions' => [ 'include/general' ],
					]
				],
				'footer' => [
					[
						'slug'       => 'footer',
						'conditions' => [ 'include/general' ],
					]
				]
			],
			'home-3' => [
				'header' => [
					[
						'slug'       => 'header-1',
						'conditions' => [ 'include/general' ],
					]
				],
				'footer' => [
					[
						'slug'       => 'footer',
						'conditions' => [ 'include/general' ],
					]
				]
			],
			'home-4' => [
				'header' => [
					[
						'slug'       => 'header-1',
						'conditions' => [ 'include/general' ],
					]
				],
				'footer' => [
					[
						'slug'       => 'footer',
						'conditions' => [ 'include/general' ],
					]
				]
			],
			'home-5' => [
				'header' => [
					[
						'slug'       => 'header-1',
						'conditions' => [ 'include/general' ],
					]
				],
				'footer' => [
					[
						'slug'       => 'footer',
						'conditions' => [ 'include/general' ],
					]
				]
			],
			'home-6' => [
				'header' => [
					[
						'slug'       => 'header-4',
						'conditions' => [ 'include/general' ],
					]
				],
				'footer' => [
					[
						'slug'       => 'footer-1',
						'conditions' => [ 'include/general' ],
					]
				]
			],
			'home-7' => [
				'header' => [
					[
						'slug'       => 'header-5',
						'conditions' => [ 'include/general' ],
					]
				],
				'footer' => [
					[
						'slug'       => 'footer-1',
						'conditions' => [ 'include/general' ],
					]
				]
			],
		];
	}

	private function reset_header_footer() {
		$footer_args = array(
			'post_type'      => 'elementor_library',
			'posts_per_page' => - 1,
			'meta_query'     => array(
				array(
					'key'     => '_elementor_template_type',
					'compare' => 'IN',
					'value'   => [ 'footer', 'header' ]
				),
			)
		);
		$footer      = new WP_Query( $footer_args );
		while ( $footer->have_posts() ) : $footer->the_post();
			update_post_meta( get_the_ID(), '_elementor_conditions', [] );
		endwhile;
		wp_reset_postdata();
	}

	public function set_demo_menus() {
		$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

		set_theme_mod(
			'nav_menu_locations',
			array(
				'primary'  => $main_menu->term_id,
				'handheld' => $main_menu->term_id,
			)
		);
	}

    public function add_plugin_page() {
        // This page will be under "Settings"
        add_options_page(
            'Custom Setup Theme',
            'Custom Setup Theme',
            'manage_options',
            'custom-setup-settings',
            array( $this, 'create_admin_page' )
        );
    }

        /**
     * Options page callback
     */
    public function create_admin_page() {
        // Set class property
        $this->options = get_option('zourney_options_setup');

        $header_data = $this->get_data_elementor_template('header');
        $footer_data = $this->get_data_elementor_template('footer');
        $tour_data = $this->get_data_elementor_template('single-post');

        $profile = $this->get_all_header_footer();

        $homepage = [];
        foreach ($profile as $key=>$value){
            $homepage[$key] = ucfirst( str_replace('-', ' ', $key) );
        }
        ?>
        <div class="wrap">
        <h1><?php esc_html_e('Custom Setup Themes', 'zourney') ?></h1>
        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
            <table class="form-table">
                <tr>
                    <th>
                        <label><?php esc_html_e('Setup Themes', 'zourney') ?></label>
                    </th>
                    <td>
                        <fieldset>
                            <ul>
                                <li>
                                    <label><?php esc_html_e('Setup Theme', 'zourney') ?>:
                                        <select name="setup-theme">
                                            <option value="profile" selected><?php esc_html_e('Select Profile', 'zourney') ?></option>
                                             <option value="custom_theme"><?php esc_html_e('Custom Header and Footer', 'zourney') ?></option>
                                        </select>
                                    </label>
                                </li>
                                <li class="profile setup-theme">
                                    <label><?php esc_html_e('Profile', 'zourney') ?>:
                                        <select name="opal-data-home">
                                            <option value="" selected> <?php esc_html_e('Select home page profile', 'zourney') ?></option>
                                            <?php foreach ($homepage as $id => $home) { ?>
                                                <option value="<?php echo esc_attr($id); ?>">
                                                    <?php echo esc_attr($home); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </label>
                                </li>
                                <li class="custom_theme setup-theme">
                                    <label><?php esc_html_e('Header', 'zourney') ?>:
                                        <select name="header">
                                            <option value="" selected><?php esc_html_e('Select header', 'zourney') ?></option>
                                            <?php foreach ($header_data as $id => $header) { ?>
                                                <option value="<?php echo esc_attr($id); ?>">
                                                    <?php echo esc_attr($header); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </label>
                                </li>
                                <li class="custom_theme setup-theme">
                                    <label><?php esc_html_e('Footer', 'zourney') ?>:
                                        <select name="footer">
                                            <option value="" selected ><?php esc_html_e('Select Footer', 'zourney') ?></option>
                                            <?php foreach ($footer_data as $id => $footer) { ?>
                                                <option value="<?php echo esc_attr($id); ?>">
                                                    <?php echo esc_attr($footer); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </label>
                                </li>
                                <li class="setup-template">
                                    <label><?php esc_html_e('Tours detail template', 'zourney') ?>:
                                        <select name="tour-template">
                                            <option value="" selected ><?php esc_html_e('Select Tours Template', 'zourney') ?></option>
                                            <?php foreach ($tour_data as $id => $tour) { ?>
                                                <option value="<?php echo esc_attr($id); ?>">
                                                    <?php echo esc_attr($tour); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </label>
                                </li>
                                <li>
                                    <input type="checkbox" id="update_elementor_content" name="opal-setup-data-elementor" value="1">
                                    <label><?php esc_html_e('Update Elementor Content', 'zourney') ?></label>
                                </li>
                                <li>
                                    <input type="checkbox" id="update_elementor_options" name="opal-setup-data-elementor-options" value="1">
                                    <label><?php esc_html_e('Update Elementor Options', 'zourney') ?></label>
                                </li>
                                 <li>
                                    <input type="checkbox" id="update_data_booking" name="opal-setup-data-booking" value="1">
                                    <label><?php esc_html_e('Update Tours Booking', 'zourney') ?></label>
                                </li>
                            </ul>
                        </fieldset>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="action" value="custom_setup_data">
            <?php submit_button(esc_html('Setup Now!')); ?>
        </form>
        <?php  if (isset($_GET['saved'])) { ?>
            <div class="updated">
                <p><?php esc_html_e('Success! Have been setup for your website', 'zourney'); ?></p>
            </div>
        <?php }
    }

    private function get_data_elementor_template($type){
        $args = array(
            'post_type'      => 'elementor_library',
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'     => '_elementor_template_type',
                    'compare' => '=',
                    'value'   => $type
                ),
            )
        );
        $data = new WP_Query($args);
        $select_data = [];
        while ($data->have_posts()): $data->the_post();
            $select_data[get_the_ID()] = get_the_title();
        endwhile;
        wp_reset_postdata();

        return $select_data;
    }


    private function reset_elementor_conditions($type) {
        $args = array(
            'post_type'      => 'elementor_library',
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'     => '_elementor_template_type',
                    'compare' => '=',
                    'value'   => $type
                ),
            )
        );
        $query = new WP_Query($args);
        while ($query->have_posts()) : $query->the_post();
            update_post_meta(get_the_ID(), '_elementor_conditions', []);
        endwhile;
        wp_reset_postdata();
    }

    public function custom_setup_data(){
        if(isset($_POST)){
            if(isset($_POST['setup-theme'])){
                if( $_POST['setup-theme'] == 'profile'){
                    if (isset($_POST['opal-data-home']) && !empty($_POST['opal-data-home'])) {
                        $home = (isset($_POST['opal-data-home']) && $_POST['opal-data-home']) ? $_POST['opal-data-home'] : 'home-1';
                        $this->setup_header_footer($home);
                    }
                }
            }

            if(isset($_POST['tour-template']) && !empty($_POST['tour-template'])){
                $tour_template= $_POST['tour-template'];
                $this->reset_elementor_conditions('single-post');
                update_post_meta($tour_template, '_elementor_conditions', ['include/to_book']);
            }

            if (isset($_POST['opal-setup-data-elementor-options'])) {
                $options = $this->get_all_options();
                // Elementor
                $active_kit_id = Elementor\Plugin::$instance->kits_manager->get_active_id();
                update_post_meta($active_kit_id, '_elementor_page_settings', $options['elementor']);
            }

            if (isset($_POST['opal-setup-data-booking'])) {
                if ( zourney_is_ba_booking_activated() ) {
                    $this->update_booking_hotel();
                    $ba_settings = wp_parse_args( $options['babe'], get_option( 'babe_settings_en', [] ) );
                    update_option( 'babe_settings_en', $ba_settings );
                    $check_oneclick['booking'] = true;
                }
            }

            if (isset($_POST['opal-setup-data-elementor']) || isset($_POST['opal-setup-data-elementor-options'])) {

                $cache = new ElementorPro\Modules\ThemeBuilder\Classes\Conditions_Cache();
                $cache->regenerate();

                Elementor\Plugin::$instance->files_manager->clear_cache();
            }

            wp_redirect(admin_url('options-general.php?page=custom-setup-settings&saved=1'));
            exit;
        }
    }

	public function get_all_options(){
        $options = [];
        $options['options']   = json_decode('{"zourney_options_social_share":"1","zourney_options_social_share_facebook":"1","zourney_options_social_share_twitter":"1","zourney_options_social_share_linkedin":"1","zourney_options_social_share_pinterest":"","zourney_options_back_to_top":"1"}', true);
        $options['elementor']   = json_decode('{"system_colors":[{"_id":"primary","title":"Primary","color":"#E46D30"},{"_id":"primary_hover","title":"Primary Hover","color":"#db5d1c"},{"_id":"secondary","title":"Secondary","color":"#8E8A46"},{"_id":"secondary_hover","title":"Secondary Hover","color":"#7f7c3f"},{"_id":"text","title":"Text","color":"#5C626A"},{"_id":"text_lighter","title":"Text Lighter","color":"#969BA1"},{"_id":"accent","title":"Accent","color":"#000000"},{"_id":"lighter","title":"Light","color":"#BDC2CB"},{"_id":"border","title":"Border","color":"#CFD3DA"}],"custom_colors":[],"system_typography":[{"_id":"primary","title":"Primary","typography_typography":"custom"},{"_id":"secondary","title":"Secondary","typography_typography":"custom"},{"_id":"accent","title":"Accent","typography_typography":"custom"},{"_id":"text","title":"Text","typography_typography":"custom"},{"_id":"heading_title","title":"Heading Title","typography_typography":"custom","typography_font_family":"Zourney Heading","typography_text_transform":"none","typography_font_weight":"400","typography_font_size":{"unit":"px","size":50,"sizes":[]},"typography_font_size_tablet":{"unit":"px","size":40,"sizes":[]},"typography_font_size_mobile":{"unit":"px","size":34,"sizes":[]},"typography_line_height":{"unit":"px","size":54,"sizes":[]},"typography_line_height_tablet":{"unit":"px","size":45,"sizes":[]},"typography_line_height_mobile":{"unit":"px","size":38,"sizes":[]}},{"_id":"heading_sub","title":"Heading Sub","typography_typography":"custom","typography_font_family":"Jost","typography_font_weight":"600","typography_text_transform":"uppercase","typography_font_size":{"unit":"px","size":12,"sizes":[]},"typography_line_height":{"unit":"px","size":16,"sizes":[]}},{"_id":"heading_footer","title":"heading Footer","typography_typography":"custom","typography_font_family":"Jost","typography_font_weight":"600","typography_text_transform":"uppercase","typography_font_size":{"unit":"px","size":12,"sizes":[]},"typography_line_height":{"unit":"px","size":16,"sizes":[]}}],"custom_typography":[],"default_generic_fonts":"Sans-serif","site_name":"Zourney","site_description":"Travel Tour Booking WordPress Theme","page_title_selector":"h1.entry-title","activeItemIndex":1,"active_breakpoints":["viewport_mobile","viewport_mobile_extra","viewport_tablet","viewport_tablet_extra","viewport_laptop"],"container_width":{"unit":"px","size":1290,"sizes":[]},"space_between_widgets":{"unit":"px","size":0,"sizes":[]},"viewport_md":768,"viewport_lg":1025}', true);
        $options['babe']   = json_decode('{"date_format":"d/m/Y","booking_obj_post_slug":"tour","zero_price_display_value":"","booking_obj_post_name":"Tour booking","booking_obj_post_name_general":"Tour booking","booking_obj_menu_name":"Tour booking","mpoints_active":0,"content_in_tabs":0,"reviews_in_tabs":0,"reviews_comment_template":"","view_only_uploaded_images":0,"results_per_page":10,"posts_per_taxonomy_page":12,"max_guests_select":10,"av_calendar_max_months":12,"results_without_av_check":0,"booking_obj_gutenberg":0,"results_view":"grid","google_api":"AIzaSyABi9hTcX1JLubvdtqY70OmrnMhaVZgHhE","google_map_start_lat":"-33.8688","google_map_start_lng":"151.2195","google_map_zoom":7,"google_map_active":1,"google_map_marker":1,"currency":"USD","currency_place":"left","price_thousand_separator":"","price_decimal_separator":"","price_decimals":0,"price_from_label":"","checkout_add_billing_address":0,"order_availability_confirm":"auto","order_payment_processing_waiting":0,"unitegallery_remove":0,"av_calendar_remove":0,"av_calendar_remove_hover_prices":0,"google_map_remove":0,"services_to_booking_form":1,"message_av_confirmation":"","message_not_available":"","message_payment_deferred":"","message_payment_expected":"","message_payment_processing":"","message_payment_received":"","message_draft":"","shop_email":"","email_new_customer_created_subject":"","email_new_customer_created_title":"","email_new_customer_created_message":"","email_password_reseted_subject":"","email_password_reseted_title":"","email_password_reseted_message":"","email_logo":"","email_header_image":"","email_footer_message":"","email_footer_credit":"","email_color_font":"","email_color_background":"","email_color_title":"","email_color_link":"","email_color_button":"","email_color_button_yes":"","email_color_button_no":"","payment_methods":["cash"],"use_extended_wp_import":"1","email_admin_new_order_subject":"","email_admin_new_order_title":"","email_admin_new_order_message":"","email_admin_order_updated_subject":"","email_admin_order_updated_title":"","email_admin_order_updated_message":"","email_admin_new_order_av_confirm_subject":"","email_admin_new_order_av_confirm_title":"","email_admin_new_order_av_confirm_message":"","email_new_order_av_confirm_subject":"","email_new_order_av_confirm_title":"","email_new_order_av_confirm_message":"","email_new_order_subject":"","email_new_order_title":"","email_new_order_message":"","email_order_updated_subject":"","email_order_updated_title":"","email_order_updated_message":"","email_new_order_to_pay_subject":"","email_new_order_to_pay_title":"","email_new_order_to_pay_message":"","email_order_rejected_subject":"","email_order_rejected_title":"","email_order_rejected_message":"","email_admin_order_canceled_subject":"","email_admin_order_canceled_title":"","email_admin_order_canceled_message":"","email_order_canceled_subject":"","email_order_canceled_title":"","email_order_canceled_message":"","coupons_active":0,"coupons_expire_days":180,"paypal_email":"","paypal_sandbox":0,"paypal_live_client_id":"","paypal_live_secret":"","paypal_test_client_id":"","paypal_test_secret":"","stripe_live_public_key":"","stripe_live_secret_key":"","stripe_test_public_key":"","stripe_test_secret_key":"","stripe_country":"","stripe_sandbox":0,"braintree_live_public_key":"","braintree_live_private_key":"","braintree_live_merchant_id":"","braintree_sandbox_public_key":"","braintree_sandbox_private_key":"","braintree_sandbox_merchant_id":"","braintree_sandbox":0,"zourney_booking_google_map_style":"light_grey_and_blue","locations_slug":"","types_slug":"","features_slug":"","criteria_arr":["location","amenities","services","price","rooms"],"wishlist_active":"1","wishlist_page":"40","wishlist_icon":"","wishlist_added":""}', true);
        return $options;
    } // end get_all_options

}

return new Zourney_Merlin_Config();
