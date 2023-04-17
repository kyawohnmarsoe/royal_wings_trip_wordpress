<div class="column-item post-style-4 hentry">
    <div class="post-inner">
        <?php zourney_post_thumbnail('zourney-item'); ?>
        <div class="entry-content-wrapper">
            <div class="entry-header">
                <div class="entry-meta">
                    <?php zourney_post_meta(); ?>
                </div>
                <?php the_title(sprintf('<h3 class="entry-title delta"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>'); ?>
            </div>
        </div>
    </div>
</div>
