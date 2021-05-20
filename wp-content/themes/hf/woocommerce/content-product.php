<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

if(is_shop() || is_product_category() || (!empty($_GET['post_type']) && $_GET['post_type'] == 'product')){
	?>


	<div <?php wc_product_class(); ?>>
		<?php


		echo '<div class="row">';
		echo '<div class="product-image col-md-3 col-lg-2">';
		woocommerce_template_loop_product_link_open();

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );

	woocommerce_template_loop_product_link_close(); 
	echo '</div>';
	echo '<div class="product-cnt col-md-6 col-lg-8">';
	woocommerce_template_loop_product_link_open();

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );


	woocommerce_template_loop_product_link_close(); 

	woocommerce_template_loop_rating();

	echo '<div class="product-desc">';
	echo '<div class="product-desc-inner">';

	the_excerpt(); 
	echo '</div>';

	?>

	<div class="product-meta-loop row">
		
		<div class="col-md-6 col-sm-12 float-left">
			<?php  
			woocommerce_template_loop_price(); 
			?>			
		</div>
		<?php

		$relatedPrograms = get_post_meta( get_the_ID(), 'hfusa-related_programs' );

		if(!empty($relatedPrograms) && is_array($relatedPrograms)){

			?>
			<div class="col-md-6 col-sm-12 float-left ">
				<strong>Program: </strong>
				<?php 
				$i=0;
				$countPrograms = count($relatedPrograms);

				foreach ($relatedPrograms as $program_id) {
					echo get_the_title($program_id);
					$i++;

					if($i < $countPrograms){
						echo ', ';
					}
				}
				?>			
			</div>
		<?php } ?>

	</div>
	<?php
	echo '</div>';
	echo '</div>';
	echo '<div class="col-md-3 col-lg-2">';
	echo '<div class="add-to-cart-section">';
	echo '<div>';

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );

	echo '</div>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	?>
</div>
<?php
}else{
	?>

	<li <?php wc_product_class(); ?>>
		<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );

	echo '<div class="product-data-cnt">';

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );


	echo '</div>';
	?>
</li>


<?php
}
?>
