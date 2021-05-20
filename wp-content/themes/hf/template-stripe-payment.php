<?php
/*
*
* Template Name: Stripe payment
*
*/
wp_head();
?>
<style>
	.field {
		background: white;
		box-sizing: border-box;
		font-weight: 400;
		border: 1px solid #CFD7DF !important;
		border-radius: 24px !important;
		color: #32315E;
		outline: none;
		flex: 1;
		height: 48px;
		line-height: 48px;
		padding: 0 20px !important;
		cursor: text;
		width: 100%;
	}
	.field-wrapper {
	    position: relative;
	    width: 100%;
        margin-left: 13px;
	}

	.currency {
	    position: absolute;
	    color: #CFD7DF;
	    left: 20px;
	    top: 0;
	    font-size: 20px;
	}
	.field.amount {
	    padding-left: 40px !important;
	}
	.field::-webkit-input-placeholder { color: #CFD7DF; }
	.field::-moz-placeholder { color: #CFD7DF; }
</style>

<?php

$order_id = $_GET['order_id'];
$order = wc_get_order( $order_id );
$order_data = $order->get_data();
$order_total = $order_data['total'];
$order_customer_id = $order_data['customer_id'];

$customer_first_name = get_user_meta( $order_customer_id, 'first_name', true );
$customer_last_name = get_user_meta( $order_customer_id, 'last_name', true );

?>

<div class="hf-payment-form">
	<form action="<?php echo get_stylesheet_directory_uri() . '/charge-stripe.php'; ?>" method="POST" id="payment-form">
		<label>
		  <span class="text-right">Name</span>
		  <div class="field-wrapper">
		  	<input name="donorName" class="field" placeholder="Customer Name" value="<?php echo $customer_first_name.' '.$customer_last_name; ?>" />
		  </div>
		</label>
		<label>
		  <span class="text-right">Card</span>
		  <div class="field-wrapper">
		  	<div id="card-element" class="field"></div>
		  </div>
		</label>
		<input type="hidden" name="amount" value="<?php echo $order_total; ?>">
		<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
		<button type="submit">Pay $<?php echo $order_total; ?></button>
	</form>
</div>

<script type="text/javascript" src="https://js.stripe.com/v3/"></script>

<?php wp_footer(); ?>
