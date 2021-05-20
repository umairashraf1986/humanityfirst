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

$guest_details= isset($_SESSION['booking_details']['guest_details']) ? $_SESSION['booking_details']['guest_details'] : array();

$guestCount= isset($guest_details["guest_email"]) ? count($guest_details["guest_email"]) : 0;
$guest_email  = isset($guest_details['guest_email'][0]) ? $guest_details['guest_email'][0] : '';
$guest_firstname  = isset($guest_details['guest_firstname'][0]) ? $guest_details['guest_firstname'][0] : '';
$guest_lastname  = isset($guest_details['guest_lastname'][0]) ? $guest_details['guest_lastname'][0] : '';
$guest_phone  = isset($guest_details['guest_phone'][0]) ? $guest_details['guest_phone'][0] : '';
$guest_company  = isset($guest_details['guest_company'][0]) ? $guest_details['guest_company'][0] : '';
$guest_role  = isset($guest_details['guest_role'][0]) ? $guest_details['guest_role'][0] : '';
$guest_affiliated_org  = isset($guest_details['guest_affiliated_org'][0]) ? $guest_details['guest_affiliated_org'][0] : '';
$guest_entree  = isset($guest_details['guest_entree'][0]) ? $guest_details['guest_entree'][0] : '';


/* Paypal Configrations */
$hf_paypal_environment = get_option( 'hf_paypal_environment' );
$hf_paypal_merchant_email = get_option( 'hf_paypal_merchant_email' );



if($hf_paypal_environment == 'live'){
    $paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
}else{
    $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
}

//Here we can used seller email id.
$merchant_email = $hf_paypal_merchant_email;
//here we can put cancel URL when payment is not completed.
$cancel_return = get_template_directory_uri().'/paypal-ipn';
//PayPal call this file for ipn
$notify_url = get_template_directory_uri().'/paypal-ipn/ipn.php';


$thankyouPage=get_page_by_path('thank-you');
$page_id = isset($thankyouPage->ID) ? $thankyouPage->ID : '';
$permalink= get_permalink( $page_id );
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
$eventName=get_the_title($event_id);
$event_price=get_post_meta( $event_id, 'hfusa-event_price' , true);

$isDinner = false;
$event_categories = get_the_terms( $event_id, 'events_category' );
foreach($event_categories as $event_cat) {
  if($event_cat->slug == 'dinner') {
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
        <div class="col-lg-4 col-md-12 col-sm-12 float-left">
          <div class="ebp-sidebar">
            <div class="ebps-inner">
              <div class="ebps-title">
                <h3><i class="fa fa-ticket" aria-hidden="true"></i> your booking</h3>
              </div>
              <div class="ebps-sub-title">
                <h2><?php echo $eventName; ?></h2>
              </div>
              <div class="clearfix"></div>
              <div id="booking-details-sidebar">
                <?php echo event_booking_details($event_id);  ?>               
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-lg-8 col-sm-12 float-right">
          <div class="">
            <div class="navigation">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link text-center active" href="#first-tab" role="tab" data-toggle="tab"><i class="fa fa-ticket" aria-hidden="true"></i> Primary Booking</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-center disabled" href="#second-tab" role="tab" data-toggle="tab"><i class="fa fa-address-card-o" aria-hidden="true"></i> Guest Booking</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-center disabled" href="#third-tab" role="tab" data-toggle="tab"><i class="fa fa-paper-plane" aria-hidden="true"></i> Confirmation</a>
                </li>
              </ul>
            </div>

            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="first-tab">
                <div class="step-one ebps-form-caontainer">
                  <div class="epbsf-inner">
                    <div class="row">
                      <form action="" method="POST" name="step-one-form" class="step-one-form" id="form-primary-booking">

                        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 float-left">
                          <input placeholder="Email *" type="text" class="form-control" name="email" id="email" value="<?php echo $email; ?>">
                          <span class="loader_icon"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/loader.gif" ></span>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                          <input placeholder="First Name *" type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $firstname; ?>">
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                          <input placeholder="Last Name *" type="text" class="form-control" name="lastname" id="lastname" value="<?php echo $lastname; ?>">
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                          <input placeholder="Phone" type="text" class="form-control" name="phone" id="phone" value="<?php echo $phone; ?>">
                          <input type="hidden" name="event_id" value="<?php echo $event_id ?>" id="booking_event_id">
                        </div>
                        <?php if(!$isDinner) { ?>
                        <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                          <input placeholder="Company" type="text" class="form-control" name="company" id="company" value="<?php echo $company; ?>">
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                          <input placeholder="Role" type="text" class="form-control" name="role" id="role" value="<?php echo $role; ?>"role>
                        </div>
                        <?php } ?>
                        <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                          <input placeholder="Affiliated Organization" type="text" class="form-control" name="affiliated_org" id="affiliated_org" value="<?php echo $affiliated_org; ?>"role>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                          <select name="entree" id="entree" class="form-control">
                            <option value="">Select Entree Option *</option>
                            <option value="Moroccan Chicken" <?php echo ($entree == 'Moroccan Chicken') ? 'selected' : ''; ?>>Moroccan Chicken</option>
                            <option value="Seared Tilapia" <?php echo ($entree == 'Seared Tilapia') ? 'selected' : ''; ?>>Seared Tilapia</option>
                            <option value="Vegetable Lasagna" <?php echo ($entree == 'Vegetable Lasagn') ? 'selected' : ''; ?>>Vegetable Lasagna</option>
                          </select>
                        </div>
                        <button id="changetabbutton" type="submit" class="blu-form-button float-right"><i class="fa fa-arrow-right" aria-hidden="true"></i> Continue 
                          <span class="ajax_loader rotate_spinner"><i class="fa fa-spinner" aria-hidden="true"></i></span>
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="second-tab">
                <div class="step-one ebps-form-caontainer">
                  <div class="epbsf-inner">
                    <div class="row">
                      <form action="" method="POST" name="step-two-form" class="step-two-form" id="step-two-form">
                        <div class="guest-infor-section" id="guest-infor-section">

                          <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 float-left">
                            <input placeholder="Email" type="text" class="form-control guest_email" name="guest_email[]" id="guest_email-1" value="<?php echo $guest_email; ?>">
                            <input type="hidden" name="is_dinner" value="<?php echo $isDinner ?>" id="is_dinner">
                          </div>
                          <div class="clearfix"></div>
                          <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                            <input placeholder="First Name *" type="text" class="form-control guest_firstname" name="guest_firstname[]" id="guest_firstname-1" value="<?php echo $guest_firstname; ?>">
                          </div>
                          <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                            <input placeholder="Last Name *" type="text" class="form-control guest_lastname" name="guest_lastname[]" id="guest_lastname-1" value="<?php echo $guest_lastname; ?>">
                          </div>
                          <div class="clearfix"></div>
                          <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                            <input placeholder="Phone" type="text" class="form-control guest_phone" name="guest_phone[]" id="guest_phone-1" value="<?php echo $guest_phone; ?>">
                          </div>
                          <?php if(!$isDinner) { ?>
                          <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                            <input placeholder="Company" type="text" class="form-control guest_company" name="guest_company[]" id="guest_company-1" value="<?php echo $guest_company; ?>">
                          </div>
                          <div class="clearfix"></div>
                          <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                            <input placeholder="Role" type="text" class="form-control guest_role" name="guest_role[]"  id="guest_role-1" value="<?php echo $guest_role; ?>">
                          </div>
                          <?php } ?>
                          <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                            <input placeholder="Affiliated Organization" type="text" class="form-control" name="guest_affiliated_org[]" id="guest_affiliated_org-1" value="<?php echo $guest_affiliated_org; ?>"role>
                          </div>
                          <div class="clearfix"></div>
                          <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                            <select name="guest_entree[]" id="guest_entree-1" class="form-control guest_entree">
                              <option value="">Select Entree Option *</option>
                              <option value="Moroccan Chicken" <?php echo ($guest_entree == 'Moroccan Chicken') ? 'selected' : ''; ?>>Moroccan Chicken</option>
                              <option value="Seared Tilapia" <?php echo ($guest_entree == 'Seared Tilapia') ? 'selected' : ''; ?>>Seared Tilapia</option>
                              <option value="Vegetable Lasagna" <?php echo ($guest_entree == 'Vegetable Lasagna') ? 'selected' : ''; ?>>Vegetable Lasagna</option>
                            </select>
                          </div>

                          <?php

                          for($i=1; $i<$guestCount;  $i++){
                            $guest_email=isset($guest_details["guest_email"][$i]) ? $guest_details["guest_email"][$i] : '';
                            $guest_firstname=isset($guest_details["guest_firstname"][$i]) ? $guest_details["guest_firstname"][$i] : '';
                            $guest_lastname=isset($guest_details["guest_lastname"][$i]) ? $guest_details["guest_lastname"][$i] : '';
                            $guest_phone=isset($guest_details["guest_phone"][$i]) ? $guest_details["guest_phone"][$i] : '';
                            $guest_company=isset($guest_details["guest_company"][$i]) ? $guest_details["guest_company"][$i] : '';
                            $guest_role=isset($guest_details["guest_role"][$i]) ? $guest_details["guest_role"][$i] : '';
                            $guest_affiliated_org=isset($guest_details["guest_affiliated_org"][$i]) ? $guest_details["guest_affiliated_org"][$i] : '';
                            $guest_entree=isset($guest_details["guest_entree"][$i]) ? $guest_details["guest_entree"][$i] : '';

                            ?>
                            <div class="extra-guest-div">
                             <div class="clearfix"></div>
                             <div class="col-sm-12 guest-separator"><hr></div>
                             <div class="clearfix"></div>
                             <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 float-left">
                              <input placeholder="Email" type="text" class="form-control guest_email" name="guest_email[]" id="guest_email-<?php echo ($i+1); ?>" value="<?php echo $guest_email; ?>">
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                              <input placeholder="First Name *" type="text" class="form-control guest_firstname" name="guest_firstname[]" id="guest_firstname-<?php echo ($i+1); ?>" value="<?php echo $guest_firstname; ?>">
                            </div>
                            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                              <input placeholder="Last Name *" type="text" class="form-control guest_lastname" name="guest_lastname[]" id="guest_lastname-<?php echo ($i+1); ?>" value="<?php echo $guest_lastname; ?>">
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                              <input placeholder="Phone" type="text" class="form-control guest_phone" name="guest_phone[]" id="guest_phone-<?php echo ($i+1); ?>" value="<?php echo $guest_phone; ?>">
                            </div>
                            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                              <input placeholder="Company" type="text" class="form-control guest_company" name="guest_company[]" id="guest_company-<?php echo ($i+1); ?>" value="<?php echo $guest_company; ?>">
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                              <input placeholder="Role" type="text" class="form-control guest_role" name="guest_role[]"  id="guest_role-<?php echo ($i+1); ?>" value="<?php echo $guest_role; ?>">
                            </div>
                            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                              <input placeholder="Affiliated Organization" type="text" class="form-control" name="guest_affiliated_org[]" id="guest_affiliated_org-<?php echo ($i+1); ?>" value="<?php echo $guest_affiliated_org; ?>"role>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                              <select name="guest_entree[]" id="guest_entree-<?php echo ($i+1); ?>" class="form-control">
                                <option value="">Select Entree Option</option>
                                <option value="Moroccan Chicken" <?php echo ($guest_entree == 'Moroccan Chicken') ? 'selected' : ''; ?>>Moroccan Chicken</option>
                                <option value="Seared Tilapia" <?php echo ($guest_entree == 'Seared Tilapia') ? 'selected' : ''; ?>>Seared Tilapia</option>
                                <option value="Vegetable Lasagna" <?php echo ($guest_entree == 'Vegetable Lasagna') ? 'selected' : ''; ?>>Vegetable Lasagna</option>
                              </select>
                            </div>
                            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                             <button type="button" class="gray-form-button remove-guest" id="">
                              Remove
                            </button>
                          </div>
                        </div>
                        <?php
                      }
                      ?>
                    </div>
                    <div class="clearfix"></div>
                    <a href="#" id="skip-guest-step" class="skip-guest-step">Skip this Step <span class="ajax_loader rotate_spinner"><i class="fa fa-spinner" aria-hidden="true"></i></span>
                    </a>
                    <button type="submit" class="blu-form-button float-right" id="geust_form_btn">
                      <i class="fa fa-arrow-right" aria-hidden="true"></i> Continue
                      <span class="ajax_loader rotate_spinner">
                        <i class="fa fa-spinner" aria-hidden="true"></i>
                      </span>
                    </button>
                    <button type="button" class="gray-form-button float-right" id="add-more-guest">
                      <i class="fa fa-user-plus"  aria-hidden="true"></i> Add Guest
                    </button>
                    <button type="button" class="blu-form-button float-right btnPreviousTab">
                      <i class="fa fa-arrow-left"  aria-hidden="true"></i> Back
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div role="tabpanel" class="tab-pane" id="third-tab">
            <div class="step-one ebps-form-caontainer">
              <div class="epbsf-inner">
                <div class="">
                  <div id="event-booking-summery"></div>
                  <div class="clearfix"></div>
                  <div class="cb-coupon-form">
                    <div class="col-lg-3 col-md-3 col-sm-12 float-left back-btn-step-3">
                      <button type="button" class="blu-form-button  btnPreviousTab">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                      </button>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-12 text-right float-right">
                      <form action="" id="coupon-code-form" class="cb-coupon-form">
                        <div class="coupon-code-wrap">
                          <input class="form-control" placeholder="Coupon" type="text" name="coupon_code" id="coupon_code">
                          <span class="loader_icon"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/loader.gif" ></span>
                        </div>
                        <button class="coupon-btn" type="submit">Apply</button>                      
                        <button class="blu-form-button coupon-clear-btn" id="coupon-clear-btn" type="button" <?php 


                        if(!isset($_SESSION['booking_details']['discount'])){
                         echo "disabled";
                       }


                       ?>>Clear</button>
                     </form>
                   </div>
                 </div>
                 <div class="clearfix"></div>

                 <div class="pay-off-container">

                  <form id="event-paypal-form" name="paypalForm" action="<?php echo $paypal_url;?>" method="post">
                    <input type="hidden" name="business" value="<?php echo $merchant_email;?>" />
                    <input type="hidden" name="notify_url" value="<?php echo $notify_url;?>" />
                    <input type="hidden" name="cancel_return" value="<?php echo $cancel_return;?>" />
                    <input type="hidden" name="return" value="<?php echo $success_return;?>" />
                    <input type="hidden" name="rm" value="2" />
                    <input type="hidden" name="lc" value="" />
                    <input type="hidden" name="no_shipping" value="1" />
                    <input type="hidden" name="no_note" value="1" />
                    <input type="hidden" name="currency_code" value="USD" />
                    <input type="hidden" name="page_style" value="paypal" />
                    <input type="hidden" name="charset" value="utf-8" />
                    <input type="hidden" name="item_name" value="Payment for <?php echo $eventName; ?>" />
                    <input type="hidden" name="cbt" value="Back to Humanity First" />
                    <input type="hidden" value="_xclick" name="cmd"/>
                    <input type="hidden" value="events" name="booking_type"/>
                    <input type="hidden" name="amount" value="" />
                    <input type="hidden" name="quantity" value="1" />
                    <input type="hidden" name="custom" value="<?php echo $arr; ?>" />
                  </form>
                  <form action="" id="pay-now-form" method="POST">

                   <div class="poc-inner <?php echo isset($event_price) && ($event_price > 0) ? '' : 'hidden'; ?>">
                     <select name="selector" id="payment-option" class="form-control">
                       <option value="">Select Payment Method</option>
                       <option value="paypal">PayPal</option>
                       <option value="stripe">Credit Card</option>
                     </select>
                     <ul>
                       <li style="display: none;" id="paypal-logo">
                         <div class="check" >
                           <img src="<?php echo get_template_directory_uri(); ?>/assets/images/paypal-logo-blue.png"  />
                         </div>
                       </li>
                       <li style="display: none;" id="stripe-logo">
                         <div class="check" >
                           <img src="<?php echo get_template_directory_uri(); ?>/assets/images/stripe-logo-blue.png" />
                         </div>
                       </li>
                     </ul>
                   </div>
                   <div class="clearfix"></div>
                   <input type="hidden" name="booking_ticket_availability" value="" id="booking-tickets-availability">
                   <button type="submit" class="blu-form-button pay-now-btn float-right" id="pay-now-btn">
                    <i class="fa fa-arrow-right" aria-hidden="true"></i> 
                    <span class="pay-now-label"><?php echo isset($event_price) && ($event_price > 0) ? 'Pay Now' : 'Confirm Booking'; ?></span>
                    <span class="ajax_loader rotate_spinner"><i class="fa fa-spinner" aria-hidden="true"></i></span>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
          <div id="ticket-booked" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-body">
                  <p>Tickets for this events are no more available!</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
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
