<?php
/*
*
* Template Name: Charge Paypal
*
*/
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
wp_head();

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
?>
<style>
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
a.btn-open-app:active,
a.btn-open-app:hover {
    background: #009bc1;
    outline: none;
}
a.btn-open-app:hover {
    color: #fff;
    text-decoration: none;
}
</style>
<?php

// Autoload the SDK Package. This will include all the files and classes to your autoloader
require get_template_directory() . '/PayPal-PHP-SDK/autoload.php';
require get_template_directory() . '/PayPal-PHP-SDK/resultPrinter.php';
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentCard;
use PayPal\Api\Transaction;

// Provide your Secret Key. Replace the given one with your app clientId, and Secret
// https://developer.paypal.com/webapps/developer/applications/myapps
// AXf_L3J8yMwXAPLn4RiXq7PKSl4jnXpdYvpnrxkBUbm9BgCgTKRIKz0lTnsFdX6u9LO62JCZaYMymdGS
// EAsdLsSc8gGVchb_mY2J450cgMm_kuZk13nFT8Zk2WbNnqRfQ7KxfxCKnlWovVX4gQVW2uikdAVOhqTb


/* Paypal Configrations */
$hf_paypal_client_id = get_option( 'hf_paypal_client_id' );
$hf_paypal_client_secret = get_option( 'hf_paypal_client_secret' );

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        $hf_paypal_client_id,     // ClientID
        $hf_paypal_client_secret      // ClientSecret
        // 'AZp7CGWXX3uVIedrRqN7eBhQBRn-052jVNcnuM7ssifDOVfL7mgcWLykGIhtHFHxEEEAaUSKVyQ8Xj8Y',     // ClientID
        // 'EH2kTtLun__65w-U1habd1XYpAZZH3BHQnIR7R70htbtqrXtoPCy_kfv-U6EMF3i2W8vNfhlC_FQ5JGR'      // ClientSecret
    )
);

$apiContext->setConfig(
  array(
    'log.LogEnabled' => true,
    'log.FileName' => 'PayPal.log',
    'log.LogLevel' => 'DEBUG'
)
);

$card = new PaymentCard();
$card->setType($_POST['card_type'])
->setNumber($_POST['card_number'])
->setExpireMonth($_POST['expiry_month'])
->setExpireYear($_POST['expiry_year'])
->setCvv2($_POST['cvc'])
->setFirstName($_POST['donorName'])
->setBillingCountry("US");
$fi = new FundingInstrument();
$fi->setPaymentCard($card);
$payer = new Payer();
$payer->setPaymentMethod("credit_card")
->setFundingInstruments(array($fi));
$item1 = new Item();
$item1->setName($_POST['programName'])
->setDescription('Donation for '.$_POST['programName'])
->setCurrency('USD')
->setQuantity(1)
->setTax(0)
->setPrice($_POST['amount']);

$itemList = new ItemList();
$itemList->setItems(array($item1));
$details = new Details();
$details->setShipping(0)
->setTax(0)
->setSubtotal($_POST['amount']);
$amount = new Amount();
$amount->setCurrency("USD")
->setTotal($_POST['amount'])
->setDetails($details);
$transaction = new Transaction();
$transaction->setAmount($amount)
->setItemList($itemList)
->setDescription("Donation for ".$_POST['programName'])
->setInvoiceNumber(uniqid());
$payment = new Payment();
$payment->setIntent("sale")
->setPayer($payer)
->setTransactions(array($transaction));
$request = clone $payment;
try {
    $payment->create($apiContext);
    $response = json_decode($payment, true);
    // echo "<pre>";
    // print_r($response);
    // echo "</pre>";
    $amount = $response['transactions'][0]['amount']['total'];

    if($response['state']=='approved') {

        if($_POST['donationFor']=='general') {
          $donationFor = 'General';
      } else {
          $donationFor = 'Program';
      }

      if($_POST['donationType']=='pledge') {
        wp_update_post( array (
            'ID' => $_POST['donationID'],
            'post_title' => $_POST['donorID'].'-'.$_POST['programID'],
            'post_type' => 'hf_donations',
            'meta_input' => array(
                'hfusa-donation_type' => 'Donation',
                'hfusa-donation_for' => $donationFor,
                'hfusa-donation_amount' => $amount,
                'hfusa-program_id' => $_POST['programID'],
                'hfusa-program_name' => $_POST['programName'],
                'hfusa-donor_id' => $_POST['donorID'],
                'hfusa-donor_name' => $_POST['donorName'],
                'hfusa-donor_email' => $_POST['donorEmail'],
                'hfusa-donor_phone' => $_POST['donorPhone'],
                'hfusa-donor_state' => $_POST['donorState'],
                'hfusa-donation_campaign_id' => $_POST['campaignID'],
                'hfusa-pledge_promise_date' => ''
            ),
        ));
    } else {
        wp_insert_post( array(
            'post_title' => $_POST['donorID'].'-'.$_POST['programID'],
            'post_type' => 'hf_donations',
            'post_status' => 'publish',
            'meta_input' => array(
                'hfusa-donation_type' => 'Donation',
                'hfusa-donation_for' => $donationFor,
                'hfusa-donation_amount' => $amount,
                'hfusa-program_id' => $_POST['programID'],
                'hfusa-program_name' => $_POST['programName'],
                'hfusa-donation_campaign_id' => $_POST['campaignID'],
                'hfusa-donor_id' => $_POST['donorID'],
                'hfusa-donor_name' => $_POST['donorName'],
                'hfusa-donor_email' => $_POST['donorEmail'],
                'hfusa-donor_phone' => $_POST['donorPhone'],
                'hfusa-donor_state' => $_POST['donorState']
            ),
        ) );
    }
    echo "<h2>Successfully charged $".$amount."!</h2>";
    echo '<a href="humanityFirstAppScheme://" class="btn-open-app">Open App</a>';
}

} catch (Exception $ex) {
    //ResultPrinter::printError('Create Payment Using Credit Card. If 500 Exception, try creating a new Credit Card using <a href="https://www.paypal-knowledge.com/infocenter/index?page=content&widgetview=true&id=FAQ1413">Step 4, on this link</a>, and using it.', 'Payment', null, $request, $ex);
    
    $response = json_decode($ex->getData(), true);
    echo "<h2>Error: ".$response['message']."</h2>";
    exit(1);
}
 //ResultPrinter::printResult('Create Payment Using Credit Card', 'Payment', $payment->getId(), $request, $payment);

return $payment;
?>