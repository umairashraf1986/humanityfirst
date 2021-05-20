<?php

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
wp_head();

class PayPal_IPN {

	function ipn($ipn_data) {
		define('SSL_P_URL', 'https://www.paypal.com/cgi-bin/webscr');
		define('SSL_SAND_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
		$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		if (!preg_match('/paypal\.com$/', $hostname)) {
			$ipn_status = 'Validation post isn\'t from PayPal';
			if ($ipn_data == true) {
				//You can send email as well
				// $this->insert_data('Validation post isn\'t from PayPal');
			}
			return false;
		}
		// parse the paypal URL
		$paypal_url = ($_REQUEST['test_ipn'] == 1) ? SSL_SAND_URL : SSL_P_URL;
		$url_parsed = parse_url($paypal_url);

		$post_string = '';
		foreach ($_REQUEST as $field => $value) {
			$post_string .= $field . '=' . urlencode(stripslashes($value)) . '&';
		}
		$post_string.="cmd=_notify-validate"; // append ipn command
		// get the correct paypal url to post request to
		$paypal_mode_status = $ipn_data; //get_option('im_sabdbox_mode');
		if ($paypal_mode_status == true)
			$fp = fsockopen('ssl://www.sandbox.paypal.com', "443", $err_num, $err_str, 60);
		else
			$fp = fsockopen('ssl://www.paypal.com', "443", $err_num, $err_str, 60);

		$ipn_response = '';

		if (!$fp) {
			// could not open the connection. If loggin is on, the error message
			// will be in the log.
			$ipn_status = "fsockopen error no. $err_num: $err_str";
			if ($ipn_data == true) {
				// echo 'fsockopen fail';
				// $this->insert_data('fsockopen fail');
			}
			return false;
		} else {
			// Post the data back to paypal
			fputs($fp, "POST $url_parsed[path] HTTP/1.1\r\n");
			fputs($fp, "Host: $url_parsed[host]\r\n");
			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
			fputs($fp, "Content-length: " . strlen($post_string) . "\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			fputs($fp, $post_string . "\r\n\r\n");

			// loop through the response from the server and append to variable
			while (!feof($fp)) {
				$ipn_response .= fgets($fp, 1024);
			}
			fclose($fp); // close connection
		}
		// Invalid IPN transaction. Check the $ipn_status and log for details.
		if (!preg_match("/VERIFIED/s", $ipn_response)) {
			$ipn_status = 'IPN Validation Failed';

			if ($ipn_data == true) {
				echo 'Validation fail';
				// $this->insert_data('Validation fail');
			}
			return false;
		} else {
			$ipn_status = "IPN VERIFIED";
			if ($ipn_data == true) {
				echo 'SUCCESS';
				// $this->insert_data('SUCCESS');
			}

			return true;
		}
	}

	function ipn_response($request) {
		include_once('../framework/classy-php-sdk/vendor/autoload.php');
		//mail("sobhagya1411@gmail.com","My subject",print_r($request,true));
		$ipn_data = true;
		if ($this->ipn($ipn_data)) {
			// if paypal sends a response code back let's handle it
			if ($ipn_data == true) {
				//mail send
				// $sub = 'PayPal IPN Message';
				// $msg = print_r($request, true);
				// $to = "Enter Receiver MailID";
				// sendEmail($to, $sub, $msg);
			}
			if(isset($request['custom']) && $request['custom'] != "") {
				parse_str($request['custom'], $output);
				if(isset($output['payment_type']) && $output['payment_type']=='events') {

					$booking_id=$output['booking_id'];
					if(!empty($booking_id)){
						
						global $wpdb;

						$booking_details=array();
						$booking_details["amount"]=$request["payment_gross"];
						$booking_details["coupon"]=$output["coupon_code"];
						$booking_details["discount_amonut"]=$output["discount_amonut"];
						$booking_details["discount_space"]=$output["discount_space"];
						$booking_details["total_cost"]=$output["total_cost"];
						$tableBookings=$wpdb->prefix.'bookings';
						$wpdb->update( 
							$tableBookings, 
							array( 
								'status' => 'approved',
							), 
							array( 'id' => $booking_id )
						);


						$bookings = $wpdb->get_row( "SELECT * FROM $tableBookings WHERE id=$booking_id" );
						if($bookings){
							$user_id=isset($bookings->user_id) ? $bookings->user_id : '';
							$event_id=isset($bookings->event_id) ? $bookings->event_id : '';
							$booking_details["userid"]=$user_id;
							$booking_details["eventid"]=$event_id;

							$booking_spaces_count = $wpdb->get_var( "SELECT SUM(booking_spaces) FROM $tableBookings WHERE event_id=$event_id AND status='approved'" );


							$event_tickets_available =get_post_meta( $event_id, 'hfusa-event_tickets_available' , true);

							if(empty($event_tickets_available)){
								$event_tickets_available=0;
							}

							$remaining_spaces = $event_tickets_available - $booking_spaces_count;
							if($remaining_spaces >= 0){
								update_post_meta( $event_id, 'hfusa-remaining_spaces', $remaining_spaces );
							} 


							if(!empty($user_id)){
								$user_info = get_userdata($user_id);
								$booking_details["first_name"]=get_user_meta( $user_id, 'first_name', true );
								$booking_details["last_name"]=get_user_meta( $user_id, 'last_name', true );
								$booking_details["role"]=get_user_meta( $user_id, 'hf_user_role', true );
								$booking_details["company"]=get_user_meta( $user_id, 'hf_user_company', true );
								$user_email=isset($user_info->data->user_email) ? $user_info->data->user_email : '';
							}

							$classy_campaign_id = get_post_meta($event_id, 'hfusa-classy_campaign_id', true);

							if($classy_campaign_id) {
								$client = new \Classy\Client([
						            'client_id' => 'ngVpuzzCKcldwe2x',
						            'client_secret' => 'QwtBc22E4F068HyU',
						            'version' => '2.0' // version of the API to be used
						        ]);

						        $session = $client->newAppSession();

						        // Post offline transaction on Classy
						        try {
						            $items = array(
						                array(
						                    "campaign_id" => $classy_campaign_id,
						                    "raw_final_price" => $output["total_cost"],
						                    "raw_currency_code" => 'USD',
						                )
						            );
						            $options = array(
						                "member_email_address" => $user_email,
						                "items" => $items,
						                "billing_first_name" => $booking_details["first_name"],
						                "billing_last_name" => $booking_details["last_name"],
						            );

						            $post_transaction = $client->post('/campaigns/'.$classy_campaign_id.'/transactions?auto_allocate=false', $session, $options);

						        } catch (\Classy\Exceptions\APIResponseException $e) {
						            // Get the HTTP response code
						            $code = $e->getCode();
						            // Get the response content
						            $content = $e->getResponseData();
						            // Get the response headers
						            $headers = $e->getResponseHeaders();
						        }
							}
						}


						$guest_firstname=isset($guest["firstname"]) ? $guest["firstname"] : '';
						$guest_lastname=isset($guest["lastname"]) ? $guest["lastname"] : '';
						$guest_email=isset($guest["email"]) && !empty($guest["email"]) ? $guest["email"] : '';
						$guest_phone=isset($guest["phone"]) && !empty($guest["phone"]) ? $guest["phone"] : 'N/A';
						$guest_role=isset($guest["role"]) && !empty($guest["role"]) ? $guest["role"] : 'N/A';
						$guest_company=isset($guest["company"]) && !empty($guest["company"]) ? $guest["company"] : 'N/A';
						$guests = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}guest_bookings WHERE booking_id=$booking_id" );
						$bookings_information=array();
						if(!empty($guests) && is_array($guests)){
							foreach ($guests as $guest) {
								$guestArr=array();
								$guestArr["firstname"] = $guest->first_name;
								$guestArr["lastname"] = $guest->last_name;
								$guestArr["email"] = $guest->email;
								$guestArr["phone"] = $guest->phone;
								$guestArr["role"] = $guest->role;
								$guestArr["company"] = $guest->company;
								$bookings_information[]=$guestArr;
							}

						}


						$booking_details["bookings_information"]	=	json_encode($bookings_information);

						$admin_email = get_option( 'admin_email' ); 
						send_booking_email_mobile($user_email,$booking_details,$booking_id,false);
						send_booking_email_mobile($admin_email,$booking_details,$booking_id,true);
					}

				}else{

					$order_id = $output['order_id'];
					$order = wc_get_order( $order_id );
					$order_data = $order->get_data();
					$order_total = $order_data['total'];
					$order_currency = $order_data['currency'];
					$order_customer_id = $order_data['customer_id'];

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
					            'meta_input'               => array(
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
			}
		}
	}

	// function issetCheck($post, $key) {
	// 	if (isset($post[$key])) {
	// 		$return = $post[$key];
	// 	} else {
	// 		$return = '';
	// 	}
	// 	return $return;
	// }

	// function insert_data($data) {
	// 	global $wpdb;
	// 	$table_name = $wpdb->prefix . "paypal_ipn_data";
	// 	$wpdb->insert( 
	// 		$table_name,
	// 		array( 
	// 			'data' => $data
	// 		)
	// 	);
	// }

}

$obj = New PayPal_IPN();
$obj->ipn_response($_REQUEST);
