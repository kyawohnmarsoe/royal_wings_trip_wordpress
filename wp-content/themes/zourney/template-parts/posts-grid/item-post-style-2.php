<div class="column-item post-style-2 hentry">
    <div class="post-inner">
        <?php zourney_post_thumbnail('zourney-post-grid'); ?>
        <div class="entry-content-wrapper">
            <div class="entry-header">
                <div class="entry-meta">
                    <?php zourney_post_meta();?>
                </div>
                <?php the_title(sprintf('<h3 class="entry-title omega"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>'); ?>
                <span class="line"></span>
            </div>
            <div class="entry-content">
                <p><?php echo wp_trim_words(wp_kses_post(get_the_excerpt()), 60); ?></p>
                <?php  echo '<div class="more-link-wrap"><a class="more-link" href="' . get_permalink() . '">' . esc_html__('Read more', 'zourney') . '<i class="zourney-icon-arrow-long-right"></i></a></div>'; ?>
            </div>
        </div>
    </div>
</div>
