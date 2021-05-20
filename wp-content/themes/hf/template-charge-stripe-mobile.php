<?php
/*
*
* Template Name: Charge Stripe Mobile (REST API)
*
*/

if(!empty($_POST['order_id'])) {

	if(!empty($_POST['stripeToken'])) {

		require_once('framework/stripe/init.php');

		$hf_stripe_secret = get_option( 'hf_stripe_secret' );

		\Stripe\Stripe::setApiKey($hf_stripe_secret);

		// Get the payment token ID
		$token  = $_POST['stripeToken'];

		$order_id = $_POST['order_id'];
		$order = wc_get_order( $order_id );
		$order_data = $order->get_data();
		$order_currency = $order_data['currency'];
		$order_total = $order_data['total'];
		$order_customer_id = $order_data['customer_id'];

		// Charge the user's card:
		$charge = \Stripe\Charge::create(array(
			"amount" => $order_total*100,
			"currency" => $order_currency,
			"description" => '',
			"source" => $token,
		));

		$sub = substr($charge, 20);

		$response = json_decode($sub, true);

		if( $response['status'] == 'succeeded' ) {
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

		header('Content-Type: application/json');
		exit($sub);
	} else {
		echo "Stripe Token is required";
	}

} else {
	echo "Order ID is required";
}

?>