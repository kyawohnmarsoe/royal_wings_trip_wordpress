<?php
/**
 * The loop template file.
 *
 * Included on pages like index.php, archive.php and search.php to display a loop of posts
 * Learn more: https://codex.wordpress.org/The_Loop
 *
 * @package zourney
 */

do_action('zourney_loop_before');

$blog_style = zourney_get_theme_option('blog_style', 'standard');

$column = 3;
$sidebar = is_active_sidebar('sidebar-blog');
if ($sidebar) {
    $column = 2;
}

$atribute = '';

if ($blog_style == 'list') {
    $atribute = 'data-elementor-columns="1"';
}

if ($blog_style == 'grid') {
    $atribute = 'data-elementor-columns=' . $column . ' data-elementor-columns-tablet=2 data-elementor-columns-mobile=1';
}
$format = 1;

if ($blog_style !== 'standard') {
    echo '<div class="row ' . esc_attr('blog-style-' . $blog_style) . '" ' . esc_attr($atribute) . '>';
}
$count = 0;
while (have_posts()) :
    the_post();

    if ($blog_style == 'list') {
        if ($count % 3 == 0) {
            $format = 4;
        } else {
            $format = 2;
        }
    }

    if ($blog_style == 'overlay') {
        if($sidebar) {
            if ($count % 5 == 0) {
                $format = 4;
            } else {
                $format = 5;
            }
        }else {
            if ($count % 6 == 0) {
                $format = 4;
            } else {
                $format = 5;
            }
        }

    }
    /**
     * Include the Post-Format-specific template for the content.
     * If you want to override this in a child theme, then include a file
     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
     */

    if ($blog_style !== 'standard') {
        get_template_part('template-parts/posts-grid/item-post-style-' . $format);
    } else {
        get_template_part('content', get_post_format());
    }
    $count++;
endwhile;

if ($blog_style !== 'standard') {
    echo '</div>';
}

/**
 * Functions hooked in to zourney_loop_after action
 *
 * @see zourney_paging_nav - 10
 */
do_action('zourney_loop_after');
