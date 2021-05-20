<?php use Roots\Sage\Titles; ?>
<?php
/**
Template Name: Classy Campaign
Template Post Type: hf_campaigns
*/
?>
<!--==================================
= Hero Section =
=================================== -->

<section class="inner-page-title-section event-detail-page" <?php echo hf_header_bg_img(); ?>>

	<div class="iptc-content">
		<h1><?= Titles\title(); ?></h1>
		<?php bootstrap_breadcrumb(); ?>
	</div>

	<div class="overlay"></div>
</section>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->

<?php
$campaignID = get_the_ID();

$stylesheetDirectory = get_stylesheet_directory_uri();
$classyCampaignID = get_post_meta( $campaignID, 'hfusa-classy_campaign_id',true );
$campaignEventID = get_post_meta( $campaignID, 'hfusa-campaign_event_id',true );
$pledged = totalTelethonDonations($classyCampaignID,'Pledge',false);
$donated = totalTelethonDonations($classyCampaignID,'Donation',true);
$donate_url = rwmb_meta('hfusa-campaign_donate_url');
$featuredImageURL = get_the_post_thumbnail_url( $campaignID );

global $wpdb;
$is_teams = false;
$is_pages = false;
$top_fundraiser_teams = $wpdb->get_results("SELECT DISTINCT `fundraising_team_id`, SUM(`donation_amount`) as total FROM {$wpdb->prefix}hf_classy_donations WHERE `classy_id`=$classyCampaignID AND `donation_type`='Donation' AND `status`='success' AND `fundraising_team_id` IS NOT NULL GROUP BY `fundraising_team_id` ORDER BY total DESC", ARRAY_A);
$top_fundraiser_pages = $wpdb->get_results("SELECT DISTINCT `fundraising_page_id`, SUM(`donation_amount`) as total FROM {$wpdb->prefix}hf_classy_donations WHERE `classy_id`=$classyCampaignID AND `donation_type`='Donation' AND `status`='success' AND `fundraising_page_id` IS NOT NULL GROUP BY `fundraising_page_id` ORDER BY total DESC", ARRAY_A);
if($top_fundraiser_teams) {
	$is_teams = true;
}
if($top_fundraiser_pages) {
	$is_pages = true;
}
$top_states_donations = $wpdb->get_results("SELECT DISTINCT `donor_state`, SUM(`donation_amount`) as total FROM {$wpdb->prefix}hf_classy_donations WHERE `classy_id`=$classyCampaignID AND `donation_type`='Donation' AND `status`='success' AND `donor_state` IS NOT NULL GROUP BY `donor_state` ORDER BY total DESC LIMIT 5", ARRAY_A);
for ($i=0; $i<count($top_states_donations); $i++) {
	$pledge_total = $wpdb->get_var("SELECT SUM(`donation_amount`) FROM {$wpdb->prefix}hf_classy_donations WHERE `classy_id`=$classyCampaignID AND `donation_type`='Pledge' AND `donor_state`='".$top_states_donations[$i]['donor_state']."'");
	if(empty($pledge_total)) {
		$pledge_total = 0;
	}
	$top_states_donations[$i]['pledge_total'] = $pledge_total;
}
$avg_donation = $wpdb->get_var("SELECT AVG(`donation_amount`) as average_donation FROM {$wpdb->prefix}hf_classy_donations WHERE `classy_id`=$classyCampaignID AND `donation_type`='Donation' AND `status`='success'");
$highest_donation = $wpdb->get_var("SELECT `donation_amount` FROM {$wpdb->prefix}hf_classy_donations WHERE `classy_id`=$classyCampaignID AND `donation_type`='Donation' AND `status`='success' ORDER BY `donation_amount` DESC LIMIT 1");
?>

<section class="inner-page-navigation" id="sticky-nav">
	<div class="container">
		<div class="row">
			<div class="pn-menu" id="event-sections-menu">
				<ul>
					<li class="active"><a class="scrollTo pnm-e-about"
						href="#about"><span>about</span></a>
					</li>
					<li><a class="scrollTo" href="#graphs"><i class="fa fa-bar-chart" aria-hidden="true"></i><span>Graphs</span></a>
					</li>
					<?php if($is_teams || $is_pages) { ?>
					<li><a class="pnm-e-fundraisers scrollTo" href="#fundraisers"><span>Fundraisers</span></a>
					</li>
					<?php }	?>
					<li><a class="pnm-e-activity scrollTo" href="#activity"><span>Activity</span></a>
					</li>
					<?php
					$campaign_gallery=get_post_meta( $campaignID, 'hfusa-campaign_gallery' );
					if(!empty($campaign_gallery) && is_array($campaign_gallery)){
					?>
					<li><a class="pnm-e-gallery scrollTo" href="#gallery"><span>Gallery</span></a>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</section>
<div class="clearfix"></div>
<?php

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
$campaign_about = (!empty(get_the_content())) ? get_the_content() : $campaign_data->default_page_post_body;
?>

<link rel="stylesheet" href="<?php echo $stylesheetDirectory; ?>/assets/styles/components/jquery.mCustomScrollbar.min.css">

<section class="campaign-hero-section full-height-fold" id="hero-fold">
	<div class="vid-container">
		<div class="hero-vid-wrapper" id="about">
			<div class="container">
				<div class="row">
					<div class="th-row-vertical-cnt w-100">
						<div class="col th-vertical-middle">
							<div class="video-main-container">
								<div class="hero-section-1">
									<div class="row">
										<div class="col-lg-8 col-md-6 col-sm-12 mb-sm-3">
											<div class="th-content">
												<div class="th-heading">
													<div class="th-text-paragraph mCustomScrollbar">
														<?php echo $campaign_about; ?>
													</div>
													<div class="th-buttons">
														<div class="row no-gutters">
															<div class="col-xl-3 col-lg-6 col-sm-12 pr-lg-2 pr-sm-0">
																<a class="btn btn-primary btn-block" href="<?php echo (!empty($donate_url)) ? $donate_url : home_url('donate'); ?>" target="_blank">Donate Now</a>
															</div>
															<div class="col-xl-3 col-lg-6 col-sm-12 pr-xl-2">
																<a class="btn btn-primary btn-block" href="<?php echo home_url( 'pledge?event_id='.$campaignEventID ); ?>" target="_blank">Pledge Now</a>
															</div>
															<div class="col-xl-3 col-lg-6 col-sm-12 pr-lg-2">
																<a class="btn btn-primary btn-block"  href="<?php echo rwmb_meta('hfusa-campaign_fundraiser_url'); ?>" target="_blank">Become a Fundraiser</a>
															</div>
															<div class="col-xl-3 col-lg-6 col-sm-12">
																<a class="btn btn-primary btn-block"  href="<?php echo home_url('contact-us'); ?>" target="_blank">Contact Us</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-12">
											<div class="th-content">
												<div class="th-heading">
													<h3 class="mt-0 text-center w-100">
														From: 
														<?php echo date('F d, Y', strtotime($campaign_data->started_at));?>
														<br>
														<?php
														if(!empty($campaign_data->ended_at)) {
															echo "To: ".date('F d, Y', strtotime($campaign_data->ended_at));
														}
														?>
													</h3>
													<div class="donation-stats">
														<h2>$<?php echo nice_number($campaign_data->goal); ?></h2>
														<h3>Goal</h3>
													</div>
													<div class="donation-stats">
														<h2>$<?php echo nice_number($campaign_overview->total_gross_amount); ?></h2>
														<h3>Donations</h3>
													</div>
													<div class="donation-stats">
														<h2>$<?php echo nice_number($pledged); ?></h2>
														<h3>Pledges</h3>
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

<?php 
	$totalCollected = $campaign_overview->total_gross_amount + totalTelethonDonations($classyCampaignID,'Pledge',false);
?>

<!--Donation Stats Box Section Start-->
<section id="stats" class="stats-section features-area item-full text-center cell-items default-padding mb-5 mt-5">
  <div class="container">
    <div class="row features-items">
      <div class="col-lg-3 col-md-6 col-sm-12 equal-height">
        <div class="item">
          <div class="icon">
            <i class="fa fa-usd"></i>
          </div>
          <div class="info">
            <h3>$<?php echo nice_number($totalCollected); ?></h3>
            <p>Total Raised</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-12 equal-height">
        <div class="item">
          <div class="icon">
            <i class="fa fa-university"></i>
          </div>
          <div class="info">
            <h3><?php echo $campaign_overview->transactions_count; ?></h3>
            <p>Total Transactions</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-12 equal-height">
        <div class="item">
          <div class="icon">
            <i class="fa fa-bar-chart"></i>
          </div>
          <div class="info">
            <h3>$<?php echo number_format($avg_donation, 2); ?></h3>
            <p>Avg. Donation Amount</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-12 equal-height">
        <div class="item">
          <div class="icon">
            <i class="fa fa-line-chart"></i>
          </div>
          <div class="info">
            <h3>$<?php echo nice_number(str_replace('.00', '', $highest_donation)); ?></h3>
            <p>Highest Donation Amount</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Donation Stats Box Section End-->
<!--============================
=            Graphs            =
=============================-->

<div class="section" id="graphs">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-12">
				<?php $states_heading = rwmb_meta('hfusa-top_five_states_heading'); ?>
				<h1 class="underlined-heading capital"><?php echo (!empty($states_heading)) ? $states_heading : 'Top 5 States'; ?></h1>
				<div id="chart"></div>
			</div>
			<div class="col-lg-6 col-md-12">
				<?php $donations_heading = rwmb_meta('hfusa-donations_collected_heading'); ?>
				<h1 class="underlined-heading capital"><?php echo (!empty($donations_heading)) ? $donations_heading : 'Donations Collected'; ?></h1>
				<div id="radialChart"></div>
			</div>
		</div>
	</div>
</div>

<!--====  End of Graphs  ====-->

<div class="container">
	<div class="row">
		<div class="col"><hr></div>
	</div>
</div>

<!--============================================
=            Donations Progress Bar            =
=============================================-->

<!--==================================
=         Fundraisers Section        =
===================================-->
<?php
if($is_teams || $is_pages) {
?>
<section class="t-map-section py-5" id="fundraisers">
	<div class="th-bottom-large-navgation" >
		<div class="container">
			<div class="row">
				<?php if($is_teams) { ?>
				<div class="col-lg-6 col-md-12 col-sm-12 mb-md-3">
					<h1 class="underlined-heading capital"><?php echo rwmb_meta('hfusa-top_teams_heading'); ?></h1>
					<div class="th-content pl-0 mt-4 mCustomScrollbar" style="max-height: 500px;">
						<?php
						foreach($top_fundraiser_teams as $fundraiser) {
							// Get fundraising team
							try {
							    $fundraising_team = $client->get('/fundraising-teams/'.$fundraiser['fundraising_team_id'], $session);
							    // $second_last_page = (int)$campaign_transactions->last_page - 1;
							    // $campaign_transactions = $client->get('/campaigns/132309/transactions?page='.$campaign_transactions->last_page, $session);
							} catch (\Classy\Exceptions\APIResponseException $e) {
							    // Get the HTTP response code
							    $code = $e->getCode();
							    echo $code;
							    // Get the response content
							    $content = $e->getResponseData();
							    echo $content;
							    // Get the response headers
							    $headers = $e->getResponseHeaders();
							    echo $headers;
							}
							// Get fundraising team
							try {
							    $fundraising_team_pages = $client->get('/fundraising-teams/'.$fundraiser['fundraising_team_id'].'/fundraising-pages', $session);
							    // $second_last_page = (int)$campaign_transactions->last_page - 1;
							    // $campaign_transactions = $client->get('/campaigns/132309/transactions?page='.$campaign_transactions->last_page, $session);
							} catch (\Classy\Exceptions\APIResponseException $e) {
							    // Get the HTTP response code
							    $code = $e->getCode();
							    echo $code;
							    // Get the response content
							    $content = $e->getResponseData();
							    echo $content;
							    // Get the response headers
							    $headers = $e->getResponseHeaders();
							    echo $headers;
							}
						?>
						<div class="item-wrapper">
							<div class="img-wrapper">
								<img src="<?php echo (!empty($fundraising_team->logo_url)) ? $fundraising_team->logo_url : get_stylesheet_directory_uri()."/assets/images/team_default_image.webp"; ?>" alt="">
							</div>
							<div class="info-wrapper">
								<div class="item-name"><b><?php echo $fundraising_team->name; ?></b></div>
								<div class="item-progress-bar">
									<?php
									$percentage = ($fundraiser['total'] / $fundraising_team->goal) * 100;
									?>
									<div class="item-progress" style="width: <?php echo $percentage; ?>%"></div>
								</div>
								<div class="item-stats"><?php echo '<b>$'.number_format($fundraiser['total'])."</b> raised (".number_format($percentage, 2)."%) ".$fundraising_team_pages->total." members"; ?></div>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php } else { ?>
				<div class="col-lg-6 col-md-12 col-sm-12 mb-md-3">
					<h1 class="underlined-heading capital"><?php echo rwmb_meta('hfusa-top_teams_heading'); ?></h1>
					<div class="th-content pl-0 mt-4 mCustomScrollbar" style="max-height: 500px;">
						<p>No teams to show.</p>
					</div>
				</div>
				<?php } ?>
				<?php if($is_pages) { ?>
				<div class="col-lg-6 col-md-12 col-sm-12">
					<h1 class="underlined-heading capital"><?php echo rwmb_meta('hfusa-top_individuals_heading'); ?></h1>
					<div class="th-content pl-0 mt-4 mCustomScrollbar" style="max-height: 500px;">
						<?php
						foreach($top_fundraiser_pages as $fundraiser) {
							// Get fundraising team
							try {
							    $fundraising_page = $client->get('/fundraising-pages/'.$fundraiser['fundraising_page_id'], $session);
							    // $second_last_page = (int)$campaign_transactions->last_page - 1;
							    // $campaign_transactions = $client->get('/campaigns/132309/transactions?page='.$campaign_transactions->last_page, $session);
							} catch (\Classy\Exceptions\APIResponseException $e) {
							    // Get the HTTP response code
							    $code = $e->getCode();
							    echo $code;
							    // Get the response content
							    $content = $e->getResponseData();
							    echo $content;
							    // Get the response headers
							    $headers = $e->getResponseHeaders();
							    echo $headers;
							}
						?>
						<div class="item-wrapper">
							<div class="img-wrapper">
								<img src="<?php echo (!empty($fundraising_page->logo_url)) ? $fundraising_page->logo_url : get_stylesheet_directory_uri().'/assets/images/individual_default_image.png'; ?>" alt="">
							</div>
							<div class="info-wrapper">
								<div class="item-name"><b><?php echo $fundraising_page->alias; ?></b></div>
								<div class="item-progress-bar">
									<?php
									$percentage = ($fundraiser['total'] / $fundraising_page->goal) * 100;
									?>
									<div class="item-progress" style="width: <?php echo $percentage; ?>%"></div>
								</div>
								<div class="item-stats"><?php echo '<b>$'.number_format($fundraiser['total'])."</b> raised (".number_format($percentage, 2)."%)"; ?></div>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php } else { ?>
				<div class="col-lg-6 col-md-12 col-sm-12">
					<h1 class="underlined-heading capital"><?php echo rwmb_meta('hfusa-top_individuals_heading'); ?></h1>
					<div class="th-content pl-0 mt-4 mCustomScrollbar" style="max-height: 500px;">
						<p>No individuals to show.</p>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</section>

<!--====  End of Fundraisers Section  ====-->
<div class="container">
	<div class="row">
		<div class="col"><hr></div>
	</div>
</div>
<?php } ?>
<!--============================================
=                 feed section                 =
=============================================-->
<?php
$activities = array();
// Get campaign activity
try {
    $campaign_activities = $client->get('/campaigns/'.$classyCampaignID.'/activity', $session);
    $last_page = $campaign_activities->last_page;
    $campaign_activities = $client->get('/campaigns/'.$classyCampaignID.'/activity?page='.$last_page, $session);
    $last_page = $campaign_activities->last_page - 1;
    foreach (array_reverse($campaign_activities->data) as $data) {
    	$activities[] = $data;
    }
    if($last_page > 0) {
    	$campaign_activities = $client->get('/campaigns/'.$classyCampaignID.'/activity?page='.$last_page, $session);
	    foreach (array_reverse($campaign_activities->data) as $data) {
	    	$activities[] = $data;
	    }
    }
} catch (\Classy\Exceptions\APIResponseException $e) {
    // Get the HTTP response code
    $code = $e->getCode();
    echo $code;
    // Get the response content
    $content = $e->getResponseData();
    echo $content;
    // Get the response headers
    $headers = $e->getResponseHeaders();
    echo $headers;
}
?>

<div class="feed-section t-map-section" id="activity">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="container">
			<div class="row">
				<?php if(count($activities) > 0) { ?>
				<div class="col-lg-6 col-md-12 col-sm-12 mb-md-3">
					<h1 class="underlined-heading capital"><?php echo rwmb_meta('hfusa-campaign_activity_heading'); ?></h1>
					<div class="th-content pl-0 mt-4 mCustomScrollbar" style="max-height: 500px;">
						<?php
						foreach ($activities as $campaign_activity) {
						?>
						<div class="item-wrapper">
							<div class="img-wrapper">
								<img src="<?php echo !empty($campaign_activity->member->thumbnail_large) ? $campaign_activity->member->thumbnail_large : get_stylesheet_directory_uri().'/assets/images/individual_default_image.png'; ?>" alt="">
							</div>
							<div class="info-wrapper">
								<?php if($campaign_activity->type == 'donation_created') { ?>
									<?php if($campaign_activity->transaction->is_anonymous) { ?>
									<div class="item-name"><?php echo $campaign_activity->link_text; ?> was donated anonymously</div>
									<?php } else { ?>
									<div class="item-name"><?php echo '<b>'.$campaign_activity->transaction->member_name.'</b> donated '.$campaign_activity->link_text; ?></div>
									<?php } ?>
									<?php if(!empty($campaign_activity->transaction->comment)) { ?>
									<div class="comment"><?php echo $campaign_activity->transaction->comment; ?></div>
									<?php } ?>
								<?php } else if($campaign_activity->type == 'ticket_purchased') { ?>
									<div class="item-name"><?php echo '<b>'.$campaign_activity->transaction->member_name.'</b> purchased a ticket'; ?></div>
								<?php } else if($campaign_activity->type == 'fundraising_page_created') { ?>
									<div class="item-name"><?php echo '<b>'.$campaign_activity->member->first_name.' '.$campaign_activity->member->last_name.'</b> created a Fundraising Page'; ?></div>
								<?php } else if ($campaign_activity->type == 'campaign_created') { ?>
									<div class="item-name"><?php echo '<b>'.$campaign_activity->member->first_name.' '.$campaign_activity->member->last_name.'</b> created a Campaign'; ?></div>
								<?php } ?>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php } else { ?>
				<div class="col-lg-6 col-md-12 col-sm-12 mb-md-3">
					<h1 class="underlined-heading capital"><?php echo rwmb_meta('hfusa-campaign_activity_heading'); ?></h1>
					<div class="th-content pl-0 mt-4 mCustomScrollbar" style="max-height: 500px;">
						<p>No activity to show.</p>
					</div>
				</div>
				<?php } ?>
				<div class="col-lg-6 col-md-12 col-sm-12 th-content-bottom">
					<h1 class="underlined-heading capital"><?php echo rwmb_meta('hfusa-twitter_feed_heading'); ?></h1>
					<div class="th-content" style="margin-top: 20px;">
						<div id="th-twitter-feeds"  class="hf-social-feeds col-sm-12 hf-social-right" style="width: 100%; height: 510px; margin-left: 0;">

							<div class="hf-cssload-thecube">
								<div class="hf-cssload-cube cssload-c1"></div>
								<div class="hf-cssload-cube cssload-c2"></div>
								<div class="hf-cssload-cube cssload-c4"></div>
								<div class="hf-cssload-cube cssload-c3"></div>
							</div>					

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--====        End of feed section      ====-->

<?php
$campaign_gallery=get_post_meta( $campaignID, 'hfusa-campaign_gallery' );
if(!empty($campaign_gallery) && is_array($campaign_gallery)){
?>
<!--=====================================
=            gallery section            =
======================================-->
<section class="t-light-box-gallery" id="gallery">
	<div class="pd-light-box">
		<ul>
			<?php
			foreach ($campaign_gallery as $key => $picID) {
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

<?php
$states = array();
$values = array();
$pledge_values = array();
foreach ($top_states_donations as $top_state) {
	$states[] = $top_state['donor_state'];
	$values[] = $top_state['total'];
	$pledge_values[] = $top_state['pledge_total'];
}
?>

<script src="<?php echo $stylesheetDirectory; ?>/assets/scripts/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript">

	loadTwitterfeeds(false);

	function loadTwitterfeeds(scroll_load){

		var max_id = jQuery('.twitter-max-id').last().data('feed-max-id');

		if(scroll_load==true){
			jQuery(".hf-social-right .hf-cssload-thecube").show();
			var box_height = jQuery('#th-twitter-feeds .mCSB_container').height();
			box_height  = box_height - 25 +'px';
			jQuery("#th-twitter-feeds .hf-cssload-thecube").css("top", box_height);
		}
		jQuery.ajax({
			url: '<?php echo $stylesheetDirectory; ?>/campaign-social-feeds.php',
			method: "POST",
			dataType: "html",
			data:  "load_th_feeds=twitter_feeds&max_id="+max_id+"&post_id=<?php echo $campaignID;  ?>"
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
<script>
	var states = <?php echo json_encode($hf_us_state_abbrevs_names); ?>;
	var keys = Object.keys(states);
	function getStateFullName(stateCode) {
		var index = jQuery.inArray(stateCode, keys);
		if(index >= 0) {
			return states[stateCode];
		} else {
			return stateCode;
		}
	}
	function numberWithCommas(x) {
		var parts = x.toString().split(".");
		parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		return parts.join(".");
	}
	jQuery(document).ready(function() {
		var stateCodes = <?php echo json_encode($states); ?>;
		var options = {
			chart: {
				type: 'bar',
				width: '100%',
				height: 500
			},
			colors: ['#0069b4', '#333'],
			plotOptions: {
				bar: {
					barHeight: '100%',
					horizontal: true,
					dataLabels: {
						position: 'top'
					},
				},
			},
			dataLabels: {
				showOn: 'always',
				enabled: true,
				textAnchor: 'end',
				name: {
					offsetY: -15,
					show: true,
					color: '#888',
					fontSize: '17px'
				},
				formatter: function(val, opt) {
					return "$" + numberWithCommas(val)
				},
				offsetX: 110,
				style: {
					colors: ['#333']
				}
			},
			series: [{
				name: 'Donations',
				data: <?php echo json_encode($values); ?>
			},
			{
				name: 'Pledges',
				data: <?php echo json_encode($pledge_values); ?>
			}],
            stroke: {
                width: 1,
              	colors: ['#fff']
            },
			xaxis: {
				categories: stateCodes,
				labels: {
					show: true,
					formatter: function (value) {
						return "$" + numberWithCommas(value);
					}
				},
				title: {
					text: 'Donations',
					style: {
						fontSize: '24px'
					}
				}
			},
			yaxis: {
				title: {
					text: 'States',
					offsetX: 10,
					style: {
						fontSize: '24px'
					}
				}
			},
			tooltip: {
				x: {
					formatter: function(seriesName) {
						return getStateFullName(seriesName)
					}
				},
				y: {
					formatter: function(value, { series, seriesIndex, dataPointIndex, w }) {
						return "$" + numberWithCommas(value)
					},
				},
			},
		}

		var chart = new ApexCharts(document.querySelector("#chart"), options);

		chart.render();

		var totalRaised = "<?php echo nice_number($totalCollected); ?>";
		totalRaised = jQuery.parseHTML(totalRaised);
		var num_raised = totalRaised[0].data.trim();
		var unit_raised = '';
		if(totalRaised.length > 1) {
			unit_raised = totalRaised[1].innerHTML;
		}
		var totalDonations = "<?php echo nice_number($campaign_overview->total_gross_amount); ?>";
		totalDonations = jQuery.parseHTML(totalDonations);
		var num_donated = totalDonations[0].data.trim();
		var unit_donated = '';
		if(totalDonations.length > 1) {
			unit_donated = totalDonations[1].innerHTML;
		}
		var percent_donations = "<?php echo ($campaign_overview->total_gross_amount / $campaign_data->goal) * 100; ?>";
		var percent_pledges = "<?php echo ($pledged / $campaign_data->goal) * 100; ?>";
		var percent_total = "<?php echo ($totalCollected / $campaign_data->goal) * 100; ?>";

		var options = {
			chart: {
				width: '100%',
				height: 400,
				type: 'radialBar',
				toolbar: {
					show: true
				}
			},
			plotOptions: {
				radialBar: {
					startAngle: -135,
					endAngle: 225,
					hollow: {
						margin: 0,
						size: '70%',
						background: '#fff',
						image: undefined,
						imageOffsetX: 0,
						imageOffsetY: 0,
						position: 'front',
						dropShadow: {
							enabled: true,
							top: 3,
							left: 0,
							blur: 4,
							opacity: 0.24
						}
					},
					track: {
						background: '#fff',
						strokeWidth: '80%',
			            margin: 0, // margin is in pixels
			            dropShadow: {
			            	enabled: true,
			            	top: -3,
			            	left: 0,
			            	blur: 4,
			            	opacity: 0.35
			            }
			        },
			        dataLabels: {
			        	showOn: 'always',
			        	name: {
			        		offsetY: -50,
			        		show: true,
			        		color: '#888',
			        		fontSize: '18px'
			        	},
			        	value: {
			        		formatter: function(val) {
			        			return parseFloat(val).toFixed(2)+"%";
			        		},
			        		color: '#111',
			        		fontSize: '44px',
			        		show: true,
			        		offsetY: -15,
			        	},
			        	total: {
			        		show: true,
			        		label: "We've Raised",
			        		formatter: function(val) {
			        			return "$"+num_raised+unit_raised;
			        		}
			        	}
			        }
			    }
			},
			fill: {
				type: 'gradient',
				gradient: {
					shade: 'dark',
					type: 'horizontal',
					shadeIntensity: 0.5,
					gradientToColors: ['#0069b4'],
					inverseColors: true,
					opacityFrom: 1,
					opacityTo: 1,
					stops: [0, 100]
				}
			},
			series: [percent_total, percent_donations, percent_pledges],
			stroke: {
				lineCap: 'round'
			},
			labels: ["Total", "Donations", "Pledges"],

		}

var chart = new ApexCharts(
	document.querySelector("#radialChart"),
	options
	);
chart.render();
chart.addText({
  x: 170,
  y: 220,
  appendTo: '.apexcharts-datalabels-group',
  textAnchor: 'middle',
  text: 'Our Goal',
  fontSize: '18px',
  foreColor: '#888'
});
var goal = "<?php echo nice_number($campaign_data->goal); ?>";
goal = jQuery.parseHTML(goal);
var num = goal[0].data.trim();
var unit = '';
if(goal.length > 1) {
	unit = goal[1].innerHTML;
}
chart.addText({
  x: 170,
  y: 250,
  appendTo: '.apexcharts-datalabels-group',
  textAnchor: 'middle',
  text: "$"+num+unit,
  fontSize: '24px',
  foreColor: '#111'
});
});
</script>
