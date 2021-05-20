<?php
/*
*
* Template Name: Charge Stripe
*
*/
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
wp_head();
?>
<style type="text/css">
  a.btn-open-app {
      display: block;
      background: linear-gradient(to bottom, #009bc1 0%,#6ba8c6 100%);
      width: 200px;
      text-align: center;
      color: #fff;
      text-decoration: none;
      padding: 10px 0;
      border-radius: 24px;
  }
  a.btn-open-app:focus, 
  a.btn-open-app:active {
      background: #009bc1;
  }
</style>
<?php
  require_once('framework/stripe/init.php');

  $hf_stripe_secret = get_option( 'hf_stripe_secret' );
  $hf_stripe_publishable_key = get_option( 'hf_stripe_publishable_key' );

  $stripe = array(
    'secret_key'      => $hf_stripe_secret,
    'publishable_key' => $hf_stripe_publishable_key
    // 'secret_key'      => 'sk_test_W8ps8heCdK4iB7YjaoD9XvH5',
    // 'publishable_key' => 'pk_test_qoBLH26qsuUweq96nUqzgzPW'
  );

  \Stripe\Stripe::setApiKey($stripe['secret_key']);

  $token  = $_POST['stripeToken'];

  $order_id = $_POST['order_id'];
  $order = wc_get_order( $order_id );
  $order_data = $order->get_data();
  $order_total = $order_data['total'];
  $order_currency = $order_data['currency'];
  $order_customer_id = $order_data['customer_id'];

  $user_info = get_userdata($order_customer_id);
  $customer_email = $user_info->user_email;

  $customer_first_name = get_user_meta( $order_customer_id, 'first_name', true );
  $customer_last_name = get_user_meta( $order_customer_id, 'last_name', true );

  $customer_phone_number = get_user_meta( $order_customer_id, 'phone_number', true );
  $customer_volunteer_city = get_user_meta( $order_customer_id, 'volunteer_city', true );
  $customer_volunteer_liststate = get_user_meta( $order_customer_id, 'volunteer_liststate', true );

  $customer = \Stripe\Customer::create(array(
      'email' => $customer_email,
      'card'  => $token
  ));

  $charge = \Stripe\Charge::create(array(
      'customer' => $customer->id,
      'amount'   => $order_total*100,
      'currency' => $order_currency
  ));

  $sub = substr($charge, 20);

  $response = json_decode($sub, true);

//   echo "<pre>";
//   print_r($response);
//   echo "</pre>";

  $amount = $response['amount']/100;

  if($response['status'] == 'succeeded') {

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

    if(isset($_POST['platform']) && $_POST['platform'] == 'web') {
        echo '<h2>Successfully charged $'.$amount.'!</h2>';
    } else {
        echo '<h2>Successfully charged $'.$amount.'!</h2><br>';
        echo '<a href="humanityFirstAppScheme://" class="btn-open-app">Open App</a>';
    }

  } else {
    echo $response['failure_message'];
  }
  
?>