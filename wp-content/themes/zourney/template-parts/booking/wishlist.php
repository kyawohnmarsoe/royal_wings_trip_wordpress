<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="ba-wishlist-container">
	<?php
	if ( ! empty( $book_ids ) ) { ?>
        <div class="wishlist-ba-header">
            <span class="ba-remove"></span>
            <span class="ba-thumbnail"><?php esc_html_e( 'Tour', 'zourney' ); ?></span>
            <span class="ba-name"></span>
            <span class="ba-price"><?php esc_html_e( 'Price', 'zourney' ); ?></span>
            <span class="ba-button"></span>
        </div>
        <div class="wishlist-ba-body">
			<?php
			foreach ( $book_ids as $book_id ) {

				$post = BABE_Post_types::get_post( $book_id );

				if ( $post ) {
					$item_url = BABE_Functions::get_page_url_with_args( $book_id, $_GET );
					?>
                    <div class="ba-wishlist-book">

                        <div class="ba-remove">
                            <a href="#"
                               class="remove zourney-wishlist-remove"
                               title="<?php esc_attr_e( 'Remove this item', 'zourney' ); ?>"
                               data-book-title="<?php echo esc_attr( get_the_title( $book_id ) ); ?>"
                               data-book-id="<?php echo absint( $book_id ); ?>">
                                <i class="zourney-icon-times"></i>
                                <img class="spinner" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/loading.gif'); ?>" alt="<?php echo esc_attr__('Zourney ', 'zourney'); ?>">
                            </a>
                        </div>

                        <div class="ba-thumbnail">
							<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $book_id ), 'medium' ) ? '<a href="' . esc_url( $item_url ) . '"><img src="' . wp_get_attachment_image_src( get_post_thumbnail_id( $book_id ), 'medium' )[0] . '"></a>' : ''; ?>
                        </div>

                        <div class="ba-name" data-title="<?php esc_attr_e( 'Tour', 'zourney' ); ?>">
                            <span class="name-title"><?php esc_html_e( 'Tour', 'zourney' ); ?></span>
                            <a href="<?php echo esc_url( $item_url ); ?>">
								<?php echo esc_attr( get_the_title( $book_id ) ); ?>
                            </a>
                        </div>

                        <div class="ba-price" data-title="<?php esc_attr_e( 'Price', 'zourney' ); ?>">
                            <span class="price-from">
                                <span class="title-price"><?php esc_html_e( 'Price', 'zourney' ); ?></span>
	                            <?php echo BABE_html::block_price_from( $post ); ?>
                            </span>
                        </div>
                        <div class="ba-button" data-title="<?php esc_attr_e( 'Book Now', 'zourney' ); ?>">
                            <a class="btn btn-book button" href="<?php echo esc_url( $item_url ); ?>">
                                <span class="button-content"> <?php esc_html_e( 'Book Now', 'zourney' ); ?></span>
                                <i class="zourney-icon-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
					<?php
				}
			}
			?>
        </div>
		<?php
	} else {
		?>
        <div class="empty-wishlist">
            <p><?php esc_html_e( 'No tour on your wishlist yet.', 'zourney' ); ?></p>
        </div>
		<?php
	}
	?>
</div>
