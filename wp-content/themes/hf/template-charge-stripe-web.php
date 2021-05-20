<?php
/*
*
* Template Name: Charge Stripe Web
*
*/
wp_head();
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

$arr = explode("_", $_POST['programs_dropdown']);
$program_id = $arr[0];
$program_name = $arr[1];
?>

<!-- Preloader -->
<div class="preloader">
  <div class="spinner"></div>
</div>
<!-- ./Preloader -->
<?php

require_once(get_stylesheet_directory().'/framework/stripe/init.php');

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

$customer = \Stripe\Customer::create(array(
  'email' => $_POST['donorEmail'],
  'card'  => $token
));

$charge = \Stripe\Charge::create(array(
  'customer' => $customer->id,
  'amount'   => $_POST['amount']*100,
  'currency' => 'usd'
));

$sub = substr($charge, 20);

$response = json_decode($sub, true);

// echo "<pre>";
// print_r($response);
// echo "</pre>";

$amount = $response['amount']/100;

if($response['status'] == 'succeeded') {

  if($program_name=='General') {
    $donationFor = 'General';
  } else {
    $donationFor = 'Program';
  }

  $campaign_id = !empty($_POST['campaign_id']) ? $_POST['campaign_id'] : '';


  if($_POST['donationType']=='pledge') {
    wp_update_post( array (
      'ID' => $_POST['donationID'],
      'post_title' => $_POST['donorID'].'-'.$program_id,
      'post_type' => 'hf_donations',
      'meta_input' => array(
        'hfusa-donation_type' => 'Donation',
        'hfusa-donation_for' => $donationFor,
        'hfusa-donation_amount' => $amount,
        'hfusa-program_id' => $program_id,
        'hfusa-program_name' => $program_name,
        'hfusa-donor_id' => $_POST['donorID'],
        'hfusa-donor_name' => $_POST['donorName'],
        'hfusa-donor_email' => $_POST['donorEmail'],
        'hfusa-donor_phone' => $_POST['donorPhone'],
        'hfusa-donor_state' => $_POST['donorState'],
        'hfusa-pledge_promise_date' => ''
      ),
    ));
  } else {
    wp_insert_post( array(
      'post_title' => $_POST['donorID'].'-'.$program_id,
      'post_type' => 'hf_donations',
      'post_status' => 'publish',
      'meta_input' => array(
        'hfusa-donation_type' => 'Donation',
        'hfusa-donation_for' => $donationFor,
        'hfusa-donation_amount' => $amount,
        'hfusa-program_id' => $program_id,
        'hfusa-program_name' => $program_name,
        'hfusa-donor_id' => $_POST['donorID'],
        'hfusa-donor_name' => $_POST['donorName'],
        'hfusa-donor_email' => $_POST['donorEmail'],
        'hfusa-donor_phone' => $_POST['donorPhone'],
        'hfusa-donor_state' => $_POST['donorState'],
        'hfusa-donation_campaign_id' => $campaign_id
      ),
    ) );
  }

  $res_url = home_url().'/checkout-response/?success=true&type=Donation&amount='.$amount;
  ?>
  <script>
   (function() {
    window.location.replace('<?php echo $res_url;?>');
  })();
</script>
<?php
} else {
  $res = $response['failure_message'];
  $res_url = home_url().'/checkout-response/?success=false&message='.$res;
  ?>
  <script>
   (function() {
    window.location.replace('<?php echo $res_url;?>');
  })();
</script>
<?php
}
?>