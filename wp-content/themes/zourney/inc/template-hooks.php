<?php
/**
 * =================================================
 * Hook zourney_page
 * =================================================
 */
add_action('zourney_page', 'zourney_page_header', 10);
add_action('zourney_page', 'zourney_page_content', 20);

/**
 * =================================================
 * Hook zourney_single_post_top
 * =================================================
 */
add_action('zourney_single_post_top', 'zourney_post_thumbnail', 10);

/**
 * =================================================
 * Hook zourney_single_post
 * =================================================
 */
add_action('zourney_single_post', 'zourney_post_header', 15);
add_action('zourney_single_post', 'zourney_post_content', 30);

/**
 * =================================================
 * Hook zourney_single_post_bottom
 * =================================================
 */
add_action('zourney_single_post_bottom', 'zourney_post_taxonomy', 5);
add_action('zourney_single_post_bottom', 'zourney_post_nav', 10);
add_action('zourney_single_post_bottom', 'zourney_display_comments', 20);

/**
 * =================================================
 * Hook zourney_loop_post
 * =================================================
 */
add_action('zourney_loop_post', 'zourney_post_header', 10);
add_action('zourney_loop_post', 'zourney_post_content', 30);

/**
 * =================================================
 * Hook zourney_footer
 * =================================================
 */
add_action('zourney_footer', 'zourney_footer_default', 20);

/**
 * =================================================
 * Hook zourney_after_footer
 * =================================================
 */

/**
 * =================================================
 * Hook wp_footer
 * =================================================
 */
add_action('wp_footer', 'zourney_form_login', 1);
add_action('wp_footer', 'zourney_mobile_nav', 1);
add_action('wp_footer', 'render_html_back_to_top', 1);

/**
 * =================================================
 * Hook wp_head
 * =================================================
 */
add_action('wp_head', 'zourney_pingback_header', 1);

/**
 * =================================================
 * Hook zourney_before_header
 * =================================================
 */

/**
 * =================================================
 * Hook zourney_content_top
 * =================================================
 */

/**
 * =================================================
 * Hook zourney_post_header_before
 * =================================================
 */

/**
 * =================================================
 * Hook zourney_post_content_before
 * =================================================
 */

/**
 * =================================================
 * Hook zourney_post_content_after
 * =================================================
 */

/**
 * =================================================
 * Hook zourney_sidebar
 * =================================================
 */
add_action('zourney_sidebar', 'zourney_get_sidebar', 10);

/**
 * =================================================
 * Hook zourney_loop_after
 * =================================================
 */
add_action('zourney_loop_after', 'zourney_paging_nav', 10);

/**
 * =================================================
 * Hook zourney_page_after
 * =================================================
 */
add_action('zourney_page_after', 'zourney_display_comments', 10);
