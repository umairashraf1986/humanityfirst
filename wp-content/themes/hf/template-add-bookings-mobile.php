<?php
/**
 * Template Name: Add Bookings Mobile (REST API)
 */



require_once('braintree-php-3.26.0/lib/autoload.php');

use Braintree\Configuration;

Configuration::reset();
Configuration::environment('sandbox');
Configuration::merchantId('vf323qvrm8dyzkxv');
Configuration::publicKey('5x6dwwjpqv5x3phc');
Configuration::privateKey('7127ac264a5dcf34437b10ae49a2a541');

require_once('framework/stripe/init.php');

header('Content-Type: application/json');

if(isset($_POST)){

  $paymentType=!empty($_POST["paymenttype"]) ? $_POST["paymenttype"] : "";
  $amount=!empty($_POST["amount"]) ? $_POST["amount"] : 0;
  $currency=!empty($_POST["currency"]) ? $_POST["currency"] : "usd";
  $desc=!empty($_POST["desc"]) ? $_POST["desc"] : "";
  $event_id=!empty($_POST["eventid"]) ? $_POST["eventid"] : "";
  $user_id=$_POST["userid"];
  $result_token  = !empty($_POST['stripeToken']) ? $_POST['stripeToken'] : '';
  $nonceFromTheClient  = !empty($_POST['payment_method_nonce']) ? $_POST['payment_method_nonce'] : '';
  $coupon_id=!empty($_POST["couponid"]) ? $_POST["couponid"] : null;
  $discountedspaces=!empty($_POST["discountedspaces"]) ? $_POST["discountedspaces"] : 0;
  $userDetails=get_userdata( $user_id );
  $email  = isset($userDetails->data->user_email) ? $userDetails->data->user_email : '';
  $bookings_information = !empty($_POST["bookings_information"]) ? $_POST["bookings_information"] : '';

  $bookingSpace = 0;

  if(!empty($bookings_information)) {
    $bookings_information = json_decode(stripslashes($bookings_information));
    $bookingSpace = count($bookings_information);
  }

  $arrayResponse = array();
  if(empty($paymentType)){
    $arrayResponse["status"] = "failed";
    $arrayResponse["message"] = "Payment type is required.";
  }else if($paymentType != "paypal" && $paymentType != "stripe"){
    $arrayResponse["status"] = "failed";
    $arrayResponse["message"] = "Valid payment type is required.";
  }else if(empty($amount)){
    $arrayResponse["status"] = "failed";
    $arrayResponse["message"] = "Payment amount is required.";
  }else if(empty($event_id)){
    $arrayResponse["status"] = "failed";
    $arrayResponse["message"] = "Event id is required.";
  }else if(empty($user_id)){
    $arrayResponse["status"] = "failed";
    $arrayResponse["message"] = "User id is required.";
  }else if($paymentType=="paypal" && empty($nonceFromTheClient)){
    $arrayResponse["status"] = "failed";
    $arrayResponse["message"] = "Token is required.Payment method nonce is required.";
  }else if($paymentType=="stripe" && empty($result_token)){
    $arrayResponse["status"] = "failed";
    $arrayResponse["message"] = "Token is required.";
  }else if(!empty($coupon_id) && empty($discountedspaces)){
    $arrayResponse["status"] = "failed";
    $arrayResponse["message"] = "Discounted spaces are required.";
  }else{

    global $wpdb;

    $event_price=get_post_meta( $event_id, 'hfusa-event_price' , true);
    $event_price = !empty($event_price) ? number_format($event_price,2) : 0;

    $booking_spaces_count = $wpdb->get_var( "SELECT SUM(booking_spaces) FROM {$wpdb->prefix}bookings WHERE event_id=$event_id AND status='approved'" );
    $event_tickets_available =get_post_meta( $event_id, 'hfusa-event_tickets_available' , true);

    if(empty($event_tickets_available)){
      $arrayResponse["status"] = "failed";
      $arrayResponse["message"] = "Event tickets are not available.";
      echo json_encode($arrayResponse);
      exit;
    }

    if(($event_tickets_available >= $booking_spaces_count) && ($event_tickets_available >= $bookingSpace)){

      if(!empty($coupon_id)){
        $used_coupons=get_post_meta( $coupon_id, 'hfusa-used_coupons', true); 
        $maximum_uses=get_post_meta( $coupon_id, 'hfusa-maximum_uses', true); 
        $used_coupons = !empty($used_coupons) ? $used_coupons : 0;
        $new_value_coupons = $used_coupons + $discountedspaces;
        if($new_value_coupons > $maximum_uses){          
          $arrayResponse["status"] = "failed";
          $arrayResponse["message"] = "Coupons are not available.";
          echo json_encode($arrayResponse);
          exit;
        }
      }

      if($paymentType=="paypal"){

       $paymentRes = Braintree_Transaction::sale([
        'amount' => $amount,
        'paymentMethodNonce' => $nonceFromTheClient,
        'options' => [
          'submitForSettlement' => True
        ]
      ]);

       $paymentRes = json_encode($paymentRes);
       $paymentRes = json_decode($paymentRes,true);

     }else{

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
        'amount'   => $amount * 100,
        'currency' => 'usd'
      ));

      $sub = substr($charge, 20);
      $paymentRes = json_decode($sub, true);

    }


    if((isset($paymentRes["success"]) && $paymentRes["success"]==true) || (isset($paymentRes['status']) && $paymentRes['status'] == 'succeeded')) {

      $arrayResponse["status"] = "success";
      $arrayResponse["message"] = "Payment succeeded";

      $primary_booking_id = $wpdb->get_var( "SELECT id FROM {$wpdb->prefix}bookings WHERE event_id=$event_id AND user_id=$user_id  AND status='approved' LIMIT 1" );
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
        $bookingSpace = $bookingSpace+1;
        $tableBookings=$wpdb->prefix.'bookings';
        $wpdb->insert($tableBookings, array(
          'event_id' => $event_id,
          'user_id' => $user_id,
          'booking_spaces' => $bookingSpace,
          'booking_price' => $event_price,
          'booking_total' => $amount,
          'coupon_id' => $coupon_id,
          'status' => 'approved',
          'booking_date' => date('Y-m-d H:i:s'),
        ));
        $booking_id=$wpdb->insert_id;
      }

      $remaining_spaces = $event_tickets_available - ($bookingSpace+$booking_spaces_count);
      if($remaining_spaces >= 0){
        update_post_meta( $event_id, 'hfusa-remaining_spaces', $remaining_spaces );
      } 

      $arrayResponse["booking_id"] = $booking_id;
      if(isset($new_value_coupons) && !empty($new_value_coupons)){
        update_post_meta( $coupon_id, 'hfusa-used_coupons', $new_value_coupons ); 
      }

      if(is_array($bookings_information) && count($bookings_information) > 0){
        $tableGuests=$wpdb->prefix.'guest_bookings';
        foreach($bookings_information as $guest){
          $firstname=isset($guest->firstname) ? $guest->firstname : '';
          $lastname=isset($guest->lastname) ? $guest->lastname : '';
          $guestEmail=isset($guest->email) ? $guest->email : '';
          $phone=isset($guest->phone) ? $guest->phone : '';
          $role=isset($guest->role) ? $guest->role : '';
          $company=isset($guest->company) ? $guest->company : '';
          $wpdb->insert($tableGuests, array(
            'booking_id' => $booking_id,
            'email' => $guestEmail,
            'phone' => $phone,
            'first_name' => $firstname,
            'last_name' => $lastname,
            'company' => $company,
            'role' => $role
          ));
        }
      }

      $admin_email = get_option( 'admin_email' ); 
      send_booking_email_mobile($email,$_POST,$booking_id,false);
      send_booking_email_mobile($admin_email,$_POST,$booking_id,true);

    } else {
      $arrayResponse["status"] = "failed";
      $arrayResponse["message"] = "Payment failed";
    }

  } else {
    $arrayResponse["status"] = "failed";
    $arrayResponse["message"] = "Event tickets are not available";
  }

}

echo json_encode($arrayResponse);
exit;
}
?>