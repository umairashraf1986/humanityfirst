<?php use Roots\Sage\Titles; ?>
<?php
/**
Template Name: Telethon
Template Post Type: hf_events
*/
?>
<!--==================================
=           Telethon Page            =
===================================-->
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
$telethonEventID = get_the_ID();
$event_sponsors=get_post_meta( $telethonEventID, 'hfusa-event_sponsors' );
$event_speakers=get_post_meta( $telethonEventID, 'hfusa-event_speakers' );
$event_guests=get_post_meta( $telethonEventID, 'hfusa-event_guests' );

$campaignID	= get_post_meta( $telethonEventID, 'hfusa-event_campaigns',true );
$classyCampaignID = get_post_meta( $campaignID, 'hfusa-classy_campaign_id',true );

global $wpdb;
// $is_teams = false;
// $is_pages = false;
// $top_fundraiser_teams = $wpdb->get_results("SELECT DISTINCT `fundraising_team_id`, SUM(`donation_amount`) as total FROM {$wpdb->prefix}hf_classy_donations WHERE `classy_id`=$classyCampaignID AND `donation_type`='Donation' AND `status`='success' AND `fundraising_team_id` IS NOT NULL GROUP BY `fundraising_team_id` ORDER BY total DESC", ARRAY_A);
// $top_fundraiser_pages = $wpdb->get_results("SELECT DISTINCT `fundraising_page_id`, SUM(`donation_amount`) as total FROM {$wpdb->prefix}hf_classy_donations WHERE `classy_id`=$classyCampaignID AND `donation_type`='Donation' AND `status`='success' AND `fundraising_page_id` IS NOT NULL GROUP BY `fundraising_page_id` ORDER BY total DESC", ARRAY_A);
// if($top_fundraiser_teams) {
// 	$is_teams = true;
// }
// if($top_fundraiser_pages) {
// 	$is_pages = true;
// }
?>
<input type="hidden" name="classyCampaignID" id="classyCampaignID" value="<?php echo $classyCampaignID; ?>">
<input type="hidden" name="telethonEventID" id="telethonEventID" value="<?php echo $telethonEventID; ?>">
<section class="inner-page-navigation" id="sticky-nav" style="<?php echo (!empty(get_post_meta( $telethonEventID, 'hfusa-top_nav_color' ))) ? 'background-color: '.get_post_meta( $telethonEventID, 'hfusa-top_nav_color', true ) : ''; ?>">
	<div class="container">
		<div class="row">
			<div class="pn-menu" id="event-sections-menu">
				<ul>
					<li class="active"><a class="scrollTo pnm-e-about"
						href="#about"><span>about</span></a>
					</li>
					<?php // if($is_teams || $is_pages) { ?>
					<li><a class="pnm-e-fundraisers scrollTo" href="#fundraisers"><span>Fundraisers</span></a>
					</li>
					<?php // }	?>
					<li><a class="pnm-e-agenda scrollTo" href="#agenda"><span>agenda</span></a>
					</li>
					<?php if(!empty($event_sponsors)) { ?>
					<li><a class="pnm-e-sponsors scrollTo" href="#sponsors"><span>Sponsors</span></a>
					<?php } ?>
					</li>
					<?php if(!empty($event_speakers)) { ?>
					<li><a class="pnm-e-speakers scrollTo" href="#hosts"><span>Hosts</span></a>
					</li>
					<?php } ?>
					<?php
					$telethon_gallery=get_post_meta( $telethonEventID, 'hfusa-telethon_gallery' );
					if(!empty($telethon_gallery) && is_array($telethon_gallery)){
					?>
					<li><a class="pnm-e-gallery scrollTo" href="#gallery"><span>Gallery</span></a>
					</li>
					<?php } ?>
					<li><a class="pnm-e-history scrollTo" href="#history"><span>history</span></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</section>
<div class="clearfix"></div>
<?php

$stylesheetDirectory = get_stylesheet_directory_uri();
$currentPagePermalink = get_the_permalink( $telethonEventID );

$parse = parse_url($currentPagePermalink);
$host = !empty($parse['host']) ? $parse['host'] : '';
$pledged = totalTelethonDonations($classyCampaignID,'Pledge',true);
$donated = totalTelethonDonations($classyCampaignID,'Donation',true);
$telethon_video_url	=	get_post_meta( $telethonEventID, 'hfusa-telethon_video_url',true );
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

$donate_url = rwmb_meta('hfusa-telethon_donate_url');
$featuredImageURL = get_the_post_thumbnail_url( $telethonEventID );

$start_time = date('h:i A', strtotime(rwmb_meta('hfusa-event_start_time')));
$end_time = date('h:i A', strtotime(rwmb_meta('hfusa-event_end_time')));


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
?>
<?php
$images = rwmb_meta( 'hfusa-intro_background', array( 'limit' => 1 ) );
$intro_background = reset( $images );
?>
<section class="telethon-hero-section full-height-fold" id="hero-fold" style="<?php echo (!empty($intro_background)) ? 'background-image: url('.$intro_background['full_url'].');' : ''; ?>">
	<div class="vid-container">
		<div class="hero-vid-wrapper" id="about">
			<div class="container">
				<div class="row">
					<div class="column">
						<div class="th-content">
							<div class="th-heading">
								<div class="th-text-paragraph mCustomScrollbar">
									<?php 
									if (have_posts()) {
										while (have_posts()) {
											the_post();
											the_content(); 
										}
									} ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="th-row-vertical-cnt">
						<div class="col th-vertical-middle">
							<div class="video-main-container">
								<div class="hero-section-1 feed-section">
									<div class="col-lg-6 col-md-6 col-sm-12 float-right pr-md-0">
										<div class="row">
											<div class="col">
												<h1 class="underlined-heading capital mt-0"><?php echo rwmb_meta('hfusa-youtube_comments_heading', array(), $telethonEventID); ?></h1>
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
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 float-left video-wraper">
										<div class="row">
											<figure class="th-content-media th-content-media-video" id="th-featured-media">
												<iframe class="th-content-media-object" id="th-featured-video" src="https://www.youtube.com/embed/<?php echo $videoId; ?>?autoplay=1&rel=0&showinfo=0" frameborder="0" allowfullscreen style="width: 100%;" height="315"></iframe>
											</figure>
											<div class="th-buttons">
												<div class="row no-gutters">
													<div class="col">
														<a href="<?php echo rwmb_meta('hfusa-telethon_campaign_url'); ?>" class="btn btn-primary btn-block btn-campaign-details float-left" target="_blank">View Campaign Details</a>
													</div>
												</div>
												<div class="row no-gutters">
													<div class="col-lg-4 col-md-6 col-sm-12 pr-md-2 pr-lg-2">
														<?php if (!empty($donate_url)) {?>
															<a class="btn btn-primary btn-block" href="<?php echo $donate_url; ?>" target="_blank">Donate Now</a>
														<?php } ?>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12 pr-lg-2">
														<a class="btn btn-primary btn-block" href="<?php echo home_url( 'pledge?event_id='.$telethonEventID ); ?>" target="_blank">Pledge Now</a>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12 pr-md-2 pr-lg-0">
														<a class="btn btn-primary btn-block"  href="<?php echo rwmb_meta('hfusa-telethon_fundraiser_url'); ?>" target="_blank">Become a Fundraiser</a>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12 pr-lg-2">
														<a class="btn btn-primary btn-block"  href="<?php echo home_url('/become-a-sponsor'); ?>" target="_blank">Be a Sponsor</a>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12 pr-md-2 pr-lg-2">
														<a class="btn btn-primary btn-block"  href="<?php echo home_url('/write-your-story'); ?>" target="_blank">Write Your Story</a>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">
														<a class="btn btn-primary btn-block"  href="<?php echo home_url('contact-us'); ?>" target="_blank">Contact Us</a>
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
=            Map Section            =
===================================-->
<section class="t-map-section">
	<div class="th-bottom-large-navgation" >
		<div id="statistics" class="donation-target-status donation-target-status-telethon" style="<?php echo (!empty(get_post_meta( $telethonEventID, 'hfusa-stats_bar_color' ))) ? 'background-color: '.get_post_meta( $telethonEventID, 'hfusa-stats_bar_color', true ) : ''; ?>">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-sm-12 mb-3 mb-md-0 text-left">
						<div class="d-inline-block telethon-hero-boxes-icons">
							<div class="icon-container float-left">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/dts-bullseye.png" alt="" />
							</div>
							<div class="dts-figures float-left">
								<h4>USD<span><?php echo nice_number($campaign_data->goal); ?></span></h4>
								<h6>TARGET</h6>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-12 mb-3 mb-md-0 text-left">
						<div class="d-inline-block telethon-hero-boxes-icons">
							<div class="icon-container float-left">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/dts-donation.png" alt="" />
							</div>
							<div class="dts-figures float-left">
								<h4>USD<span class="donations-collected">
									<?php echo nice_number($campaign_overview->donations_amount); ?></span>
								</h4>
								<h6>DONATIONS</h6>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-12 text-right">
						<div class="d-inline-block telethon-hero-boxes-icons">
							<div class="icon-container float-left">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/dts-pledged.png" alt="" />
							</div>
							<div class="dts-figures float-left">
								<h4>USD<span id=""><?php echo $pledged; ?></span></h4>
								<h6 class="text-left">PLEDGED</h6>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="total-donations" style="<?php echo (!empty(get_post_meta( $telethonEventID, 'hfusa-progress_bar_color' ))) ? 'background-color: '.get_post_meta( $telethonEventID, 'hfusa-progress_bar_color', true ) : ''; ?>">
		<div class="container">
			<div class="figures">
				<?php $totalCollected = $campaign_overview->donations_amount + totalTelethonDonations($classyCampaignID,'Pledge',false); ?>
				<div class="float-left">$<?php echo number_format($totalCollected); ?> Raised</div>
				<div class="float-right text-right">$<?php echo nice_number($campaign_data->goal); ?> Goal</div>
			</div>
			<div class="clearfix"></div>
			<div class="progress-bar">
				<div class="scrolling-bar" style="width: <?php echo (($totalCollected / $campaign_data->goal) * 100).'%'; ?>"></div>
			</div>
		</div>
	</div>
</section>

<!--====  End of Map Section  ====-->

<?php
$images = rwmb_meta( 'hfusa-map_background', array( 'limit' => 1 ) );
$map_background = reset( $images );
?>
<div class="t-map-section map-schedule-section" style="<?php echo (!empty($map_background)) ? 'background-image: url('.$map_background['full_url'].');' : ''; ?>">
	<div class="container">
		<div class="row">
			<?php
			$donationsData = hf_state_donattions($classyCampaignID);
			echo '<div data-states-donations='.$donationsData.' id="state-donations"></div>';
			?>
			<div class="col-lg-3 col-md-12 col-sm-12">
				<div class="t-map-statistics telethon-map-statistics">
					<div class="tms-header">
						<h5>latest donations</h5>
						<h4 class="donations-collected">$ <?php echo nice_number($campaign_overview->donations_amount); ?></h4>
					</div>
					<div class="tms-body content-telethon-donations mCustomScrollbar">
						<?php
						$idLatestDonation = 0;
						global $wpdb;

						$latestDonations = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}hf_classy_donations WHERE donation_type='Donation' AND classy_id=$classyCampaignID AND status='success' ORDER BY id DESC LIMIT 50", ARRAY_A);

						if ( $wpdb->num_rows > 0 ) {
							$i=0;
							foreach ( $latestDonations as $donation ) {

								$donationID = $donation['id'];
								if($i==0){
									$idLatestDonation = $donationID;
								}
								$donor_name=($donation['is_anonymous']) ? 'Anonymous' : $donation['donor_name'];
								$donation_amount=$donation['donation_amount'];
								$donor_state=$donation['donor_state'];
								$donationDate= date('M d, Y | h:i A',strtotime($donation['created_at']));
								?>
								<div class="tms-list-item">
									<?php 
									$donor_state = strtoupper($donor_state);
									$key = array_search ($donor_state, $hf_us_state_abbrevs_names);

									if($key == false){
										$key = $donor_state;
									}

									$flagURLPng=ABSPATH.'/wp-content/themes/hf/assets/images/us-states/'.strtolower($key).'.png';
									$flagURLJpg=ABSPATH.'/wp-content/themes/hf/assets/images/us-states/'.strtolower($key).'.jpg';

									if(file_exists($flagURLPng)){
										$flagFile = '/assets/images/us-states/'.strtolower($key).'.png';
									}else if(file_exists($flagURLJpg)){
										$flagFile = '/assets/images/us-states/'.strtolower($key).'.jpg';
									}else{
										$flagFile = '/assets/images/us-states/dummy-flag.jpg';
									}
									if(!empty($flagFile)){
										?>
										<div class="flag-container">
											<img src="<?php echo $stylesheetDirectory.$flagFile; ?>">
										</div>
									<?php } ?>
									<div class="country-details">
										<h5><?php echo $donor_name; ?></h5>
										<?php if(!empty($donationDate)){ ?>
											<h6>
												<i class="fa fa-clock-o" aria-hidden="true"></i>
												<?php echo $donationDate; ?>
											</h6>
										<?php } ?>
									</div>
									<div class="tms-amount">
										<h6>$<?php echo $donation_amount; ?></h6>
									</div>
								</div>

								<?php
								$i++;
							}
							wp_reset_postdata();
						} else {
							echo '<div class="col-sm-12 sidebar-zero-donations">No donations.</div>';
						}

						?>
					</div>
					<div class="gray-donate-btn" data-latest-donation="<?php echo $idLatestDonation; ?>">
						<a href="<?php echo (!empty($donate_url)) ? $donate_url : home_url('/donate').'?campaign_id='.$campaignID; ?>" target="_blank"><i class="fa fa-heart" aria-hidden="true"></i> DONATE NOW</a>
					</div>							
				</div>
			</div>
			<div class="col-lg-6 col-md-12 col-sm-12">
				<div class="interactive-map-container">

					<div id="container-maps" class="states-map-inner"></div>
				</div>
			</div>
			<div class="col-lg-3 col-md-12 col-sm-12">
				<div class="t-map-statistics telethon-map-statistics">
					<div class="tms-header">
						<h5>latest pledges</h5>
						<h4 class="donations-collected">$ <?php echo $pledged; ?></h4>
					</div>
					<div class="tms-body content-telethon-donations mCustomScrollbar">
						<?php
						$idLatestPledge = 0;
						global $wpdb;

						$latestPledges = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}hf_classy_donations WHERE donation_type='Pledge' AND classy_id=$classyCampaignID AND donation_amount > 0 ORDER BY created_at DESC LIMIT 50", ARRAY_A);

						if ( $wpdb->num_rows > 0 ) {
							$i=0;
							foreach ( $latestPledges as $pledge ) {

								$pledgeID = $pledge['id'];
								if($i==0){
									$idLatestPledge = $pledgeID;
								}
								$donor_name=$pledge['donor_name'];
								$pledge_amount=$pledge['donation_amount'];
								$donor_state=$pledge['donor_state'];
								$pledgeDate= date('M d, Y | h:i A',strtotime($pledge['created_at']));
								?>
								<div class="tms-list-item">
									<?php 
									$donor_state = strtoupper($donor_state);
									$key = array_search ($donor_state, $hf_us_state_abbrevs_names);

									if($key == false){
										$key = $donor_state;
									}

									$flagURLPng=ABSPATH.'/wp-content/themes/hf/assets/images/us-states/'.strtolower($key).'.png';
									$flagURLJpg=ABSPATH.'/wp-content/themes/hf/assets/images/us-states/'.strtolower($key).'.jpg';

									if(file_exists($flagURLPng)){
										$flagFile = '/assets/images/us-states/'.strtolower($key).'.png';
									}else if(file_exists($flagURLJpg)){
										$flagFile = '/assets/images/us-states/'.strtolower($key).'.jpg';
									}else{
										$flagFile = '/assets/images/us-states/dummy-flag.jpg';
									}
									if(!empty($flagFile)){
										?>
										<div class="flag-container">
											<img src="<?php echo $stylesheetDirectory.$flagFile; ?>">
										</div>
									<?php } ?>
									<div class="country-details">
										<h5><?php echo $donor_name; ?></h5>
										<?php if(!empty($pledgeDate)){ ?>
											<h6>
												<i class="fa fa-clock-o" aria-hidden="true"></i>
												<?php echo $pledgeDate; ?>
											</h6>
										<?php } ?>
									</div>
									<div class="tms-amount">
										<h6>$<?php echo $pledge_amount; ?></h6>
									</div>
								</div>

								<?php
								$i++;
							}
							wp_reset_postdata();
						} else {
							echo '<div class="col-sm-12 sidebar-zero-donations">No pledges.</div>';
						}

						?>
					</div>
					<div class="gray-donate-btn" data-latest-donation="<?php echo $idLatestDonation; ?>">
						<a href="<?php echo home_url( 'pledge?event_id='.$telethonEventID ); ?>" target="_blank"><i class="fa fa-heart" aria-hidden="true"></i> PLEDGE NOW</a>
					</div>							
				</div>
			</div>
		</div>
	</div>

	<!--==================================
	=         Fundraisers Section        =
	===================================-->
	<?php
	// if($is_teams || $is_pages) {
	?>
	<section class="t-map-section py-5" id="fundraisers" style="display: none;">
		<?php /*
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
									<img src="<?php echo $fundraising_page->logo_url; ?>" alt="">
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
		*/ ?>
	</section>

	<!--====  End of Fundraisers Section  ====-->
	<div class="container">
		<div class="row">
			<div class="col"><hr></div>
		</div>
	</div>
	<?php // } ?>

	<!--==============================
	=            Schedule            =
	===============================-->

	<section class="schedule-section" id="agenda" style="background-color: transparent;">
		<div class="container">
			<h2 class="heading-st1 text-center"><?php echo rwmb_meta('hfusa-agenda_heading', array(), $telethonEventID); ?></h2>
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
														aria-hidden="true"></i><?php echo $value['start_time']; echo (!empty($value['end_time'])) ? ' - '.$value['end_time'] : ''; ?></span>
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
</div>
<div class="clearfix"></div>

<!--====  End of Schedule  ====-->

<!--============================================
=            sponsors and speakers             =
=============================================-->
<section class="t-sponsors-speakers">
	<div class="container">
		<div class="row rtl-display">
			<div class="col-12 float-left">
				<?php
					if(!empty($event_sponsors) && is_array($event_sponsors)){
				?>
				<div id="sponsors" class="col-sm-12 mb-3">
					<div class="t-sponsors">
						<h1 class="underlined-heading capital"><?php echo rwmb_meta('hfusa-sponsors_heading', array(), $telethonEventID); ?></h1>
						<div class="sponsors-logos-container th-speaker-sponsor-carosel">
							<?php
								foreach ($event_sponsors as $key => $sponsorID) {
									?>
									<div class="th-carousel-item">
										<a href="<?php echo get_the_permalink( $sponsorID ); ?>" target="_blank">
											<?php  echo get_the_post_thumbnail( $sponsorID,'full' ); ?>
										</a>
									</div>
									<?php
								}
							?>
						</div>
					</div>
				</div>
				<?php } ?>
				<?php
					if(!empty($event_speakers) && is_array($event_speakers)){
				?>
				<div id="hosts" class="col-sm-12 col-lg-6 col-md-12 float-left">
					<div class="t-speakers">
						<h1 class="underlined-heading capital"><?php echo rwmb_meta('hfusa-hosts_heading', array(), $telethonEventID); ?></h1>
						<div class="speakers-list-container th-speaker-sponsor-carosel">
							<?php
								foreach ($event_speakers as $key => $speakerID) {
									?>
									<div class="th-carousel-item">
										<a href="<?php echo get_the_permalink( $speakerID ); ?>" class="rounded-link" target="_blank">
											<?php
											$avatar = get_the_post_thumbnail_url($speakerID);
											if( empty($avatar) ) {
												$avatar = $stylesheetDirectory.'/assets/images/default-avatar.png';
											}
											?>
											<img src="<?php echo $avatar; ?>" alt="<?php echo get_the_title($speakerID); ?>" />
										</a>
										<div class="clearfix"></div>
										<h5 class="speaker-name"><a href="<?php echo get_the_permalink( $speakerID ); ?>"><?php echo get_the_title($speakerID); ?></a></h5>
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
				<?php } ?>
				<?php
					if(!empty($event_guests) && is_array($event_guests)){
				?>
				<div id="guests" class="col-sm-12 col-lg-6 col-md-12 float-left">
					<div class="t-speakers">
						<h1 class="underlined-heading capital"><?php echo rwmb_meta('hfusa-guests_heading', array(), $telethonEventID); ?></h1>
						<div class="speakers-list-container th-speaker-sponsor-carosel">
							<?php
								foreach ($event_guests as $key => $speakerID) {
									?>
									<div class="th-carousel-item">
										<a href="<?php echo get_the_permalink( $speakerID ); ?>" class="rounded-link" target="_blank">
											<?php
											$avatar = get_the_post_thumbnail_url($speakerID);
											if( empty($avatar) ) {
												$avatar = $stylesheetDirectory.'/assets/images/default-avatar.png';
											}
											?>
											<img src="<?php echo $avatar; ?>" alt="<?php echo get_the_title($speakerID); ?>" />
										</a>
										<div class="clearfix"></div>
										<h5 class="speaker-name"><a href="<?php echo get_the_permalink( $speakerID ); ?>"><?php echo get_the_title($speakerID); ?></a></h5>
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
				<?php } ?>
			</div>
		</div>
	</div>
</section>
<div class="clearfix"></div>

<!--====  End of sponsors and speakers   ====-->

<!--============================================
=                 feed section                 =
=============================================-->

<?php
$images = rwmb_meta( 'hfusa-feed_background', array( 'limit' => 1 ) );
$feed_background = reset( $images );
?>
<div class="feed-section" style="<?php echo (!empty($feed_background)) ? 'background-image: url('.$feed_background['full_url'].');' : ''; ?>">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="container">
			<div class="row">
				<div class="col th-content-bottom">
					<h1 class="underlined-heading capital"><?php echo rwmb_meta('hfusa-twitter_feed_heading', array(), $telethonEventID); ?></h1>
					<div class="th-content">
						<div id="th-fb-feeds" class="hf-social-feeds col-sm-12  hf-social-left d-none">

							<div class="hf-cssload-thecube">
								<div class="hf-cssload-cube cssload-c1"></div>
								<div class="hf-cssload-cube cssload-c2"></div>
								<div class="hf-cssload-cube cssload-c4"></div>
								<div class="hf-cssload-cube cssload-c3"></div>
							</div>

						</div>
						<div id="th-twitter-feeds"  class="hf-social-feeds col-sm-12 hf-social-right">

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
</div>

<!--====        End of feed section      ====-->

<?php
if(!empty($telethon_gallery) && is_array($telethon_gallery)){
	?>

<!--=====================================
=            gallery section            =
======================================-->
<section class="t-light-box-gallery" id="gallery">
	<div class="pd-light-box">
		<ul>
			<?php
			foreach ($telethon_gallery as $key => $picID) {
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

<section class="t-history-section" id="history">
	<div class="container">
		<div class="row rtl-display">
			<div class="col-12 float-left">
				<?php  
				echo get_post_meta( $telethonEventID, 'hfusa-telethon_history', true);
				?>
			</div>
		</div>
	</div>
</section>



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

<!--============================
=            Footer            =
=============================-->
<?php /*
<section class="telethon-footer">
	<div class="tfooter-logo">
		<?php 
		$images = rwmb_meta( 'hfusa-telethon_footer_logo', array( 'limit' => 1 ) );
		$telethon_footer_logo = reset( $images );
		?>
		<a href="<?php echo get_the_permalink(); ?>"><img alt="Telethon" src="<?php echo $telethon_footer_logo['full_url'] ?>" /></a>
	</div>
	<div class="tf-social-icons">
		<ul>
			<?php
			$telethon_link_pinterest=get_post_meta( $telethonEventID, 'hfusa-telethon_link_pinterest', true );
			$telethon_link_fb=get_post_meta( $telethonEventID, 'hfusa-telethon_link_fb', true );
			$telethon_link_gplus=get_post_meta( $telethonEventID, 'hfusa-telethon_link_gplus', true );
			$telethon_link_twitter=get_post_meta( $telethonEventID, 'hfusa-telethon_link_twitter', true );

			if($telethon_link_pinterest){
				echo '<li><a target="_blank" href="'.$telethon_link_pinterest.'"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>';
			}
			if($telethon_link_fb){
				echo '<li><a target="_blank" href="'.$telethon_link_fb.'"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>';
			}
			if($telethon_link_gplus){
				echo '<li><a target="_blank" href="'.$telethon_link_gplus.'"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>';
			}
			if($telethon_link_twitter){
				echo '<li><a target="_blank" href="'.$telethon_link_twitter.'"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>';
			}
			?>
		</ul>
	</div>
	<p class="text-paragraph text-center">Copyright <?php echo date('Y'); ?> Humanity First USA - All rights reserved. </p>
</section>
*/ ?>

<!--====  End of Footer  ====-->

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
<?php
$arrayCodes = array();
$i=0;
foreach ($hf_us_state_abbrevs_names as $key => $value) {
	$value = strtolower($value);
	$value = str_replace(" ", "-", $value);
	$arrayCodes[$i]["code"] = strtolower($key);
	$arrayCodes[$i]["Donation"] = "--";
	$arrayCodes[$i]["Pledge"] = "--";
	$arrayCodes[$i]["value"] = 0;
	$arrayCodes[$i]["name"] = $value;
	$i++;
}
?>
<script type="text/javascript">
	
	var map_data = JSON.parse('<?php echo json_encode($arrayCodes); ?>');

	jQuery(function() {

		var s_data = jQuery('#state-donations').data('states-donations');
		jQuery.each(map_data, function () {
			this.code = this.code.toUpperCase();
			if(s_data[this.name] && s_data[this.name]["Donation"]){    		
				this.Donation = "$" + parseFloat(Math.round(s_data[this.name]["Donation"] * 100) / 100).toFixed(2);
				this.value = parseFloat(Math.round(s_data[this.name]["Donation"] * 100) / 100).toFixed(2);
			}
			if(s_data[this.name] && s_data[this.name]["Pledge"]){    		
				this.Pledge = "$" + parseFloat(Math.round(s_data[this.name]["Pledge"] * 100) / 100).toFixed(2);
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
				title: {
                    text: 'Donations',
                    style: {
                        color: ( // theme
                            Highcharts.defaultOptions &&
                            Highcharts.defaultOptions.legend &&
                            Highcharts.defaultOptions.legend.title &&
                            Highcharts.defaultOptions.legend.title.style &&
                            Highcharts.defaultOptions.legend.title.style.color
                        ) || 'black'
                    }
                },
                align: 'center',
                verticalAlign: 'bottom',
                floating: false,
                padding: 12,
                itemMarginBottom: 5,
                layout: 'horizontal',
                alignColumns: true,
                valueDecimals: 0,
                backgroundColor: ( // theme
                    Highcharts.defaultOptions &&
                    Highcharts.defaultOptions.legend &&
                    Highcharts.defaultOptions.legend.backgroundColor
                ) || 'rgba(255, 255, 255, 0.85)',
                symbolRadius: 0,
                symbolHeight: 14,
                shadow: {"color": "rgba(0, 0, 0, 0.2)", "offsetX": "0", "offsetY": "0", "width": "10"},
                symbolRadius: 7
			},
			responsive: {
				rules: [{
					condition: {
						maxWidth: 500,
					},
					chartOptions: {
						legend: {
							align: 'center',
							layout: 'horizontal',
							verticalAlign: 'bottom',
						}
					}
				}]
			},
			mapNavigation: {
				enabled: true
			},
			colors: ['rgba(0, 105, 180, 0.05)', 'rgba(0, 105, 180, 0.2)', 'rgba(0, 105, 180, 0.4)', 'rgba(0, 105, 180, 0.5)', 'rgba(0, 105, 180, 0.6)', 'rgba(0, 105, 180, 0.8)', 'rgba(0, 105, 180, 1)'],
			colorAxis: {
                dataClasses: [{
                    to: 0,
                    name: 'None'
                }, {
                    from: 1,
                    to: 1000,
                    name: '1 - 1000'
                }, {
                    from: 1001,
                    to: 2000,
                    name: '1001 - 2000'
                }, {
                    from: 2001,
                    to: 5000,
                    name: '2001 - 5000'
                }, {
                    from: 5001,
                    to: 10000,
                    name: '5001 - 10000'
                }, {
                    from: 10001,
                    to: 15000,
                    name: '10001 - 15000'
                }, {
                    from: 15000,
                    name: '15000 or more'
                }]
            },
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

		function getWidth() {
			return Math.max(
				document.body.scrollWidth,
				document.documentElement.scrollWidth,
				document.body.offsetWidth,
				document.documentElement.offsetWidth,
				document.documentElement.clientWidth
				);
		}

		/*code for stickey youtube video frame*/
		var $window = jQuery( window );
		var $featuredMedia = jQuery("#th-featured-media" );
		var $featuredVideo = jQuery("#th-featured-video" );
		var player;
		var top = $featuredMedia.offset().top;
		var offset = Math.floor( top );

		$window
		.on( "resize", function() {
			top = $featuredMedia.offset().top;
			offset = Math.floor( top );
			if(getWidth() > 768) {
				if($featuredVideo.hasClass("is-sticky")){
					var transformleft = jQuery(".hero-section-1").offset().left;
					$featuredVideo.css('transform', 'translateX(-'+(transformleft-10)+'px)');
				}else{
					$featuredVideo.css('transform', 'translateX(0)');
				}
			}
		} )

		.on( "scroll", function() {
			if(getWidth() > 768) {
				$featuredVideo.toggleClass( "is-sticky", $window.scrollTop() > offset );
				if($featuredVideo.hasClass("is-sticky")){
					var transformleft = jQuery(".hero-section-1").offset().left;
					$featuredVideo.css('transform', 'translateX(-'+(transformleft-10)+'px)');
				}else{
					$featuredVideo.css('transform', 'translateX(0)');
				}
			}
		} );



		jQuery('.t-video-comments-box').on('scroll', function() {

			if(jQuery(this).scrollTop() + jQuery(this).innerHeight() >= jQuery(this)[0].scrollHeight) {
				loadYoutubefeeds();
			}
		})



	});

	// loadFBfeeds(false);
	loadTwitterfeeds(false);

	// function loadFBfeeds(scroll_load){

	// 	var after_id = jQuery('.facebook-after-id').last().data('feed-after-id');

	// 	if(scroll_load==true){
	// 		jQuery(".hf-social-left .hf-cssload-thecube").show();
	// 		var box_height = jQuery('#th-fb-feeds .mCSB_container').height();
	// 		box_height  = box_height - 25 +'px';
	// 		jQuery("#th-fb-feeds .hf-cssload-thecube").css("top", box_height);
	// 	}

	// 	jQuery.ajax({
	// 		url: '<?php echo $stylesheetDirectory; ?>/telethon-social-feeds.php',
	// 		method: "POST",
	// 		dataType: "html",
	// 		data:  "load_th_feeds=fb_feeds&after_id="+after_id+"&post_id=<?php echo $telethonEventID;  ?>"
	// 	}).success(function (data) {
	// 		if(data){
	// 			jQuery("#th-fb-feeds").mCustomScrollbar({
	// 				callbacks:{
	// 					onTotalScroll:function(){
	// 						loadFBfeeds(true);
	// 					}
	// 				}
	// 			});

	// 			jQuery(".hf-social-left .mCSB_container").append(data);
	// 			jQuery("#th-fb-feeds").mCustomScrollbar("update");
	// 		}

	// 	}).always(function() {
	// 		jQuery(".hf-social-left .hf-cssload-thecube").hide();
	// 	});	
	// }

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
			data:  "load_th_feeds=twitter_feeds&max_id="+max_id+"&post_id=<?php echo $telethonEventID;  ?>"
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
			data:  "load_th_feeds=youtube_feeds&token="+token+"&post_id=<?php echo $telethonEventID;  ?>"
		}).success(function (data) {
			if(data){
				jQuery(".t-video-comments-box-inner").append(data);
			}
		}).always(function() {
			jQuery(".t-video-comments-box .hf-cssload-thecube").hide();
		});
	}
</script>
<script>
	// if(typeof(EventSource) !== "undefined") {
	// 	<?php
	// 	$path = $stylesheetDirectory.'/telethon-updates.php';
	// 	?>
	// 	var source = new EventSource("<?php // echo $path; ?>");
	// 	source.onmessage = function(event) {
	// 		var latestDonationPage = jQuery('.gray-donate-btn').attr('data-latest-donation');			
	// 		if(event.data > latestDonationPage){
	// 			console.log('new donation added');
	// 			jQuery.ajax({
	// 				url: ajax_object.ajaxurl,
	// 				method: "POST",
	// 				dataType: "json",
	// 				data:  "action=hf_load_telethon_donations&telethon_campaign=<?php echo $campaignID;?>&latest_donation="+latestDonationPage
	// 			}).success(function (data) {
	// 				if(data && data.latest_donations){
	// 					var donation_collected_prev = jQuery(".dts-figures .donations-collected").text();
	// 					var data_donations_amount = data.total_donations_amount;
	// 					var total_doantions = 0;
	// 					var donation_amount_prefix = 0;
	// 					var donation_amount_postfix = '';

	// 					if (data_donations_amount.indexOf('span') > -1) {
	// 						data_donations_amount = data_donations_amount.split(" ");
	// 						donation_amount_prefix = data_donations_amount[0];
	// 						donation_amount_postfix = data_donations_amount[1];
	// 						if(donation_amount_postfix = '<span>K</span>'){
	// 							total_doantions = donation_amount_prefix*1000;
	// 						}else if(donation_amount_postfix = '<span>M</span>'){
	// 							total_doantions = donation_amount_prefix*1000000;
	// 						}else if(donation_amount_postfix = '<span>M</span>'){
	// 							total_doantions = donation_amount_prefix*1000000;
	// 						}else if(donation_amount_postfix = '<span>B</span>'){
	// 							total_doantions = donation_amount_prefix*1000000000;
	// 						}
	// 					}else{
	// 						total_doantions = data_donations_amount;
	// 						donation_amount_prefix = data_donations_amount;
	// 					}

	// 					/* animate the counter for the donations collected */
	// 					jQuery('.dts-figures .donations-collected').prop('Counter',donation_collected_prev).animate({
	// 						Counter: donation_amount_prefix
	// 					}, {
	// 						duration: 3000,
	// 						easing: 'swing',
	// 						step: function (now) {
	// 							if(total_doantions < 1000 ){
	// 								jQuery('.dts-figures .donations-collected').html(Math.ceil(now));
	// 							}else{
	// 								jQuery('.dts-figures .donations-collected').html(donation_amount_prefix+' '+donation_amount_postfix);
	// 							}
	// 						}
	// 					});

	// 					jQuery(".tms-header h4").html( '$ '+donation_amount_prefix+' '+donation_amount_postfix );

	// 					/* insert and animate new donation record in the latest donations sidebar*/
	// 					jQuery(data.latest_donations).clone().hide().prependTo('.telethon-map-statistics .mCSB_container').slideDown();

	// 					if(jQuery(data.latest_donations).length > 0){
	// 						jQuery('.sidebar-zero-donations').hide();
	// 					}

	// 					jQuery('.gray-donate-btn').attr('data-latest-donation', data.latest_donation_id); 
	// 					var obj = JSON.parse(data.data_donation); 
	// 					jQuery('#state-donations').data('states-donations',obj);

	// 					/* update the map states data */
	// 					jQuery.each(map_data, function () {
	// 						this.code = this.code.toUpperCase();
	// 						if(obj[this.name] && obj[this.name]["Donation"]){    		
	// 							this.Donation = "$" + obj[this.name]["Donation"];
	// 						}
	// 						if(obj[this.name] && obj[this.name]["Pledge"]){    		
	// 							this.Pledge = "$" + obj[this.name]["Pledge"];
	// 						}
	// 					});

	// 					var map_data_new = JSON.stringify(map_data);
	// 					map_data_new = JSON.parse(map_data_new);
	// 					jQuery("#container-maps").highcharts().series[0].update({
	// 						data: map_data_new
	// 					});
	// 				}else if(data && data.latest_donation_id){
	// 					jQuery('.gray-donate-btn').attr('data-latest-donation', data.latest_donation_id);
	// 				}
	// 			});
	// 		}
	// 	}
	// } 
</script>
