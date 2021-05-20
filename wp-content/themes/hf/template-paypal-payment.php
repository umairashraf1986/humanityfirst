<?php
/*
*
* Template Name: Paypal Payment
*
*/
wp_head();




/* Paypal Configrations */
$hf_paypal_environment = get_option( 'hf_paypal_environment' );
$hf_paypal_merchant_email = get_option( 'hf_paypal_merchant_email' );

if($hf_paypal_environment == 'live'){
    $paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
}else{
    $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
}

// $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
//Here we can used seller email id.
$merchant_email = $hf_paypal_merchant_email;
// $merchant_email = 'umair_ashraf1986@yahoo.com';

//here we can put cancel URL when payment is not completed.
$cancel_return = get_template_directory_uri().'/paypal-ipn';
//here we can put cancel URL when payment is Successful.
$success_return = get_template_directory_uri().'/paypal-ipn/success.php';
//PayPal call this file for ipn
$notify_url = get_template_directory_uri().'/paypal-ipn/ipn.php';

$order_id = $_GET['order_id'];
$order = wc_get_order( $order_id );
$order_data = $order->get_data();
$order_total = $order_data['total'];
$order_currency = $order_data['currency'];
$order_customer_id = $order_data['customer_id'];

$arr = array(
    "order_id" => $order_id
);
$arr = http_build_query($arr);
?>
<form name="paypalForm" action="<?php echo $paypal_url;?>" method="post">
    <input type="hidden" name="business" value="<?php echo $merchant_email;?>" />
    <input type="hidden" name="notify_url" value="<?php echo $notify_url;?>" />
    <input type="hidden" name="cancel_return" value="<?php echo $cancel_return;?>" />
    <input type="hidden" name="return" value="<?php echo $success_return;?>" />
    <input type="hidden" name="rm" value="2" />
    <input type="hidden" name="lc" value="" />
    <input type="hidden" name="no_shipping" value="1" />
    <input type="hidden" name="no_note" value="1" />
    <input type="hidden" name="currency_code" value="<?php echo $order_currency; ?>" />
    <input type="hidden" name="page_style" value="paypal" />
    <input type="hidden" name="charset" value="utf-8" />
    <input type="hidden" name="item_name" value="Donation for Humanity First" />
    <input type="hidden" name="cbt" value="Back to Humanity First" />
    <input type="hidden" value="_xclick" name="cmd"/>
    <input type="hidden" name="amount" value="<?php echo $order_total; ?>" />
    <input type="hidden" name="quantity" value="1" />
    <input type="hidden" name="custom" value="<?php echo $arr; ?>" />
</form>

<!-- Preloader -->
<div class="preloader">
  <div class="spinner"></div>
</div>
<!-- ./Preloader -->

<script type="text/javascript">
    document.paypalForm.submit();
</script>

<?php wp_footer(); ?>
