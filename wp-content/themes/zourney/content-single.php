<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="single-content">
        <?php
        /**
         * Functions hooked in to zourney_single_post_top action
         *
         * @see zourney_post_thumbnail       - 10
         *
         */
        do_action('zourney_single_post_top'); ?>

        <div class="entry-content-wrapper">
            <?php
            /**
             * Functions hooked in to zourney_single_post action
             * @see zourney_post_header          - 15
             * @see zourney_post_content         - 30
             */
            do_action('zourney_single_post');

            /**
             * Functions hooked in to zourney_single_post_bottom action
             *
             * @see zourney_post_taxonomy       - 5
             * @see zourney_post_nav            - 10
             * @see zourney_display_comments    - 20
             */
            do_action('zourney_single_post_bottom');
            ?>
        </div>
    </div>

</article><!-- #post-## -->
