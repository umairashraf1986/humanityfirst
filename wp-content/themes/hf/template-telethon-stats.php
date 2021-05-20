<?php wp_head(); use Roots\Sage\Titles; ?>
<?php
/**
Template Name: Telethon Stats
*/
?>
<style type="text/css">
	.th-bottom-large-navgation .donation-target-status {
		padding: 15px;
	}
	.total-donations {
		padding: 10px 0 30px;
	}
	.featured-campaigns-ticker {
		position: static;
	}
	.featured-campaigns-ticker .featured-campaign-wrapper {
		line-height: 28px;
		padding: 20px 0;
		height: 70px;
	}
	.featured-campaigns-ticker .featured-campaign-wrapper .featured-campaign-slider a,
	.featured-campaign-slider b {
	    font-size: 28px;
	}
</style>
<?php
$telethonEventID = 15288;
$event_sponsors=get_post_meta( $telethonEventID, 'hfusa-event_sponsors' );
$event_speakers=get_post_meta( $telethonEventID, 'hfusa-event_speakers' );
$event_guests=get_post_meta( $telethonEventID, 'hfusa-event_guests' );

$campaignID	= get_post_meta( $telethonEventID, 'hfusa-event_campaigns',true );
$classyCampaignID = get_post_meta( $campaignID, 'hfusa-classy_campaign_id',true );

$pledged = totalTelethonDonations($classyCampaignID,'Pledge',true);
$donated = totalTelethonDonations($classyCampaignID,'Donation',true);

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
<div class="template-telethon-stats">
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
$args = array(
  'post_type' => array('hf_campaigns', 'hf_events', 'hf_alerts'),
  'tax_query' => array(
    'relation' => 'OR',
    array(
      'taxonomy' => 'campaign_category',
      'field'    => 'slug',
      'terms'    => 'featured',
    ),
    array(
      'taxonomy' => 'events_category',
      'field'    => 'slug',
      'terms'    => 'featured',
    ),
    array(
      'taxonomy' => 'alerts_category',
      'field'    => 'slug',
      'terms'    => 'featured',
    ),
  ),
  'posts_per_page' => -1
);
$campaigns_loop = new WP_Query( $args );
$GLOBALS['campaigns'] = $campaigns_loop->have_posts();
if($campaigns_loop->have_posts()) {
  ?>
  <!-- Featured Campaigns -->
  <div class="featured-campaigns-ticker">
    <div class="row no-gutters">
      <div class="col">
        <div class="featured-campaign-wrapper">
          <div class="featured-campaign-slider">
            <?php
            $events = array();
            $campaigns = array();
            $alerts = array();
            while($campaigns_loop->have_posts()) :
              $campaigns_loop->the_post();
              if(get_post_type() == 'hf_events') {
                $events[] = "<a href=".get_the_permalink()." class=\"featured-campaign-link\">".get_the_title()."</a>";
              }
              if(get_post_type() == 'hf_alerts') {
                $alerts[] = "<a href=".get_the_permalink()." class=\"featured-campaign-link\">".get_the_title()."</a>";
              }
              if(get_post_type() == 'hf_campaigns') {
                $campaigns[] = "<a href=".get_the_permalink()." class=\"featured-campaign-link\">".get_the_title()."</a>";
              }
              ?>
            <?php endwhile; ?>
            <?php
            if($alerts) {
              $alertStr = '<b>Alerts:</b> ';
              foreach ($alerts as $alert) {
                $alertStr .= $alert." ";
              }
              echo $alertStr;
            }
            if($events) {
              $eventStr = '<b>Events:</b> ';
              foreach ($events as $event) {
                $eventStr .= $event." ";
              }
              echo $eventStr;
            }
            if($campaigns) {
              $campaignStr = '<b>Campaigns:</b> ';
              foreach ($campaigns as $campaign) {
                $campaignStr .= $campaign." ";
              }
              echo $campaignStr;
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
</div>
<?php wp_footer();?>