<?php

$form = '<form class="pull-left product-search-form" role="search" method="get" id="searchform" action="' . esc_url( home_url( '/'  ) ) . '">
	<div>
	<label class="srch-prod">Search here</label>
		<label class="screen-reader-text" for="s">' . __( 'Search for:', 'woocommerce' ) . '</label>
		<input type="text" value="' . get_search_query() . '" name="s" class="form-control" id="s" placeholder="' . __( 'Search..', 'woocommerce' ) . '" />
		<input type="submit" class="btn-blue" id="searchsubmit" value="'. esc_attr__( 'Search', 'woocommerce' ) .'" />
		<input type="hidden" name="post_type" value="product" />
	</div>
</form>';

echo $form;
