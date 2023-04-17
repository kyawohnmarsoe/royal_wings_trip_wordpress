<?php
// Item Block
add_filter( 'babe_shortcode_all_items_item_html', 'zourney_ba_item_block', 10, 3 );
// Item Block related
add_filter( 'babe_post_related_item_html', 'zourney_ba_item_block', 10, 3 );

add_filter( 'babe_shortcode_all_items_html', 'zourney_babe_shortcode_all_items_html', 10, 3 );

add_filter('babe_pager_args','zourney_babe_pager_args',10);