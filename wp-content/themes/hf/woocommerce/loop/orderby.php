<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if(!empty($_GET['program_id'])){

	$program_id = $_GET['program_id'];
	?>
	<div class="float-left hf-program-filter-shop-page">
		<h5>Displaying products related to "<?php echo get_the_title($program_id); ?>" 
			<a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">View all Products</a>
		</h5>
	</div>
	<?php
}
?>

<div class="shop-page-filters">
	<div class="row">
		<div class="col-sm-12 col-md-4"><?php get_product_search_form(); ?></div>
		<div class="float-right col-sm-12 col-md-4  hf-categories-filter text-left">
			<label for="product_cat">Filter</label>
			<div class="dropdown-cnt">
				<?php the_widget( 'WC_Widget_Product_Categories', 'dropdown=1' ); ?>
			</div>
		</div>
		<div class="hf-categories-filter text-left col-sm-12 col-md-4 ">
			<label>Sort by</label>
			<form class="woocommerce-ordering" method="get">
				<select name="orderby" class="orderby">
					<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
						<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
					<?php endforeach; ?>
				</select>
				<input type="hidden" name="paged" value="1" />
				<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
			</form>
		</div>
	</div>
</div>
