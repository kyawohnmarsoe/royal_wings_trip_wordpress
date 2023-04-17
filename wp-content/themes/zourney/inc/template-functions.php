<?php

if (!function_exists('zourney_display_comments')) {
    /**
     * Zourney display comments
     *
     * @since  1.0.0
     */
    function zourney_display_comments() {
        // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open() || 0 !== intval(get_comments_number())) :
            comments_template();
        endif;
    }
}

if (!function_exists('zourney_comment')) {
    /**
     * Zourney comment template
     *
     * @param array $comment the comment array.
     * @param array $args the comment args.
     * @param int $depth the comment depth.
     *
     * @since 1.0.0
     */
    function zourney_comment($comment, $args, $depth) {
        if ('div' === $args['style']) {
            $tag       = 'div';
            $add_below = 'comment';
        } else {
            $tag       = 'li';
            $add_below = 'div-comment';
        }
        ?>
        <<?php echo esc_attr($tag) . ' '; ?><?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?> id="comment-<?php comment_ID(); ?>">

        <div class="comment-body">
            <div class="comment-author vcard">
                <?php echo get_avatar($comment, 50); ?>
            </div>
            <?php if ('div' !== $args['style']) : ?>
            <div id="div-comment-<?php comment_ID(); ?>" class="comment-content">
                <?php endif; ?>
                <div class="comment-head">
                    <div class="comment-meta commentmetadata">
                        <?php printf('<cite class="fn">%s</cite>', get_comment_author_link()); ?>
                        <?php if ('0' === $comment->comment_approved) : ?>
                            <em class="comment-awaiting-moderation"><?php esc_attr_e('Your comment is awaiting moderation.', 'zourney'); ?></em>
                            <br/>
                        <?php endif; ?>

                        <a href="<?php echo esc_url(htmlspecialchars(get_comment_link($comment->comment_ID))); ?>"
                           class="comment-date">
                            <?php echo '<time datetime="' . get_comment_date('c') . '">' . get_comment_date() . '</time>'; ?>
                        </a>
                    </div>
                    <div class="reply">
                        <?php
                        comment_reply_link(
                            array_merge(
                                $args, array(
                                    'add_below' => $add_below,
                                    'depth'     => $depth,
                                    'max_depth' => $args['max_depth'],
                                )
                            )
                        );
                        ?>
                        <?php edit_comment_link(esc_html__('Edit', 'zourney'), '  ', ''); ?>
                    </div>
                </div>
                <div class="comment-text">
                    <?php comment_text(); ?>
                </div>
                <?php if ('div' !== $args['style']) : ?>
            </div>
        <?php endif; ?>
        </div>
        <?php
    }
}

if (!function_exists('zourney_credit')) {
    /**
     * Display the theme credit
     *
     * @return void
     * @since  1.0.0
     */
    function zourney_credit() {
        ?>
        <div class="site-info">
            <?php echo apply_filters('zourney_copyright_text', $content = esc_html__('Coppyright', 'zourney') . ' &copy; ' . date('Y') . ' ' . '<a class="site-url" href="' . site_url() . '">' . get_bloginfo('name') . '</a>' . esc_html__('. All Rights Reserved.', 'zourney')); ?>
        </div><!-- .site-info -->
        <?php
    }
}

if (!function_exists('zourney_site_branding')) {
    /**
     * Site branding wrapper and display
     *
     * @return void
     * @since  1.0.0
     */
    function zourney_site_branding() {
        ?>
        <div class="site-branding">
            <?php echo zourney_site_title_or_logo(); ?>
        </div>
        <?php
    }
}

if (!function_exists('zourney_site_title_or_logo')) {
    /**
     * Display the site title or logo
     *
     * @param bool $echo Echo the string or return it.
     *
     * @return string
     * @since 2.1.0
     */
    function zourney_site_title_or_logo() {
        ob_start();
        the_custom_logo(); ?>
        <div class="site-branding-text">
            <?php if (is_front_page()) : ?>
                <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                          rel="home"><?php bloginfo('name'); ?></a></h1>
            <?php else : ?>
                <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                         rel="home"><?php bloginfo('name'); ?></a></p>
            <?php endif; ?>

            <?php
            $description = get_bloginfo('description', 'display');

            if ($description || is_customize_preview()) :
                ?>
                <p class="site-description"><?php echo esc_html($description); ?></p>
            <?php endif; ?>
        </div><!-- .site-branding-text -->
        <?php
        $html = ob_get_clean();

        return $html;
    }
}

if (!function_exists('zourney_primary_navigation')) {
    /**
     * Display Primary Navigation
     *
     * @return void
     * @since  1.0.0
     */
    function zourney_primary_navigation() {
        ?>
        <nav class="main-navigation" role="navigation"
             aria-label="<?php esc_attr_e('Primary Navigation', 'zourney'); ?>">
            <?php
            $args = apply_filters('zourney_nav_menu_args', [
                'fallback_cb'     => '__return_empty_string',
                'theme_location'  => 'primary',
                'container_class' => 'primary-navigation',
            ]);
            wp_nav_menu($args);
            ?>
        </nav>
        <?php
    }
}

if (!function_exists('zourney_mobile_navigation')) {
    /**
     * Display Handheld Navigation
     *
     * @return void
     * @since  1.0.0
     */
    function zourney_mobile_navigation() {
        ?>
        <nav class="mobile-navigation" aria-label="<?php esc_attr_e('Mobile Navigation', 'zourney'); ?>">
            <?php
            wp_nav_menu(
                array(
                    'theme_location'  => 'handheld',
                    'container_class' => 'handheld-navigation',
                )
            );
            ?>
        </nav>
        <?php
    }
}

if (!function_exists('zourney_vertical_navigation')) {
    /**
     * Display Vertical Navigation
     *
     * @return void
     * @since  1.0.0
     */
    function zourney_vertical_navigation() {

        if (isset(get_nav_menu_locations()['vertical'])) {
            $string = get_term(get_nav_menu_locations()['vertical'], 'nav_menu')->name;
            ?>
            <nav class="vertical-navigation" aria-label="<?php esc_attr_e('Vertical Navigation', 'zourney'); ?>">
                <div class="vertical-navigation-header">
                    <i class="zourney-icon-caret-vertiacl-menu"></i>
                    <span class="vertical-navigation-title"><?php echo esc_html($string); ?></span>
                </div>
                <?php

                $args = apply_filters('zourney_nav_menu_args', [
                    'fallback_cb'     => '__return_empty_string',
                    'theme_location'  => 'vertical',
                    'container_class' => 'vertical-menu',
                ]);

                wp_nav_menu($args);
                ?>
            </nav>
            <?php
        }
    }
}

if (!function_exists('zourney_homepage_header')) {
    /**
     * Display the page header without the featured image
     *
     * @since 1.0.0
     */
    function zourney_homepage_header() {
        edit_post_link(esc_html__('Edit this section', 'zourney'), '', '', '', 'button zourney-hero__button-edit');
        ?>
        <header class="entry-header">
            <?php
            the_title('<h1 class="entry-title">', '</h1>');
            ?>
        </header><!-- .entry-header -->
        <?php
    }
}

if (!function_exists('zourney_page_header')) {
    /**
     * Display the page header
     *
     * @since 1.0.0
     */
    function zourney_page_header() {

        if (is_front_page() || !is_page_template('default')) {
            return;
        }

        ?>
        <header class="entry-header">
            <?php
            if (has_post_thumbnail()) {
                zourney_post_thumbnail('full');
            }
            the_title('<h1 class="entry-title">', '</h1>');
            ?>
        </header><!-- .entry-header -->
        <?php
    }
}

if (!function_exists('zourney_page_content')) {
    /**
     * Display the post content
     *
     * @since 1.0.0
     */
    function zourney_page_content() {
        ?>
        <div class="entry-content">
            <?php the_content(); ?>
            <?php
            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'zourney'),
                    'after'  => '</div>',
                )
            );
            ?>
        </div><!-- .entry-content -->
        <?php
    }
}

if (!function_exists('zourney_post_header')) {
    /**
     * Display the post header with a link to the single post
     *
     * @since 1.0.0
     */
    function zourney_post_header() {
        ?>
        <header class="entry-header">
            <?php

            /**
             * Functions hooked in to zourney_post_header_before action.
             */
            do_action('zourney_post_header_before');

            if (is_single()) {
                ?>
                <div class="entry-meta single-meta">
                    <?php zourney_post_meta(); ?>
                </div>
                <?php
                the_title('<h1 class="entry-title">', '</h1>');
            } else { ?>
                <div class="entry-meta">
                    <?php zourney_post_meta(); ?>
                </div>
                <?php the_title(sprintf('<h3 class="entry-title omega"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>'); ?>
                <span class="line"></span>
            <?php }
            do_action('zourney_post_header_after');
            ?>
        </header><!-- .entry-header -->
        <?php
    }
}

if (!function_exists('zourney_post_content')) {
    /**
     * Display the post content with a link to the single post
     *
     * @since 1.0.0
     */
    function zourney_post_content() {
        ?>
        <div class="entry-content">
            <?php

            /**
             * Functions hooked in to zourney_post_content_before action.
             *
             */
            do_action('zourney_post_content_before');


            if (is_single()) {
                the_content(
                    sprintf(
                    /* translators: %s: post title */
                        esc_html__('Read More', 'zourney')
                    )
                );
            } else {
                the_excerpt();
                echo '<div class="more-link-wrap"><a class="more-link" href="' . get_permalink() . '">' . esc_html__('Read more', 'zourney') . '<i class="zourney-icon-arrow-long-right"></i></a></div>';
            }

            /**
             * Functions hooked in to zourney_post_content_after action.
             *
             */
            do_action('zourney_post_content_after');

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'zourney'),
                    'after'  => '</div>',
                )
            );
            ?>
        </div><!-- .entry-content -->
        <?php
    }
}

if (!function_exists('zourney_post_meta')) {
    /**
     * Display the post meta
     *
     * @since 1.0.0
     */
    function zourney_post_meta($atts = array()) {
        global $post;
        if ('post' !== get_post_type()) {
            return;
        }

        extract(
            shortcode_atts(
                array(
                    'show_date'    => true,
                    'show_cat'     => true,
                    'show_author'  => true,
                    'show_comment' => false,
                ),
                $atts
            )
        );

        $posted_on = '';
        // Posted on.
        if ($show_date) {
            $posted_on = '<div class="posted-on">' . sprintf('<a href="%1$s" rel="bookmark">%2$s</a>', esc_url(get_permalink()), get_the_modified_date()) . '</div>';
        }

        $categories_list = get_the_category_list(', ');
        $categories      = '';
        if ($show_cat && $categories_list) {
            // Make sure there's more than one category before displaying.
            $categories = '<div class="categories-link"><span class="screen-reader-text">' . esc_html__('Categories', 'zourney') . '</span>' . $categories_list . '</div>';
        }
        $author = '';
        // Author.
        if ($show_author == 1) {
            $author_id = $post->post_author;
            $author    = sprintf(
                '<div class="post-author"><a href="%1$s" class="url fn" rel="author">%2$s</a></div>',
                esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                esc_html(get_the_author_meta('display_name', $author_id))
            );
        }

        echo wp_kses(
            sprintf('%1$s %2$s %3$s', $categories, $posted_on, $author), array(
                'div'  => array(
                    'class' => array(),
                ),
                'span' => array(
                    'class' => array(),
                ),
                'i'    => array(
                    'class' => array(),
                ),
                'a'    => array(
                    'href'  => array(),
                    'rel'   => array(),
                    'class' => array(),
                ),
                'time' => array(
                    'datetime' => array(),
                    'class'    => array(),
                )
            )
        );

        if ($show_comment) { ?>
            <div class="meta-reply">
                <?php
                comments_popup_link(esc_html__('0 comments', 'zourney'), esc_html__('1 comment', 'zourney'), esc_html__('% comments', 'zourney'));
                ?>
            </div>
            <?php
        }

    }
}

if (!function_exists('zourney_get_allowed_html')) {
    function zourney_get_allowed_html() {
        return apply_filters(
            'zourney_allowed_html',
            array(
                'br'     => array(),
                'i'      => array(),
                'b'      => array(),
                'u'      => array(),
                'em'     => array(),
                'del'    => array(),
                'a'      => array(
                    'href'  => true,
                    'class' => true,
                    'title' => true,
                    'rel'   => true,
                ),
                'strong' => array(),
                'span'   => array(
                    'style' => true,
                    'class' => true,
                ),
            )
        );
    }
}

if (!function_exists('zourney_edit_post_link')) {
    /**
     * Display the edit link
     *
     * @since 2.5.0
     */
    function zourney_edit_post_link() {
        edit_post_link(
            sprintf(
                wp_kses(__('Edit <span class="screen-reader-text">%s</span>', 'zourney'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            ),
            '<div class="edit-link">',
            '</div>'
        );
    }
}

if (!function_exists('zourney_categories_link')) {
    /**
     * Prints HTML with meta information for the current cateogries
     */
    function zourney_categories_link() {

        // Get Categories for posts.
        $categories_list = get_the_category_list(' ');

        if ('post' === get_post_type() && $categories_list) {
            // Make sure there's more than one category before displaying.
            echo '<span class="categories-link"><span class="screen-reader-text">' . esc_html__('Categories', 'zourney') . '</span>' . $categories_list . '</span>';
        }
    }
}

if (!function_exists('zourney_post_taxonomy')) {
    /**
     * Display the post taxonomies
     *
     * @since 2.4.0
     */
    function zourney_post_taxonomy() {
        /* translators: used between list items, there is a space after the comma */

        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list('');
        if ($tags_list) : ?>
            <aside class="entry-taxonomy">

                <div class="tags-links">
                    <strong><?php echo esc_html(_n('Tag:', 'Tags:', count(get_the_tags()), 'zourney')); ?></strong>
                    <?php printf('%s', $tags_list); ?>
                </div>

            </aside>
        <?php endif;
    }
}

if (!function_exists('zourney_paging_nav')) {
    /**
     * Display navigation to next/previous set of posts when applicable.
     */
    function zourney_paging_nav() {
        global $wp_query;

        $args = array(
            'type'      => 'list',
            'next_text' => '<span>' . esc_html__('Next', 'zourney') . '</span><i class="zourney-icon zourney-icon-arrow-right"></i>',
            'prev_text' => '<i class="zourney-icon zourney-icon-arrow-left"></i><span>' . esc_html__('Prev', 'zourney') . '</span>',
        );

        the_posts_pagination($args);
    }
}

if (!function_exists('zourney_post_nav')) {
    /**
     * Display navigation to next/previous post when applicable.
     */
    function zourney_post_nav() {
        $prev_post      = get_previous_post();
        $next_post      = get_next_post();
        $args           = [];
        $thumbnail_prev = '';
        $thumbnail_next = '';

        if ($prev_post) {
            $thumbnail_prev = get_the_post_thumbnail($prev_post->ID, array(60, 60));
        };

        if ($next_post) {
            $thumbnail_next = get_the_post_thumbnail($next_post->ID, array(60, 60));
        };
        if ($next_post) {
            $args['next_text'] = '<span class="nav-content"><span class="reader-text">' . esc_html__('Next', 'zourney') . '</span><span class="title">%title</span></span>' . $thumbnail_next;
        }
        if ($prev_post) {
            $args['prev_text'] = $thumbnail_prev . '<span class="nav-content"><span class="reader-text">' . esc_html__('Prev', 'zourney') . ' </span><span class="title">%title</span></span> ';
        }

        the_post_navigation($args);
    }
}

if (!function_exists('zourney_posted_on')) {
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     *
     * @deprecated 2.4.0
     */
    function zourney_posted_on() {
        _deprecated_function('zourney_posted_on', '2.4.0');
    }
}

if (!function_exists('zourney_homepage_content')) {
    /**
     * Display homepage content
     * Hooked into the `homepage` action in the homepage template
     *
     * @return  void
     * @since  1.0.0
     */
    function zourney_homepage_content() {
        while (have_posts()) {
            the_post();

            get_template_part('content', 'homepage');

        } // end of the loop.
    }
}

if (!function_exists('zourney_get_sidebar')) {
    /**
     * Display zourney sidebar
     *
     * @uses get_sidebar()
     * @since 1.0.0
     */
    function zourney_get_sidebar() {
        get_sidebar();
    }
}

if (!function_exists('zourney_post_thumbnail')) {
    /**
     * Display post thumbnail
     *
     * @param string $size the post thumbnail size.
     *
     * @uses has_post_thumbnail()
     * @uses the_post_thumbnail
     * @var $size . thumbnail|medium|large|full|$custom
     * @since 1.5.0
     */
    function zourney_post_thumbnail($size = 'post-thumbnail') {

        if (has_post_thumbnail()) {
            echo '<div class="post-thumbnail">';
            the_post_thumbnail($size ? $size : 'post-thumbnail');
            echo '</div>';
        }

    }
}

if (!function_exists('zourney_primary_navigation_wrapper')) {
    /**
     * The primary navigation wrapper
     */
    function zourney_primary_navigation_wrapper() {
        echo '<div class="zourney-primary-navigation"><div class="col-full">';
    }
}

if (!function_exists('zourney_primary_navigation_wrapper_close')) {
    /**
     * The primary navigation wrapper close
     */
    function zourney_primary_navigation_wrapper_close() {
        echo '</div></div>';
    }
}

if (!function_exists('zourney_header_container')) {
    /**
     * The header container
     */
    function zourney_header_container() {
        echo '<div class="col-full">';
    }
}

if (!function_exists('zourney_header_container_close')) {
    /**
     * The header container close
     */
    function zourney_header_container_close() {
        echo '</div>';
    }
}

if (!function_exists('zourney_header_custom_link')) {
    function zourney_header_custom_link() {
        echo zourney_get_theme_option('custom-link', '');
    }

}

if (!function_exists('zourney_header_contact_info')) {
    function zourney_header_contact_info() {
        echo zourney_get_theme_option('contact-info', '');
    }

}


if (!function_exists('zourney_template_account_dropdown')) {
    function zourney_template_account_dropdown() {
        if (!zourney_get_theme_option('show_header_account', true)) {
            return;
        }
        ?>
        <div class="account-wrap" id="zourney-dashboard" style="display: none;">
            <div class="account-inner <?php if (is_user_logged_in()): echo "dashboard"; endif; ?>">
                <?php if (is_user_logged_in()) {
                    zourney_account_dropdown();
                }
                ?>
            </div>
        </div>
        <?php
    }
}

if (!function_exists('zourney_form_login')) {
    function zourney_form_login() {
        if (!is_user_logged_in()) {
            if (zourney_is_ba_booking_activated()):

                $account_page = intval(BABE_Settings::$settings['my_account_page']);
                $account_link = get_the_permalink($account_page);

                ?>
                <div class="account-wrap mfp-hide" id="zourney-login-form">
                    <div class="my_account_page_content_wrapper">
                        <?php echo BABE_My_account::get_login_form(); ?>
                        <?php if (get_option('users_can_register')) : ?>
                            <div class="login_registration">
                                <span><?php esc_html_e('Do not have an account?', 'zourney'); ?></span>
                                <div class="registration_link">
                                    <a class="btn-register js-btn-register-popup"
                                       href="#zourney-register-form"><?php esc_html_e('Register', 'zourney'); ?></a>
                                </div>
                            </div>

                        <?php endif; ?>
                    </div>
                </div>
                <div class="account-wrap mfp-hide" id="zourney-register-form">
                    <div class="my_account_page_content_wrapper">

                        <?php if (get_option('users_can_register')) : ?>

                            <div id="signup_form" class="zourney-form-popup login_reg_content">
                                <h3 class="zourney-login-title"><?php esc_html_e('Sign Up', 'zourney'); ?></h3>
                                <form name="registration_form" id="registration_form"
                                      action="<?php echo esc_url(BABE_Settings::get_my_account_page_url(array('action' => 'registration'))); ?>"
                                      method="post">

                                    <div class="new-username">
                                        <label for="new_username"><?php esc_html_e('Username *', 'zourney'); ?></label>
                                        <input type="text" name="new_username" id="new_username" class="input" value=""
                                               size="20" required="required">
                                        <div class="new-username-check-msg"><?php esc_html_e('This username already exists*', 'zourney'); ?></div>
                                    </div>

                                    <div class="new-first-name">
                                        <label for="new_first_name"><?php esc_html_e('First name', 'zourney'); ?></label>
                                        <input type="text" name="new_first_name" id="new_first_name" class="input"
                                               value="" size="20" required="required">
                                    </div>
                                    <div class="new-last-name">
                                        <label for="new_last_name"><?php esc_html_e('Last name', 'zourney'); ?></label>
                                        <input type="text" name="new_last_name" id="new_last_name" class="input"
                                               value="" size="20" required="required">
                                    </div>

                                    <div class="new-email">
                                        <label for="new_email"><?php esc_html_e('Your email *', 'zourney'); ?></label>
                                        <input type="text" name="new_email" id="new_email" class="input" value=""
                                               size="20" required="required">
                                        <div class="new-email-check-msg"><?php esc_html_e('This email already exists', 'zourney'); ?></div>
                                    </div>
                                    <div class="new-email">
                                        <label for="new_email_confirm"><?php esc_html_e('Confirm email *', 'zourney'); ?></label>
                                        <input type="text" name="new_email_confirm" id="new_email_confirm" class="input"
                                               value="" size="20" required="required">
                                    </div>

                                    <div class="new-submit">
                                        <input type="submit" name="new-submit" id="new-submit"
                                               class="button button-primary"
                                               value="<?php esc_attr_e('Sign up', 'zourney'); ?>">
                                        <div class="form-spinner"><i class="fas fa-spinner fa-spin"></i></div>
                                    </div>
                                </form>
                                <div class="login_registration">
                                    <span><?php esc_html_e('Already have an account?', 'zourney'); ?></span>
                                    <div class="registration_link">
                                        <a class="btn-login js-btn-login-popup"
                                           href="#zourney-login-form"><?php esc_html_e('Login', 'zourney'); ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php else: ?>
                <div class="account-wrap mfp-hide" id="zourney-login-form">
                    <div class="login-form-head">
                        <span class="login-form-title"><?php esc_attr_e('Sign in', 'zourney') ?></span>
                        <?php if (get_option('users_can_register')) : ?>
                            <span class="pull-right">
                        <a class="register-link" href="<?php echo esc_url(wp_registration_url()); ?>"
                           title="<?php esc_attr_e('Register', 'zourney'); ?>"><?php esc_attr_e('Create an Account', 'zourney'); ?></a>
                    </span>
                        <?php endif; ?>
                    </div>
                    <form class="zourney-login-form-ajax" data-toggle="validator">
                        <p>
                            <label><?php esc_attr_e('Username or email', 'zourney'); ?>
                                <span class="required">*</span></label>
                            <input name="username" type="text" required
                                   placeholder="<?php esc_attr_e('Username', 'zourney') ?>">
                        </p>
                        <p>
                            <label><?php esc_attr_e('Password', 'zourney'); ?> <span class="required">*</span></label>
                            <input name="password" type="password" required
                                   placeholder="<?php esc_attr_e('Password', 'zourney') ?>">
                        </p>
                        <button type="submit" data-button-action
                                class="btn btn-primary btn-block w-100 mt-1"><?php esc_html_e('Login', 'zourney') ?></button>
                        <input type="hidden" name="action" value="zourney_login">
                        <?php wp_nonce_field('ajax-zourney-login-nonce', 'security-login'); ?>
                    </form>
                    <div class="login-form-bottom">
                        <a href="<?php echo wp_lostpassword_url(get_permalink()); ?>" class="lostpass-link"
                           title="<?php esc_attr_e('Lost your password?', 'zourney'); ?>"><?php esc_attr_e('Lost your password?', 'zourney'); ?></a>
                    </div>
                </div>
            <?php
            endif;
        } else { ?>
            <div class="account-wrap" id="zourney-dashboard" style="display: none;">
                <div class="account-inner dashboard">
                    <?php zourney_account_dropdown(); ?>
                </div>
            </div>
            <?php
        }
    }
}


if (!function_exists('zourney_account_dropdown')) {
    function zourney_account_dropdown() { ?>
        <?php if (has_nav_menu('my-account')) : ?>
            <nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e('Dashboard', 'zourney'); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'my-account',
                    'menu_class'     => 'account-links-menu',
                    'depth'          => 1,
                ));
                ?>
            </nav><!-- .social-navigation -->
        <?php else: ?>
            <?php
            $check_role               = false;
            if (zourney_is_ba_booking_activated()) {
                $user_info  = wp_get_current_user();
                $check_role = BABE_My_account::validate_role($user_info);
            }

            if ($check_role):
                $nav_arr = Zourney_BA_Booking::list_account_menu($check_role);
                $current_nav_slug_arr = BABE_My_account::get_current_nav_slug($nav_arr);
                $current_nav_slug     = key($current_nav_slug_arr);
                $depth                = 0;

                ?>
                <ul class="account-dashboard">
                    <?php
                    foreach ($nav_arr as $nav_slug => $nav_item) {

                        $current_page_class = 'my_account_nav_item my_account_nav_item_' . $nav_slug . ' my_account_nav_item_' . $depth;
                        $current_page_class .= $current_nav_slug == $nav_slug ? ' my_account_nav_item_current' : ''; ?>
                        <li class="<?php echo esc_attr($current_page_class); ?>">
                            <?php
                            if (is_array($nav_item)) {
                                $nav_item['title'] = isset($nav_item['title']) ? $nav_item['title'] : '';
                                ?>

                                <?php
                                printf("%s", Zourney_BA_Booking::get_nav_html($nav_item, $current_nav_slug, ($depth + 1)));
                            } else {
                                printf("%s", Zourney_BA_Booking::get_nav_item_html($nav_slug, $nav_item, $depth));
                            } ?>
                        </li>
                        <?php
                    }
                    ?>
                </ul>

            <?php else: ?>
                <ul class="account-dashboard">
                    <li>
                        <a class="nav-link" href="<?php echo esc_url(get_dashboard_url(get_current_user_id())); ?>"
                           title="<?php esc_attr_e('Dashboard', 'zourney'); ?>"><?php esc_html_e('Dashboard', 'zourney'); ?></a>
                    </li>
                    <li>
                        <a class="nav-link" title="<?php esc_attr_e('Log out', 'zourney'); ?>" class="tips"
                           href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><?php esc_html_e('Log Out', 'zourney'); ?></a>
                    </li>
                </ul>
            <?php endif; ?>
        <?php endif;

    }
}

if (!function_exists('zourney_mobile_handheld_footer')) {
    function zourney_mobile_handheld_footer() {
        $phone  = zourney_get_theme_option('handheld_phone');
        $button = zourney_get_theme_option('handheld_button');

        if ($phone || $button) { ?>
            <div class="mobile-nav-footer">
                <?php if ($phone): ?>
                    <div class="phone-menu">
                        <a href="<?php echo esc_attr(zourney_get_theme_option('handheld_phone_link')); ?>"><?php echo esc_html($phone); ?></a>
                    </div>
                <?php endif; ?>
                <?php if ($button): ?>
                    <div class="button-menu">
                        <a href="<?php echo esc_attr(zourney_get_theme_option('handheld_button_link')); ?>">
                            <span><?php echo esc_html($button); ?></span><i class="zourney-icon-long-arrow-right"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php }
    }
}

if (!function_exists('zourney_header_search_popup')) {
    function zourney_header_search_popup() {
        ?>
        <div class="site-search-popup">
            <div class="site-search-popup-wrap">
                <div class="site-search">
                    <?php get_search_form(); ?>
                </div>
                <a href="#" class="site-search-popup-close">
                    <svg class="close-icon" xmlns="http://www.w3.org/2000/svg" width="23.691" height="22.723" viewBox="0 0 23.691 22.723"><g transform="translate(-126.154 -143.139)"><line x2="23" y2="22" transform="translate(126.5 143.5)" fill="none" stroke="CurrentColor" stroke-width="1"></line><path d="M0,22,23,0" transform="translate(126.5 143.5)" fill="none" stroke="CurrentColor" stroke-width="1"></path></g></svg>
                </a>
            </div>
        </div>
        <div class="site-search-popup-overlay"></div>
        <?php
    }
}

if (!function_exists('zourney_header_search_button')) {
    function zourney_header_search_button() {

        add_action('wp_footer', 'zourney_header_search_popup', 1);
        ?>
        <div class="site-header-search">
            <a href="#" class="button-search-popup"><i class="zourney-icon-search"></i></a>
        </div>
        <?php
    }
}

if (!function_exists('zourney_mobile_nav')) {
    function zourney_mobile_nav() {
        if (isset(get_nav_menu_locations()['handheld'])) {
            ?>
            <div class="zourney-mobile-nav">
                <div class="menu-scroll-mobile">
                    <a href="#" class="mobile-nav-close"><i class="zourney-icon-times"></i></a>
                    <?php zourney_mobile_navigation(); ?>
                </div>
                <?php zourney_mobile_handheld_footer(); ?>
            </div>
            <div class="zourney-overlay"></div>
            <?php
        }
    }
}


if (!function_exists('zourney_mobile_nav_button')) {
    function zourney_mobile_nav_button() {
        if (isset(get_nav_menu_locations()['handheld'])) {
            ?>
            <a href="#" class="menu-mobile-nav-button">
				<span
                        class="toggle-text screen-reader-text"><?php echo esc_attr(apply_filters('zourney_menu_toggle_text', esc_html__('Menu', 'zourney'))); ?></span>
                <i class="zourney-icon-bars"></i>
            </a>
            <?php
        }
    }
}

if (!function_exists('zourney_footer_default')) {
    function zourney_footer_default() {
        get_template_part('template-parts/copyright');
    }
}

if (!function_exists('zourney_social_share')) {
    function zourney_social_share() {
        get_template_part('template-parts/socials');
    }
}

if (!function_exists('zourney_pingback_header')) {
    /**
     * Add a pingback url auto-discovery header for single posts, pages, or attachments.
     */
    function zourney_pingback_header() {
        if (is_singular() && pings_open()) {
            echo '<link rel="pingback" href="', esc_url(get_bloginfo('pingback_url')), '">';
        }
    }
}

if (!function_exists('modify_read_more_link')) {
    function modify_read_more_link($html) {
        return preg_replace('/<a(.*)>(.*)<\/a>/iU', sprintf('<span class="more-link-wrap"><a$1><span class="faux-button">$2</span><i class="zourney-icon-long-arrow-right"></i> <span class="screen-reader-text">"%1$s"</span></a></span>', get_the_title(get_the_ID())), $html);
    }
}

add_filter('the_content_more_link', 'modify_read_more_link');

function darken_color($rgb, $darker = 1.1) {

    $hash = (strpos($rgb, '#') !== false) ? '#' : '';
    $rgb  = (strlen($rgb) == 7) ? str_replace('#', '', $rgb) : ((strlen($rgb) == 6) ? $rgb : false);
    if (strlen($rgb) != 6) {
        return $hash . '000000';
    }
    $darker = ($darker > 1) ? $darker : 1;

    list($R16, $G16, $B16) = str_split($rgb, 2);

    $R = sprintf("%02X", floor(hexdec($R16) / $darker));
    $G = sprintf("%02X", floor(hexdec($G16) / $darker));
    $B = sprintf("%02X", floor(hexdec($B16) / $darker));

    return $hash . $R . $G . $B;
}


if (!function_exists('zourney_update_comment_fields')) {
    function zourney_update_comment_fields($fields) {

        $commenter = wp_get_current_commenter();
        $req       = get_option('require_name_email');
        $aria_req  = $req ? "aria-required='true'" : '';

        $fields['author']
            = '<p class="comment-form-author">
			<input id="author" name="author" type="text" placeholder="' . esc_attr__("Your Name *", "zourney") . '" value="' . esc_attr($commenter['comment_author']) .
              '" size="30" ' . $aria_req . ' />
		</p>';

        $fields['email']
            = '<p class="comment-form-email">
			<input id="email" name="email" type="email" placeholder="' . esc_attr__("Email Address *", "zourney") . '" value="' . esc_attr($commenter['comment_author_email']) .
              '" size="30" ' . $aria_req . ' />
		</p>';

        $fields['url']
            = '<p class="comment-form-url">
			<input id="url" name="url" type="url"  placeholder="' . esc_attr__("Your Website", "zourney") . '" value="' . esc_attr($commenter['comment_author_url']) .
              '" size="30" />
			</p>';

        return $fields;
    }
}

add_filter('comment_form_default_fields', 'zourney_update_comment_fields');

add_filter('bcn_breadcrumb_title', 'zourney_breadcrumb_title_swapper', 3, 10);

function zourney_breadcrumb_title_swapper($title, $type, $id) {
    if (in_array('home', $type)) {
        $title = esc_html__('Home', 'zourney');
    }
    return $title;
}

if (!function_exists('render_html_back_to_top')) {
    function render_html_back_to_top() {
        if (zourney_get_theme_option('back_to_top')) {
            echo <<<HTML
        <a href="#" class="scrollup"><i class="zourney-icon-angle-up"></i></a>
HTML;
        }
    }
}