<article id="post-<?php the_ID(); ?>" <?php post_class('article-default'); ?>>
    <?php
    zourney_post_thumbnail('post-thumbnail');
    ?>
    <div class="entry-content-wrapper">
        <?php
        /**
         * Functions hooked in to zourney_loop_post action
         *
         * @see zourney_post_header          - 10
         * @see zourney_post_content         - 30
         */
        do_action('zourney_loop_post');
        ?>
    </div>

</article><!-- #post-## -->

