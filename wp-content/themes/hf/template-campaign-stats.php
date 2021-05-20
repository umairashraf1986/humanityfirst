<?php wp_head(); use Roots\Sage\Titles; ?>
<?php
/**
Template Name: Campaign Stats
*/
?>
<?php
$campaignID = 15286;

$stylesheetDirectory = get_stylesheet_directory_uri();
$classyCampaignID = get_post_meta( $campaignID, 'hfusa-classy_campaign_id',true );

$pledged = totalTelethonDonations($classyCampaignID,'Pledge',false);

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

$totalCollected = $campaign_overview->total_gross_amount + totalTelethonDonations($classyCampaignID,'Pledge',false);

global $wpdb;$is_teams = false;
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
<!--Donation Stats Box Section Start-->
<section id="stats" class="stats-section features-area item-full text-center cell-items default-padding mb-5">
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
        <?php $states_heading = rwmb_meta('hfusa-top_five_states_heading', '', $campaignID); ?>
        <h1 class="underlined-heading capital"><?php echo (!empty($states_heading)) ? $states_heading : 'Top 5 States'; ?></h1>
        <div id="chart"></div>
      </div>
      <div class="col-lg-6 col-md-12">
        <?php $donations_heading = rwmb_meta('hfusa-donations_collected_heading', '', $campaignID); ?>
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

<?php
if($is_teams || $is_pages) {
?>
<!--==================================
=         Fundraisers Section        =
===================================-->
<section class="t-map-section py-5" id="fundraisers">
  <div class="th-bottom-large-navgation" >
    <div class="container">
      <div class="row">
        <?php if($is_teams) { ?>
        <div class="col-lg-6 col-md-12 col-sm-12 mb-md-3">
          <h1 class="underlined-heading capital"><?php echo rwmb_meta('hfusa-top_teams_heading', '', $campaignID); ?></h1>
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
          <h1 class="underlined-heading capital"><?php echo rwmb_meta('hfusa-top_teams_heading', '', $campaignID); ?></h1>
          <div class="th-content pl-0 mt-4 mCustomScrollbar" style="max-height: 500px;">
            <p>No teams to show.</p>
          </div>
        </div>
        <?php } ?>
        <?php if($is_pages) { ?>
        <div class="col-lg-6 col-md-12 col-sm-12">
          <h1 class="underlined-heading capital"><?php echo rwmb_meta('hfusa-top_individuals_heading', '', $campaignID); ?></h1>
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
          <h1 class="underlined-heading capital"><?php echo rwmb_meta('hfusa-top_individuals_heading', '', $campaignID); ?></h1>
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
<?php } ?>

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
<?php wp_footer();?>