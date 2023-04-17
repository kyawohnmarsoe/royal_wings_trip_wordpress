<?php
get_header(); ?>
    <div id="primary" class="content">
        <main id="main" class="site-main">
            <div class="error-404 not-found">
                <div class="page-content text-center">
                    <div class="error-img">
                        <img src="<?php echo get_theme_file_uri('assets/images/404/404_image.png') ?>" alt="<?php echo esc_attr__('404 Page', 'zourney') ?>">
                    </div>
                    <div class="page-title"><span><?php esc_html_e('Oops! That Page Can\'t Be Found.', 'zourney'); ?></span></div>
                    <div class="error-text">
                        <span><?php esc_html_e("It looks like nothing was found at this location. You can either go back to the last page or go to ", 'zourney') ?><a
                                    href="<?php echo esc_url(home_url('/')); ?>"
                                    class="return-home"><?php esc_html_e('Home page.', 'zourney'); ?></a></span>
                    </div>
                    <div class="error-button">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="back-to-homepage">
                            <span class="button-content-wrapper">
                                <span class="button-text"><?php esc_html_e('Back to Home', 'zourney'); ?></span>
                            </span>
                        </a>
                    </div>
                </div><!-- .page-content -->
            </div><!-- .error-404 -->
        </main><!-- #main -->
    </div><!-- #primary -->
<?php
get_footer();
