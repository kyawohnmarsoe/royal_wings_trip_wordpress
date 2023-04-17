<?php
/**
 * BA Header
 *
 * @version 1.0.0
 */

$user_info = wp_get_current_user();
$check_role = BABE_My_account::validate_role($user_info);
if (!$check_role) {
    return;
}
?>

<div class="my_account_page_header_wrapper">
    <div class="my_account_page_header_inner d-flex justify-content-between">
        <?php zourney_site_branding(); ?>

        <a class="button button-go-back-home desktop-hide-down" href="<?php echo esc_url(home_url('/')); ?>">
            <i class="zourney-icon-home"></i>
            <span><?php esc_html_e('Homepage', 'zourney'); ?></span>
        </a>
        <a href="#" class="menu-mobile-nav-button">
            <span class="toggle-text screen-reader-text"><?php echo esc_attr(apply_filters('zourney_menu_toggle_text', esc_html__('Menu', 'zourney'))); ?></span>
            <i class="zourney-icon-bars"></i>
        </a>
    </div>
</div>
