<?php use Roots\Sage\Titles; ?>
<!--==================================
= Hero Section =
=================================== -->

<section class="inner-page-title-section about-us-page" <?php echo hf_header_bg_img(); ?>>

  <div class="iptc-content filter-head-block ">
    <h1><?= Titles\title(); ?></h1>
    <?php bootstrap_breadcrumb(); ?>
  </div>

  <div class="overlay"></div>
</section>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->

<section class="blog-content page-wrapper">

  <div class="hf-grid-layout hf-gl-events">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="hf-gl-header hf-gl-header-events">
            <ul class="hf-filter hf-news-filter">
              <li><a href="#!" data-filter="*">All</a></li>
              <li><a href="#!" data-filter=".past_event">Past Events</a></li>
              <li><a href="#!" data-filter=".current_event">Current Events</a></li>
              <li><a href="#!" data-filter=".future_event">Future Events</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row hf-gl-row hf-filter-grid">

        <?php 
        $loop = new WP_Query( 
          array( 
            'post_type' => 'hf_events', 
            'posts_per_page' => -1,
            'order'     => 'DESC',
            'meta_key' => 'hfusa-event_date',
            'orderby'   => 'meta_value'
          )
        );
        ?>
        <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
          <?php
          $event_location = get_post_meta(get_the_ID(), 'hfusa-event_location', true);
          $categories = wp_get_post_terms(get_the_ID(), 'events_category', array("fields" => "all"));

          $categoryClasses = "";
          foreach($categories as $category){
            $categoryClasses .= " ".$category->slug;
          }

          $event_start_date = get_post_meta(get_the_ID(), 'hfusa-event_date', true);
          $event_end_date = get_post_meta(get_the_ID(), 'hfusa-event_end_date', true);

          $today = current_time('timestamp');
          $timestampStart = strtotime($event_start_date);
          $timestampEnd = strtotime($event_end_date);

          $labelStartDate = date("F d, Y", $timestampStart);

          $eventClass = '';

          if($timestampEnd < $today){
            $eventClass = 'past_event';
          }else if($timestampStart <= $today && $timestampEnd >= $today){
            $eventClass = 'current_event';
          }else if($timestampStart > $today){
            $eventClass = 'future_event';
          }
          ?>
          <div class="hf-grid-item col-lg-3 col-md-6 col-sm-12 <?php echo $eventClass;  ?> <?php echo $today; ?>">
            <div class="hf-gl-item">
              <div class="hf-gl-wrapper">
                <div class="hf-gl-item-img" style="overflow: hidden; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                  <a href="<?php the_permalink(); ?>">
                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" />
                  </a>
                </div>
                <h2 class="hf-gl-item-heading">
                  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>
                <div class="hf-gl-item-cat event-info">
                  <span class="event-date"><i class="fa fa-clock-o"></i> <?php echo $labelStartDate; ?></span>
                  <?php
                  foreach($categories as $category){
                    $category_names .= " ".$category->name;
                    if($category->name == "Popular"){
                      echo '<span class="popular-tag pull-right tag-cnt"><i class="fa fa-bolt"></i> Popular</span>';
                    }
                    if($category->name == "Featured"){
                      echo '<span class="featured-tag pull-right tag-cnt"><i class="fa fa-bookmark-o"></i> Featured</span>';
                    }
                  }
                  ?>
                </div>
                <div class="clearfix"></div>
                <div class="hf-gl-item-text">
                  <?php the_excerpt(); ?>
                </div>

                <?php if( !empty($event_location) ) { ?>
                  <span class="event-location"><i class="fa fa-map-o"></i> <?php echo $event_location; ?></span>
                <?php } ?>


                <div class="hf-gl-item-event-buttons">
                  <?php
                  $event_total_tickets = get_post_meta( get_the_ID(), 'hfusa-event_tickets_available', true );
                  $event_remaining_tickets = get_post_meta( get_the_ID(), 'hfusa-remaining_spaces', true );
                  $template_slug = get_page_template_slug( get_the_ID() );
                  ?>
                  <?php
                  $border_style = "border-bottom-right-radius: 5px;";
                  if(empty($template_slug) || $template_slug != 'template-telethon.php'){
                    if( !empty($event_total_tickets) && $event_total_tickets > 0 ) {
                      if( empty($event_remaining_tickets) || $event_remaining_tickets > 0 ) {
                        $border_style = "";
                      }
                    }
                  }
                  ?>
                  <a href="<?php the_permalink(); ?>" class="event-more-info <?php
                  if(!empty($template_slug) && $template_slug == 'template-telethon.php' || $event_total_tickets <= 0 || empty($event_total_tickets)){ echo 'event-more-info-telethon'; }?>" style="<?php echo $border_style; ?>">
                  <i class="fa fa-file-text"></i> More Info
                </a>
                <?php
                $buyButtonCls = 'event-buy-ticket';
                if(empty($template_slug) || $template_slug != 'template-telethon.php'){
                  if( !empty($event_total_tickets) && $event_total_tickets > 0 ) {
                    if( !empty($event_remaining_tickets) && $event_remaining_tickets <= 0 ) {
                      $buyButtonCls = 'event-sold-out';
                    }
                    $registerURL = get_post_meta( get_the_ID(), 'hfusa-register_button_url', true );
                    $bookingPageUrl=home_url('/event-booking');
                    ?>
                    <a href="<?php echo (!empty($registerURL)) ? $registerURL : esc_url( add_query_arg( 'event_id', get_the_ID(), $bookingPageUrl ) );
                    ?>" class="<?php echo $buyButtonCls; ?>" target="_blank">
                    <?php
                    if( empty($event_remaining_tickets) || $event_remaining_tickets > 0 ) {
                      ?>
                      <i class="fa fa-credit-card"></i> Register
                      <?php 
                    } else {
                      ?>
                      <i class="fa fa-ban" aria-hidden="true"></i> Sold Out
                      <?php
                    }
                    ?>
                  </a>
                  <?php
                }
              } 
              ?>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; wp_reset_query(); ?>
  </div>
</div>
</div>

</section>
<div class="clearfix"></div>
<div class="page-content">
</div>