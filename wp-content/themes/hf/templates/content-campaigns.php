<?php use Roots\Sage\Titles; ?>
<!--==================================
= Hero Section =
=================================== -->

<?php
// Classy API
require_once ABSPATH.'wp-content/themes/hf/framework/classy-php-sdk/vendor/autoload.php';

$client = new \Classy\Client([
  'client_id'     => 'ngVpuzzCKcldwe2x',
  'client_secret' => 'QwtBc22E4F068HyU',
    'version'       => '2.0' // version of the API to be used
]);

$session = $client->newAppSession();
?>

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
                $campaignArray = array();
                $loop = new WP_Query(
                    array(
                        'post_type' => 'hf_campaigns',
                        'posts_per_page' => -1,
                        'order' => 'ASC'
                    )
                );
                ?>
                <?php while ($loop->have_posts()) : $loop->the_post(); ?>
                    <?php

                    $categoryClasses = "";

                    $classyCampaignID = get_post_meta( get_the_ID(), 'hfusa-classy_campaign_id',true );

                    // Get information regarding campaign
                    try {
                      $campaign_data = $client->get('/campaigns/'.$classyCampaignID, $session);
                    } catch (\Classy\Exceptions\APIResponseException $e) {
                        // Get the HTTP response code
                      $code = $e->getCode();
                        // echo $code;
                        // Get the response content
                      $content = $e->getResponseData();
                        // echo $content;
                        // Get the response headers
                      $headers = $e->getResponseHeaders();
                        // echo $headers;
                    }

                    // $start_date = get_post_meta(get_the_ID(), 'hfusa-start_date', true);
                    // $end_date = get_post_meta(get_the_ID(), 'hfusa-end_date', true);
                    // $target_price = get_post_meta(get_the_ID(), 'hfusa-target_price', true);

                    $start_date = $campaign_data->started_at;
                    $end_date = $campaign_data->ended_at;
                    $target_price = $campaign_data->goal;

                    $timestampStart = strtotime($start_date);
                    $timestampEnd = strtotime($end_date);

                    $eventClass = '';

                    if ($timestampEnd < $today) {
                        $eventClass = 'past_event';
                    } else if ($timestampStart <= $today && $timestampEnd >= $today) {
                        $eventClass = 'current_event';
                    } else if ($timestampStart > $today) {
                        $eventClass = 'future_event';
                    }

                    $campaignArray[] = array(
                      "start_date" => $start_date,
                      "end_date"   => $end_date,
                      "target_price"   => $target_price,
                      "timestampStart"   => $timestampStart,
                      "timestampEnd"   => $timestampEnd,
                      "eventClass"   => $eventClass,
                      "id"   => get_the_ID(),
                      "title"   => get_the_title(),
                      "excerpt"   => get_the_excerpt(),
                    );

                    ?>
                    
                <?php endwhile;
                wp_reset_query(); ?>

                <?php
                  array_multisort(array_column($campaignArray, 'timestampStart'), SORT_DESC, $campaignArray);
                  foreach ($campaignArray as $campaign) { 
                    $today = current_time('timestamp');
                    $id = $campaign['id'];
                    $labelStartDate = date("F d, Y", $campaign['timestampStart']);
                    ?>
                    <div class="hf-grid-item col-lg-3 col-md-6 col-sm-12 <?php echo $campaign['eventClass']; ?> <?php echo $today; ?>">
                        <div class="hf-gl-item">
                            <div class="hf-gl-wrapper">
                                <div class="hf-gl-item-img" style="overflow: hidden; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                                    <a href="<?php echo get_the_permalink($id); ?>">
                                        <img src="<?php echo get_the_post_thumbnail_url($id); ?>"
                                             alt="<?php echo $campaign['title']; ?>"/>
                                    </a>
                                </div>
                                <h2 class="hf-gl-item-heading">
                                    <a href="<?php echo get_the_permalink($id); ?>"><?php echo $campaign['title']; ?></a>
                                </h2>
                                <div class="hf-gl-item-cat event-info">
                                    <span class="event-date"><i
                                                class="fa fa-clock-o"></i> <?php echo $labelStartDate; ?></span>
                                </div>
                                <div class="clearfix"></div>
                                <div class="hf-gl-item-text">
                                    <?php echo $campaign['excerpt']; ?>
                                </div>


                                <div class="hf-gl-item-event-buttons">
                                    <?php
                                    $template_slug = get_page_template_slug($id);
                                    ?>
                                    <a href="<?php echo get_the_permalink($id); ?>" class="event-more-info">
                                        <i class="fa fa-file-text"></i> More Info
                                    </a>
                                  <?php
                                  $value = rwmb_meta( 'hfusa-campaign_donate_url', '', $id );
                                  ?>
                                    <a href="<?php echo $value;?>" class="event-buy-ticket">
                                        <i class="fa fa-donate"></i> Donate
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php  }
                ?>
            </div>
        </div>
    </div>

</section>
<div class="clearfix"></div>
