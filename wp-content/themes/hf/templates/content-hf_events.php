<?php use Roots\Sage\Titles; ?>
<!--==================================
= Hero Section =
=================================== -->

<style type="text/css">
  .t-sponsors-speakers .speakers-list-container .th-carousel-item a.rounded-link {
    width: 150px;
    height: 150px;
  }
  .t-sponsors-speakers .speakers-list-container .th-carousel-item .speaker-name {
    font-size: 14px;
  }
  .t-sponsors-speakers .speakers-list-container .th-carousel-item ul.slc-social-profiles li {
    width: auto;
    margin-right: 10px;
  }
  .modal-header {
    border-bottom: none;
    padding-bottom: 0;
    padding-right: 30px;
    padding-left: 30px;
  }
  .modal-body {
    padding-bottom: 40px;
    padding-right: 30px;
    padding-left: 30px;
  }
  .modal-body .body-wrapper img {
    width: 150px;
    height: 150px;
    margin: 0 auto;
    display: block;
    margin-bottom: 10px;
    border-radius: 4px;
    object-fit: cover;
  }
  .modal-body .title {
    text-align: center;
    font-size: 20px;
    font-weight: 500;
    margin-bottom: 5px;
  }
  .modal-body .designation {
    text-align: center;
    font-size: 16px;
    margin-bottom: 5px;
  }
  .modal-body .bio {
    text-align: justify;
  }
  .modal-body img.modal-preloader {
    display: block;
    margin: 0 auto;
    position: static;
    background: transparent;
  }
  .webinar-message {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
  }
  .spons-images ul {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    padding: 0;
    margin: 0;
  }
  .sponsors-section .sponsors-logos .spons-images ul li {
    width: 33.33%;
    height: auto;
  } 
  .sponsors-section .sponsors-logos .spons-images ul li:nth-child(3) {
    border-right: 0 solid #e9ecef;
  } 
  .sponsors-section .sponsors-logos .spons-images ul li:nth-child(4) {
    border-top: 1px solid #e9ecef;
    border-right: 1px solid #e9ecef;
  }
  .sponsors-section .sponsors-logos .spons-images ul li img {
    width: 100%;
    position: relative;
    transform: none;
    top: unset;
    left: unset;
    right: unset;  
  }
</style>

<section class="inner-page-title-section event-detail-page" <?php echo hf_header_bg_img(); ?>>

  <div class="iptc-content">
    <h1><?= Titles\title(); ?></h1>
    <?php bootstrap_breadcrumb(); ?>
  </div>

  <div class="overlay"></div>
</section>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->

<?php $stylesheetDirectory = get_stylesheet_directory_uri(); ?>

<?php while (have_posts()) : the_post(); ?>

  <?php
  $event_speakers = get_post_meta(get_the_ID(), 'hfusa-event_speakers');
  $event_guests=get_post_meta( get_the_ID(), 'hfusa-event_guests' );
  $event_sponsors = get_post_meta(get_the_ID(), 'hfusa-event_sponsors');
  $event_gallery = rwmb_meta('hfusa-event_gallery', array('size' => 'thumbnail'));
  $venue_images = rwmb_meta('hfusa-venue_gallery', array('size' => 'thumbnail'));
  ?>


  <section class="inner-page-navigation" id="sticky-nav">
    <div class="container">
      <div class="row">
        <div class="pn-menu" id="event-sections-menu">
          <ul>
            <li class="active"><a class="scrollTo pnm-e-about"
                                  href="#event-about-section"><span>about</span></a>
            </li>
            <?php if (!$is_agenda_empty) { ?>
              <li><a class="pnm-e-agenda scrollTo" href="#event-agenda-section"><span>agenda</span></a>
              </li>
            <?php } ?>
            <?php if ($event_speakers && is_array($event_speakers)) { ?>
              <li><a class="pnm-e-speakers scrollTo" href="#event-speakers-section"><span>speakers</span></a>
              </li>
            <?php } ?>
            <?php
            $has_not_location = rwmb_meta('hfusa-event_has_not_location');
            if(empty($has_not_location) || !$has_not_location) {
            ?>
            <li><a class="pnm-e-venue scrollTo" href="#event-venu-section"><span>venue</span></a>
            </li>
            <?php } ?>
            <?php
            if ($event_sponsors && is_array($event_sponsors)) {
              ?>
              <li><a class="pnm-e-sponsors scrollTo" href="#event-sponsors-section"><span>sponsors</span></a>
              </li>
            <?php } ?>
            <li><a class="pnm-e-gallery scrollTo" href="#gallery"><span>Gallery</span></a>
            </li>
            <!-- <li><a class="pnm-e-register scrollTo" href="<?php
            $bookingPageUrl = home_url('/event-booking');
            echo esc_url(add_query_arg('event_id', get_the_ID(), $bookingPageUrl));
            ?>">Register</a>
            </li> -->
          </ul>
        </div>
      </div>

    </div>
    </div>
    </div>
  </section>
  <div class="clearfix"></div>


  <!--====================================
  =             event detail             =
  =====================================-->
  <!--====  event intro  ====-->

  <section class="event-detail-content page-wrapper pt-2" id="event-about-section">
    <div class="container">
      <div class="row rtl-display">
        <div class="col-lg-8 col-md-12 col-sm-12 float-left">
          <div class="event-post">
            <div class="event-container">
              <div class="event-feature">
                <img src="<?php echo get_the_post_thumbnail_url(); ?>"
                     alt="<?php the_title(); ?>" <?php echo (get_the_slug() == "providing-food-security-for-humanity") ? 'style="object-position: bottom;"' : '' ?> />
              </div>
              <div class="text-paragraph">
                <?php the_content(); ?>
              </div>
              <div class="clearfix"></div>


              <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>


          </div>
          <div class="row d-none">
            <div class="container container-products-telethon" id="donations">
              <h2>Featured Products</h2>
              <?php
              $post_ids = rwmb_meta('hfusa-event_products');
              if ($post_ids) {
              ?>
              <div class="products-telethon">
                <?php

                  foreach ($post_ids as $post_id) {
                    ?>
                    <div class="">
                      <div class="th-singleproduct-wrapper">

                        <?php

                        if (has_post_thumbnail($post_id)) {
                          echo '<a target="_blank" href="' . get_the_permalink($post_id) . '">' . get_the_post_thumbnail($post_id) . '</a>';
                        } else {
                          echo '<a target="_blank" href="' . get_the_permalink($post_id) . '">' . wc_placeholder_img("thumbnail") . '</a>';
                        }

                        echo '<div class="link-details">';
                        echo '<a target="_blank" class="product-link" href="' . get_the_permalink($post_id) . '">' . get_the_title($post_id) . '</a>';
                        echo '</div>';

                        ?>
                      </div>
                    </div>
                    <?php
                  }

                ?>
              </div><!--/.products-->
              <?php
              } else {
                echo __('No products found');
              }
              wp_reset_postdata();
              ?>

            </div>
          </div>
        </div>


        <div class="col-lg-4 col-md-12 col-sm-12 float-right">
          <div class="blog-sidebar">
            <div class="row">
              <?php
              $event_total_tickets = get_post_meta(get_the_ID(), 'hfusa-event_tickets_available', true);
              if ($event_total_tickets && $event_total_tickets > 0) {
                ?>
                <div class="write-your-story-btn col-lg-6 col-md-6 col-sm-12">
                  <?php
                  $bookingPageUrl = home_url('/event-booking');
                  $bookingURL = esc_url(add_query_arg('event_id', get_the_ID(), $bookingPageUrl));
                  $registerURL = get_post_meta( get_the_ID(), 'hfusa-register_button_url', true );
                  ?>
                  <a href="<?php echo (!empty($registerURL)) ? $registerURL : $bookingURL; ?>" target="_blank"><i class="fa fa-credit-card-alt"></i> Register</a>
                </div>
              <?php } ?>
              <div class="write-your-story-btn col-lg-6 col-md-6 col-sm-12">
                <?php
                $bookingPageUrl = home_url('/become-event-sponsor');
                $becomeSponsorURL = esc_url(add_query_arg('event_id', get_the_ID(), $bookingPageUrl));
                $sponsorURL = get_post_meta( get_the_ID(), 'hfusa-sponsor_button_url', true );
                ?>
                <a href="<?php echo (!empty($sponsorURL)) ? $sponsorURL : $becomeSponsorURL; ?>" target="_blank"><i class="fa fa-handshake-o"></i> Sponsor</a>
              </div>
              <div class="write-your-story-btn col-lg-6 col-md-6 col-sm-12">
                <?php
                $donateURL = get_post_meta( get_the_ID(), 'hfusa-donate_button_url', true );
                ?>
                <a href="<?php echo (!empty($donateURL)) ? $donateURL : home_url('donate'); ?>"target="_blank"><i class="fa fa-heart-o"></i> Donate</a>
              </div>
              <div class="write-your-story-btn col-lg-6 col-md-6 col-sm-12">
                <?php 
                $contactURL = get_post_meta( get_the_ID(), 'hfusa-contact_us_button_url', true );
                ?>
                <a href="<?php echo (!empty($contactURL)) ? $contactURL : home_url('contact-us'); ?>" target="_blank"><i class="fa fa-envelope"></i> Contact Us</a>
              </div>
            </div>
            <div class="sidebar-links">
              <h4>Details</h4>
              <div class="detail-container">

                <div class="de-date">
                  <div class="icon">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                  </div>
                  <div class="date">
                    <h5>Event Date</h5>
                    <h6><?php echo rwmb_meta('hfusa-event_date'); ?></h6>
                  </div>
                </div>

                <div class="de-date">
                  <div class="icon">
                    <i class="fa fa-play-circle-o" aria-hidden="true"></i>
                  </div>
                  <div class="date">
                    <h5>Start Time</h5>
                    <h6><?php echo date('h:i A', strtotime(rwmb_meta('hfusa-event_start_time'))); ?></h6>
                  </div>
                </div>

                <div class="de-date">
                  <div class="icon">
                    <i class="fa fa-power-off" aria-hidden="true"></i>
                  </div>
                  <div class="date">
                    <h5>End Time</h5>
                    <h6><?php echo date('h:i A', strtotime(rwmb_meta('hfusa-event_end_time'))); ?></h6>
                  </div>
                </div>

                <?php
                $has_not_location = rwmb_meta('hfusa-event_has_not_location');
                if(empty($has_not_location) || !$has_not_location) {
                ?>
                <div class="de-date">
                  <div class="icon">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                  </div>
                  <div class="date">
                    <h5>Venue</h5>
                    <h6><?php echo rwmb_meta('hfusa-event_location'); ?></h6>
                  </div>
                </div>
                <?php } ?>

                <div class="de-date">

                  <div title="Add to Calendar" class="addeventatc">
                    Add to Calendar <i class="fa fa-chevron-down"></i>
                    <span class="start">10/18/2019 07:00 PM</span>
                    <span class="end">10/18/2019 10:00 PM</span>
                    <span class="timezone">America/Chicago</span>
                    <span class="title">Atlanta Dinner</span>
                    <span class="description">Providing Food Security for Humanity</span>
                    <span class="location">1848 Old Norcross Rd, Lawrenceville, GA 30044, USA</span>
                  </div>
                </div>

              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </section>
  <div class="clearfix"></div>


  <!--====  end of event intro  ====-->

  <!--===============================
  =            Starts In            =
  ================================-->

  <section class="event-starts-in">
    <div class="container">
      <div class="row rtl-display">
        <div class="col-12 float-left">
          <h3>Event Starts in</h3>
          <?php
          date_default_timezone_set('Asia/Karachi');
          $event_date = rwmb_meta('hfusa-event_date');
          $start_time = rwmb_meta('hfusa-event_start_time');
          $event_date_time = strtotime($event_date . " " . $start_time);
          ?>
          <p id="demo" class="count-down-timer"></p>
        </div>
      </div>
    </div>
  </section>
  <div class="clearfix"></div>
  <script>
      var countDownDate = "<?php echo $event_date_time;?>";

      var x = setInterval(function () {

          var now = Math.floor(Date.now() / 1000);


          var distance = countDownDate - now;

          var days = Math.floor(distance / (60 * 60 * 24));
          var hours = Math.floor((distance % (60 * 60 * 24)) / (60 * 60));
          var minutes = Math.floor((distance % (60 * 60)) / 60);
          var seconds = Math.floor(distance % 60);

          document.getElementById("demo").innerHTML = "<time><span>" + days + "</span> <b>Days</b> </time>" + "<time><span>" + hours + "</span><b>Hours</b> </time>" + "<time><span>" + minutes + "</span><b>Minutes</b> </time> " + "<time><span>" + seconds + "</span><b>Seconds</b> </time>";

          if (distance < 0) {
              clearInterval(x);
              document.getElementById("demo").innerHTML = "<div style='color: #0069b4;'>EXPIRED</div>";
          }
      }, 1000);
  </script>
  <!--====  End of Starts In  ====-->

  <!--==============================
  =            Schedule            =
  ===============================-->

  <?php if (!$is_agenda_empty) { ?>
    <section class="schedule-section" id="event-agenda-section">
      <div class="container">
        <h2 class="heading-st1 text-center"><?php echo rwmb_meta('hfusa-agenda_heading', array(), get_the_ID()); ?></h2>
        <div class="row rtl-display">
          <div class="row justify-content-center">
            <div class="col-sm-12 col-md-12">
                <?php
                $group_value = rwmb_meta( 'events_agendas_meta_box_container' );

                if(!empty($group_value)){
                    foreach ($group_value as $key => $value) {
                        # code...
                        if(isset($value['agenda_title'])){
                            ?>
                          <div class="col-sm-12 agenda-box row">
                            <div class="agenda-box-inner col-sm-12" data-toggle="collapse" data-parent="#accordion"
                                 href="#collapse<?php echo $key; ?>">
                              <div class="container-fluid">
                                <div class="row">
                                  <div class="col-lg-4 col-sm-4 col-xs-6">
                                <span class="panel-date"><i class="fa fa-hourglass-start"
                                                            aria-hidden="true"></i><?php echo $value['start_time']; ?><?php echo (!empty($value['end_time'])) ? " - ".$value['end_time'] : ""; ?></span>
                                  </div>
                                  <div class="col-lg-8 col-sm-8 col-xs-6 text-right">
                                    <span class="schedule-title"><?php echo $value['agenda_title']; ?></span>
                                    <span class="schedule-arrow" data-toggle="collapse" data-parent="#accordion"
                                          href="#collapse<?php echo($count); ?>"><i class="fa fa-chevron-down"
                                                                                    aria-hidden="true"></i></span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div id="collapse<?php echo $key; ?>" class="collapse  agenda_details_outer col-sm-12 ">

                              <div class="agenda_details">
                                  <?php if($value['desc'] !== ''):?>
                                    <div class="col-sm-12"><p><?php echo $value['desc']; ?></p></div>
                                  <?php endif;?>
                                  <?php if (isset($value['presenter_post']) && !empty($value['presenter_post'])):?>
                                      <?php foreach ($value['presenter_post'] as $k => $presenter_id):
                                          $pres_img = get_the_post_thumbnail($presenter_id, 'thumbnail');
                                          $author = get_the_title($presenter_id);
                                          $presenter_post = get_post($presenter_id);
                                          $desc = $presenter_post->post_content;
                                          $show_agenda_title = get_post_meta($presenter_id, 'amplify-show_agenda_title', true);
                                          ?>
                                      <div class="col-sm-12 row agenda-presenter">
                                        <div class="col-sm-12">
                                          <div class="row">
                                              <?php
                                              if (!empty($pres_img)) {
                                                  ?>
                                                <div class="author_img col-sm-2">
                                                    <?php
                                                    echo $pres_img;
                                                    ?>
                                                </div>
                                              <?php } ?>

                                            <div class="desc col-sm-10">

                                              <div class="col-sm-12" style="padding-left: 0;">

                                                  <?php
                                                  if ($show_agenda_title == false && !empty($author)) { ?>
                                                    <div class="agenda_details_author">
                                                      <div class="author-name">
                                                        <strong>
                                                            <?php echo $author; ?></strong>
                                                      </div>
                                                    </div>
                                                  <?php } ?>

                                                  <?php echo $desc; ?>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <?php endforeach;?>
                                  <?php endif;?>
                                <div class="sponsor_img_agenda col-sm-12">
                                    <?php
                                    $sponsor_logo = isset($value["hf_sponsor_logo"]) ? $value["hf_sponsor_logo"] : '';

                                    if (!empty($sponsor_logo) && is_array($sponsor_logo)) {

                                        foreach ($sponsor_logo as $logo => $v) {

                                            $spon_logo = wp_get_attachment_image_src($v, 'medium');
                                            if (!empty($spon_logo)) {
                                                ?>
                                                <?php
                                                echo '<img src="' . $spon_logo[0] . '">';
                                                ?>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                              </div>
                            </div>
                          </div>
                            <?php
                        }
                    }
                } else {
                    echo '<div class="col-sm-12 text-center">No Agendas found for this event!</div>';
                }
                ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php } ?>
  <div class="clearfix"></div>

  <!--====  End of Schedule  ====-->

  <?php
  if ($event_speakers && is_array($event_speakers)) {
    ?>
    <!--======================================
    =            Speakers Section            =
    =======================================-->

    <section class="speakers-container t-sponsors-speakers inverted" id="event-speakers-section">
      <div class="container">
        <h2 class="heading-st1 text-center mb-5"><?php echo rwmb_meta('hfusa-hosts_heading', array(), get_the_ID()); ?></h2>
        <!-- <div class="speakers-slider">
          <?php foreach ($event_speakers as $key => $id) { ?>
            <div class="speaker-slide">
              <?php
              $avatar = get_the_post_thumbnail_url($id);
              if (empty($avatar)) {
                $avatar = get_stylesheet_directory_uri() . '/assets/images/default-avatar.png';
              }
              ?>
              <img src="<?php echo $avatar; ?>" alt="" class="speaker-img">
              <h3><?php echo get_the_title($id); ?></h3>
              <h4 class="speaker-designation"><?php echo get_post_meta($id, 'hfusa-speaker_designation', true); ?></h4>
              <div class="speaker-about">
                <?php
                $post_data = get_post($id);
                $content = apply_filters('the_content', $post_data->post_content);
                echo $content;
                ?>
              </div>
              <div class="social-icons">
                <?php
                $speaker_facebook = get_post_meta($id, 'hfusa-speaker_facebook', true);
                $speaker_twitter = get_post_meta($id, 'hfusa-speaker_twitter', true);
                $speaker_linkedin = get_post_meta($id, 'hfusa-speaker_linkedin', true);
                $speaker_email = get_post_meta($id, 'hfusa-speaker_email', true);
                ?>
                <?php if ($speaker_email) { ?>
                  <a href="mailto:<?php echo $speaker_email; ?>"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                <?php } ?>
                <?php if ($speaker_facebook) { ?>
                  <a href="<?php echo $speaker_facebook; ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <?php } ?>
                <?php if ($speaker_twitter) { ?>
                  <a href="<?php echo $speaker_twitter; ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                <?php } ?>
                <?php if ($speaker_linkedin) { ?>
                  <a href="<?php echo $speaker_linkedin; ?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
        </div> -->
        <div class="speakers-list-container th-speaker-sponsor-carosel">
          <?php
          foreach ($event_speakers as $key => $id) {
            ?>
            <div class="th-carousel-item">
              <a href="<?php echo get_the_permalink( $id ); ?>" class="rounded-link" target="_blank" data-toggle="modal" data-target="#speakerModal" data-speakerid="<?php echo $id; ?>">
                <?php
                $avatar = get_the_post_thumbnail_url($id);
                if( empty($avatar) ) {
                  $avatar = $stylesheetDirectory.'/assets/images/default-avatar.png';
                }
                ?>
                <img src="<?php echo $avatar; ?>" alt="<?php echo get_the_title($id); ?>" />
              </a>
              <div class="clearfix"></div>
              <h5 class="speaker-name"><a href="<?php echo get_the_permalink( $id ); ?>" data-toggle="modal" data-target="#speakerModal" data-speakerid="<?php echo $id; ?>"><?php echo get_the_title($id); ?></a></h5>
              <ul class="slc-social-profiles text-center">
                <?php
                $speaker_facebook= get_post_meta( $id, 'hfusa-speaker_facebook',true );
                $speaker_twitter= get_post_meta( $id, 'hfusa-speaker_twitter',true );
                $speaker_linkedin= get_post_meta( $id, 'hfusa-speaker_linkedin',true );
                ?>
                <?php
                if($speaker_facebook){
                  echo '<li><a href="'.$speaker_facebook.'" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>';
                }
                if($speaker_twitter){
                  echo '<li><a href="'.$speaker_twitter.'" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>';
                }
                if($speaker_linkedin){
                  echo '<li><a href="'.$speaker_linkedin.'" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>';
                }
                ?>
              </ul>
            </div>
            <?php 
          }
          ?>
        </div>
      </div>
    </section>

    <!--====  End of Speakers Section  ====-->
  <?php } ?>

  <!--====================================
  =            Special Guests            =
  =====================================-->
    
  <?php
  if(!empty($event_guests) && is_array($event_guests)){
    ?>
    <div class="container">
      <div class="row">
        <div class="col">
          <section class="t-sponsors-speakers" style="background-color: #fff;">
            <div id="guests" class="col-sm-12 col-lg-12 col-md-12">
              <div class="t-speakers">
                <h1 class="underlined-heading capital"><?php echo rwmb_meta('hfusa-guests_heading', array(), get_the_ID()); ?></h1>
                <div class="speakers-list-container th-speaker-sponsor-carosel">
                  <?php
                  foreach ($event_guests as $key => $speakerID) {
                    ?>
                    <div class="th-carousel-item">
                      <a href="<?php echo get_the_permalink( $speakerID ); ?>" class="rounded-link" target="_blank" data-toggle="modal" data-target="#speakerModal" data-speakerid="<?php echo $speakerID; ?>">
                        <?php
                        $avatar = get_the_post_thumbnail_url($speakerID);
                        if( empty($avatar) ) {
                          $avatar = $stylesheetDirectory.'/assets/images/default-avatar.png';
                        }
                        ?>
                        <img src="<?php echo $avatar; ?>" alt="<?php echo get_the_title($speakerID); ?>" />
                      </a>
                      <div class="clearfix"></div>
                      <h5 class="speaker-name"><a href="<?php echo get_the_permalink( $speakerID ); ?>" data-toggle="modal" data-target="#speakerModal" data-speakerid="<?php echo $speakerID; ?>"><?php echo get_the_title($speakerID); ?></a></h5>
                      <!--<h6 class="speaker-designation">senior developer</h6>-->
                      <ul class="slc-social-profiles text-center">
                        <?php
                        $speaker_facebook= get_post_meta( $speakerID, 'hfusa-speaker_facebook',true );
                        $speaker_twitter= get_post_meta( $speakerID, 'hfusa-speaker_twitter',true );
                        $speaker_linkedin= get_post_meta( $speakerID, 'hfusa-speaker_linkedin',true );
                        ?>
                        <?php
                        if($speaker_facebook){
                          echo '<li><a href="'.$speaker_facebook.'" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>';
                        }
                        if($speaker_twitter){
                          echo '<li><a href="'.$speaker_twitter.'" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>';
                        }
                        if($speaker_linkedin){
                          echo '<li><a href="'.$speaker_linkedin.'" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>';
                        }
                        ?>
                      </ul>
                    </div>
                    <?php 
                  }
                  ?>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
    
  <?php } ?>
  
  <!--====  End of Special Guests  ====-->
  

  <!--==========================================
  =            Addreass Map Section            =
  ===========================================-->
  <?php
  $has_not_location = rwmb_meta('hfusa-event_has_not_location');
  if(empty($has_not_location) || !$has_not_location) {
  ?>
  <section class="map-section" id="event-venu-section">
    <div class="row m-0">
      <div class="col-md-6">
        <div class="map-main-container">
          <?php
          $args = array(
            'width' => '100%',
            'height' => '450px',
            'marker' => true,
            'js_options' => array(
              'zoom' => 10,
            )
          );
          echo rwmb_meta('hfusa-event_map', $args);
          ?>
        </div>
      </div>
      <div class="col-md-6">
        <?php if ($venue_images && is_array($venue_images)): ?>
          <div class="venue-images" id="venue-images">
            <?php foreach ($venue_images as $picID) { ?>
              <div class="venue-image">
                <img src="<?php echo $picID['full_url']; ?>"/>
              </div>
            <?php } ?>
          </div>
        <?php endif ?>
      </div>
    </div>
  </section>
  <div class="clearfix"></div>
  <?php } ?>

  <!--====  End of Addreass Map Section  ====-->


  <!--==============================
  =            Sponsors            =
  ===============================-->
  <?php
  if ($event_sponsors && is_array($event_sponsors)) {
    ?>
    <section class="sponsors-section" id="event-sponsors-section">
      <div class="container">
        <div class="row rtl-display">
          <div class="col-12 float-left">
            <?php
            $sponsors_heading = rwmb_meta('hfusa-sponsors_heading');
            if(!empty($sponsors_heading)) {
            ?>
            <h3><?php echo $sponsors_heading; ?></h3>
            <?php } ?>
            <div class="sponsors-logos">
              <div class="spons-images">
                <div>
                  <ul>
                    <?php
                    foreach ($event_sponsors as $event_sponsor) {
                      if (get_post_status($event_sponsor) == 'publish') {
                        if(!empty(get_the_post_thumbnail_url($event_sponsor))) {
                        ?>
                        <li>
                          <a href="<?php the_permalink($event_sponsor); ?>">
                            <img src="<?php echo get_the_post_thumbnail_url($event_sponsor); ?>"
                                 alt="<?php the_title($event_sponsor); ?>"/></a>
                        </li>
                        <?php
                        }
                      }
                    } ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php } ?>
  <div class="clearfix"></div>
  <!--====  End of Sponsors  ====-->
  <!--====  end of event detail ====-->
<?php endwhile; ?>
<!--=====================================
=            gallery section            =
======================================-->
<?php if ($event_gallery && is_array($event_gallery)): ?>
  <section class="t-light-box-gallery" id="gallery">
    <div class="pd-light-box">
      <ul>
        <?php foreach ($event_gallery as $picID) { ?>
          <li>
            <img src="<?php echo $picID['url'] ?>">
            <a href="#<?php echo $picID['ID']; ?>" class="open-image"><i class="fa fa-search-plus"
                                                                         aria-hidden="true"></i></a>
            <a href="#_" class="hf_gallery_lightbox hf_t_gallery_lightbox" id="<?php echo $picID['ID']; ?>">
              <img src="<?php echo $picID['full_url']; ?>"/>
            </a>
          </li>
        <?php } ?>
      </ul>
    </div>
  </section>
  <div class="clearfix"></div>
<?php endif ?>
<!--====  End of gallery section  ====-->

<!-- Modal -->
<div class="modal fade" id="speakerModal" tabindex="-1" role="dialog" aria-labelledby="speakerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="margin-top: 50px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="speakerModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="body-wrapper" style="display: none;">
          <img src="" alt="Bill Bolling" class="speaker-img">
          <div class="about mb-4">
            <div class="title"></div>
            <div class="designation"></div>
          </div>
          <div class="bio"></div>
        </div>
        <img src="<?php echo $stylesheetDirectory.'/assets/images/100px(blue).gif' ?>" class="modal-preloader">
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  jQuery(document).ready(function() {
    // jQuery("#speakerModal").modal('show');
    jQuery('#speakerModal').on('show.bs.modal', function (event) {
      jQuery(".modal-preloader").show();
      jQuery(".body-wrapper").hide();
      var button = jQuery(event.relatedTarget);
      var speakerID = button.data('speakerid');
      var modal = jQuery(this);

      var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";

      jQuery.ajax({
        url: ajaxurl,
        method: "POST",
        dataType: "json",
        data: "speakerID="+speakerID+"&action=get_speaker_details"

      }).success(function (data) {
        jQuery(".modal-preloader").hide();
        jQuery(".body-wrapper").show();
        modal.find('.modal-body .speaker-img').attr({'src': data.avatar, 'alt': data.title})
        modal.find('.modal-body .title').text(data.title)
        modal.find('.modal-body .designation').text(data.designation)
        modal.find('.modal-body .bio').html(data.bio)
      })
      });
  });
</script>