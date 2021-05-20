<?php

function validate_event_user_action(){

	$user_email = isset($_POST['user_email']) && !empty($_POST['user_email']) ? $_POST['user_email'] : '';
	$booking_event_id = isset($_POST['booking_event_id']) && !empty($_POST['booking_event_id']) ? $_POST['booking_event_id'] : '';
	$arrayUser = array('user_exist' => false,'boooking_exist'=>false );
	$_SESSION['booking_details']['primary_user_details']['boooking_exist']=false;
	global $wpdb;
	if(!empty($user_email)){
		$userDetails=get_user_by( 'email',$user_email );
		if(isset($userDetails->ID)){
			$user_id=$userDetails->ID;
			$first_name=get_user_meta( $user_id, 'first_name', true );
			$last_name=get_user_meta( $user_id, 'last_name', true );
			$phone_number=get_user_meta( $user_id, 'phone_number', true );
			$primary_booking_role=get_user_meta( $user_id, 'hf_user_role', true );

			$arrayUser["user_exist"]=true;
			$arrayUser["first_name"]=$first_name;
			$arrayUser["last_name"]=$last_name;
			$arrayUser["phone_number"]=$phone_number;
			$arrayUser["primary_booking_role"]=$primary_booking_role;
			$user_count = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}bookings WHERE user_id=$user_id AND event_id=$booking_event_id and status='approved'" );
			if($user_count > 0){
				$arrayUser["boooking_exist"]=true;
				$_SESSION['booking_details']['primary_user_details']['boooking_exist']=true;
			}
		}
	}
	echo json_encode($arrayUser);
	exit;
}

add_action( 'wp_ajax_validate_event_user_action', 'validate_event_user_action' ); 
add_action( 'wp_ajax_nopriv_validate_event_user_action', 'validate_event_user_action' );

function primary_booking_form_action(){

	global $wpdb;

	$boooking_exist=isset($_SESSION['booking_details']['primary_user_details']['boooking_exist']) && $_SESSION['booking_details']['primary_user_details']['boooking_exist'] == true ? true : false;
	$_SESSION['booking_details']['primary_user_details'] = $_POST;
	$_SESSION['booking_details']['primary_user_details']['boooking_exist'] = $boooking_exist;
	$coupon_code= isset($_SESSION['booking_details']['discount']['coupon_code']) ? $_SESSION['booking_details']['discount']['coupon_code'] : '';

	$event_id = $_SESSION['booking_details']['primary_user_details']['event_id'];

	if(!empty($coupon_code)){
		get_booking_discount($coupon_code);
	}

	$response=array();
	$coupon_amount				=	 get_booking_discount();
	$response['total']=hfBookingTotal()-$coupon_amount;
	$response['content_cart']   =    event_booking_details();
	$response['boooking_exist']=$_SESSION['booking_details']['primary_user_details']['boooking_exist'];

	if($boooking_exist) {
		$user = get_user_by('email', $_SESSION['booking_details']['primary_user_details']['email']);
		$user_id = $user->ID;

		$guest_bookings = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}guest_bookings WHERE `booking_id`=(SELECT id FROM {$wpdb->prefix}bookings WHERE `user_id`=$user_id AND `event_id`=$event_id)", ARRAY_A);

		$response['guest_bookings'] = $guest_bookings;
 	}

	echo json_encode($response);
	exit;
}

add_action( 'wp_ajax_primary_booking_form_action', 'primary_booking_form_action' ); 
add_action( 'wp_ajax_nopriv_primary_booking_form_action', 'primary_booking_form_action' );

function guest_booking_form_action(){

	if(!isset($_POST["skip"])){
		$_SESSION['booking_details']['guest_details'] = $_POST;
	}else{
		unset($_SESSION['booking_details']['guest_details']);
	}

	$coupon_code= isset($_SESSION['booking_details']['discount']['coupon_code']) ? $_SESSION['booking_details']['discount']['coupon_code'] : '';

	if(!empty($coupon_code)){
		get_booking_discount($coupon_code);
	}


	$response=array();
	$contentHtml='';
	$primary_user_details= isset($_SESSION['booking_details']['primary_user_details']) ? $_SESSION['booking_details']['primary_user_details'] : '';
	$guest_details= isset($_SESSION['booking_details']['guest_details']) ? $_SESSION['booking_details']['guest_details'] : '';

	if($primary_user_details){

		$email=$primary_user_details["email"];
		$firstname=$primary_user_details["firstname"];
		$lastname=$primary_user_details["lastname"];
		$phone=$primary_user_details["phone"];
		$company=$primary_user_details["company"];
		$role=$primary_user_details["role"];
		$affiliated_org=$primary_user_details["affiliated_org"];
		$entree=$primary_user_details["entree"];

		if($role && $company){
			$company= ", ".$company;
		}

		$contentHtml .='<div class="confirmation-booking">
		<div class="cb-head">
		<h3><i class="fa fa-ticket" aria-hidden="true"></i> Primary Booking</h3>
		</div>
		<div class="cb-content-main">
		<div class="cb-content">
		<h6 class="col-lg-6 col-md-6 col-sm-12 float-left"><i class="fa fa-user"
		aria-hidden="true"></i> '.$firstname.' '.$lastname.'
		</h6>
		<h6 class="col-lg-6 col-md-6 col-sm-12 float-left">
		<i class="fa fa-paper-plane"
		aria-hidden="true"></i><span class="summery-label">'.$email.'</span></h6>';

		if($phone){
			$contentHtml .='<h6 class="col-lg-6 col-md-6 col-sm-12 float-left"><i class="fa fa-phone"
			aria-hidden="true"></i> '.$phone.'
			</h6>';			
		}

		if($role || $company){
			$contentHtml .='<h6 class="col-lg-6 col-md-6 col-sm-12 float-left company-role"><i class="fa fa-industry"
			aria-hidden="true"></i> '.$role.$company.'
			</h6>';
		}

		if($affiliated_org){
			$contentHtml .='<h6 class="col-lg-6 col-md-6 col-sm-12 float-left"><i class="fa fa-sitemap"
			aria-hidden="true"></i> '.$affiliated_org.'
			</h6>';			
		}

		if($entree){
			$contentHtml .='<h6 class="col-lg-6 col-md-6 col-sm-12 float-left"><i class="fa fa-cutlery"
			aria-hidden="true"></i> '.$entree.'
			</h6>';			
		}

		$contentHtml .='</div>
		</div>
		</div>';

		if($guest_details){


			$contentHtml .='<div class="confirmation-booking">
			<div class="cb-head">
			<h3><i class="fa fa-address-card-o" aria-hidden="true"></i> Guest Booking</h3>
			</div>';
			$guestCount= count($guest_details["guest_email"]);


			for($i=0; $i<$guestCount;  $i++){

				$guest_firstname=$guest_details["guest_firstname"][$i];
				$guest_lastname=$guest_details["guest_lastname"][$i];
				$guest_email=$guest_details["guest_email"][$i];
				$guest_phone=$guest_details["guest_phone"][$i];
				$guest_role=$guest_details["guest_role"][$i];
				$guest_company=$guest_details["guest_company"][$i];
				$guest_affiliated_org=$guest_details["guest_affiliated_org"][$i];
				$guest_entree=$guest_details["guest_entree"][$i];

				if($guest_role && $guest_company){
					$guest_company= ", ".$guest_company;
				}

				$guestCounter = ($i+1);

				$contentHtml .='<div class="cb-content-main">
				<div class="cb-tit1e">
				<h5><i class="fa fa-circle" aria-hidden="true"></i> Guest '.sprintf("%02d", $guestCounter).'</h5>
				</div>
				<div class="cb-content">
				<h6 class="col-lg-6 col-md-6 col-sm-12 float-left"><i class="fa fa-user"
				aria-hidden="true"></i> '.$guest_firstname.' '.$guest_lastname.'</h6>';

				if($guest_email){
					$contentHtml .='<h6 class="col-lg-6 col-md-6 col-sm-12 float-left"><i class="fa fa-paper-plane"
					aria-hidden="true"></i><span class="summery-label">'.$guest_email.'</span></h6>';
				}

				if($guest_phone){
					$contentHtml .='<h6 class="col-lg-6 col-md-6 col-sm-12 float-left"><i class="fa fa-phone"
					aria-hidden="true"></i> '.$guest_phone.'</h6>';
				}

				if($guest_role || $guest_company){
					$contentHtml .='<h6 class="col-lg-6 col-md-6 col-sm-12 float-left company-role"><i class="fa fa-industry"
					aria-hidden="true"></i> '.$guest_role.$guest_company.'</h6>';
				}

				if($guest_affiliated_org){
					$contentHtml .='<h6 class="col-lg-6 col-md-6 col-sm-12 float-left"><i class="fa fa-sitemap"
					aria-hidden="true"></i> '.$guest_affiliated_org.'
					</h6>';			
				}

				if($guest_entree){
					$contentHtml .='<h6 class="col-lg-6 col-md-6 col-sm-12 float-left"><i class="fa fa-cutlery"
					aria-hidden="true"></i> '.$guest_entree.'
					</h6>';			
				}



				$contentHtml .='</div>
				</div>';
			}
			$contentHtml .='</div>';
		}
	}

	$coupon_amount				=				get_booking_discount();
	$response['content'] 		=				$contentHtml;
	$response['content_cart']   =				event_booking_details();
	$response['total']          =				hfBookingTotal()-$coupon_amount;
	$response['event_tickets_available']	=	event_tickets_available();
	echo json_encode($response);
	exit;
}

add_action( 'wp_ajax_guest_booking_form_action', 'guest_booking_form_action' ); 
add_action( 'wp_ajax_nopriv_guest_booking_form_action', 'guest_booking_form_action' );

function pay_booking_form_action(){


	$paymentResponse=false;
	$charge_type= isset($_POST["charge_type"]) && !empty($_POST["charge_type"]) ? $_POST["charge_type"] : '';

	if($charge_type=="stripe"){

		require_once('framework/stripe/init.php');

		$amount=$_POST["booking_total"];
		$result_token  = $_POST['result_token'];
		$email  = $_POST['email'];



		$hf_stripe_secret = get_option( 'hf_stripe_secret' );
		$hf_stripe_publishable_key = get_option( 'hf_stripe_publishable_key' );

		$stripe = array(
			'secret_key'      => $hf_stripe_secret,
			'publishable_key' => $hf_stripe_publishable_key
    		// 'secret_key'      => 'sk_test_W8ps8heCdK4iB7YjaoD9XvH5',
    		// 'publishable_key' => 'pk_test_qoBLH26qsuUweq96nUqzgzPW'
		);

		\Stripe\Stripe::setApiKey($stripe['secret_key']);

		$customer = \Stripe\Customer::create(array(
			'email' => $email,
			'card'  => $result_token
		));

		$charge = \Stripe\Charge::create(array(
			'customer' => $customer->id,
			'amount'   => $amount*100,
			'currency' => 'usd'
		));

		
		$sub = substr($charge, 20);
		$paymentRes = json_decode($sub, true);

		if($paymentRes['status'] == 'succeeded') {
			$paymentResponse = true;
		}

	}else if($charge_type=="paypal"){
		hf_create_booking_record($charge_type,true);
		exit;
	}


	hf_create_booking_record($charge_type,$paymentResponse);
	exit;
}



add_action( 'wp_ajax_pay_booking_form_action', 'pay_booking_form_action' ); 
add_action( 'wp_ajax_nopriv_pay_booking_form_action', 'pay_booking_form_action' );

function booking_events_redirect() {
	global $post;
	$post_name=isset($post->post_name) ? $post->post_name : '';
	$event_id = isset($_GET['event_id']) && !empty($_GET['event_id']) ? $_GET['event_id'] : '';
	if($post_name == 'event-booking' && empty($event_id)){
		$redirectPage = site_url( '/current-happenings/events/' );
		wp_redirect($redirectPage);
		exit;
	}
}
add_action ('template_redirect', 'booking_events_redirect');

function hfBookingTotal(){

	$bookingTotal=0;

	if(isset($_SESSION['booking_details'])){
		$primary_user_details= isset($_SESSION['booking_details']['primary_user_details']) ? $_SESSION['booking_details']['primary_user_details'] : '';

		$guest_details= isset($_SESSION['booking_details']['guest_details']) ? $_SESSION['booking_details']['guest_details'] : '';
		if($primary_user_details){
			$event_id = isset($primary_user_details['event_id']) ? $primary_user_details['event_id'] : '';
			$event_price=get_post_meta( $event_id, 'hfusa-event_price' , true);            
			if($primary_user_details['boooking_exist']==false){
				$bookingTotal +=$event_price;
			}

			if($guest_details){
				$guestCount= count($guest_details["guest_email"]);
				$bookingTotal +=($event_price*$guestCount);  
			}

		} 
	}

	return number_format($bookingTotal,2);
}

function event_booking_details($event_id=''){

	$discount_amonut= isset($_SESSION['booking_details']['discount']['amount']) ? $_SESSION['booking_details']['discount']['amount'] : 0;
	$discount_space= isset($_SESSION['booking_details']['discount']['space']) ? $_SESSION['booking_details']['discount']['space'] : 0;
	$primary_user_details= isset($_SESSION['booking_details']['primary_user_details']) ? $_SESSION['booking_details']['primary_user_details'] : '';

	if(empty($event_id)){
		$event_id=isset($primary_user_details['event_id']) ? $primary_user_details['event_id'] : '';
	}  

	$event_price=get_post_meta( $event_id, 'hfusa-event_price' , true);
	$event_price_formatted=  (!empty($event_price) && ($event_price >= 0))  ? number_format($event_price,2) : 0;
	$booking_space=event_booking_space();
	$booking_total=hfBookingTotal();
	$grand_total=$booking_total-$discount_amonut;

	$grand_total_formatted= ($grand_total > 0)  ? number_format($grand_total,2) : 0;

	$htmlString='';
	$htmlString .='<div class="ebps-label">
	<div class="ebpsl-inner col-sm-12">
	<h5 class="text-left col-lg-6 float-left">Price/booking</h5>
	<h5 class="text-right col-lg-6 float-left">$'.$event_price_formatted.'</h5>
	</div>';

	if($booking_space>=1){
		$htmlString .='
		<div class="ebpsl-inner col-sm-12">
		<h5 class="text-left col-lg-6 float-left">Booking Spaces</h5>
		<h5 class="text-right col-lg-6 float-left">'.$booking_space.'</h5>
		</div>';
	}

	if(!empty($discount_amonut) && $grand_total_formatted >=0){
		$htmlString .='<div class="ebpsl-inner col-sm-12">
		<h5 class="text-left col-lg-6 float-left">Discount</h5>
		<h5 class="text-right col-lg-6 float-left">$'.number_format($discount_amonut,2).'</h5>
		</div>';
		$htmlString .='
		<div class="ebpsl-inner col-sm-12">
		<h5 class="text-left col-lg-6 float-left">Discount Spaces</h5>
		<h5 class="text-right col-lg-6 float-left">'.$discount_space.'</h5>
		</div>';
	}

	$htmlString .='</div>';
	$htmlString .='<div class="clearfix"></div>
	<div class="ebps-footer" id="booking-total-sidebar">
	<h5 class="float-left text-left">Grand Total</h5>
	<h5 class="float-right text-right" id="grand-total">$<span>'.$grand_total_formatted.'</span></h5>
	</div>';
	return $htmlString;
}

function get_booking_discount($coupon_code=''){
	$coupon_amount=0;
	$discount_percentage=0;
	$dateCurrent=date("Y-m-d");
	$dateCurrentTimeStemp= strtotime($dateCurrent);
	$event_id= isset($_SESSION['booking_details']['primary_user_details']) ? $_SESSION['booking_details']['primary_user_details']['event_id'] : '';
	$booking_space=event_booking_space();
	$discount_space=event_booking_space();
	$event_price=get_post_meta( $event_id, 'hfusa-event_price' , true);

	if(!empty($coupon_code)){
		$args=array(
			'post_type' => 'hf_coupons',
			'posts_per_page'=>1,
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key'     => 'hfusa-coupon_code',
					'value'   => $coupon_code,
					'compare' => '=',
				),
				array(
					'key'     => 'hfusa-coupon_start_date',
					'value'   => $dateCurrentTimeStemp,
					'compare' => '<=',
				),
				array(
					'key'     => 'hfusa-coupon_end_date',
					'value'   => $dateCurrentTimeStemp,
					'compare' => '>=',
				),
				array(
					'key'     => 'hfusa-coupon_events',
					'value'   => array( $event_id ),
					'compare' => 'IN',
				),

			),
		);
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {    
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$postId= get_the_ID();
				$discount_percentage=get_post_meta( $postId, 'hfusa-discount_percentage', true );
				$maximum_uses= get_post_meta( $postId, 'hfusa-maximum_uses', true);
				$used_coupons= get_post_meta( $postId, 'hfusa-used_coupons', true);
				$used_coupons= !empty($used_coupons) ? $used_coupons : 0;
				$remainingCoupons=$maximum_uses-$used_coupons; 
				if($remainingCoupons>0){
					if($booking_space > $remainingCoupons){
						$discount_space = $remainingCoupons;
					}
					$total=$discount_space*$event_price;
					$coupon_amount = ($discount_percentage / 100) * $total;
					$_SESSION['booking_details']['discount']['amount']=$coupon_amount;
					$_SESSION['booking_details']['discount']['space']=$discount_space;
					$_SESSION['booking_details']['discount']['coupon_id']=$postId;
					$_SESSION['booking_details']['discount']['coupon_code']=$coupon_code;
				}
			}
			wp_reset_postdata();
		} 

	}else if(isset($_SESSION['booking_details']['discount']['amount'])){
		$coupon_amount = $_SESSION['booking_details']['discount']['amount'];
	}
	return  number_format($coupon_amount,2);
}

function event_booking_space(){
	$bookingSpace=0;
	$primary_user_details= isset($_SESSION['booking_details']['primary_user_details']) ? $_SESSION['booking_details']['primary_user_details'] : '';
	$guest_details= isset($_SESSION['booking_details']['guest_details']) ? $_SESSION['booking_details']['guest_details'] : '';

	if(isset($_SESSION['booking_details']['primary_user_details']['boooking_exist']) && $_SESSION['booking_details']['primary_user_details']['boooking_exist'] != true){
		$bookingSpace=1;
	}

	if($guest_details){
		$guestCount= count($guest_details["guest_email"]);
		$bookingSpace +=$guestCount;  
	}

	return $bookingSpace;
}

function coupon_code_form_action(){
	$coupon_code = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
	$response=array();
	$coupon_amount				=	 get_booking_discount($coupon_code);
	$response['coupon_amount']  =    $coupon_amount;
	$response['content_cart']   =    event_booking_details();
	$response['total']          =    hfBookingTotal()-$coupon_amount;
	echo json_encode($response);
	exit;
}
add_action( 'wp_ajax_coupon_code_form_action', 'coupon_code_form_action' ); 
add_action( 'wp_ajax_nopriv_coupon_code_form_action', 'coupon_code_form_action' );

function reset_coupon_code_action(){
	unset($_SESSION['booking_details']['discount']);
	$response['content_cart']   =    event_booking_details();
	$response['total']          =    hfBookingTotal();
	echo json_encode($response);
	exit;
}
add_action( 'wp_ajax_reset_coupon_code_action', 'reset_coupon_code_action' ); 
add_action( 'wp_ajax_nopriv_reset_coupon_code_action', 'reset_coupon_code_action' );

function send_booking_email($sendTo='',$booking_details='',$booking_id, $is_admin=false){

	include_once('lib_barcode/qrlib.php');

	$primary_user_details= isset($booking_details['primary_user_details']) ? $booking_details['primary_user_details'] : '';
	$guest_details= isset($booking_details['guest_details']) ? $booking_details['guest_details'] : '';

	$firstname=isset($primary_user_details["firstname"]) ? $primary_user_details["firstname"] : '';
	$lastname=isset($primary_user_details["lastname"]) ? $primary_user_details["lastname"] : '';
	$phone=isset($primary_user_details["phone"]) && !empty($primary_user_details["phone"]) ? $primary_user_details["phone"] : 'N/A';
	// $role=isset($primary_user_details["role"]) && !empty($primary_user_details["role"]) ? $primary_user_details["role"] : 'N/A';
	// $company=isset($primary_user_details["company"])  && !empty($primary_user_details["company"]) ? $primary_user_details["company"] : 'N/A';
	$affiliated_org=isset($primary_user_details["affiliated_org"])  && !empty($primary_user_details["affiliated_org"]) ? $primary_user_details["affiliated_org"] : 'N/A';
	$entree=isset($primary_user_details["entree"])  && !empty($primary_user_details["entree"]) ? $primary_user_details["entree"] : 'N/A';

	$user_email=isset($primary_user_details["email"]) ? $primary_user_details["email"] : '';
	$event_id=isset($primary_user_details["event_id"]) ? $primary_user_details["event_id"] : '';
	$event_title = get_the_title($event_id);
	$discount_space= isset($_SESSION['booking_details']['discount']['space']) ? $_SESSION['booking_details']['discount']['space'] : 0;
	$coupon_code= isset($_SESSION['booking_details']['discount']['coupon_code']) && !empty($_SESSION['booking_details']['discount']['coupon_code']) ? $_SESSION['booking_details']['discount']['coupon_code'] : 'N/A';

	$discount_amonut	=	get_booking_discount();
	$total          =	hfBookingTotal();
	$grandTotal= $total-$discount_amonut;

	$mailBody='';
	$mailBody .='<!DOCTYPE html>
	<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;margin-top:0 !important;margin-bottom:0 !important;margin-right:auto !important;margin-left:auto !important;padding-top:0 !important;padding-bottom:0 !important;padding-right:0 !important;padding-left:0 !important;height:100% !important;width:100% !important;" >
	<head style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<meta charset="utf-8" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" > <!-- utf-8 works for most cases -->
	<meta name="viewport" content="width=device-width" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" > <!-- Forcing initial-scale shouldn\'t be necessary -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" > <!-- Use the latest (edge) version of IE rendering engine -->
	<meta name="x-apple-disable-message-reformatting" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >  <!-- Disable auto-scale in iOS 10 Mail entirely -->
	<title style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></title> <!-- The title tag shows in email notifications, like Android 4.4. -->
	<!--[if mso]>
	<style style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	* {
		font-family: sans-serif !important !important;
	}
	</style>
	<![endif]-->
	<style style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >

	html,
	body {
		margin: 0 auto !important;
		padding: 0 !important;
		height: 100% !important;
		width: 100% !important;
	}


	* {
		-ms-text-size-adjust: 100%;
		-webkit-text-size-adjust: 100%;
	}


	div[style*="margin: 16px 0"] {
		margin: 0 !important;
	}


	table,
	td {
		mso-table-lspace: 0pt !important;
		mso-table-rspace: 0pt !important;
	}

	table {
		border-spacing: 0 !important;
		border-collapse: collapse !important;
		table-layout: fixed !important;
		margin: 0 auto !important;
	}
	table table table {
		table-layout: auto;
	}


	img {
		-ms-interpolation-mode:bicubic;
	}


	table.responsive-table {
		font-family: arial, sans-serif;
		border-collapse: collapse;
		width: 100%;

	}

	table.responsive-table td, th {
		border: 1px solid #dddddd;
		text-align: left;
		padding: 8px 15px;
	}

	table.responsive-table th {
		border: 1px solid #dddddd;
		text-align: left;
		padding: 12px 15px;
	}


	*[x-apple-data-detectors],  
	.x-gmail-data-detectors,    
	.x-gmail-data-detectors *,
	.aBn {
		border-bottom: 0 !important;
		cursor: default !important;
		color: inherit !important;
		text-decoration: none !important;
		font-size: inherit !important;
		font-family: inherit !important;
		font-weight: inherit !important;
		line-height: inherit !important;
	}

	a {
		cursor: pointer !important;
	}
	.a6S {
		display: none !important;
		opacity: 0.01 !important;
	}

	img.g-img + div {
		display: none !important;
	}

	.button-link {
		text-decoration: none !important;
	}


	@media only screen and (min-device-width: 375px) and (max-device-width: 413px) { 
		.email-container {
			min-width: 375px !important;
		}
	}

	@media screen and (max-width: 480px) {

		u ~ div .email-container {
			min-width: 100vw;
			width: 100% !important;
		}
	}


	.button-td,
	.button-a {
		transition: all 100ms ease-in;
	}
	.button-td:hover,
	.button-a:hover {
		background: #555555 !important;
		border-color: #555555 !important;
	}


	@media screen and (max-width: 600px) {



		.email-container {
			width: 100% !important;
			margin: auto !important;
		}


		.fluid {
			max-width: 100% !important;
			height: auto !important;
			margin-left: auto !important;
			margin-right: auto !important;
		}


		.stack-column,
		.stack-column-center {
			display: block !important;
			width: 100% !important;
			max-width: 100% !important;
			direction: ltr !important;
		}

		.stack-column-center {
			text-align: center !important;
		}

		.center-on-narrow {
			text-align: center !important;
			display: block !important;
			margin-left: auto !important;
			margin-right: auto !important;
			float: none !important;
		}
		table.center-on-narrow {
			display: inline-block !important;
		}

		.email-container p {
			font-size: 17px !important;
		}
		.responsive-table{
			width: auto !important;
		}
	}

	</style>



	<!--[if gte mso 9]>
	<xml style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<o:OfficeDocumentSettings style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<o:AllowPNG style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" />
	<o:PixelsPerInch style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >96</o:PixelsPerInch>
	</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->

	</head>
	<body width="100%" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;background-color:#fff;margin-top:0 !important;margin-bottom:0 !important;margin-right:auto !important;margin-left:auto !important;mso-line-height-rule:exactly;padding-top:0 !important;padding-bottom:0 !important;padding-right:0 !important;padding-left:0 !important;height:100% !important;width:100% !important;" >
	<center style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:100%;text-align:left;" >

	<!-- Visually Hidden Preheader Text : BEGIN -->
	<div style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family:sans-serif;" >
	(Optional) This text will appear in the inbox preview, but not the email body. It can be used to supplement the email subject line or even summarize the email\'s contents. Extended text preheaders (~490 characters) seems like a better UX for anyone using a screenreader or voice-command apps like Siri to dictate the contents of an email. If this text is not included, email clients will automatically populate it using the text (including image alt text) at the start of the email\'s body.
	</div>
	<!-- Visually Hidden Preheader Text : END -->

	<!-- Email Header : BEGIN -->
	<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600"  class="email-container" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;margin-top:0 !important;margin-bottom:0 !important;margin-right:auto !important;margin-left:auto !important;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-spacing:0 !important;border-collapse:collapse !important;table-layout:fixed !important;" >
	<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;padding-top:20px;padding-bottom:20px;padding-right:0;padding-left:0;text-align:center;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;" >
	<img src="'.get_stylesheet_directory_uri().'/assets/images/logo.png" width="200" alt="Humanity First" border="0" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;height:auto;font-family:sans-serif;font-size:15px;line-height:140%;color:#555555;-ms-interpolation-mode:bicubic;" >
	</td>
	</tr>
	</table>
	<!-- Email Header : END -->
	<!-- Email Body : BEGIN -->
	<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600"  class="email-container" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;margin-top:0 !important;margin-bottom:0 !important;margin-right:auto !important;margin-left:auto !important;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-spacing:0 !important;border-collapse:collapse !important;table-layout:fixed !important;" >

	<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<td bgcolor="#ffffff" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:left;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;" >

	<h1 style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-family:sans-serif;font-size:22px;line-height:125%;color:#333333;font-weight:normal;" >Dear ';


	if($is_admin==true){
		$mailBody .='Admin';
	}else{
		$mailBody .=$firstname.' '.$lastname;
	}

	$mailBody .=',</h1>
	</td>
	</tr>
	<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<td bgcolor="#ffffff" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;padding-top:0;padding-bottom:40px;padding-right:20px;padding-left:20px;font-family:sans-serif;font-size:15px;line-height:140%;color:#555555;text-align:left;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;" >
	<p style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" >';

	if($is_admin==true){
		$mailBody .='A booking has been made for the event "'.$event_title.'". Below are the details of the booking.';
	}else{
		$mailBody .='Thank you for booking for the event "'.$event_title.'". Your booking has been confirmed and your booking details are listed below.';
	}

	$mailBody .='</p>
	</td>
	</tr>
	<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<td bgcolor="#ffffff" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;padding-top:0;padding-bottom:40px;padding-right:20px;padding-left:20px;font-family:sans-serif;font-size:15px;line-height:140%;color:#555555;text-align:left;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;width:100%;" >
	<div style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;overflow-x:auto;" >
	<table class="responsive-table" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-spacing:0 !important;table-layout:fixed !important;margin-top:0 !important;margin-bottom:0 !important;margin-right:auto !important;margin-left:auto !important;font-family:arial, sans-serif;border-collapse:collapse !important;width:100%;" >
	<thead style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;background-color:#009bc1;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;color:#fff;line-height:36px;text-align:center;width: 100%;" >
	<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width: 100%;" >
	<th  colspan="2" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;text-align:center;border-width:1px;border-style:solid;border-color:#dddddd;padding-top:12px;padding-bottom:12px;padding-right:15px;padding-left:15px;width: 100%;" >Primary Booking</th>
	</tr>
	</thead>
	<tbody style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >';

	$mailBody .='
	<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Name </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >'.$firstname.' '.$lastname.'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	</tr>

	<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Email </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><a href="mailto:'.$user_email.'" target="_blank">'.$user_email.'</a><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	</tr>

	<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Affiliated Organization </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >'.$affiliated_org.'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	</tr>

	<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Entree Option </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >'.$entree.'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	</tr>';

	$mailBody .='</tbody>
	</table>
	</div>
	</td>
	</tr>';

	if($guest_details){
		$guestCount= count($guest_details["guest_email"]);
		for($i=0; $i<$guestCount;  $i++){
			$guest_firstname=isset($guest_details["guest_firstname"][$i]) ? $guest_details["guest_firstname"][$i] : '';
			$guest_lastname=isset($guest_details["guest_lastname"][$i]) ? $guest_details["guest_lastname"][$i] : '';
			$guest_email=isset($guest_details["guest_email"][$i]) && !empty($guest_details["guest_email"][$i]) ? $guest_details["guest_email"][$i] : '';
			$guest_phone=isset($guest_details["guest_phone"][$i]) && !empty($guest_details["guest_phone"][$i]) ? $guest_details["guest_phone"][$i] : 'N/A';
			// $guest_role=isset($guest_details["guest_role"][$i]) && !empty($guest_details["guest_role"][$i]) ? $guest_details["guest_role"][$i] : 'N/A';
			// $guest_company=isset($guest_details["guest_company"][$i]) && !empty($guest_details["guest_company"][$i]) ? $guest_details["guest_company"][$i] : 'N/A';
			$guest_affiliated_org=isset($guest_details["guest_affiliated_org"][$i]) && !empty($guest_details["guest_affiliated_org"][$i]) ? $guest_details["guest_affiliated_org"][$i] : 'N/A';
			$guest_entree=isset($guest_details["guest_entree"][$i]) && !empty($guest_details["guest_entree"][$i]) ? $guest_details["guest_entree"][$i] : 'N/A';

			$mailBody .='<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
			<td bgcolor="#ffffff" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;padding-top:0;padding-bottom:40px;padding-right:20px;padding-left:20px;font-family:sans-serif;font-size:15px;line-height:140%;color:#555555;text-align:left;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;" >
			<div style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;overflow-x:auto;" >
			<table class="responsive-table" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-spacing:0 !important;table-layout:fixed !important;margin-top:0 !important;margin-bottom:0 !important;margin-right:auto !important;margin-left:auto !important;font-family:arial, sans-serif;border-collapse:collapse !important;width:100%;" >
			<thead style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;background-color:#009bc1;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;color:#fff;line-height:36px;text-align:center;" >
			<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
			<th  colspan="2" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;text-align:center;border-width:1px;border-style:solid;border-color:#dddddd;padding-top:12px;padding-bottom:12px;padding-right:15px;padding-left:15px;" >Guest '.($i+1).' Booking</th>
			</tr>
			</thead>
			<tbody style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
			<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
			<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
			<p class="MsoNormal"><b>Name</b> <u></u><u></u></p>
			</td>
			<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
			<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >'.$guest_firstname.' '.$guest_lastname.'</b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
			</td>
			</tr>
			<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
			<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
			<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Email </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
			</td>
			<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
			<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >';
			
			if(!empty($guest_email)){
				$mailBody .='<a href="mailto:'.$guest_email.'" target="_blank">'.$guest_email.'</a>';
			}else{
				$mailBody .='N/A';
			}

			$mailBody .='<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
			</td>
			</tr>
			<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
			<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
			<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Affiliated Organization </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
			</td>
			<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
			<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >'.$guest_affiliated_org.'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
			</td>
			</tr>
			<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
			<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
			<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Entree Option </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
			</td>
			<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
			<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >'.$guest_entree.'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
			</td>
			</tr>
			</tbody>
			</table>
			</div>
			</td>
			</tr>';
		}
	}

	$mailBody .='<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<td bgcolor="#ffffff" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;padding-top:0;padding-bottom:40px;padding-right:20px;padding-left:20px;font-family:sans-serif;font-size:15px;line-height:140%;color:#555555;text-align:left;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;" >
	<div style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;overflow-x:auto;" >
	<table class="responsive-table" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-spacing:0 !important;table-layout:fixed !important;margin-top:0 !important;margin-bottom:0 !important;margin-right:auto !important;margin-left:auto !important;font-family:arial, sans-serif;border-collapse:collapse !important;width:100%;" >
	<thead style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;background-color:#009bc1;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;color:#fff;line-height:36px;text-align:center;" >
	<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<th  colspan="2" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;text-align:center;border-width:1px;border-style:solid;border-color:#dddddd;padding-top:12px;padding-bottom:12px;padding-right:15px;padding-left:15px;" >Payment Details</th>

	</tr>
	</thead>
	<tbody style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Booking ID </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >'.$booking_id.'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	</tr>
	<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Booking Date </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >'.Date("M jS Y").'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	</tr>
	<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Total Cost </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >$'.$total.'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	</tr>';


	if(!empty($discount_amonut)){

		$mailBody .='
		<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
		<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
		<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Coupon Used </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
		</td>
		<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
		<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" > '.$coupon_code.'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
		</td>
		</tr>
		<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
		<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
		<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Discount Applied  </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
		</td>
		<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
		<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >$'.number_format($discount_amonut,2).'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
		</td>
		</tr>
		<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
		<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
		<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Discounted Tickets </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
		</td>
		<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
		<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >'.$discount_space.'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
		</td>
		</tr>';

	}


	$mailBody .=' <tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b>Net Total </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >  $'.number_format($grandTotal,2).'  <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	</tr>

	</tbody>
	</table>
	</div>
	</td>
	</tr>';


	$upload_dir = wp_upload_dir();
	$tempDir =$upload_dir['basedir'].'/qrcode/';
	$baseurl =$upload_dir['baseurl'].'/qrcode';
	$checkinPage=home_url('/checkin-bookings');
	$codeContents=esc_url( add_query_arg( 'booking_id', $booking_id, $checkinPage ) );
	$encrypted = hfEncryptIt($codeContents);
	$encrypted=stripslashes(str_replace('/', '', $encrypted));

	if (!file_exists($tempDir)) {
		mkdir($tempDir, 0777, true);
	}

	$fileName = '005_file_'.$encrypted.'.png';    
	$pngAbsoluteFilePath = $tempDir.$fileName;
	$urlRelativeFilePath = $tempDir.$fileName;

	if (!file_exists($pngAbsoluteFilePath)) {
		QRcode::png($codeContents, $pngAbsoluteFilePath);
	}


	$mailBody .='<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<td bgcolor="#ffffff" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;padding-top:0;padding-bottom:40px;padding-right:20px;padding-left:20px;font-family:sans-serif;font-size:15px;line-height:140%;color:#555555;text-align:left;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;" >
	<div style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;overflow-x:auto;" >
	<table class="responsive-table" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-spacing:0 !important;table-layout:fixed !important;margin-top:0 !important;margin-bottom:0 !important;margin-right:auto !important;margin-left:auto !important;font-family:arial, sans-serif;border-collapse:collapse !important;width:100%;" >
	<thead style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;background-color:#009bc1;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;color:#fff;line-height:36px;text-align:center;" >
	<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<th  colspan="2" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;text-align:center;border-width:1px;border-style:solid;border-color:#dddddd;padding-top:12px;padding-bottom:12px;padding-right:15px;padding-left:15px;" >QR code</th>
	</tr>
	</thead>
	<tbody style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<td colspan="2" align="center" style="text-align:center;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="width:100%; text-align:center;"><img src="'.$baseurl.'/'.$fileName.'" /><u></u><u></u></p>
	<p class="MsoNormal" style="width:100%; text-align:center;"><small><i>This QR Code will be used for check-in purpose.</i></small></p>
	</td>
	</tr>
	</tbody>
	</table>
	</div>
	</td>
	</tr>';
	$mailBody .='
	</td>
	</tr>
	<!-- Background Image with Text : END -->

	</table>
	<!-- Email Body : END -->

	<!-- Email Footer : BEGIN -->
	<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;max-width:680px;font-family:sans-serif;color:#888888;font-size:12px;line-height:140%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-spacing:0 !important;border-collapse:collapse !important;table-layout:fixed !important;margin-top:0 !important;margin-bottom:0 !important;margin-right:auto !important;margin-left:auto !important;" >
	<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<td  class="x-gmail-data-detectors" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;padding-top:40px;padding-bottom:40px;padding-right:10px;padding-left:10px;width:100%;font-family:inherit !important;font-size:inherit !important;line-height:inherit !important;text-align:center;color:inherit !important;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-bottom-width:0 !important;cursor:default !important;text-decoration:none !important;font-weight:inherit !important;" >
	Humanity First © '.date("Y").' - All Rights Reserved.
	</td>
	</tr>
	</table>
	<!-- Email Footer : END -->

	<!-- Full Bleed Background Section : BEGIN -->
	<table role="presentation" bgcolor="#709f2b" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-spacing:0 !important;border-collapse:collapse !important;table-layout:fixed !important;margin-top:0 !important;margin-bottom:0 !important;margin-right:auto !important;margin-left:auto !important;" >
	<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<td valign="top" align="center" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;" >
	<div  class="email-container" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;max-width:600px;margin-top:auto;margin-bottom:auto;margin-right:auto;margin-left:auto;" >
	<!--[if mso]>
	</td>
	</tr>
	</table>
	<![endif]-->
	</div>
	</td>
	</tr>
	</table>
	<!-- Full Bleed Background Section : END -->
	</center>
	</body>
	</html>';	

	if($is_admin==true){
		$subject = 'Booking is created for event '.$event_title;
	}else{
		$subject = '"'.$event_title.'" - Booking Confirmation';
	}

	$headers = array('Content-Type: text/html; charset=UTF-8');
	$emailSent=wp_mail($sendTo, $subject, $mailBody, $headers);

	if($emailSent){
		error_log('mail sent');
	}else{
		error_log('mail not sent');
	}

}

function hfEncryptIt( $q ) {
	return base64_encode($q);
}

function hfDecryptIt( $q ) {
	return base64_decode($q);
}


function event_booking_total_action(){
	$response=array();
	$coupon_amount				=	 get_booking_discount();
	$response['total']=hfBookingTotal()-$coupon_amount;
	echo json_encode($response);
	exit;
}
add_action( 'wp_ajax_event_booking_total_action', 'event_booking_total_action' ); 
add_action( 'wp_ajax_nopriv_event_booking_total_action', 'event_booking_total_action' );



function hf_create_booking_record($charge_type,$paymentResponse){

	$response=array(
		"tickets_available"=>true,
		"tickets_booked"=>true,
	);

	if(empty($charge_type) || (!empty($charge_type) && $paymentResponse==true)){

		global $wpdb;

		$booking_details = isset($_SESSION['booking_details']) ? $_SESSION['booking_details'] : '';

		$primary_user_details= isset($booking_details['primary_user_details']) ? $booking_details['primary_user_details'] : '';
		$guest_details= isset($booking_details['guest_details']) ? $booking_details['guest_details'] : '';
		$coupon_id=isset($booking_details['discount']['coupon_id']) ? $booking_details['discount']['coupon_id'] : 0;
		$coupon_code=isset($booking_details['discount']['coupon_code']) ? $booking_details['discount']['coupon_code'] : '';
		$discount_amonut=isset($booking_details['discount']['amount']) ? $booking_details['discount']['amount'] : '';
		$discount_space=isset($booking_details['discount']['space']) ? $booking_details['discount']['space'] : '';


		$user_email=isset($primary_user_details["email"]) ? $primary_user_details["email"] : '';
		$event_id=isset($primary_user_details["event_id"]) ? $primary_user_details["event_id"] : '';
		$userDetails=get_user_by( 'email',$user_email );
		$bookingSpace=event_booking_space();	
		$user_id='';
		$event_price=get_post_meta( $event_id, 'hfusa-event_price' , true);
		$event_price = !empty($event_price) ? number_format($event_price,2) : 0;

		$booking_spaces_count = $wpdb->get_var( "SELECT SUM(booking_spaces) FROM {$wpdb->prefix}bookings WHERE event_id=$event_id AND status='approved'" );
		$event_tickets_available =get_post_meta( $event_id, 'hfusa-event_tickets_available' , true);

		if(empty($event_tickets_available)){
			$event_tickets_available=0;
		}

		$firstname=isset($primary_user_details["firstname"]) ? $primary_user_details["firstname"] : '';
		$lastname=isset($primary_user_details["lastname"]) ? $primary_user_details["lastname"] : '';
		$phone=isset($primary_user_details["phone"]) ? $primary_user_details["phone"] : '';
		$role=isset($primary_user_details["role"]) ? $primary_user_details["role"] : '';
		$company=isset($primary_user_details["company"]) ? $primary_user_details["company"] : '';
		$affiliated_org=isset($primary_user_details["affiliated_org"]) ? $primary_user_details["affiliated_org"] : '';
		$entree=isset($primary_user_details["entree"]) ? $primary_user_details["entree"] : '';


		if(isset($userDetails->ID)){
			$user_id=$userDetails->ID;
		}else{

			$userdata = array(
				'user_login'  =>  $user_email,
				'user_pass'   =>  $user_email,
				'first_name'   =>  $firstname,
				'last_name'   =>  $lastname,
				'phone_number'   =>  $phone,
				'user_email'   =>  $user_email
			);
			$user_id = wp_insert_user( $userdata ) ;
		}

		update_user_meta($user_id, 'hf_user_role', $role);
		update_user_meta($user_id, 'hf_user_company', $company);
		update_user_meta($user_id, 'first_name', $firstname);
		update_user_meta($user_id, 'last_name', $lastname);
		update_user_meta($user_id, 'hf_user_affiliated_org', $affiliated_org);
		update_user_meta($user_id, 'hf_user_entree', $entree);


		if(($event_tickets_available > $booking_spaces_count) && ($event_tickets_available >= $bookingSpace)){
			$booking_status="approved";

			if($charge_type == 'paypal'){
				$booking_status="pending";
			} else {

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
			                    "raw_final_price" => hfBookingTotal(),
			                    "raw_currency_code" => 'USD',
			                )
			            );
			            $options = array(
			                "member_email_address" => $user_email,
			                "items" => $items,
			                "billing_first_name" => $firstname,
			                "billing_last_name" => $lastname,
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

			$primary_booking_id = $wpdb->get_var( "SELECT id FROM {$wpdb->prefix}bookings WHERE event_id=$event_id AND user_id=$user_id  and status='approved' LIMIT 1" );
			if(!empty($primary_booking_id)){
				$booking_id=$primary_booking_id;
				$booking_spaces = $wpdb->get_var( "SELECT booking_spaces FROM {$wpdb->prefix}bookings WHERE event_id=$event_id AND user_id=$user_id  AND status='approved' LIMIT 1" );

				if(!empty($booking_spaces) && $booking_spaces > 0){
					$currentBookingSpace=$bookingSpace+$booking_spaces;
				}else{
					$currentBookingSpace=$bookingSpace;
				}

				$tableBookings=$wpdb->prefix.'bookings';
				$wpdb->update( 
					$tableBookings, 
					array( 
						'booking_spaces' => $currentBookingSpace,
					), 
					array( 'id' => $primary_booking_id )
				);
			}else{
				$tableBookings=$wpdb->prefix.'bookings';
				$wpdb->insert($tableBookings, array(
					'event_id' => $event_id,
					'user_id' => $user_id,
					'booking_spaces' => $bookingSpace,
					'booking_price' => $event_price,
					'booking_total' => hfBookingTotal(),
					'coupon_id' => $coupon_id,
					'status' => $booking_status,
					'booking_date' => date('Y-m-d H:i:s'),
				));
				$booking_id=$wpdb->insert_id;
			}
			
			if($charge_type != 'paypal'){
				$remaining_spaces = $event_tickets_available - ($bookingSpace+$booking_spaces_count);
				if($remaining_spaces >= 0){
					update_post_meta( $event_id, 'hfusa-remaining_spaces', $remaining_spaces );
				} 
			}

			if(!empty($coupon_id)){
				$used_coupons=get_post_meta( $coupon_id, 'hfusa-used_coupons', true);	
				$used_coupons = !empty($used_coupons) ? $used_coupons : 0;
				$new_value = $used_coupons + $bookingSpace;
				update_post_meta( $coupon_id, 'hfusa-used_coupons', $new_value ); 
			}


			if($guest_details){
				if(isset($guest_details['pre_guest_booking_id'])) {
					$preGuestCount= count($guest_details["pre_guest_booking_id"]);
					$tableGuests=$wpdb->prefix.'guest_bookings';
					for($i=0; $i<$preGuestCount;  $i++){
						$pre_guest_firstname=isset($guest_details["pre_guest_firstname"][$i]) ? $guest_details["pre_guest_firstname"][$i] : '';
						$pre_guest_lastname=isset($guest_details["pre_guest_lastname"][$i]) ? $guest_details["pre_guest_lastname"][$i] : '';
						$pre_guest_email=isset($guest_details["pre_guest_email"][$i]) ? $guest_details["pre_guest_email"][$i] : '';
						$pre_guest_phone=isset($guest_details["pre_guest_phone"][$i]) ? $guest_details["pre_guest_phone"][$i] : '';
						$pre_guest_role=isset($guest_details["pre_guest_role"][$i]) ? $guest_details["pre_guest_role"][$i] : '';
						$pre_guest_company=isset($guest_details["pre_guest_company"][$i]) ? $guest_details["pre_guest_company"][$i] : '';
						$pre_guest_affiliated_org=isset($guest_details["pre_guest_affiliated_org"][$i]) ? $guest_details["pre_guest_affiliated_org"][$i] : '';
						$pre_guest_entree=isset($guest_details["pre_guest_entree"][$i]) ? $guest_details["pre_guest_entree"][$i] : '';
						$wpdb->update(
							$tableGuests, 
							array(
								'email' => $pre_guest_email,
								'phone' => $pre_guest_phone,
								'first_name' => $pre_guest_firstname,
								'last_name' => $pre_guest_lastname,
								'company' => $pre_guest_company,
								'role' => $pre_guest_role,
								'affiliated_org' => $pre_guest_affiliated_org,
								'entree' => $pre_guest_entree
							),
							array( 'id' => $guest_details["pre_guest_booking_id"][$i] )
						);
					}
				}
				$guestCount= count($guest_details["guest_email"]);
				$tableGuests=$wpdb->prefix.'guest_bookings';
				for($i=0; $i<$guestCount;  $i++){
					$guest_firstname=isset($guest_details["guest_firstname"][$i]) ? $guest_details["guest_firstname"][$i] : '';
					$guest_lastname=isset($guest_details["guest_lastname"][$i]) ? $guest_details["guest_lastname"][$i] : '';
					$guest_email=isset($guest_details["guest_email"][$i]) ? $guest_details["guest_email"][$i] : '';
					$guest_phone=isset($guest_details["guest_phone"][$i]) ? $guest_details["guest_phone"][$i] : '';
					$guest_role=isset($guest_details["guest_role"][$i]) ? $guest_details["guest_role"][$i] : '';
					$guest_company=isset($guest_details["guest_company"][$i]) ? $guest_details["guest_company"][$i] : '';
					$guest_affiliated_org=isset($guest_details["guest_affiliated_org"][$i]) ? $guest_details["guest_affiliated_org"][$i] : '';
					$guest_entree=isset($guest_details["guest_entree"][$i]) ? $guest_details["guest_entree"][$i] : '';
					$wpdb->insert($tableGuests, array(
						'booking_id' => $booking_id,
						'email' => $guest_email,
						'phone' => $guest_phone,
						'first_name' => $guest_firstname,
						'last_name' => $guest_lastname,
						'company' => $guest_company,
						'role' => $guest_role,
						'affiliated_org' => $guest_affiliated_org,
						'entree' => $guest_entree
					));
				}
			}

			$thankyouPage=get_page_by_path('thank-you');
			$page_id = isset($thankyouPage->ID) ? $thankyouPage->ID : '';
			$permalink= get_permalink( $page_id );

			if($charge_type != 'paypal'){
				$admin_email = get_option( 'admin_email' ); 
				send_booking_email($user_email,$booking_details,$booking_id,false);
				send_booking_email($admin_email,$booking_details,$booking_id,true);
			}else{

				$arr = array(
					"payment_type" => "events",
					"booking_id" => $booking_id,
					"coupon_code" => $coupon_code,
					"discount_amonut" => $discount_amonut,
					"discount_space" => $discount_space,
					"total_cost" => hfBookingTotal(),
				);
				$arr = http_build_query($arr);
				$response["booking_details"]=$arr;
			}
			$response["redirect_url"]=$permalink;	
			unset($_SESSION['booking_details']);

		}else{
			$response["tickets_available"]=false;
			$response["tickets_booked"]=false;
		}


	}else if(!empty($charge_type) && $paymentResponse==false){
		$response["tickets_booked"]=false;
	}

	echo json_encode($response);
	exit;

}

function event_tickets_available(){
	global $wpdb;
	$event_id=isset($_SESSION['booking_details']['primary_user_details']["event_id"]) ? $_SESSION['booking_details']['primary_user_details']["event_id"] : '';

	$booking_spaces_count = $wpdb->get_var( "SELECT SUM(booking_spaces) FROM {$wpdb->prefix}bookings WHERE event_id=$event_id      AND status='approved'" );
	$event_tickets_available =get_post_meta( $event_id, 'hfusa-event_tickets_available' , true);

	$currentBookingUsers = event_booking_space();

	if(empty($event_tickets_available)){
		$event_tickets_available=0;
	}


	if(!empty($event_tickets_available) && ($event_tickets_available >= ($booking_spaces_count+$currentBookingUsers))){
		return true;
	}else{
		return false;
	}
}


function send_booking_email_mobile($sendTo='',$booking_details='',$booking_id, $is_admin=false){	

	include_once('lib_barcode/qrlib.php');

	$user_id = isset($booking_details["userid"]) ? $booking_details["userid"] : "";
	$event_id = isset($booking_details["eventid"]) ? $booking_details["eventid"] : "";
	$amount = isset($booking_details["amount"]) ? $booking_details["amount"] : 0;
	$guest_details = json_decode(stripslashes($booking_details['bookings_information']), true);

	$coupon_code = isset($booking_details["coupon"]) && !empty($booking_details["coupon"]) ? $booking_details["coupon"] : "N/A";	
	$firstname=get_user_meta( $user_id, 'first_name', true );
	$lastname=get_user_meta( $user_id, 'last_name', true );
	$userDetails=get_userdata( $user_id );
	$user_email  = isset($userDetails->data->user_email) ? $userDetails->data->user_email : '';
	$role=isset($booking_details["role"]) && !empty($booking_details["role"]) ? $booking_details["role"] : 'N/A';
	$company=isset($booking_details["company"])  && !empty($booking_details["company"]) ? $booking_details["company"] : 'N/A';
	$event_title = get_the_title($event_id);
	$discount_space= !empty($booking_details["discount_space"]) ? $booking_details["discount_space"] : 0;
	$discount_amonut  = !empty($booking_details["discount_amonut"]) ? $booking_details["discount_amonut"] : 0;
	$total          = !empty($booking_details["total_cost"]) ? $booking_details["total_cost"] : $amount;
	$grandTotal= $amount;


	$mailBody='';
	$mailBody .='<!DOCTYPE html>
	<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;margin-top:0 !important;margin-bottom:0 !important;margin-right:auto !important;margin-left:auto !important;padding-top:0 !important;padding-bottom:0 !important;padding-right:0 !important;padding-left:0 !important;height:100% !important;width:100% !important;" >
	<head style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<meta charset="utf-8" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" > <!-- utf-8 works for most cases -->
	<meta name="viewport" content="width=device-width" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" > <!-- Forcing initial-scale shouldn\'t be necessary -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" > <!-- Use the latest (edge) version of IE rendering engine -->
	<meta name="x-apple-disable-message-reformatting" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >  <!-- Disable auto-scale in iOS 10 Mail entirely -->
	<title style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></title> <!-- The title tag shows in email notifications, like Android 4.4. -->
	<!--[if mso]>
	<style style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
  * {
	font-family: sans-serif !important !important;
}
</style>
<![endif]-->
<style style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >

html,
body {
	margin: 0 auto !important;
	padding: 0 !important;
	height: 100% !important;
	width: 100% !important;
}


  * {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}


div[style*="margin: 16px 0"] {
	margin: 0 !important;
}


table,
td {
	mso-table-lspace: 0pt !important;
	mso-table-rspace: 0pt !important;
}

table {
	border-spacing: 0 !important;
	border-collapse: collapse !important;
	table-layout: fixed !important;
	margin: 0 auto !important;
}
table table table {
	table-layout: auto;
}


img {
	-ms-interpolation-mode:bicubic;
}


table.responsive-table {
	font-family: arial, sans-serif;
	border-collapse: collapse;
	width: 100%;

}

table.responsive-table td, th {
	border: 1px solid #dddddd;
	text-align: left;
	padding: 8px 15px;
}

table.responsive-table th {
	border: 1px solid #dddddd;
	text-align: left;
	padding: 12px 15px;
}


  *[x-apple-data-detectors],  
.x-gmail-data-detectors,    
.x-gmail-data-detectors *,
.aBn {
	border-bottom: 0 !important;
	cursor: default !important;
	color: inherit !important;
	text-decoration: none !important;
	font-size: inherit !important;
	font-family: inherit !important;
	font-weight: inherit !important;
	line-height: inherit !important;
}

a {
	cursor: pointer !important;
}
.a6S {
	display: none !important;
	opacity: 0.01 !important;
}

img.g-img + div {
	display: none !important;
}

.button-link {
	text-decoration: none !important;
}


@media only screen and (min-device-width: 375px) and (max-device-width: 413px) { 
	.email-container {
		min-width: 375px !important;
	}
}

@media screen and (max-width: 480px) {

	u ~ div .email-container {
		min-width: 100vw;
		width: 100% !important;
	}
}


.button-td,
.button-a {
	transition: all 100ms ease-in;
}
.button-td:hover,
.button-a:hover {
	background: #555555 !important;
	border-color: #555555 !important;
}


@media screen and (max-width: 600px) {



	.email-container {
		width: 100% !important;
		margin: auto !important;
	}


	.fluid {
		max-width: 100% !important;
		height: auto !important;
		margin-left: auto !important;
		margin-right: auto !important;
	}


	.stack-column,
	.stack-column-center {
		display: block !important;
		width: 100% !important;
		max-width: 100% !important;
		direction: ltr !important;
	}

	.stack-column-center {
		text-align: center !important;
	}

	.center-on-narrow {
		text-align: center !important;
		display: block !important;
		margin-left: auto !important;
		margin-right: auto !important;
		float: none !important;
	}
	table.center-on-narrow {
		display: inline-block !important;
	}

	.email-container p {
		font-size: 17px !important;
	}
	.responsive-table{
		width: auto !important;
	}
}

</style>



<!--[if gte mso 9]>
<xml style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<o:OfficeDocumentSettings style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<o:AllowPNG style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" />
<o:PixelsPerInch style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >96</o:PixelsPerInch>
</o:OfficeDocumentSettings>
</xml>
<![endif]-->

</head>
<body width="100%" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;background-color:#fff;margin-top:0 !important;margin-bottom:0 !important;margin-right:auto !important;margin-left:auto !important;mso-line-height-rule:exactly;padding-top:0 !important;padding-bottom:0 !important;padding-right:0 !important;padding-left:0 !important;height:100% !important;width:100% !important;" >
<center style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:100%;text-align:left;" >

<!-- Visually Hidden Preheader Text : BEGIN -->
<div style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family:sans-serif;" >
(Optional) This text will appear in the inbox preview, but not the email body. It can be used to supplement the email subject line or even summarize the email\'s contents. Extended text preheaders (~490 characters) seems like a better UX for anyone using a screenreader or voice-command apps like Siri to dictate the contents of an email. If this text is not included, email clients will automatically populate it using the text (including image alt text) at the start of the email\'s body.
</div>
<!-- Visually Hidden Preheader Text : END -->

<!-- Email Header : BEGIN -->
<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600"  class="email-container" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;margin-top:0 !important;margin-bottom:0 !important;margin-right:auto !important;margin-left:auto !important;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-spacing:0 !important;border-collapse:collapse !important;table-layout:fixed !important;" >
<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;padding-top:20px;padding-bottom:20px;padding-right:0;padding-left:0;text-align:center;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;" >
<img src="'.get_stylesheet_directory_uri().'/assets/images/logo.png" width="200" alt="Humanity First" border="0" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;height:auto;font-family:sans-serif;font-size:15px;line-height:140%;color:#555555;-ms-interpolation-mode:bicubic;" >
</td>
</tr>
</table>
<!-- Email Header : END -->
<!-- Email Body : BEGIN -->
<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600"  class="email-container" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;margin-top:0 !important;margin-bottom:0 !important;margin-right:auto !important;margin-left:auto !important;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-spacing:0 !important;border-collapse:collapse !important;table-layout:fixed !important;" >

<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<td bgcolor="#ffffff" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:left;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;" >

<h1 style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-family:sans-serif;font-size:22px;line-height:125%;color:#333333;font-weight:normal;" >Dear ';


if($is_admin==true){
	$mailBody .='Admin';
}else{
	$mailBody .=$firstname.' '.$lastname;
}

$mailBody .=',</h1>
</td>
</tr>
<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<td bgcolor="#ffffff" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;padding-top:0;padding-bottom:40px;padding-right:20px;padding-left:20px;font-family:sans-serif;font-size:15px;line-height:140%;color:#555555;text-align:left;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;" >
<p style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" >';

if($is_admin==true){
	$mailBody .='A booking has been made for the event "'.$event_title.'". Below are the details of the booking.';
}else{
	$mailBody .='Thank you for booking for the event "'.$event_title.'". Your booking has been confirmed and your booking details are listed below.';
}

$mailBody .='</p>
</td>
</tr>
<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<td bgcolor="#ffffff" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;padding-top:0;padding-bottom:40px;padding-right:20px;padding-left:20px;font-family:sans-serif;font-size:15px;line-height:140%;color:#555555;text-align:left;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;width:100%;" >
<div style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;overflow-x:auto;" >
<table class="responsive-table" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-spacing:0 !important;table-layout:fixed !important;margin-top:0 !important;margin-bottom:0 !important;margin-right:auto !important;margin-left:auto !important;font-family:arial, sans-serif;border-collapse:collapse !important;width:100%;" >
<thead style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;background-color:#009bc1;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;color:#fff;line-height:36px;text-align:center;width: 100%;" >
<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width: 100%;" >
<th  colspan="2" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;text-align:center;border-width:1px;border-style:solid;border-color:#dddddd;padding-top:12px;padding-bottom:12px;padding-right:15px;padding-left:15px;width: 100%;" >Primary Booking</th>
</tr>
</thead>
<tbody style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >';

$mailBody .='
<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Name </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
</td>
<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >'.$firstname.' '.$lastname.'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
</td>
</tr>

<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Email </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
</td>
<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><a href="mailto:'.$user_email.'" target="_blank">'.$user_email.'</a><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
</td>
</tr>

<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Company Name </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
</td>
<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >'.$company.'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
</td>
</tr>

<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Role </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
</td>
<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >'.$role.'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
</td>
</tr>';


$mailBody .='</tbody>
</table>
</div>
</td>
</tr>';


if(!empty($guest_details)){
	$i=1;
	foreach($guest_details as $guest){
		$guest_firstname=isset($guest["firstname"]) ? $guest["firstname"] : '';
		$guest_lastname=isset($guest["lastname"]) ? $guest["lastname"] : '';
		$guest_email=isset($guest["email"]) && !empty($guest["email"]) ? $guest["email"] : '';
		$guest_phone=isset($guest["phone"]) && !empty($guest["phone"]) ? $guest["phone"] : 'N/A';
		$guest_role=isset($guest["role"]) && !empty($guest["role"]) ? $guest["role"] : 'N/A';
		$guest_company=isset($guest["company"]) && !empty($guest["company"]) ? $guest["company"] : 'N/A';

		$mailBody .='<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
		<td bgcolor="#ffffff" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;padding-top:0;padding-bottom:40px;padding-right:20px;padding-left:20px;font-family:sans-serif;font-size:15px;line-height:140%;color:#555555;text-align:left;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;" >
		<div style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;overflow-x:auto;" >
		<table class="responsive-table" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-spacing:0 !important;table-layout:fixed !important;margin-top:0 !important;margin-bottom:0 !important;margin-right:auto !important;margin-left:auto !important;font-family:arial, sans-serif;border-collapse:collapse !important;width:100%;" >
		<thead style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;background-color:#009bc1;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;color:#fff;line-height:36px;text-align:center;" >
		<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
		<th  colspan="2" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;text-align:center;border-width:1px;border-style:solid;border-color:#dddddd;padding-top:12px;padding-bottom:12px;padding-right:15px;padding-left:15px;" >Guest '.($i).' Booking</th>
		</tr>
		</thead>
		<tbody style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
		<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
		<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
		<p class="MsoNormal"><b>Name</b> <u></u><u></u></p>
		</td>
		<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
		<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >'.$guest_firstname.' '.$guest_lastname.'</b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
		</td>
		</tr>
		<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
		<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
		<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Email </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
		</td>
		<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
		<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >';

		if(!empty($guest_email)){
			$mailBody .='<a href="mailto:'.$guest_email.'" target="_blank">'.$guest_email.'</a>';
		}else{
			$mailBody .='N/A';
		}

		$mailBody .='<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
		</td>
		</tr>
		<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
		<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
		<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Company Name </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
		</td>
		<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
		<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >'.$guest_company.'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
		</td>
		</tr>
		<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
		<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
		<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Role </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
		</td>
		<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
		<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >'.$guest_role.'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
		</td>
		</tr>
		</tbody>
		</table>
		</div>
		</td>
		</tr>';
		$i++;
	}
}

$mailBody .='<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<td bgcolor="#ffffff" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;padding-top:0;padding-bottom:40px;padding-right:20px;padding-left:20px;font-family:sans-serif;font-size:15px;line-height:140%;color:#555555;text-align:left;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;" >
<div style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;overflow-x:auto;" >
<table class="responsive-table" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-spacing:0 !important;table-layout:fixed !important;margin-top:0 !important;margin-bottom:0 !important;margin-right:auto !important;margin-left:auto !important;font-family:arial, sans-serif;border-collapse:collapse !important;width:100%;" >
<thead style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;background-color:#009bc1;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;color:#fff;line-height:36px;text-align:center;" >
<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<th  colspan="2" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;text-align:center;border-width:1px;border-style:solid;border-color:#dddddd;padding-top:12px;padding-bottom:12px;padding-right:15px;padding-left:15px;" >Payment Details</th>

</tr>
</thead>
<tbody style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Booking ID </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
</td>
<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >'.$booking_id.'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
</td>
</tr>
<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Booking Date </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
</td>
<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >'.Date("M jS Y").'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
</td>
</tr>
<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Total Cost </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
</td>
<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >$'.number_format($total,2).'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
</td>
</tr>';


if(!empty($discount_amonut)){

	$mailBody .='
	<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Coupon Used </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" > '.$coupon_code.'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	</tr>
	<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Discount Applied  </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >$'.number_format($discount_amonut,2).'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	</tr>
	<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >Discounted Tickets </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
	<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >'.$discount_space.'<u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
	</td>
	</tr>';

}


$mailBody .=' <tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:40%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ><b>Net Total </b> <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
</td>
<td style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
<p class="MsoNormal" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >  $'.number_format($grandTotal,2).'  <u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u><u style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" ></u></p>
</td>
</tr>

</tbody>
</table>
</div>
</td>
</tr>';


$upload_dir = wp_upload_dir();
$tempDir =$upload_dir['basedir'].'/qrcode/';
$baseurl =$upload_dir['baseurl'].'/qrcode';
$checkinPage=home_url('/checkin-bookings');
$codeContents=esc_url( add_query_arg( 'booking_id', $booking_id, $checkinPage ) );
$encrypted = hfEncryptIt($codeContents);
$encrypted=stripslashes(str_replace('/', '', $encrypted));

if (!file_exists($tempDir)) {
	mkdir($tempDir, 0777, true);
}

$fileName = '005_file_'.$encrypted.'.png';    
$pngAbsoluteFilePath = $tempDir.$fileName;
$urlRelativeFilePath = $tempDir.$fileName;

if (!file_exists($pngAbsoluteFilePath)) {
	QRcode::png($codeContents, $pngAbsoluteFilePath);
}


$mailBody .='<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<td bgcolor="#ffffff" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;padding-top:0;padding-bottom:40px;padding-right:20px;padding-left:20px;font-family:sans-serif;font-size:15px;line-height:140%;color:#555555;text-align:left;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;" >
<div style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;overflow-x:auto;" >
<table class="responsive-table" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-spacing:0 !important;table-layout:fixed !important;margin-top:0 !important;margin-bottom:0 !important;margin-right:auto !important;margin-left:auto !important;font-family:arial, sans-serif;border-collapse:collapse !important;width:100%;" >
<thead style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;background-color:#009bc1;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;color:#fff;line-height:36px;text-align:center;" >
<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<th  colspan="2" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;text-align:center;border-width:1px;border-style:solid;border-color:#dddddd;padding-top:12px;padding-bottom:12px;padding-right:15px;padding-left:15px;" >QR code</th>
</tr>
</thead>
<tbody style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<td colspan="2" align="center" style="text-align:center;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;width:60%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-width:1px;border-style:solid;border-color:#dddddd;text-align:left;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;" >
<p class="MsoNormal" style="width:100%; text-align:center;"><img src="'.$baseurl.'/'.$fileName.'" /><u></u><u></u></p>
<p class="MsoNormal" style="width:100%; text-align:center;"><small><i>This QR Code will be used for check-in purpose.</i></small></p>
</td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>';
$mailBody .='
</td>
</tr>
<!-- Background Image with Text : END -->

</table>
<!-- Email Body : END -->

<!-- Email Footer : BEGIN -->
<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;max-width:680px;font-family:sans-serif;color:#888888;font-size:12px;line-height:140%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-spacing:0 !important;border-collapse:collapse !important;table-layout:fixed !important;margin-top:0 !important;margin-bottom:0 !important;margin-right:auto !important;margin-left:auto !important;" >
<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<td  class="x-gmail-data-detectors" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;padding-top:40px;padding-bottom:40px;padding-right:10px;padding-left:10px;width:100%;font-family:inherit !important;font-size:inherit !important;line-height:inherit !important;text-align:center;color:inherit !important;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-bottom-width:0 !important;cursor:default !important;text-decoration:none !important;font-weight:inherit !important;" >
Humanity First © '.date("Y").' - All Rights Reserved.
</td>
</tr>
</table>
<!-- Email Footer : END -->

<!-- Full Bleed Background Section : BEGIN -->
<table role="presentation" bgcolor="#709f2b" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;border-spacing:0 !important;border-collapse:collapse !important;table-layout:fixed !important;margin-top:0 !important;margin-bottom:0 !important;margin-right:auto !important;margin-left:auto !important;" >
<tr style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;" >
<td valign="top" align="center" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;" >
<div  class="email-container" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;max-width:600px;margin-top:auto;margin-bottom:auto;margin-right:auto;margin-left:auto;" >
<!--[if mso]>
</td>
</tr>
</table>
<![endif]-->
</div>
</td>
</tr>
</table>
<!-- Full Bleed Background Section : END -->
</center>
</body>
</html>';

if($is_admin==true){
	$subject = 'Booking is created for event '.$event_title;
}else{
	$subject = '"'.$event_title.'" - Booking Confirmation';
}
$headers = array('Content-Type: text/html; charset=UTF-8'); 
$emailSent=wp_mail($sendTo, $subject, $mailBody, $headers);

if($emailSent){
	error_log($sendTo);
}else{
	error_log('mail not sent');
}

}


function hf_excerpt_more_st1($more) {
	global $post;

	if(get_post_type($post) == "hf_alerts"){
		return '… <a href="'. get_permalink($post->ID) . '">' . 'Read More &raquo;' . '</a>';
	}

	return $more;

}
add_filter('excerpt_more', 'hf_excerpt_more_st1');

function in_admin_header_hf_events() {
	$screen = get_current_screen();
	if($screen->post_type=='hf_events' && $screen->id=='hf_events') {
		global $post;
		global $wpdb;
		$event_id = $post->ID;

		if(!empty($event_id)){
			
			$tableBookings=$wpdb->prefix.'bookings';
			$post_type = get_post_type($event_id);

			if ( "hf_events" != $post_type ) return;

			$event_tickets_available= get_post_meta($event_id,'hfusa-event_tickets_available',true);
			if(empty($event_tickets_available)){
				$event_tickets_available=0;
			}

			$booking_spaces_count = $wpdb->get_var( "SELECT SUM(booking_spaces) FROM $tableBookings WHERE event_id=$event_id AND status='approved'" );

			if(!empty($booking_spaces_count) && $booking_spaces_count > 0){
				$remaining_spaces = $event_tickets_available - $booking_spaces_count;
				if($remaining_spaces >= 0){
					update_post_meta( $event_id, 'hfusa-remaining_spaces', $remaining_spaces );
				}
			}else{
				update_post_meta( $event_id, 'hfusa-remaining_spaces', $event_tickets_available );
			}
		}
	}
}

add_action('in_admin_header','in_admin_header_hf_events');
?>