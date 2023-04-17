<?php
$theme           = wp_get_theme('zourney');
$zourney_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (!isset($content_width)) {
    $content_width = 980; /* pixels */
}
require get_theme_file_path('inc/class-tgm-plugin-activation.php');
$zourney = (object)array(
    'version' => $zourney_version,
    /**
     * Initialize all the things.
     */
    'main'    => require 'inc/class-main.php'
);

require get_theme_file_path('inc/class-walker-menu.php');
require get_theme_file_path('inc/functions.php');
require get_theme_file_path('inc/template-hooks.php');
require get_theme_file_path('inc/template-functions.php');
require_once get_theme_file_path('inc/merlin/vendor/autoload.php');
require_once get_theme_file_path('inc/merlin/class-merlin.php');
require_once get_theme_file_path('inc/merlin-config.php');
require_once get_theme_file_path('inc/class-customize.php');


if ( zourney_is_elementor_activated() ) {
	require get_theme_file_path( 'inc/elementor/functions-elementor.php' );
	$zourney->elementor = require get_theme_file_path( 'inc/elementor/class-elementor.php' );
    $zourney->megamenu  = require get_theme_file_path('inc/megamenu/megamenu.php');
    $zourney->parallax  = require get_theme_file_path('inc/elementor/section-parallax.php');

    if (defined('ELEMENTOR_PRO_VERSION')) {
        require get_theme_file_path('inc/elementor/class-elementor-pro.php');
    }
}

if (zourney_is_ba_booking_activated()) {
    $zourney->booking         = require get_theme_file_path('inc/booking/class-ba.php');
    $zourney->booking_reviews = require get_theme_file_path('inc/booking/ba-reviews.php');
    $zourney->locations       = 'locations';
    $zourney->types           = 'types';

    require get_theme_file_path('inc/booking/ba-template-functions.php');
    require get_theme_file_path('inc/booking/ba-template-hooks.php');

    $zourney->booking_wishlist = require get_theme_file_path('inc/booking/ba-wishlist.php');
}

if (!is_user_logged_in()) {
    require get_theme_file_path('inc/modules/class-login.php');
}
