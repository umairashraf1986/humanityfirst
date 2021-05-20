<?php
/**
 * Template Name: Check in Bookings
 */



if(isset($_POST["checkin_primary"]) || isset($_POST["checkin_guest"])){

  if(isset($_POST["checkin_primary"]) && !empty($_POST["checkin_primary"])){
    $checkin_primary = $_POST["checkin_primary"];
    $tableBookings=$wpdb->prefix.'bookings';
    $wpdb->update( 
      $tableBookings, 
      array( 
        'checked_in' => 1,
      ), 
      array( 'id' => $checkin_primary )
    );

  }


  if(isset($_POST["checkin_guest"]) && !empty($_POST["checkin_guest"])){
    $checkin_guest = $_POST["checkin_guest"];
    $tableGuests=$wpdb->prefix.'guest_bookings';
    foreach ($checkin_guest as $value) {     
      $wpdb->update( 
        $tableGuests, 
        array( 
          'checked_in' => 1,
        ), 
        array( 'id' => $value )
      );
    }
  }
}
?>
<?php use Roots\Sage\Titles; ?>
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

<?php

if( (isset($_POST["checkin_primary"]) && !empty($_POST["checkin_primary"])) || (isset($_POST["checkin_guest"]) && !empty($_POST["checkin_guest"]))){

 $booking_id = isset($_POST['booking_id']) && !empty($_POST['booking_id']) ? $_POST['booking_id'] : '';


 ?>
 <section class="event-booking-process-container page-wrapper">
  <div class="container">
    <div class="row rtl-display">
      <div class="col-md-12 col-lg-8 col-sm-12">
        <div class="tab-content">
          <div class="step-one ebps-form-caontainer">
            <div class="epbsf-inner">
              <h3>Following bookings are confirmed and checked in</h3>
              <?php
              global $wpdb;
              $bookings = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}bookings WHERE id=$booking_id and checked_in=1" );
              if($bookings){
                $user_id=isset($bookings->user_id) ? $bookings->user_id : '';

                if(!empty($user_id)){

                  $user_info = get_userdata($user_id);
                  $first_name=get_user_meta( $user_id, 'first_name', true );
                  $last_name=get_user_meta( $user_id, 'last_name', true );
                  $phone_number=get_user_meta( $user_id, 'phone_number', true );
                  $primary_booking_role=get_user_meta( $user_id, 'hf_user_role', true );
                  $primary_booking_company=get_user_meta( $user_id, 'hf_user_company', true );
                  $user_email=isset($user_info->data->user_email) ? $user_info->data->user_email : '';

                  ?>
                  <div class="confirmation-booking">
                    <div class="cb-head">
                      <h3><i class="fa fa-ticket" aria-hidden="true"></i> Primary Booking</h3>
                    </div>
                    <div class="cb-content-main">
                      <div class="cb-content">
                        <?php if(!empty($first_name) || !empty($last_name) ){?>
                        <h6 class="col-lg-6 col-md-6 col-sm-12 float-left"><i class="fa fa-user" aria-hidden="true"></i> <?php echo !empty($first_name) ? $first_name : ''; ?> <?php echo !empty($last_name) ? $last_name : ''; ?>
                        </h6>
                        <?php } ?>
                        <h6 class="col-lg-6 col-md-6 col-sm-12 float-left">
                          <i class="fa fa-paper-plane" aria-hidden="true"></i>
                          <span class="summery-label"><?php echo $user_email; ?></span>
                        </h6>
                        <h6 class="col-lg-6 col-md-6 col-sm-12 float-left"><i class="fa fa-phone" aria-hidden="true"></i> 123456789
                        </h6>
                        <?php  if(!empty($primary_booking_role) || !empty($primary_booking_company) ){ ?>
                        <h6 class="col-lg-6 col-md-6 col-sm-12 float-left company-role"><i class="fa fa-industry" aria-hidden="true"></i> 
                          <?php 

                          echo !empty($primary_booking_role) ? $primary_booking_role : ''; 

                          if(!empty($primary_booking_role) && !empty($primary_booking_company)){
                            echo ',';
                          }

                          echo !empty($primary_booking_company) ? $primary_booking_company : '';

                          ?>
                        </h6>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                  <?php 
                } }

                $guest_bookings = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}guest_bookings WHERE booking_id=$booking_id and checked_in=1" );

                if($guest_bookings){
                  ?>
                  <div class="confirmation-booking">
                    <div class="cb-head">
                      <h3><i class="fa fa-address-card-o" aria-hidden="true"></i> Guest Booking</h3>
                    </div>
                    <?php
                    $i=1;
                    foreach ($guest_bookings as $guest_booking) {
                      ?>
                      <div class="cb-content-main">
                        <div class="cb-tit1e">
                          <h5><i class="fa fa-circle" aria-hidden="true"></i> Guest <?php echo sprintf("%02d", $i); ?></h5>
                        </div>
                        <div class="cb-content">

                          <?php if(!empty($guest_booking->first_name) || !empty($guest_booking->last_name) ){?>

                          <h6 class="col-lg-6 col-md-6 col-sm-12 float-left"><i class="fa fa-user" aria-hidden="true"></i> <?php echo !empty($guest_booking->first_name) ? $guest_booking->first_name : ''; ?> <?php echo !empty($guest_booking->last_name) ? $guest_booking->last_name : ''; ?>
                          </h6>

                          <?php } ?> 


                          <?php if(!empty($guest_booking->email) ){?>

                          <h6 class="col-lg-6 col-md-6 col-sm-12 float-left"><i class="fa fa-paper-plane" aria-hidden="true"></i><span class="summery-label"><?php echo !empty($guest_booking->email) ? $guest_booking->email : '-'; ?></span></h6>

                          <?php } ?>

                          <?php if(!empty($guest_booking->phone) ){?>

                          <h6 class="col-lg-6 col-md-6 col-sm-12 float-left"><i class="fa fa-phone" aria-hidden="true"></i> <?php echo !empty($guest_booking->phone) ? $guest_booking->phone : '-'; ?></h6>

                          <?php } ?>

                          <?php  if(!empty($guest_booking->company) || !empty($guest_booking->role) ){ ?>

                          <h6 class="col-lg-6 col-md-6 col-sm-12 float-left company-role"><i class="fa fa-industry" aria-hidden="true"></i> 
                            <?php 

                            echo !empty($guest_booking->role) ? $guest_booking->role : ''; 

                            if(!empty($primary_booking_role) && !empty($primary_booking_company)){
                              echo ',';
                            }


                            echo !empty($guest_booking->company) ? $guest_booking->company : ''; 
                            ?>
                          </h6>

                          <?php } ?>

                        </div>
                      </div>
                      <?php $i++;
                    }?>
                  </div>
                  <?php } ?>
                  <div class="clearfix"></div> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </section>
    <?php
  }else{
    ?>

    <!--====  End of Hero Section  ====-->
    <secton class="checkin-main-container page-wrapper">
      <div class="container">
        <div class="row rtl-display">
          <div class="col-sm-12">
            <?php

            $booking_id = isset($_GET['booking_id']) && !empty($_GET['booking_id']) ? $_GET['booking_id'] : '';
            global $wpdb;
            $bookings = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}bookings WHERE id=$booking_id" );

            if($bookings){
              $id= $bookings->id;
              $guest_bookings = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}guest_bookings WHERE booking_id=$id" );
              ?>


              <form method="POST" action="" id="checkin-booking">
                <table class="table table-hover table-bordered table-striped table-responsive">
                  <thead>
                    <tr>
                      <th style="text-align:center;">
                        <label class="form-check-label">
                          <input id="checkAll" type="checkbox" class="form-check-input">
                        </label>
                      </th>
                      <th class="min-width-st1">First Name</th>
                      <th class="min-width-st1">Last Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Company</th>
                      <th>Role</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php

                    if($bookings){

                      $user_id=isset($bookings->user_id) ? $bookings->user_id : '';

                      if(!empty($user_id)){

                        $user_info = get_userdata($user_id);
                        $first_name=get_user_meta( $user_id, 'first_name', true );
                        $last_name=get_user_meta( $user_id, 'last_name', true );
                        $phone_number=get_user_meta( $user_id, 'phone_number', true );
                        $primary_booking_role=get_user_meta( $user_id, 'hf_user_role', true );
                        $primary_booking_company=get_user_meta( $user_id, 'hf_user_company', true );
                        $user_email=isset($user_info->data->user_email) ? $user_info->data->user_email : '';

                        ?>
                        <tr>
                          <td align="center">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" name="checkin_primary" value="<?php echo $id; ?>">
                            </label>
                          </td>
                          <td><?php echo !empty($first_name) ? $first_name : '-'; ?></td>
                          <td><?php echo !empty($last_name) ? $last_name : '-'; ?></td>
                          <td><?php echo $user_email; ?></td>
                          <td><?php echo !empty($phone_number) ? $phone_number : '-'; ?></td>
                          <td><?php echo !empty($primary_booking_company) ? $primary_booking_company : '-'; ?></td>
                          <td><?php echo !empty($primary_booking_role) ? $primary_booking_role : '-'; ?></td>
                        </tr>
                        <?php
                      }
                    }

                    if($guest_bookings){

                      foreach ($guest_bookings as $guest_booking) {
                        ?>
                        <tr>
                          <td align="center">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" name="checkin_guest[]" value="<?php echo $guest_booking->id; ?>">
                            </label>
                          </td>
                          <td><?php echo !empty($guest_booking->first_name) ? $guest_booking->first_name : '-'; ?></td>
                          <td><?php echo !empty($guest_booking->last_name) ? $guest_booking->last_name : '-'; ?></td>
                          <td><?php echo !empty($guest_booking->email) ? $guest_booking->email : '-'; ?></td>
                          <td><?php echo !empty($guest_booking->phone) ? $guest_booking->phone : '-'; ?></td>
                          <td><?php echo !empty($guest_booking->company) ? $guest_booking->company : '-'; ?></td>
                          <td><?php echo !empty($guest_booking->role) ? $guest_booking->role : '-'; ?></td>
                        </tr>
                        <?php } } ?>
                      </tbody>
                    </table>
                    <input type="hidden" name="booking_id" value="<?php echo $booking_id;  ?>">
                    <button id="changetabbutton" type="submit" class="blu-form-button float-left">
                      <i class="fa fa-arrow-right" aria-hidden="true"></i> Check in
                    </button>
                  </form>
                  <?php }else{
                    ?>
                    <div class="col-sm-12 text-center"><p>Sorry ! no bookings found.</p></div>
                    <?php
                  } ?>
                </div>
              </div>
            </div>
          </secton>
          <?php
        }
        ?>