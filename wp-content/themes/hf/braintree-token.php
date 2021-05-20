<?php

/*
*
* Template Name: Braintree Token (REST API)
*
*/

require_once('braintree-php-3.26.0/lib/autoload.php');

use Braintree\Configuration;

Configuration::reset();

Configuration::environment('sandbox');
Configuration::merchantId('vf323qvrm8dyzkxv');
Configuration::publicKey('5x6dwwjpqv5x3phc');
Configuration::privateKey('7127ac264a5dcf34437b10ae49a2a541');

if(isset($_POST['payment_method_nonce']) && !empty($_POST['payment_method_nonce'])) {
	$nonceFromTheClient = $_POST["payment_method_nonce"];
	if(!empty($_POST['order_id'])) {
		$order_id = $_POST['order_id'];
		$order = wc_get_order( $order_id );
		$order_data = $order->get_data();
		$order_total = $order_data['total'];
		$order_customer_id = $order_data['customer_id'];

		$result = Braintree_Transaction::sale([
		  'amount' => $order_total,
		  'paymentMethodNonce' => $nonceFromTheClient,
		  'options' => [
		    'submitForSettlement' => True
		  ]
		]);

		if( $result->success == true ) {
			// Iterating through each WC_Order_Item_Product objects
			foreach ($order->get_items() as $item_key => $item_values):

			    ## Using WC_Order_Item methods ##

			    // Item ID is directly accessible from the $item_key in the foreach loop or
			    $item_id = $item_values->get_id();

			    ## Using WC_Order_Item_Product methods ##

			    $product_id = $item_values->get_product_id(); // the Product id
			    $product = $item_values->get_product(); // the WC_Product object

			    ## Access Order Items data properties (in an array of values) ##
			    $item_data = $item_values->get_data();

			    $product_name = $item_data['name'];
			    $product_id = $item_data['product_id'];
			    $variation_id = $item_data['variation_id'];
			    $quantity = $item_data['quantity'];
			    $tax_class = $item_data['tax_class'];
			    $line_subtotal = $item_data['subtotal'];
			    $line_subtotal_tax = $item_data['subtotal_tax'];
			    $line_total = $item_data['total'];
			    $line_total_tax = $item_data['total_tax'];

			    $program_id = get_post_meta( $product_id, 'hfusa-related_programs', true );

			    $customer_first_name = get_user_meta( $order_customer_id, 'first_name', true );
			    $customer_last_name = get_user_meta( $order_customer_id, 'last_name', true );

			    $customer_phone_number = get_user_meta( $order_customer_id, 'phone_number', true );
			    $customer_volunteer_city = get_user_meta( $order_customer_id, 'volunteer_city', true );
			    $customer_volunteer_liststate = get_user_meta( $order_customer_id, 'volunteer_liststate', true );

			    $user_info = get_userdata($order_customer_id);
			    $customer_email = $user_info->user_email;

			    if(!empty($program_id)) {

			    	// Create post object
					$donation = array(
						'post_type'                => 'hf_donations',
						'post_title'               => $order_customer_id."-".$program_id,
						'post_status'              => 'publish',
						'meta_input'   			   => array(
					        'hfusa-donation_type'      => 'Donation',
							'hfusa-donation_for'       => 'Program',
							'hfusa-donation_amount'    => $line_total,
							'hfusa-program_id'         => $program_id,
							'hfusa-program_name'       => get_the_title( $program_id ),
							'hfusa-donor_id'           => $order_customer_id,
							'hfusa-donor_name'         => $customer_first_name." ".$customer_last_name,
							'hfusa-donor_email'        => $customer_email,
							'hfusa-donor_phone'        => $customer_phone_number,
							'hfusa-donor_city'         => $customer_volunteer_city,
							'hfusa-donor_state'        => $customer_volunteer_liststate,
							'hfusa-donation_order_id'  => $order_id,
					    ),
					);
					 
					// Insert the post into the database
					wp_insert_post( $donation );
			    }

			endforeach;

			$order = new WC_Order($order_id);
			$order->update_status('processing');
		}

		header("Content-Type: application/json");
		echo json_encode($result);
	} else {
		echo "Order ID is required";
	}
} else {
	echo ($clientToken = Braintree_ClientToken::generate());
}
	