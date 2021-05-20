<?php
/**
 * Template Name: Get Donations Mobile (REST API)
 */
if( !empty($_POST['user_id']) ) {
  $args = array(
    "post_type" => "hf_donations",
    "posts_per_page" => -1,
    "meta_key" => "hfusa-donor_id",
    "meta_value" => $_POST['user_id']
  );
} elseif( !empty($_POST['program_id']) ) {
  $args = array(
    "post_type" => "hf_donations",
    "posts_per_page" => -1,
    "meta_key" => "hfusa-program_id",
    "meta_value" => $_POST['program_id']
  );
}  elseif( !empty($_POST['campaign_id']) ) {
  $args = array(
    "post_type" => "hf_donations",
    "posts_per_page" => -1,
    "meta_key" => "hfusa-donation_campaign_id",
    "meta_value" => $_POST['campaign_id']
  );
} else {
  $args = array(
    "post_type" => "hf_donations",
    "posts_per_page" => -1
  );
}

$response = array();

$donations = new WP_Query( $args );

if( $donations->have_posts() ) :
  while( $donations->have_posts() ) : $donations->the_post();
    $response[] = array(
      "id" => get_the_ID(),
      "publish_date" => get_the_date('m/d/Y', get_the_ID()),
      "hfusa-donation_type" => rwmb_meta('hfusa-donation_type'),
      "hfusa-donation_for" => rwmb_meta('hfusa-donation_for'),
      "hfusa-donation_amount" => rwmb_meta('hfusa-donation_amount'),
      "hfusa-campaign_id" => rwmb_meta('hfusa-donation_campaign_id'),
      "hfusa-program_id" => rwmb_meta('hfusa-program_id'),
      "hfusa-program_name" => rwmb_meta('hfusa-program_name'),
      "hfusa-donor_id" => rwmb_meta('hfusa-donor_id'),
      "hfusa-donor_name" => rwmb_meta('hfusa-donor_name'),
      "hfusa-donor_email" => rwmb_meta('hfusa-donor_email'),
      "hfusa-donor_phone" => rwmb_meta('hfusa-donor_phone'),
      "hfusa-donor_city" => rwmb_meta('hfusa-donor_city'),
      "hfusa-donor_state" => rwmb_meta('hfusa-donor_state'),
      "hfusa-pledge_promise_date" => rwmb_meta('hfusa-pledge_promise_date')
    );
  endwhile;
  wp_reset_postdata();
endif;

header("Content-Type: application/json");
echo json_encode($response, JSON_PRETTY_PRINT);
exit;

?>