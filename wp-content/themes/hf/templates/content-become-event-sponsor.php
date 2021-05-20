<?php

use Roots\Sage\Titles;


$primary_user_details = isset($_SESSION['booking_details']['primary_user_details']) ? $_SESSION['booking_details']['primary_user_details'] : '';
$email = isset($primary_user_details["email"]) ? $primary_user_details["email"] : "";
$firstname = isset($primary_user_details["firstname"]) ? $primary_user_details["firstname"] : "";
$lastname = isset($primary_user_details["lastname"]) ? $primary_user_details["lastname"] : "";
$phone = isset($primary_user_details["phone"]) ? $primary_user_details["phone"] : "";
$company = isset($primary_user_details["company"]) ? $primary_user_details["company"] : "";
$role = isset($primary_user_details["role"]) ? $primary_user_details["role"] : "";
$affiliated_org = isset($primary_user_details["affiliated_org"]) ? $primary_user_details["affiliated_org"] : "";
$entree = isset($primary_user_details["entree"]) ? $primary_user_details["entree"] : "";

$guest_details = isset($_SESSION['booking_details']['guest_details']) ? $_SESSION['booking_details']['guest_details'] : array();

$guestCount = isset($guest_details["guest_email"]) ? count($guest_details["guest_email"]) : 0;
$guest_email = isset($guest_details['guest_email'][0]) ? $guest_details['guest_email'][0] : '';
$guest_firstname = isset($guest_details['guest_firstname'][0]) ? $guest_details['guest_firstname'][0] : '';
$guest_lastname = isset($guest_details['guest_lastname'][0]) ? $guest_details['guest_lastname'][0] : '';
$guest_phone = isset($guest_details['guest_phone'][0]) ? $guest_details['guest_phone'][0] : '';
$guest_company = isset($guest_details['guest_company'][0]) ? $guest_details['guest_company'][0] : '';
$guest_role = isset($guest_details['guest_role'][0]) ? $guest_details['guest_role'][0] : '';
$guest_affiliated_org = isset($guest_details['guest_affiliated_org'][0]) ? $guest_details['guest_affiliated_org'][0] : '';
$guest_entree = isset($guest_details['guest_entree'][0]) ? $guest_details['guest_entree'][0] : '';


/* Paypal Configrations */
$hf_paypal_environment = get_option('hf_paypal_environment');
$hf_paypal_merchant_email = get_option('hf_paypal_merchant_email');


if ($hf_paypal_environment == 'live') {
  $paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
} else {
  $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
}

//Here we can used seller email id.
$merchant_email = $hf_paypal_merchant_email;
//here we can put cancel URL when payment is not completed.
$cancel_return = get_template_directory_uri() . '/paypal-ipn';
//PayPal call this file for ipn
$notify_url = get_template_directory_uri() . '/paypal-ipn/ipn.php';


$thankyouPage = get_page_by_path('thank-you');
$page_id = isset($thankyouPage->ID) ? $thankyouPage->ID : '';
$permalink = get_permalink($page_id);
//here we can put success URL when payment is Successful.
$success_return = $permalink;

$arr = array(
  "payment_type" => "events"
);
$arr = http_build_query($arr);
?>
<!--==================================
= Hero Section =
=================================== -->


<section class="inner-page-title-section about-us-page" <?php echo hf_header_bg_img(); ?>>

  <div class="iptc-content">
    <h1><?= Titles\title(); ?></h1>
    <?php bootstrap_breadcrumb(); ?>
  </div>

  <div class="overlay"></div>
</section>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->

<?php

$event_id = isset($_GET['event_id']) && !empty($_GET['event_id']) ? $_GET['event_id'] : '';
$eventName = get_the_title($event_id);
$event_price = get_post_meta($event_id, 'hfusa-event_price', true);

$isDinner = false;
$event_categories = get_the_terms($event_id, 'events_category');
foreach ($event_categories as $event_cat) {
  if ($event_cat->slug == 'dinner') {
    $isDinner = true;
  }
}

?>

<div class="page-content">

  <!--====================================
  =       Current Happenings             =
  =====================================-->
  <section class="event-booking-process-container page-wrapper">
    <div class="container">
      <div class="row rtl-display">

        <div class="col-md-12 col-lg-12 col-sm-12 float-right">
          <div class="">

            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="first-tab">
                <?php echo do_shortcode('[ninja_form id=9]');?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>


  </section>
</div>
<div class="clearfix"></div>
<!--====  end of Current Happenings  ====-->

<script type="text/javascript" src="https://checkout.stripe.com/checkout.js"></script>

<!--====  End of PAGE  ====-->
