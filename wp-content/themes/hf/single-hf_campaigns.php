<?php

$stylesheetDirectory = get_stylesheet_directory_uri();
$donationCampaignID = get_the_ID();
$currentPagePermalink = get_the_permalink( $donationCampaignID );
// $campaignID	=	get_post_meta( $donationCampaignID, 'hfusa-event_campaigns',true );
$parse = parse_url($currentPagePermalink);
$host = !empty($parse['host']) ? $parse['host'] : '';
$telethon_video_url	=	get_post_meta( $donationCampaignID, 'hfusa-campaign_video_url',true );
if(!empty($telethon_video_url)) {
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $telethon_video_url, $match);
    $videoId = isset($match[1]) ? $match[1] : '';
    $key = get_option( 'hf_youtube_api_key' );
    $liveStreamingLink = 'https://www.googleapis.com/youtube/v3/videos?part='.urlencode('snippet,contentDetails,statistics,liveStreamingDetails').'&id='.$videoId.'&key='.$key;
    $request = wp_remote_get( $liveStreamingLink );
    $chatEnabled = false;
    if( !is_wp_error( $request ) ) {
        $body = wp_remote_retrieve_body( $request );
        $liveStreamingDetails = json_decode( $body );
        if(isset($liveStreamingDetails->items[0]->liveStreamingDetails->activeLiveChatId)){
            $chatEnabled = true;
        }
    }
}
$donate_url = rwmb_meta('hfusa-campaign_donate_url');

$featuredImageURL = get_the_post_thumbnail_url( $donationCampaignID );

$classyCampaignID = get_post_meta( $donationCampaignID, 'hfusa-classy_campaign_id', true );

// Classy API
require_once 'framework/classy-php-sdk/vendor/autoload.php';

$client = new \Classy\Client([
    'client_id'     => 'ngVpuzzCKcldwe2x',
    'client_secret' => 'QwtBc22E4F068HyU',
    'version'       => '2.0' // version of the API to be used
]);

$session = $client->newAppSession();

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

// Get information regarding campaign
try {
    $campaign_overview = $client->get('/campaigns/'.$classyCampaignID.'/overview', $session);
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

// Get transactions information regarding campaign
try {
    $campaign_transactions = $client->get('/campaigns/'.$classyCampaignID.'/transactions', $session);
    $campaign_transactions = $client->get('/campaigns/'.$classyCampaignID.'/transactions?page='.$campaign_transactions->last_page, $session);
    $latest_donations = array();
    $latest_donations = array_merge($latest_donations, $campaign_transactions->data);
    while(count($latest_donations) < 20) {
        $pageToLoad = (int)$campaign_transactions->current_page - 1;
        $campaign_transactions = $client->get('/campaigns/'.$classyCampaignID.'/transactions?page='.$pageToLoad, $session);
        $latest_donations = array_merge($latest_donations, $campaign_transactions->data);
    }
} catch (\Classy\Exceptions\APIResponseException $e) {
    // Get the HTTP response code
    $code = $e->getCode();
    error_log($code);
    // Get the response content
    $content = $e->getResponseData();
    error_log($content);
    // Get the response headers
    $headers = $e->getResponseHeaders();
    error_log($headers);
}
?>

<link rel="stylesheet" href="<?php echo $stylesheetDirectory; ?>/assets/styles/components/jquery.mCustomScrollbar.min.css">

<script type="text/javascript">
    function loadFBfeeds(scroll_load){

        var after_id = jQuery('.facebook-after-id').last().data('feed-after-id');

        if(scroll_load==true){
            jQuery(".hf-social-left .hf-cssload-thecube").show();
            var box_height = jQuery('#th-fb-feeds .mCSB_container').height();
            box_height  = box_height - 25 +'px';
            jQuery("#th-fb-feeds .hf-cssload-thecube").css("top", box_height);
        }

        jQuery.ajax({
            url: '<?php echo $stylesheetDirectory; ?>/telethon-social-feeds.php',
            method: "POST",
            dataType: "html",
            data:  "load_th_feeds=fb_feeds&after_id="+after_id+"&post_id=<?php echo $donationCampaignID;  ?>"
        }).success(function (data) {
            if(data){
                jQuery("#th-fb-feeds").mCustomScrollbar({
                    callbacks:{
                        onTotalScroll:function(){
                            loadFBfeeds(true);
                        }
                    }
                });

                jQuery(".hf-social-left .mCSB_container").append(data);
                jQuery("#th-fb-feeds").mCustomScrollbar("update");
            }

        }).always(function() {
            jQuery(".hf-social-left .hf-cssload-thecube").hide();
        });
    }

    function loadTwitterfeeds(scroll_load){

        var max_id = jQuery('.twitter-max-id').last().data('feed-max-id');

        if(scroll_load==true){
            jQuery(".hf-social-right .hf-cssload-thecube").show();
            var box_height = jQuery('#th-twitter-feeds .mCSB_container').height();
            box_height  = box_height - 25 +'px';
            jQuery("#th-twitter-feeds .hf-cssload-thecube").css("top", box_height);
        }
        jQuery.ajax({
            url: '<?php echo $stylesheetDirectory; ?>/telethon-social-feeds.php',
            method: "POST",
            dataType: "html",
            data:  "load_th_feeds=twitter_feeds&max_id="+max_id+"&post_id=<?php echo $donationCampaignID;  ?>"
        }).success(function (data) {
            if(data){
                jQuery("#th-twitter-feeds").mCustomScrollbar({
                    callbacks:{
                        onTotalScroll:function(){
                            loadTwitterfeeds(true);
                        }
                    }
                });

                jQuery(".hf-social-right .mCSB_container").append(data);
                jQuery("#th-twitter-feeds").mCustomScrollbar("update");
            }
        }).always(function() {
            jQuery(".hf-social-right .hf-cssload-thecube").hide();
        });
    }
</script>

<section class="telethon-hero-section full-height-fold" id="hero-fold" style="background-image: url(<?php echo $featuredImageURL; ?>);">
    <div class="vid-container">
        <div class="hf-overlay"></div>
        <div class="hero-vid-wrapper">
            <div class="container">
                <div class="row">
                    <div class="th-row-vertical-cnt">
                        <div class="col th-vertical-middle">
                            <div class="video-main-container">
                                <div class="hero-section-1">
                                    <div class="col-lg-6 col-md-6 col-sm-12 float-right">
                                        <div class="row">
                                            <div class="th-content">
                                                <div class="th-heading">
                                                    <h1><?php the_title(); ?></h1>
                                                    <h3><?php rwmb_the_value('hfusa-start_date', array( 'format' => 'F j, Y' ));?></h3>
                                                    <div class="th-text-paragraph mCustomScrollbar">
                                                        <?php
                                                        if(!empty(get_the_content())){
                                                            the_content();
                                                        } else {
                                                            echo $campaign_data->default_page_post_body;
                                                        }
                                                        
                                                        ?>
                                                    </div>
                                                    <div class="th-buttons">
                                                        <a class="btn btn-primary btn-hollow-y-border" href="<?php echo (!empty($donate_url)) ? $donate_url : home_url('/donate').'?campaign_id='.$donationCampaignID; ?>" target="_blank">DONATE NOW</a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if(!empty($telethon_video_url)) { ?>
                                        <div class="col-lg-6 col-md-6 col-sm-12 float-left video-wraper">
                                            <div class="row">
                                                <figure class="th-content-media th-content-media-video" id="th-featured-media">
                                                    <iframe class="th-content-media-object" id="th-featured-video" src="https://www.youtube.com/embed/<?php echo $videoId; ?>?autoplay=1&rel=0&showinfo=0" frameborder="0" allowfullscreen style="width: 100%;" height="315"></iframe>
                                                </figure>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="hero-section-2">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12 col-sm-12">
                                                <?php if(!empty($telethon_video_url)) { ?>
                                                    <div class="row-container-comments">
                                                        <?php  if($chatEnabled == true){ ?>
                                                            <iframe style="width: 100%;"  height="280" src="https://www.youtube.com/live_chat?v=<?php echo $videoId; ?>&embed_domain=<?php echo $host; ?>" frameborder="0" allowfullscreen></iframe>
                                                        <?php }else{?>

                                                            <div class="t-video-comments-box">
                                                                <div class="t-video-comments-box-inner">
                                                                    <?php

                                                                    $yourubeVideoComments = 'https://www.googleapis.com/youtube/v3/commentThreads?part=snippet%2Creplies&maxResults=20&videoId='.$videoId.'&key='.$key;

                                                                    $request = wp_remote_get( $yourubeVideoComments );
                                                                    if( !is_wp_error( $request ) ) {
                                                                        $body = wp_remote_retrieve_body( $request );
                                                                        $commentsDetails = json_decode( $body );

                                                                        $totalResults = isset($commentsDetails->pageInfo->totalResults) ? $commentsDetails->pageInfo->totalResults : 0;
                                                                        $nextPageToken = isset($commentsDetails->nextPageToken) ? $commentsDetails->nextPageToken : 0;
                                                                        if($totalResults > 0){

                                                                            $items = isset($commentsDetails->items) ? $commentsDetails->items : '';

                                                                            if(!empty($items) && is_array($items)){

                                                                                foreach($items as $item){

                                                                                    $snippet = $item->snippet->topLevelComment->snippet;
                                                                                    $authorDisplayName = $snippet->authorDisplayName;
                                                                                    $authorProfileImageUrl = $snippet->authorProfileImageUrl;
                                                                                    $textDisplay = $snippet->textDisplay;
                                                                                    $authorChannelUrl = $snippet->authorChannelUrl;

                                                                                    ?>
                                                                                    <div class="t-individual-comment">
                                                                                        <img alt="" src="<?php echo $authorProfileImageUrl; ?>" width="24" height="24">
                                                                                        <span><a target="_blank" href="<?php echo $authorChannelUrl; ?>"><strong><?php echo $authorDisplayName; ?></strong></a></span>
                                                                                        <span><?php echo $textDisplay; ?></span>
                                                                                    </div>

                                                                                    <?php

                                                                                }
                                                                                ?>

                                                                                <div data-next-page-token='<?php echo $nextPageToken; ?>' class="t-next-page-token"></div>
                                                                                <?php
                                                                            }
                                                                        }else{

                                                                            echo '<p>No comments yet!</p>';
                                                                        }

                                                                    }else{

                                                                        echo '<p>No comments yet!</p>';

                                                                    }

                                                                    ?>

                                                                </div>
                                                                <div class="hf-cssload-thecube" style="">
                                                                    <div class="hf-cssload-cube cssload-c1"></div>
                                                                    <div class="hf-cssload-cube cssload-c2"></div>
                                                                    <div class="hf-cssload-cube cssload-c4"></div>
                                                                    <div class="hf-cssload-cube cssload-c3"></div>
                                                                </div>
                                                            </div>


                                                        <?php } ?>






                                                    </div>
                                                <?php } ?>

                                                <!-- <div class="row">
                                                    <div class="container container-products-telethon">


                                                    </div>
                                                </div> -->
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-sm-12">
                                                <div class="row">
                                                    <div class="container container-products-telethon">
                                                        <div class="products-telethon">
                                                            <?php
                                                            $post = get_post($donationCampaignID); 
                                                            $campaignSlug = $post->post_name;
                                                            $args = array(
                                                                'post_type' => 'product',
                                                                'posts_per_page' => 12,
                                                                'tax_query' => array(
                                                                    array(
                                                                        'taxonomy' => 'product_cat',
                                                                        'field'    => 'slug',
                                                                        'terms'    => $campaignSlug
                                                                    ),
                                                                ),
                                                            );
                                                            $loop = new WP_Query( $args );
                                                            if ( $loop->have_posts() ) {
                                                                while ( $loop->have_posts() ) : $loop->the_post();
                                                                    ?>
                                                                    <div class="">
                                                                        <div class="th-singleproduct-wrapper">

                                                                            <?php


                                                                            if(has_post_thumbnail()){
                                                                                echo '<a target="_blank" href="'.get_the_permalink().'">'.get_the_post_thumbnail().'</a>';
                                                                            }else{
                                                                                echo '<a target="_blank" href="'.get_the_permalink().'">'.wc_placeholder_img("thumbnail").'</a>';
                                                                            }

                                                                            echo '<div class="link-details">';
                                                                            echo '<a target="_blank" class="product-link" href="'.get_the_permalink().'">'.get_the_title().'</a>';
                                                                            echo '</div>';


                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                endwhile;
                                                            } else {
                                                                echo __( 'No products found' );
                                                            }
                                                            wp_reset_postdata();
                                                            ?>
                                                        </div><!--/.products--></div>
                                                    </div>
                                                </div>
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

<!--==================================
=            Map Ssection            =
===================================-->
<section class="t-map-section">

    <div class="th-bottom-large-navgation" >

        <div id="statistics" class="donation-target-status donation-target-status-telethon">
            <div class="container">
                <div class="row rtl-display d-flex align-items-center">
                    <div class="col-4 float-left text-left">
                        <div class="d-inline-block telethon-hero-boxes-icons">
                            <div class="icon-container float-left">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/dts-bullseye.png" alt="" />
                            </div>
                            <div class="dts-figures float-left">
                                <?php



                                // $targeted_amount	=	get_post_meta( $campaignID, 'hfusa-target_price',true );
                                ?>
                                <h4>USD<span>
                                    <?php 
                                    // echo nice_number($targeted_amount); 
                                    echo nice_number($campaign_data->goal);
                                    ?></span></h4>
                                    <h6>target</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 float-left text-center">
                            <div class="d-inline-block telethon-hero-boxes-icons">
                                <div class="icon-container float-left">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/dts-donation.png" alt="" />
                                </div>
                                <div class="dts-figures float-left text-left">
                                    <h4>USD<span class="donations-collected">
                                        <?php 
                                    // echo totalTelethonDonations($campaignID,'Donation',true); 
                                        echo nice_number($campaign_overview->donations_amount);
                                        ?></span></h4>
                                        <h6>DONATIONS</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 float-left text-right">
                                <div class="d-inline-block telethon-hero-boxes-icons">
                                    <div class="icon-container float-left">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/dts-pledged.png" alt="" />
                                    </div>
                                    <div class="dts-figures float-left text-left">
                                        <h4><span id="" class="ml-0">
                                            <?php 
                                    // echo totalTelethonDonations($campaignID,'Pledge',true); 
                                            echo number_format($campaign_overview->percent_to_goal, 2).'%';
                                            ?></span></h4>
                                            <h6>Achieved</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="container">
                    <div class="row">
                        <?php
            // $donationsData = hf_state_donattions($campaignID);
            // echo '<div data-states-donations='.$donationsData.' id="state-donations"></div>';
                        ?>
            <!-- <div class="col-lg-9 col-md-12 col-sm-12">
                <div class="interactive-map-container">

                    <div id="container-maps" class="states-map-inner"></div>
                </div>
            </div> -->
            <div class="col-lg-4 col-md-12 col-sm-12">
                <div class="t-map-statistics telethon-map-statistics">
                    <div class="tms-header">
                        <h5>latest donations</h5>
                        <h4 class="donations-collected">$ <?php 
                        // echo totalTelethonDonations($campaignID,'donation',true); 
                        echo nice_number($campaign_overview->donations_amount);
                        ?></h4>
                    </div>
                    <div class="tms-body content-telethon-donations mCustomScrollbar">
                        <?php
                        // $idLatestDonation = 0;
                        // $args = array(
                        //     'posts_per_page'=> 50,
                        //     'post_type' => 'hf_donations',
                        //     'meta_query' => array(
                        //         'relation' => 'AND',
                        //         array(
                        //             'key'     => 'hfusa-donation_campaign_id',
                        //             'value'   => $campaignID,
                        //             'compare' => '=',
                        //         ),
                        //         array(
                        //             'key'     => 'hfusa-donation_type',
                        //             'value'   => 'Donation',
                        //             'compare' => '=',
                        //         )
                        //     ),
                        // );
                        // $the_query = new WP_Query( $args );
                        // if ( $the_query->have_posts() ) {
                        //     $i=0;
                        //     while ( $the_query->have_posts() ) {
                        //         $the_query->the_post();
                        //         $donationID = get_the_ID();
                        //         if($i==0){
                        //             $idLatestDonation = $donationID;
                        //         }
                        //         $donor_name=get_post_meta( $donationID, 'hfusa-donor_name',true );
                        //         $donation_amount=get_post_meta( $donationID, 'hfusa-donation_amount',true );
                        //         $donor_state=get_post_meta( $donationID, 'hfusa-donor_state',true );
                        //         $doantionDate='';
                        //         $doantionDate= get_the_date('M d, Y | h:i A',$donationID);
                        if ( !empty($latest_donations) ) {
                            foreach ($latest_donations as $campaign_transaction) {
                                ?>
                                <div class="tms-list-item">
                                    <?php
                                    // $donor_state = strtoupper($donor_state);
                                    // $key = array_search ($donor_state, $hf_us_state_abbrevs_names);

                                    // if($key == false){
                                    //     $key = $donor_state;
                                    // }
                                    if($campaign_transaction->billing_country == 'US') {
                                        $flagURLPng='/assets/images/us-states/'.strtolower($campaign_transaction->billing_state).'.png';
                                        $flagURLJpg='/assets/images/us-states/'.strtolower($campaign_transaction->billing_state).'.jpg';

                                        if(file_exists(get_template_directory().$flagURLJpg)){
                                            $flagFile = $stylesheetDirectory.$flagURLJpg;
                                        }else if(file_exists(get_template_directory().$flagURLPng)) {
                                            $flagFile = $stylesheetDirectory.$flagURLPng;
                                        }else{
                                            $flagFile = $stylesheetDirectory.'/assets/images/us-states/dummy-flag.jpg';
                                        }
                                    }else{
                                        $flagFile = $stylesheetDirectory.'/assets/images/us-states/dummy-flag.jpg';
                                    }

                                    
                                    if(!empty($flagFile)){
                                        ?>
                                        <div class="flag-container">
                                            <img src="<?php echo $flagFile; ?>">
                                        </div>
                                    <?php } ?>
                                    <div class="country-details">
                                        <h5>
                                            <?php 
                                            if($campaign_transaction->is_anonymous) {
                                                echo "Anonymous";
                                            } else {
                                                echo $campaign_transaction->member_name;
                                            }
                                            ?>   
                                        </h5>
                                        <h6>
                                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                                            <?php echo date('dS M Y', strtotime($campaign_transaction->created_at)); ?>
                                        </h6>
                                    </div>
                                    <div class="tms-amount">
                                        <h6>$<?php echo $campaign_transaction->donation_net_amount; ?></h6>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<div class="col-sm-12 sidebar-zero-donations">No donations.</div>';
                        }
                        ?></div>
                        <div class="gray-donate-btn" data-latest-donation="<?php // echo $idLatestDonation; ?>">
                            <a href="<?php echo (!empty($donate_url)) ? $donate_url : home_url('/donate').'?campaign_id='.$donationCampaignID; ?>" target="_blank"><i class="fa fa-heart" aria-hidden="true"></i> DONATE NOW</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12 th-content-bottom">

                    <div class="th-content">
                        <?php 
                        $telethonFBPage  = get_post_meta( $donationCampaignID, 'hfusa-telethon_fb_page',true ); 
                        if(!empty($telethonFBPage)) {
                            ?>
                            <div id="th-fb-feeds" class="hf-social-feeds col-sm-12  hf-social-left">

                                <div class="hf-cssload-thecube">
                                    <div class="hf-cssload-cube cssload-c1"></div>
                                    <div class="hf-cssload-cube cssload-c2"></div>
                                    <div class="hf-cssload-cube cssload-c4"></div>
                                    <div class="hf-cssload-cube cssload-c3"></div>
                                </div>

                            </div>
                            <script>loadFBfeeds(false);</script>
                        <?php } ?>
                        <?php
                        $twitterHashtag  = get_post_meta( $donationCampaignID, 'hfusa-telethon_twitter_page',true );
                        if(!empty($twitterHashtag)) {
                            ?>
                            <div id="th-twitter-feeds"  class="hf-social-feeds col-sm-12 hf-social-right">

                                <div class="hf-cssload-thecube">
                                    <div class="hf-cssload-cube cssload-c1"></div>
                                    <div class="hf-cssload-cube cssload-c2"></div>
                                    <div class="hf-cssload-cube cssload-c4"></div>
                                    <div class="hf-cssload-cube cssload-c3"></div>
                                </div>

                            </div>
                            <script>loadTwitterfeeds(false);</script>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--====  End of Map Section  ====-->

<!--==============================
=            Schedule            =
===============================-->
<?php

$event_agendas = get_post_meta( $donationCampaignID, 'hfusa-agandas_details' );
$is_agenda_empty = true;

if( !empty($event_agendas) ) {
    if(!is_array($event_agendas[0])){
        $event_agendas = unserialize($event_agendas[0]);
    }else{
        $event_agendas = $event_agendas[0];
    }

    if( empty($event_agendas) || empty($event_agendas[0]['agenda_title'])) {
        $is_agenda_empty = true;
    }
    $count=0;
}

?>
<?php if(!$is_agenda_empty){ ?>

    <section class="schedule-section" id="agenda">
        <div class="container">
            <h2 class="heading-st1 text-center">Conference Schedule</h2>
            <div class="row rtl-display">
                <div class="row justify-content-center">
                    <div class="col-sm-12 col-md-12">

                        <?php

                        function hfCompareByValue($a, $b) {
                            if(!isset($a["start_time"]) || !isset($b["start_time"])){
                                return false;
                            }
                            return $a["start_time"] > $b["start_time"];
                        }

                        $sortedArr=array();

                        $is_empty = true;

                        $i=0;

                        foreach($event_agendas as $array){
                            $sortedArr[$i]['agenda_title']= !empty($array['agenda_title']) ? $array['agenda_title'] : '';
                            $sortedArr[$i]['desc']= !empty($array['desc']) ? $array['desc'] : '';
                            $sortedArr[$i]['presenter_post']= !empty($array['presenter_post']) ? $array['presenter_post'] : '';
                            $sortedArr[$i]['sponsor_logo'] = !empty($array['sponsor_logo']) ? $array['sponsor_logo'] : '';
                            if(isset($array['sponsor_logo'][0][0]) && is_array($array['sponsor_logo'][0])){
                                $sortedArr[$i]['sponsor_logo'] = $array['sponsor_logo'][0];
                            }

                            $sortedArr[$i]['start_time']= !empty($array['start_time']) ? $array['start_time'] : '';
                            $sortedArr[$i]['end_time']= !empty($array['end_time']) ? $array['end_time'] : '';
                            $i++;
                        }
                        usort($sortedArr, 'hfCompareByValue');

                        if($sortedArr && is_array($sortedArr)){
                            echo '<div id="accordion">';
                            foreach ($sortedArr as $subArr) {
                                $agenda_title = !empty($subArr["agenda_title"]) ? $subArr["agenda_title"] : '';
                                $desc = !empty($subArr["desc"]) ? $subArr["desc"] : '';
                                $presenter_post = !empty($subArr["presenter_post"]) ? $subArr["presenter_post"] : '';
                                $start_time = !empty($subArr["start_time"]) ? $subArr["start_time"] : '';
                                $end_time = !empty($subArr["end_time"]) ? $subArr["end_time"] : '';
                                if( !empty($agenda_title) ) {
                                    $is_empty = false;
                                    ?>
                                    <div class="col-sm-12 agenda-box row" >

                                        <div class="agenda-box-inner" data-toggle="collapse" data-parent="#accordion"
                                        href="#collapse<?php echo($count); ?>" >
                                        <div class="col-sm-12">
                                            <div class="row">

                                                <div class="col-lg-4 col-sm-4 col-xs-6">
                                                    <span class="panel-date"><i class="fa fa-hourglass-start" aria-hidden="true"></i><?php echo $start_time; ?> - <?php echo $end_time; ?></span>
                                                </div>
                                                <div class="col-lg-8 col-sm-8 col-xs-6 text-right">
                                                    <span class="schedule-title"><?php echo $agenda_title; ?></span>
                                                    <span class="schedule-arrow" data-toggle="collapse" data-parent="#accordion"
                                                    href="#collapse<?php echo($count); ?>" ><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="collapse<?php echo($count); ?>" class="collapse  agenda_details_outer col-sm-12 " >

                                        <div class="agenda_details">

                                            <?php

                                            if(!empty($desc)){
                                                ?>
                                                <div class="col-sm-12"><p><?php echo $desc; ?></p></div>

                                                <?php
                                            }

                                            if(!empty($presenter_post) && is_array($presenter_post)){

                                                foreach ($presenter_post as $presenter_id) {

                                                    ?>

                                                    <div class="col-sm-12 row agenda-presenter">
                                                        <?php
                                                        $pres_img = get_the_post_thumbnail($presenter_id,'thumbnail');
                                                        $author = get_the_title( $presenter_id );
                                                        $presenter_post = get_post($presenter_id);
                                                        $desc = $presenter_post->post_content;

                                                        $show_agenda_title = get_post_meta( $presenter_id, 'amplify-show_agenda_title', true );

                                                        ?>
                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <?php
                                                                if(!empty($pres_img))
                                                                {
                                                                    ?>
                                                                    <div class="author_img col-lg-2">
                                                                        <?php
                                                                        echo $pres_img;
                                                                        ?>
                                                                    </div>
                                                                <?php } ?>

                                                                <div class="desc col-lg-10">

                                                                    <div class="col-lg-12">

                                                                        <?php
                                                                        if($show_agenda_title == false && !empty($author)){ ?>
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

                                                    <?php } } ?>

                                                    <div class="sponsor_img_agenda col-sm-12">
                                                        <?php
                                                        $sponsor_logo  = !empty($subArr["sponsor_logo"]) ? $subArr["sponsor_logo"] : '';
                                                        if(!empty($sponsor_logo) && is_array($sponsor_logo)){

                                                            foreach ($sponsor_logo as $logo) {

                                                                $spon_logo=wp_get_attachment_image_src($logo,'medium');
                                                                if(!empty($spon_logo))
                                                                {
                                                                    ?>
                                                                    <?php
                                                                    echo '<img src="'.$spon_logo[0].'">';
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
                                        $count=$count+1;
                                    }
                                }
                                echo '</div>';
                                if($is_empty === true) {
                                    echo '<div class="col-sm-12 text-center">No Agendas found for this event!</div>';
                                }
                            }else{
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

<!--============================================
=            sponsors and speakers             =
=============================================-->

<!--<section class="t-sponsors-speakers">
    <div class="container">
        <div class="row rtl-display">
            <div class="col-12 float-left">
                <div id="partners" class="col-lg-6 col-md-12 col-sm-12 float-left">
                    <div class="t-sponsors">
                        <h1 class="underlined-heading capital">Partners</h1>
                        <div class="sponsors-logos-container th-speaker-sponsor-carosel">
                            <?php
/*                            $campaignPartners =get_post_meta( $donationCampaignID, 'hfusa-campaign_partners' );
                            if(!empty($campaignPartners) && is_array($campaignPartners)){
                                foreach ($campaignPartners as $key => $partnerID) {
                                    */?>
                                    <div class="th-carousel-item">
                                        <a href="<?php /*echo get_the_permalink( $partnerID ); */?>">
                                            <?php /* echo get_the_post_thumbnail( $partnerID,'full' ); */?>
                                        </a>
                                    </div>
                                    <?php
/*                                }
                            }
                            */?>
                        </div>
                    </div>
                </div>
                <div id="speakers" class="col-lg-6 col-md-12 col-sm-12 float-left">
                    <div class="t-speakers">
                        <h1 class="underlined-heading capital">SPEAKERS</h1>
                        <div class="speakers-list-container th-speaker-sponsor-carosel">
                            <?php
/*                            $event_speakers=get_post_meta( $donationCampaignID, 'hfusa-event_speakers' );
                            if(!empty($event_speakers) && is_array($event_speakers)){
                                foreach ($event_speakers as $key => $speakerID) {
                                    */?>
                                    <div class="th-carousel-item">
                                        <a href="<?php /*echo get_the_permalink( $speakerID ); */?>" class="rounded-link">
                                            <?php
/*                                            $avatar = get_the_post_thumbnail_url($speakerID);
                                            if( empty($avatar) ) {
                                                $avatar = $stylesheetDirectory.'/assets/images/default-avatar.png';
                                            }
                                            */?>
                                            <img src="<?php /*echo $avatar; */?>" alt="<?php /*echo get_the_title($speakerID); */?>" />
                                        </a>
                                        <div class="clearfix"></div>
                                        <h5 class="speaker-name"><a href="<?php /*echo get_the_permalink( $speakerID ); */?>"><?php /*echo get_the_title($speakerID); */?></a></h5>
                                        <h6 class="speaker-designation">senior developer</h6>
                                        <ul class="slc-social-profiles text-center">
                                            <?php
/*                                            $speaker_facebook= get_post_meta( $speakerID, 'hfusa-speaker_facebook',true );
                                            $speaker_twitter= get_post_meta( $speakerID, 'hfusa-speaker_twitter',true );
                                            $speaker_linkedin= get_post_meta( $speakerID, 'hfusa-speaker_linkedin',true );
                                            $speeker_google_plus= get_post_meta( $speakerID, 'hfusa-speeker_google_plus',true );
                                            */?>
                                            <?php
/*                                            if($speaker_facebook){
                                                echo '<li><a href="'.$speaker_facebook.'" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>';
                                            }
                                            if($speeker_google_plus){
                                                echo '<li><a href="'.$speeker_google_plus.'" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>';
                                            }
                                            if($speaker_twitter){
                                                echo '<li><a href="'.$speaker_twitter.'" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>';
                                            }
                                            if($speaker_linkedin){
                                                echo '<li><a href="'.$speaker_linkedin.'" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>';
                                            }
                                            */?>
                                        </ul>
                                    </div>
                                    <?php
/*                                }
                            }
                            */?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="clearfix"></div>-->

<!--====  End of sponsors and speakers   ====-->

<?php
$campaignGallery=get_post_meta( $donationCampaignID, 'hfusa-campaign_gallery' );
if(!empty($campaignGallery) && is_array($campaignGallery)){
    ?>
<!--=====================================
=            gallery section            =
======================================-->
<section class="t-light-box-gallery" id="gallery">
    <div class="pd-light-box">
        <ul>
            <?php
            foreach ($campaignGallery as $key => $picID) {
                $attachment_url = wp_get_attachment_image_src( $picID,'medium_large' );
                if(isset($attachment_url[0])){
                    ?>
                    <li>
                        <img src="<?php echo $attachment_url[0]; ?>">
                        <a href="#<?php echo $picID; ?>" class="open-image"><i class="fa fa-search-plus" aria-hidden="true"></i></a>
                        <a href="#_" class="hf_gallery_lightbox hf_t_gallery_lightbox" id="<?php echo $picID; ?>">
                            <img src="<?php echo $attachment_url[0]; ?>" />
                        </a>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>
</section>
<div class="clearfix"></div>

<!--====  End of gallery section  ====-->
<?php } ?>

<?php
$campaignHistory = get_post_meta( $donationCampaignID, 'hfusa-Campaign_history', true);
if(!empty($campaignHistory)) {
    ?>
    <section class="t-history-section" id="history">
        <div class="container">
            <div class="row rtl-display">
                <div class="col-12 float-left">
                    <?php
                    echo $campaignHistory;
                    ?>
                </div>
            </div>
        </div>
    </section>
<?php } ?>


<!--================================
=            Newsletter            =
=================================-->
<section class="t-newsletter">
    <div class="hf-overlay"></div>
    <div class="container">
        <div class="row rtl-display">
            <div class="col-12 float-left">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-sm-12 col-md-10">
                        <h3>SUBSCRIBE TO OUR NEWSLETTER</h3>
                        <div class="row justify-content-center">
                            <div class="col-10">
                                <div class="t-newsletter-form">
                                    <?php echo do_shortcode('[yikes-mailchimp form="1"]'); ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--====  End of Newsletter  ====-->


<!--====  End of Telethon Page  ====-->



<!-- Modal -->
<div class="modal fade telethon-pledge-modal" id="telethonPledgeModal"  tabindex="-1" role="dialog" aria-labelledby="telethonPledgeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="telethonPledgeModalLabel">Pledge</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form class="clearfix" id="telethon-pledge-form">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <input type="email" class="form-control" name="user_email" id="user_email" placeholder="Email" required="true">
                        </div>
                        <div class="col-sm-6 form-group">
                            <input type="text" class="form-control" name="user_first_name" id="user_first_name" placeholder="First Name" required="true">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <input type="text" class="form-control" name="user_last_name" id="user_last_name" placeholder="Last Name" required="true">
                        </div>
                        <div class="col-sm-6 form-group">
                            <input type="text" class="form-control" name="user_middle_name" id="user_middle_name" placeholder="Middle Name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <input type="text" class="form-control" name="user_phone" id="user_phone" placeholder="Phone" required="true">
                        </div>
                        <div class="col-sm-6 form-group">
                            <input type="text" class="form-control" name="user_city" id="user_city" placeholder="City" required="true">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <select class="form-control" name="user_state" id="user_state" required="true">
                                <?php
                                echo '<option value="">Select State</option>';
                                foreach($hf_us_state_abbrevs_names as $key => $value){
                                    echo '<option value="'.$key.'">'.ucwords(strtolower($value)).'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-6 form-group">
                            <input type="text" class="form-control" name="user_zip" id="user_zip" placeholder="Zip code" required="true">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <textarea name="user_address" id="user_address" class="form-control" placeholder="Street address"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <input type="number" class="form-control" name="pledge_amount" id="pledge_amount" placeholder="Pledge Amount" required="true">
                        </div>
                        <div class="col-sm-6 form-group">
                            <input type="text" class="form-control" name="pledge_promise_date" id="pledge_promise_date" placeholder="Pledge promise date" required="true">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <select class="form-control" name="pledge_recurrence" id="pledge_recurrence" required="">
                                <option value="">Select Pledge Recurrence</option>
                                <option value="One Time">One Time</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Quarterly">Quarterly</option>
                            </select>
                        </div>
                        <div class="col-sm-6 form-group">
                            <input type="number" class="form-control" name="pledge_recursive_amount" id="pledge_recursive_amount" placeholder="Pledge Total Amount" required="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <div class="g-recaptcha" data-sitekey="6LejGTIUAAAAADHIetCzuvCqHU1fnmfjN_1f0imB" data-callback="telethonRecaptchaCallback"></div>
                            <div class="error recaptcha-error"></div>
                            <span id="telethon-pledge-captcha" class="telethon-pledge-captcha"></span>
                        </div>
                        <div class="col-sm-6 form-group text-right">
                            <button type="submit" class="btn btn-primary pull-right btn-primary-submit">Submit <i style="font-size:24px;position: relative;top: 3px;margin-left: 6px;" class="fa fa-refresh fa-spin"></i></button>
                        </div>
                    </div>

                </form>

                <div id="server-response"></div>

            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
</script>
<script src="<?php echo $stylesheetDirectory; ?>/assets/scripts/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?php echo $stylesheetDirectory; ?>/assets/scripts/highmaps.js"></script>
<script src="<?php echo $stylesheetDirectory; ?>/assets/scripts/us-all.js"></script>
<script type="text/javascript">

    jQuery(function() {

        /*code for stickey youtube video frame*/
        var $window = jQuery( window );
        var $featuredMedia = jQuery("#th-featured-media" );
        var $featuredVideo = jQuery("#th-featured-video" );
        var player;
        var top = $featuredMedia.offset().top;
        var offset = Math.floor( top + ( $featuredMedia.outerHeight() / 2 ) );

        $window
        .on( "resize", function() {
            top = $featuredMedia.offset().top;
            offset = Math.floor( top + ( $featuredMedia.outerHeight() / 2 ) );

            if($featuredVideo.hasClass("is-sticky")){
                var transformleft = jQuery(".hero-section-1").offset().left;
                $featuredVideo.css('transform', 'translateX(-'+(transformleft-10)+'px)');
            }else{
                $featuredVideo.css('transform', 'translateX(0)');
            }
        } )

        .on( "scroll", function() {
            $featuredVideo.toggleClass( "is-sticky", $window.scrollTop() > offset );
            if($featuredVideo.hasClass("is-sticky")){
                var transformleft = jQuery(".hero-section-1").offset().left;
                $featuredVideo.css('transform', 'translateX(-'+(transformleft-10)+'px)');
            }else{
                $featuredVideo.css('transform', 'translateX(0)');
            }
        } );



        jQuery('.t-video-comments-box').on('scroll', function() {

            if(jQuery(this).scrollTop() + jQuery(this).innerHeight() >= jQuery(this)[0].scrollHeight) {
                loadYoutubefeeds();
            }
        })



    });

    function loadYoutubefeeds(){

        var token = jQuery('.t-next-page-token').last().data('next-page-token');
        jQuery(".t-video-comments-box .hf-cssload-thecube").show();

        jQuery.ajax({
            url: '<?php echo $stylesheetDirectory; ?>/telethon-social-feeds.php',
            method: "POST",
            dataType: "html",
            data:  "load_th_feeds=youtube_feeds&token="+token+"&post_id=<?php echo $donationCampaignID;  ?>"
        }).success(function (data) {
            if(data){
                jQuery(".t-video-comments-box-inner").append(data);
            }
        }).always(function() {
            jQuery(".t-video-comments-box .hf-cssload-thecube").hide();
        });
    }
</script>
<!-- <script type="text/javascript">
    <?php
    $arrayCodes = array();
    $i=0;
    foreach ($hf_us_state_abbrevs_names as $key => $value) {
        $value = strtolower($value);
        $value = str_replace(" ", "-", $value);
        $arrayCodes[$i]["code"] = strtolower($key);
        $arrayCodes[$i]["Donation"] = "--";
        $arrayCodes[$i]["Pledge"] = "--";
        $arrayCodes[$i]["name"] = $value;
        $i++;
    }
    ?>

    var map_data = JSON.parse('<?php echo json_encode($arrayCodes); ?>');

    jQuery(function() {

        var s_data = jQuery('#state-donations').data('states-donations');
        jQuery.each(map_data, function () {
            this.code = this.code.toUpperCase();
            if(s_data[this.name] && s_data[this.name]["Donation"]){
                this.Donation = "$" + s_data[this.name]["Donation"];
            }
            if(s_data[this.name] && s_data[this.name]["Pledge"]){
                this.Pledge = "$" + s_data[this.name]["Pledge"];
            }
        });

        Highcharts.mapChart('container-maps', {
            chart: {
                borderColor: '#0069b4',
                map: 'countries/us/us-all',
                borderWidth: 1
            },
            title: {
                text: ''
            },
            credits: {
                enabled:false
            },
            exporting: {
                enabled :false
            },
            legend: {
                enabled:false
            },
            mapNavigation: {
                enabled: true
            },
            colors: ['#009ABF'],
            series: [{
                animation: {
                    duration: 1000
                },
                data: map_data,
                joinBy: ['postal-code', 'code'],
                states: {
                    hover: {
                        color: '#0069b4'
                    }
                },
                dataLabels: {
                    enabled: true,
                    color: '#FFFFFF',
                    format: '{point.code}'
                },
                name: 'Donations',
                tooltip: {
                    pointFormat: '{point.name}: {point.Donation} <br> {point.name}: {point.Pledge}',
                    headerFormat: '',
                    pointFormat: '<b>{point.name}</b><br/><br/>Donation: {point.Donation} <br/>Pledge: {point.Pledge}'
                }
            }]
        });

        /*code for stickey youtube video frame*/
        var $window = jQuery( window );
        var $featuredMedia = jQuery("#th-featured-media" );
        var $featuredVideo = jQuery("#th-featured-video" );
        var player;
        var top = $featuredMedia.offset().top;
        var offset = Math.floor( top + ( $featuredMedia.outerHeight() / 2 ) );

        $window
            .on( "resize", function() {
                top = $featuredMedia.offset().top;
                offset = Math.floor( top + ( $featuredMedia.outerHeight() / 2 ) );

                if($featuredVideo.hasClass("is-sticky")){
                    var transformleft = jQuery(".hero-section-1").offset().left;
                    $featuredVideo.css('transform', 'translateX(-'+(transformleft-10)+'px)');
                }else{
                    $featuredVideo.css('transform', 'translateX(0)');
                }
            } )

            .on( "scroll", function() {
                $featuredVideo.toggleClass( "is-sticky", $window.scrollTop() > offset );
                if($featuredVideo.hasClass("is-sticky")){
                    var transformleft = jQuery(".hero-section-1").offset().left;
                    $featuredVideo.css('transform', 'translateX(-'+(transformleft-10)+'px)');
                }else{
                    $featuredVideo.css('transform', 'translateX(0)');
                }
            } );



        jQuery('.t-video-comments-box').on('scroll', function() {

            if(jQuery(this).scrollTop() + jQuery(this).innerHeight() >= jQuery(this)[0].scrollHeight) {
                loadYoutubefeeds();
            }
        })



    });

    loadFBfeeds(false);
    loadTwitterfeeds(false);

    function loadFBfeeds(scroll_load){

        var after_id = jQuery('.facebook-after-id').last().data('feed-after-id');

        if(scroll_load==true){
            jQuery(".hf-social-left .hf-cssload-thecube").show();
            var box_height = jQuery('#th-fb-feeds .mCSB_container').height();
            box_height  = box_height - 25 +'px';
            jQuery("#th-fb-feeds .hf-cssload-thecube").css("top", box_height);
        }

        jQuery.ajax({
            url: '<?php echo $stylesheetDirectory; ?>/telethon-social-feeds.php',
            method: "POST",
            dataType: "html",
            data:  "load_th_feeds=fb_feeds&after_id="+after_id+"&post_id=<?php echo $donationCampaignID;  ?>"
        }).success(function (data) {
            if(data){
                jQuery("#th-fb-feeds").mCustomScrollbar({
                    callbacks:{
                        onTotalScroll:function(){
                            loadFBfeeds(true);
                        }
                    }
                });

                jQuery(".hf-social-left .mCSB_container").append(data);
                jQuery("#th-fb-feeds").mCustomScrollbar("update");
            }

        }).always(function() {
            jQuery(".hf-social-left .hf-cssload-thecube").hide();
        });
    }

    function loadTwitterfeeds(scroll_load){

        var max_id = jQuery('.twitter-max-id').last().data('feed-max-id');

        if(scroll_load==true){
            jQuery(".hf-social-right .hf-cssload-thecube").show();
            var box_height = jQuery('#th-twitter-feeds .mCSB_container').height();
            box_height  = box_height - 25 +'px';
            jQuery("#th-twitter-feeds .hf-cssload-thecube").css("top", box_height);
        }
        jQuery.ajax({
            url: '<?php echo $stylesheetDirectory; ?>/telethon-social-feeds.php',
            method: "POST",
            dataType: "html",
            data:  "load_th_feeds=twitter_feeds&max_id="+max_id+"&post_id=<?php echo $donationCampaignID;  ?>"
        }).success(function (data) {
            if(data){
                jQuery("#th-twitter-feeds").mCustomScrollbar({
                    callbacks:{
                        onTotalScroll:function(){
                            loadTwitterfeeds(true);
                        }
                    }
                });

                jQuery(".hf-social-right .mCSB_container").append(data);
                jQuery("#th-twitter-feeds").mCustomScrollbar("update");
            }
        }).always(function() {
            jQuery(".hf-social-right .hf-cssload-thecube").hide();
        });
    }


    function loadYoutubefeeds(){

        var token = jQuery('.t-next-page-token').last().data('next-page-token');
        jQuery(".t-video-comments-box .hf-cssload-thecube").show();

        jQuery.ajax({
            url: '<?php echo $stylesheetDirectory; ?>/telethon-social-feeds.php',
            method: "POST",
            dataType: "html",
            data:  "load_th_feeds=youtube_feeds&token="+token+"&post_id=<?php echo $donationCampaignID;  ?>"
        }).success(function (data) {
            if(data){
                jQuery(".t-video-comments-box-inner").append(data);
            }
        }).always(function() {
            jQuery(".t-video-comments-box .hf-cssload-thecube").hide();
        });
    }
</script> -->
<script>
    // if(typeof(EventSource) !== "undefined") {
    //     <?php
    //     $path = $stylesheetDirectory.'/telethon-updates.php';
    //     ?>
    //     var source = new EventSource("<?php // echo $path; ?>");
    //     source.onmessage = function(event) {
    //         var latestDonationPage = jQuery('.gray-donate-btn').attr('data-latest-donation');
    //         if(event.data > latestDonationPage){
    //             console.log('new donation added');
    //             jQuery.ajax({
    //                 url: ajax_object.ajaxurl,
    //                 method: "POST",
    //                 dataType: "json",
    //                 data:  "action=hf_load_telethon_donations&telethon_campaign=<?php // echo $campaignID;?>&latest_donation="+latestDonationPage
    //             }).success(function (data) {
    //                 if(data && data.latest_donations){
    //                     var donation_collected_prev = jQuery(".dts-figures .donations-collected").text();
    //                     var data_donations_amount = data.total_donations_amount;
    //                     var total_doantions = 0;
    //                     var donation_amount_prefix = 0;
    //                     var donation_amount_postfix = '';

    //                     if (data_donations_amount.indexOf('span') > -1) {
    //                         data_donations_amount = data_donations_amount.split(" ");
    //                         donation_amount_prefix = data_donations_amount[0];
    //                         donation_amount_postfix = data_donations_amount[1];
    //                         if(donation_amount_postfix = '<span>K</span>'){
    //                             total_doantions = donation_amount_prefix*1000;
    //                         }else if(donation_amount_postfix = '<span>M</span>'){
    //                             total_doantions = donation_amount_prefix*1000000;
    //                         }else if(donation_amount_postfix = '<span>M</span>'){
    //                             total_doantions = donation_amount_prefix*1000000;
    //                         }else if(donation_amount_postfix = '<span>B</span>'){
    //                             total_doantions = donation_amount_prefix*1000000000;
    //                         }
    //                     }else{
    //                         total_doantions = data_donations_amount;
    //                         donation_amount_prefix = data_donations_amount;
    //                     }

    //                     /* animate the counter for the donations collected */
    //                     jQuery('.dts-figures .donations-collected').prop('Counter',donation_collected_prev).animate({
    //                         Counter: donation_amount_prefix
    //                     }, {
    //                         duration: 3000,
    //                         easing: 'swing',
    //                         step: function (now) {
    //                             if(total_doantions < 1000 ){
    //                                 jQuery('.dts-figures .donations-collected').html(Math.ceil(now));
    //                             }else{
    //                                 jQuery('.dts-figures .donations-collected').html(donation_amount_prefix+' '+donation_amount_postfix);
    //                             }
    //                         }
    //                     });

    //                     jQuery(".tms-header h4").html( '$ '+donation_amount_prefix+' '+donation_amount_postfix );

    //                     /* insert and animate new donation record in the latest donations sidebar*/
    //                     jQuery(data.latest_donations).clone().hide().prependTo('.telethon-map-statistics .mCSB_container').slideDown();

    //                     if(jQuery(data.latest_donations).length > 0){
    //                         jQuery('.sidebar-zero-donations').hide();
    //                     }

    //                     jQuery('.gray-donate-btn').attr('data-latest-donation', data.latest_donation_id);
    //                     var obj = JSON.parse(data.data_donation);
    //                     jQuery('#state-donations').data('states-donations',obj);

    //                     /* update the map states data */
    //                     jQuery.each(map_data, function () {
    //                         this.code = this.code.toUpperCase();
    //                         if(obj[this.name] && obj[this.name]["Donation"]){
    //                             this.Donation = "$" + obj[this.name]["Donation"];
    //                         }
    //                         if(obj[this.name] && obj[this.name]["Pledge"]){
    //                             this.Pledge = "$" + obj[this.name]["Pledge"];
    //                         }
    //                     });

    //                     var map_data_new = JSON.stringify(map_data);
    //                     map_data_new = JSON.parse(map_data_new);
    //                     jQuery("#container-maps").highcharts().series[0].update({
    //                         data: map_data_new
    //                     });
    //                 }else if(data && data.latest_donation_id){
    //                     jQuery('.gray-donate-btn').attr('data-latest-donation', data.latest_donation_id);
    //                 }
    //             });
    //         }
    //     }
    // }
</script>
