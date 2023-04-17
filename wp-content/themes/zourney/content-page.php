<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * Functions hooked in to zourney_page action
	 *
	 * @see zourney_page_header          - 10
	 * @see zourney_page_content         - 20
	 *
	 */
	do_action( 'zourney_page' );
	?>
</article><!-- #post-## -->
