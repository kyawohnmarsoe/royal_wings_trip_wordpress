<?php

get_header(); ?>

	<div id="primary">
		<main id="main" class="site-main">

			<?php
			while ( have_posts() ) :
				the_post();

				do_action( 'zourney_page_before' );

				get_template_part( 'content', 'page' );

				/**
				 * Functions hooked in to zourney_page_after action
				 *
				 * @see zourney_display_comments - 10
				 */
				do_action( 'zourney_page_after' );

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'zourney_sidebar' );
get_footer();
