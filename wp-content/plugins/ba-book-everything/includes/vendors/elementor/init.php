<?php
/**
 * Initialize Elementor
 *
 * @since   1.3.13
 */
 
// Add a custom category for panel widgets
add_action( 'elementor/init', 'babe_el_init', 0);
function babe_el_init(){
   
   \Elementor\Plugin::$instance->elements_manager->add_category( 
   	  'book-everything-elements',
   	  array(
   		'title' => __( 'Book Everything', 'ba-book-everything' ),
   		'icon' => 'fa fa-plug', //default icon
   	  ),
      1 // position
   );
   
   // Include custom functions of elementor widgets
   $widgets = [
       'allitems',
       'search_form',
       'booking_form',
       'item_stars',
       'item_address_map',
       'item_calendar',
       'item_slideshow',
       'item_faqs',
       'item_steps',
       'item_related',
       'item_price_from',
   ];

   foreach ( $widgets as $file ) {
       include_once BABE_PLUGIN_DIR . '/includes/vendors/elementor/widgets/' . $file . '.php';
   }
}

// Register widgets
add_action( 'elementor/widgets/widgets_registered', 'babe_el_register_widgets' );
function babe_el_register_widgets(){

    if ( !class_exists('BABE_Elementor_Allitems_Widget') ) {
        return;
    }

    \Elementor\Plugin::instance()->widgets_manager->register(new BABE_Elementor_Searchform_Widget());
    \Elementor\Plugin::instance()->widgets_manager->register(new BABE_Elementor_Bookingform_Widget());
    \Elementor\Plugin::instance()->widgets_manager->register(new BABE_Elementor_Allitems_Widget());

    \Elementor\Plugin::instance()->widgets_manager->register(new BABE_Elementor_Itemrelated_Widget());

    \Elementor\Plugin::instance()->widgets_manager->register(new BABE_Elementor_Itempricefrom_Widget());

    \Elementor\Plugin::instance()->widgets_manager->register(new BABE_Elementor_Itemstars_Widget());
    \Elementor\Plugin::instance()->widgets_manager->register(new BABE_Elementor_Itemslideshow_Widget());

    \Elementor\Plugin::instance()->widgets_manager->register(new BABE_Elementor_Itemcalendar_Widget());

    \Elementor\Plugin::instance()->widgets_manager->register(new BABE_Elementor_Itemfaqs_Widget());

    \Elementor\Plugin::instance()->widgets_manager->register(new BABE_Elementor_Itemsteps_Widget());
    \Elementor\Plugin::instance()->widgets_manager->register(new BABE_Elementor_Itemaddressmap_Widget());
}


