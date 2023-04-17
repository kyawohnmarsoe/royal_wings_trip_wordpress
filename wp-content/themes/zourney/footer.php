
		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'zourney_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php
		/**
		 * Functions hooked in to zourney_footer action
		 *
		 * @see zourney_footer_default - 20
         * @see zourney_handheld_footer_bar - 25 - woo
		 *
		 */
		do_action( 'zourney_footer' );

		?>

	</footer><!-- #colophon -->

	<?php

		/**
		 * Functions hooked in to zourney_after_footer action
		 * @see zourney_sticky_single_add_to_cart 	- 999 - woo
		 */
		do_action( 'zourney_after_footer' );
	?>

</div><!-- #page -->

<?php

/**
 * Functions hooked in to wp_footer action
 * @see zourney_form_login 	- 1
 * @see zourney_mobile_nav - 1
 * @see render_html_back_to_top - 1
 *
 */

wp_footer();
?>

</body>
</html>
