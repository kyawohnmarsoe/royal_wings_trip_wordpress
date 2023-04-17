<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Zourney_Elementor')) :

    /**
     * The Zourney Elementor Integration class
     */
    class Zourney_Elementor {
        private $suffix = '';

        public function __construct() {
            $this->suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';

            add_action('wp', [$this, 'register_auto_scripts_frontend']);
            add_action('elementor/init', array($this, 'add_category'));
            add_action('wp_enqueue_scripts', [$this, 'add_scripts'], 15);
            add_action('elementor/widgets/register', array($this, 'customs_widgets'));
            add_action('elementor/widgets/register', array($this, 'include_widgets'));
            add_action('elementor/frontend/after_enqueue_scripts', [$this, 'add_js']);

            // Custom Animation Scroll
            add_filter('elementor/controls/animations/additional_animations', [$this, 'add_animations_scroll']);

            // Backend
            add_action('elementor/editor/after_enqueue_styles', [$this, 'add_style_editor'], 99);

            // Add Icon Custom
            add_action('elementor/icons_manager/native', [$this, 'add_icons_native'], 20);
            add_action('elementor/controls/controls_registered', [$this, 'add_icons'], 20);

            // Add Breakpoints
            add_action('wp_enqueue_scripts', 'zourney_elementor_breakpoints', 9999);

            add_filter('elementor/fonts/additional_fonts', [$this, 'additional_fonts']);
            add_action('wp_enqueue_scripts', [$this, 'elementor_kit']);
        }

        public function elementor_kit() {
            $active_kit_id = Elementor\Plugin::$instance->kits_manager->get_active_id();
            Elementor\Plugin::$instance->kits_manager->frontend_before_enqueue_styles();
            $myvals = get_post_meta($active_kit_id, '_elementor_page_settings', true);

            if (!empty($myvals)) {
                $css = '';
                foreach ($myvals['system_colors'] as $key => $value) {
                    $css .= $value['color'] !== '' ? '--' . $value['_id'] . ':' . $value['color'] . ';' : '';
                }

                $var = "body{{$css}}";
                wp_add_inline_style('zourney-style', $var);
            }
        }

        public function additional_fonts($fonts) {
            $fonts["Jost"]   = 'system';
            $fonts["Zourney Heading"] = 'system';
            $fonts["Zourney Sub"]    = 'system';

            return $fonts;
        }

        public function add_js() {
            global $zourney_version;
            wp_enqueue_script('zourney-elementor-frontend', get_theme_file_uri('/assets/js/elementor-frontend.js'), [], $zourney_version);
        }

        public function add_style_editor() {
            global $zourney_version;
            wp_enqueue_style('zourney-elementor-editor-icon', get_theme_file_uri('/assets/css/admin/elementor/icons.css'), [], $zourney_version);
        }

        public function add_scripts() {
            global $zourney_version;
            wp_enqueue_style('zourney-elementor', get_template_directory_uri() . '/assets/css/base/elementor.css', '', $zourney_version);
            wp_style_add_data('zourney-elementor', 'rtl', 'replace');

            // Add Scripts
            wp_register_script('tweenmax', get_theme_file_uri('/assets/js/vendor/TweenMax.min.js'), array('jquery'), '1.11.1');
            wp_register_script('parallaxmouse', get_theme_file_uri('/assets/js/vendor/jquery-parallax.js'), array('jquery'), $zourney_version);
            wp_register_script('zourney-elementor-item-related', get_theme_file_uri('/assets/js/booking/item-related.js'), array('jquery', 'elementor-frontend'), $zourney_version, true);
            wp_register_script('zourney-elementor-ba-all-items', get_theme_file_uri('/assets/js/booking/ba-all-items.js'), array('jquery', 'elementor-frontend'), $zourney_version, true);
        }


        public function register_auto_scripts_frontend() {
            global $zourney_version;
            wp_register_script('zourney-elementor-image-carousel', get_theme_file_uri('/assets/js/elementor/image-carousel.js'), array('jquery','elementor-frontend'), $zourney_version, true);
            wp_register_script('zourney-elementor-login', get_theme_file_uri('/assets/js/elementor/login.js'), array('jquery','elementor-frontend'), $zourney_version, true);
            wp_register_script('zourney-elementor-posts-grid', get_theme_file_uri('/assets/js/elementor/posts-grid.js'), array('jquery','elementor-frontend'), $zourney_version, true);
            wp_register_script('zourney-elementor-tabs', get_theme_file_uri('/assets/js/elementor/tabs.js'), array('jquery','elementor-frontend'), $zourney_version, true);
            wp_register_script('zourney-elementor-testimonial', get_theme_file_uri('/assets/js/elementor/testimonial.js'), array('jquery','elementor-frontend'), $zourney_version, true);
            wp_register_script('zourney-elementor-video', get_theme_file_uri('/assets/js/elementor/video.js'), array('jquery','elementor-frontend'), $zourney_version, true);
           
        }

        public function add_category() {
            Elementor\Plugin::instance()->elements_manager->add_category(
                'zourney-addons',
                array(
                    'title' => esc_html__('Zourney Addons', 'zourney'),
                    'icon'  => 'fa fa-plug',
                ),
                1);
        }

        public function add_animations_scroll($animations) {
            $animations['Zourney Animation'] = [
                'opal-move-up'    => 'Move Up',
                'opal-move-down'  => 'Move Down',
                'opal-move-left'  => 'Move Left',
                'opal-move-right' => 'Move Right',
                'opal-flip'       => 'Flip',
                'opal-helix'      => 'Helix',
                'opal-scale-up'   => 'Scale',
                'opal-am-popup'   => 'Popup',
            ];

            return $animations;
        }

        public function customs_widgets() {
            $files = glob(get_theme_file_path('/inc/elementor/custom-widgets/*.php'));
            foreach ($files as $file) {
                if (file_exists($file)) {
                    require_once $file;
                }
            }
        }

        /**
         * @param $widgets_manager Elementor\Widgets_Manager
         */
        public function include_widgets($widgets_manager) {
            $files = glob(get_theme_file_path('/inc/elementor/widgets/*.php'));
            foreach ($files as $file) {
                if (file_exists($file)) {
                    require_once $file;
                }
            }
        }


        public function add_icons( $manager ) {
            $new_icons = json_decode( '{"zourney-icon-acreage":"acreage","zourney-icon-adventure":"adventure","zourney-icon-arrow-long-left":"arrow-long-left","zourney-icon-arrow-long-right":"arrow-long-right","zourney-icon-bag":"bag","zourney-icon-beach":"beach","zourney-icon-best-price":"best-price","zourney-icon-binoculars":"binoculars","zourney-icon-boat":"boat","zourney-icon-booking":"booking","zourney-icon-calendar":"calendar","zourney-icon-camp":"camp","zourney-icon-card-remove":"card-remove","zourney-icon-city":"city","zourney-icon-clock-1":"clock-1","zourney-icon-clock-time":"clock-time","zourney-icon-email":"email","zourney-icon-facebook-f":"facebook-f","zourney-icon-flag":"flag","zourney-icon-food":"food","zourney-icon-google-plus-g":"google-plus-g","zourney-icon-heritage":"heritage","zourney-icon-honeymoon":"honeymoon","zourney-icon-linkedin-in":"linkedin-in","zourney-icon-login":"login","zourney-icon-map":"map","zourney-icon-menu":"menu","zourney-icon-minus":"minus","zourney-icon-package":"package","zourney-icon-people":"people","zourney-icon-percent":"percent","zourney-icon-phone-1":"phone-1","zourney-icon-phone":"phone","zourney-icon-pin":"pin","zourney-icon-plane":"plane","zourney-icon-play":"play","zourney-icon-quote-2":"quote-2","zourney-icon-rating":"rating","zourney-icon-search":"search","zourney-icon-share":"share","zourney-icon-shopping-1":"shopping-1","zourney-icon-staff":"staff","zourney-icon-star-2":"star-2","zourney-icon-star-bold":"star-bold","zourney-icon-stars-1":"stars-1","zourney-icon-support":"support","zourney-icon-tag-left":"tag-left","zourney-icon-testimonial":"testimonial","zourney-icon-ticket":"ticket","zourney-icon-tour":"tour","zourney-icon-travel":"travel","zourney-icon-trip":"trip","zourney-icon-trips":"trips","zourney-icon-wallet":"wallet","zourney-icon-wildlife":"wildlife","zourney-icon-world":"world","zourney-icon-angle-down":"angle-down","zourney-icon-angle-left":"angle-left","zourney-icon-angle-right":"angle-right","zourney-icon-angle-up":"angle-up","zourney-icon-arrow-down":"arrow-down","zourney-icon-arrow-left":"arrow-left","zourney-icon-arrow-right":"arrow-right","zourney-icon-arrows-h":"arrows-h","zourney-icon-bars":"bars","zourney-icon-calendar-alt":"calendar-alt","zourney-icon-camera-alt":"camera-alt","zourney-icon-caret-down":"caret-down","zourney-icon-caret-left":"caret-left","zourney-icon-caret-right":"caret-right","zourney-icon-caret-up":"caret-up","zourney-icon-cart-empty":"cart-empty","zourney-icon-check-circle":"check-circle","zourney-icon-check-square":"check-square","zourney-icon-check":"check","zourney-icon-chevron-circle-left":"chevron-circle-left","zourney-icon-chevron-circle-right":"chevron-circle-right","zourney-icon-chevron-down":"chevron-down","zourney-icon-chevron-left":"chevron-left","zourney-icon-chevron-right":"chevron-right","zourney-icon-chevron-up":"chevron-up","zourney-icon-circle":"circle","zourney-icon-clock":"clock","zourney-icon-cloud-download-alt":"cloud-download-alt","zourney-icon-comment":"comment","zourney-icon-comments-alt":"comments-alt","zourney-icon-comments":"comments","zourney-icon-contact":"contact","zourney-icon-credit-card":"credit-card","zourney-icon-dot-circle":"dot-circle","zourney-icon-edit":"edit","zourney-icon-envelope":"envelope","zourney-icon-expand-alt":"expand-alt","zourney-icon-external-link-alt":"external-link-alt","zourney-icon-eye":"eye","zourney-icon-fan":"fan","zourney-icon-file-alt":"file-alt","zourney-icon-file-archive":"file-archive","zourney-icon-filter":"filter","zourney-icon-folder-open":"folder-open","zourney-icon-folder":"folder","zourney-icon-free_ship":"free_ship","zourney-icon-frown":"frown","zourney-icon-gift":"gift","zourney-icon-grip-horizontal":"grip-horizontal","zourney-icon-heart-fill":"heart-fill","zourney-icon-heart":"heart","zourney-icon-history":"history","zourney-icon-home":"home","zourney-icon-info-circle":"info-circle","zourney-icon-instagram":"instagram","zourney-icon-level-up-alt":"level-up-alt","zourney-icon-location-circle":"location-circle","zourney-icon-long-arrow-alt-down":"long-arrow-alt-down","zourney-icon-long-arrow-alt-left":"long-arrow-alt-left","zourney-icon-long-arrow-alt-right":"long-arrow-alt-right","zourney-icon-long-arrow-alt-up":"long-arrow-alt-up","zourney-icon-long-arrow-left":"long-arrow-left","zourney-icon-long-arrow-right":"long-arrow-right","zourney-icon-map-marker-alt":"map-marker-alt","zourney-icon-map-marker-check":"map-marker-check","zourney-icon-meh":"meh","zourney-icon-minus-circle":"minus-circle","zourney-icon-mobile-android-alt":"mobile-android-alt","zourney-icon-money-bill":"money-bill","zourney-icon-pencil-alt":"pencil-alt","zourney-icon-play-2":"play-2","zourney-icon-plus-circle":"plus-circle","zourney-icon-plus":"plus","zourney-icon-quote":"quote","zourney-icon-random":"random","zourney-icon-reply-all":"reply-all","zourney-icon-reply":"reply","zourney-icon-search-plus":"search-plus","zourney-icon-shield-check":"shield-check","zourney-icon-shopping-basket":"shopping-basket","zourney-icon-shopping-cart":"shopping-cart","zourney-icon-sign-in-alt":"sign-in-alt","zourney-icon-sign-out-alt":"sign-out-alt","zourney-icon-smile":"smile","zourney-icon-spinner":"spinner","zourney-icon-square":"square","zourney-icon-star":"star","zourney-icon-sync":"sync","zourney-icon-tachometer-alt":"tachometer-alt","zourney-icon-tags":"tags","zourney-icon-th-large":"th-large","zourney-icon-th-list":"th-list","zourney-icon-thumbtack":"thumbtack","zourney-icon-times-circle":"times-circle","zourney-icon-times":"times","zourney-icon-trophy-alt":"trophy-alt","zourney-icon-truck":"truck","zourney-icon-unlock":"unlock","zourney-icon-user-headset":"user-headset","zourney-icon-user-shield":"user-shield","zourney-icon-user":"user","zourney-icon-users":"users","zourney-icon-video":"video","zourney-icon-adobe":"adobe","zourney-icon-amazon":"amazon","zourney-icon-android":"android","zourney-icon-angular":"angular","zourney-icon-apper":"apper","zourney-icon-apple":"apple","zourney-icon-atlassian":"atlassian","zourney-icon-behance":"behance","zourney-icon-bitbucket":"bitbucket","zourney-icon-bitcoin":"bitcoin","zourney-icon-bity":"bity","zourney-icon-bluetooth":"bluetooth","zourney-icon-btc":"btc","zourney-icon-centos":"centos","zourney-icon-chrome":"chrome","zourney-icon-codepen":"codepen","zourney-icon-cpanel":"cpanel","zourney-icon-discord":"discord","zourney-icon-dochub":"dochub","zourney-icon-docker":"docker","zourney-icon-dribbble":"dribbble","zourney-icon-dropbox":"dropbox","zourney-icon-drupal":"drupal","zourney-icon-ebay":"ebay","zourney-icon-facebook":"facebook","zourney-icon-figma":"figma","zourney-icon-firefox":"firefox","zourney-icon-google-plus":"google-plus","zourney-icon-google":"google","zourney-icon-grunt":"grunt","zourney-icon-gulp":"gulp","zourney-icon-html5":"html5","zourney-icon-jenkins":"jenkins","zourney-icon-joomla":"joomla","zourney-icon-link-brand":"link-brand","zourney-icon-linkedin":"linkedin","zourney-icon-mailchimp":"mailchimp","zourney-icon-opencart":"opencart","zourney-icon-paypal":"paypal","zourney-icon-pinterest-p":"pinterest-p","zourney-icon-reddit":"reddit","zourney-icon-skype":"skype","zourney-icon-slack":"slack","zourney-icon-snapchat":"snapchat","zourney-icon-spotify":"spotify","zourney-icon-trello":"trello","zourney-icon-twitter":"twitter","zourney-icon-vimeo":"vimeo","zourney-icon-whatsapp":"whatsapp","zourney-icon-wordpress":"wordpress","zourney-icon-yoast":"yoast","zourney-icon-youtube":"youtube"}', true );
			$icons     = $manager->get_control( 'icon' )->get_settings( 'options' );
			$new_icons = array_merge(
				$new_icons,
				$icons
			);
			// Then we set a new list of icons as the options of the icon control
			$manager->get_control( 'icon' )->set_settings( 'options', $new_icons ); 
        }

        public function add_icons_native($tabs) {
            global $zourney_version;
            $tabs['opal-custom'] = [
                'name'          => 'zourney-icon',
                'label'         => esc_html__('Zourney Icon', 'zourney'),
                'prefix'        => 'zourney-icon-',
                'displayPrefix' => 'zourney-icon-',
                'labelIcon'     => 'fab fa-font-awesome-alt',
                'ver'           => $zourney_version,
                'fetchJson'     => get_theme_file_uri('/inc/elementor/icons.json'),
                'native'        => true,
            ];

            return $tabs;
        }
    }
endif;

return new Zourney_Elementor();
