<?php
/**
 * Template Name: Bookings Mobile (REST API)
 */

header('Content-Type: application/json');

global $wpdb;

$qry = "SELECT * FROM {$wpdb->prefix}bookings";

$where_clause = " WHERE 1=1 ";

if( isset($_POST['eventid']) && !empty($_POST['eventid'])) {
  $eventid = $_POST['eventid'];
  $where_clause .= " AND `event_id`=$eventid";
}

if( isset($_POST['userid']) && !empty($_POST['userid'])) {
  $userid = $_POST['userid'];
  if( empty($where_clause) ) {
    $where_clause .= " AND `user_id`=$userid";
  } else {
    $where_clause .= " AND `user_id`=$userid";
  }
}

$where_clause .= " AND `status`='approved'";

$qry .= $where_clause;

$bookings = $wpdb->get_results($qry, ARRAY_A);

$response = [];

if($bookings) {
  foreach ($bookings as $booking) {
    $booking_id = $booking['id'];
    $guest_bookings = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}guest_bookings WHERE `booking_id`=$booking_id", ARRAY_A);
    $guest_arr = [];
    if($guest_bookings) {
      foreach ($guest_bookings as $guest_booking) {
        $guest_arr[] = array(
          "firstname" => $guest_booking['first_name'],
          "lastname" => $guest_booking['last_name'],
          "email" => $guest_booking['email'],
          "phone" => $guest_booking['phone'],
          "company" => $guest_booking['company'],
          "role" => $guest_booking['role'],
          "checked_in" => $guest_booking['checked_in']
        );
      }
    }

    $eventDetails  = array();
    $event_id = $booking['event_id'];
    if(!empty($event_id)){
      $eventDetails["event_name"] = get_the_title($event_id);
      $eventDetails["thumbnail_id"] = get_post_thumbnail_id($event_id);
      $eventDetails["thumbnail_url"] = get_the_post_thumbnail_url($event_id);
      $eventDetails["event_date"] = get_post_meta($event_id,"hfusa-event_date",true);
      $eventDetails["start_time"] = get_post_meta($event_id,"hfusa-event_start_time",true);
      $eventDetails["end_time"] = get_post_meta($event_id,"hfusa-event_end_time",true);
      $eventDetails["event_location"] = get_post_meta($event_id,"hfusa-event_location",true);
    }


    $response[] = array(
      "booking_id" => $booking_id,
      "event_id" => $booking['event_id'],
      "user_id" => $booking['user_id'],
      "booked_spaces" => $booking['booking_spaces'],
      "booking_price" => $booking['booking_price'],
      "booking_total" => $booking['booking_total'],
      "coupon_id" => $booking['coupon_id'],
      "checked_in" => $booking['checked_in'],
      "guests" => $guest_arr,
      "event_details" => $eventDetails

    );
  }
}

// echo "<pre>";
// print_r($response);
// echo "</pre>";

echo json_encode($response, JSON_PRETTY_PRINT);
?>