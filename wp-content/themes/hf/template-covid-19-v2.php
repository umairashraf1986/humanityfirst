<?php use Roots\Sage\Titles; ?>
<?php
/**
Template Name: COVID-19 V2
*/

$stylesheetDirectory = get_stylesheet_directory_uri();
global $wpdb;
?>
<style type="text/css">
	.event-detail-page {
		background-image: none;
	}
	.interactive-map-container {
		position: relative;
	}
	.interactive-map-container .disclaimer {
		font-size: 12px;
		font-style: italic;
		position: absolute;
		right: 1px;
		bottom: auto;
		width: 100%;
		text-align: center;
	}
	.interactive-map-container .disclaimer p {
		margin: 0;
	}
	.action-buttons-wrapper {
		position: fixed;
		z-index: 9999;
		background: white;
		border: 1px solid #0069b4;
		padding: 20px;
		border-top-right-radius: 4px;
		border-bottom-right-radius: 4px;
		top: 50%;
		left: 0;
		transform: translateX(-100%) translateY(-50%);
		transition: transform 0.3s ease-in;
	}
	.action-buttons-wrapper.open {
		transform: translateY(-50%);
	}
	.action-buttons-wrapper a.buttons-trigger {
		position: absolute;
		right: -104px;
		top: 50%;
		transform: translateY(-50%) rotate(-90deg);
		background: #000;
		color: white;
		padding: 10px 20px;
		border-bottom-right-radius: 10px;
		border-bottom-left-radius: 10px;
	}
	.left-action-buttons a.btn.btn-primary {
		padding: 0.75rem;
	}
</style>

<!--===================================
=            Title Section            =
====================================-->

<section class="inner-page-title-section event-detail-page" <?php echo hf_header_bg_img(); ?>>

	<div class="iptc-content">
		<h1><?= Titles\title(); ?></h1>
		<?php bootstrap_breadcrumb(); ?>
	</div>

	<div class="overlay"></div>
</section>
<div class="clearfix"></div>

<!--====  End of Title Section  ====-->

<?php
$recordsData = hf_covid_19_state_records();
echo '<div data-states-records='.$recordsData.' id="state-records"></div>';
?>

<?php
$top_buttons = rwmb_meta('top_buttons_fields');
if(!empty($top_buttons)) {
	?>

<!--=================================
=            Top Buttons            =
==================================-->

<section class="page-top-buttons">
	<div class="buttons-wrapper">
		<?php foreach($top_buttons as $top_button) { ?>
			<a href="<?php echo $top_button['hfusa-top_button_url'] ?>" class="btn" <?php echo ($top_button['hfusa-top_button_target']) ? "target='_blank'" : ""; ?>><?php echo $top_button['hfusa-top_button_label'] ?></a>
		<?php } ?>
	</div>
</section>

<!--====  End of Top Buttons  ====-->

<?php } ?>

<!--===================================
=            Links Buttons            =
====================================-->

<?php
$left_buttons = rwmb_meta('left_buttons_fields');
if(!empty($left_buttons)) {
	?>
	<div class="action-buttons-wrapper">
		<?php
		$buttons_heading = rwmb_meta('hfusa-left_buttons_heading');
		?>
		<a href="#!" class="buttons-trigger"><?php echo (!empty($buttons_heading)) ? $buttons_heading : 'Links to CDC'; ?></a>
		<div class="left-action-buttons">
			<?php foreach ($left_buttons as $left_button) { ?>
				<a href="<?php echo $left_button['hfusa-left_button_url'] ?>" class="btn btn-primary btn-block" <?php echo ($left_button['hfusa-left_button_target']) ? "target='_blank'" : ""; ?>><?php echo $left_button['hfusa-left_button_label'] ?></a>
			<?php } ?>
		</div>
	</div>
<?php } ?>

<!--====  End of Links Buttons  ====-->

<?php
$summary_heading = rwmb_meta('hfusa-summary_heading');
if(!empty($summary_heading)) {
	?>

	<section class="summary py-0 mt-5">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<h1 class="underlined-heading capital"><?php echo $summary_heading; ?></h1>
				</div>
			</div>
		</div>
	</section>

<?php } ?>

<!--========================================
=            Engagement Summary            =
=========================================-->
<?php
$slider_shortcode = rwmb_meta('hfusa-slider_shortcode');
?>
<section class="summary">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 <?php echo (!empty($slider_shortcode)) ? 'col-xl-7' : ''; ?>">
				<?php
				$bottom_actions = rwmb_meta('bottom_actions');
				if(!empty($bottom_actions)) {
					?>
					<div class="action-wrapper h-100">
						<div class="row align-items-center h-100 justify-content-center">
							<?php foreach ($bottom_actions as $bottom_action) { ?>
								<div class="col-12 col-md-4 col-sm-6 mb-4">
									<div class="action-item">
										<a href="<?php echo $bottom_action['hfusa-action_url'] ?>" style="background: <?php echo $bottom_action['hfusa-action_color']; ?>" <?php echo ($bottom_action['hfusa-action_target']) ? "target='_blank'" : ""; ?>>
											<?php if(!empty(wp_get_attachment_image_src(reset($bottom_action['hfusa-action_icon']))[0])) { ?>
											<img src="<?php echo wp_get_attachment_image_src(reset($bottom_action['hfusa-action_icon']))[0]; ?>">
											<?php } ?>
											<span><?php echo $bottom_action['hfusa-action_label'] ?></span>
										</a>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			</div>
			<?php if(!empty($slider_shortcode)) { ?>
				<div class="col-12 col-xl-5">
					<?php echo do_shortcode($slider_shortcode); ?>
					<?php
					$below_actions = rwmb_meta('below_slider_actions');
					if(!empty($below_actions)) {
						?>
						<div class="action-wrapper mt-5 pt-4">
							<div class="row align-items-center h-100 justify-content-center">
								<?php foreach ($below_actions as $below_action) { ?>
									<div class="col-12 col-md-4 col-sm-6 mb-4">
										<div class="action-item">
											<a href="<?php echo $below_action['hfusa-below_action_url'] ?>" style="background: <?php echo $below_action['hfusa-below_action_color']; ?>" <?php echo ($below_action['hfusa-below_action_target']) ? "target='_blank'" : ""; ?>>
												<?php if(!empty(wp_get_attachment_image_src(reset($below_action['hfusa-below_action_icon']))[0])) { ?>
												<img src="<?php echo wp_get_attachment_image_src(reset($below_action['hfusa-below_action_icon']))[0]; ?>">
												<?php } ?>
												<span><?php echo $below_action['hfusa-below_action_label'] ?></span>
											</a>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
</section>

<!--====  End of Engagement Summary  ====-->

<!--=================================
=            Map Section            =
==================================-->

<section class="covid-map-section pt-4">
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<h1 class="underlined-heading capital mb-5"><?php echo rwmb_meta('hfusa-situation_heading'); ?></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 mb-4 mb-xl-0">
				<?php
				$stats_covid = rwmb_meta('stats_covid');
				if(!empty($stats_covid)) {

					$results = $wpdb->get_results("SELECT SUM(totalTestResults) as total, SUM(positive) as positive, SUM(negative) as negative, SUM(death) as death FROM {$wpdb->prefix}hf_covid_19_records", ARRAY_A);
					$results = reset($results);
					?>
					<div class="right-stats-wrapper h-100">
						<div class="row justify-content-center">
							<?php for($i=0; $i<count($stats_covid); $i++) { ?>
								<div class="col-12">
									<div class="right-stat" style="background: <?php echo $stats_covid[$i]['hfusa-stat_color']; ?>">
										<!-- <h4><?php echo $stats_covid[$i]['hfusa-stat_label']; ?></h4> -->
										<?php
										switch ($i) {
											case 0:
											$figure = number_format($results['total']);
											break;
											case 1:
											$figure = number_format($results['positive']);
											break;
											case 2:
											$figure = number_format($results['negative']);
											break;
											case 3:
											$figure = number_format($results['death']);
											break;

											default:
											$figure = '';
											break;
										}
										?>
										<div class="figure"><?php echo $figure; ?></div>
										<div class="caption"><?php echo $stats_covid[$i]['hfusa-stat_label']; ?></div>
									</div>
								</div>
							<?php } ?>
						</div>
						<?php
						$disclaimer = rwmb_meta('hfusa-update_disclaimer');
						if(!empty($disclaimer)) {
							?>
							<div class="disclaimer"><?php echo $disclaimer; ?></div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
			<div class="col-12 col-lg-9 col-md-8 col-xl-6 m-xl-0 mb-4">
				<div class="interactive-map-container">
					<div id="container-maps" class="states-map-inner"></div>
					<?php
					$disclaimer = rwmb_meta('hfusa-map_disclaimer');
					if(!empty($disclaimer)) {
						$lastUpdated = $wpdb->get_var("SELECT start_time FROM {$wpdb->prefix}hf_covid_19_cron_log ORDER BY id DESC LIMIT 1");
						$text = '';
						if(!empty($lastUpdated)) {
							$text = "<p>Website data was last updated at: ".date('m/d/Y H:i:s', strtotime($lastUpdated))." GMT</p>";
						}	
					?>
						<div class="disclaimer"><?php echo $disclaimer.$text; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="col-12 col-xl-4 m-xl-0 mb-4 mt-5">
				<!-- <div id="chart"></div> -->
				<?php
				$top_states = $wpdb->get_results("SELECT `state`, `positive`, `death`, `hospitalized` FROM {$wpdb->prefix}hf_covid_19_records GROUP BY `state` ORDER BY positive DESC LIMIT 10", ARRAY_A);
				?>
				<div class="table-responsive">
					<table class="table table-sm">
						<caption>Top 10 most affected States</caption>
						<thead>
							<tr>
								<th>State</th>
								<th class="text-center">Positive</th>
								<th class="text-center">Deaths</th>
								<th class="text-center">Hospitalized</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($top_states as $top_state) {
							?>
								<tr>
									<td><?php echo $top_state['state']; ?></td>
									<td class="text-center"><?php echo number_format($top_state['positive']); ?></td>
									<td class="text-center"><?php echo number_format($top_state['death']); ?></td>
									<td class="text-center"><?php echo (is_null($top_state['hospitalized'])) ? '-' : number_format($top_state['hospitalized']); ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<!--====  End of Map Section  ====-->

<?php
$top_states_active = $wpdb->get_results("SELECT `state`, `positive` FROM {$wpdb->prefix}hf_covid_19_records GROUP BY `state` ORDER BY positive DESC LIMIT 10", ARRAY_A);
$top_states_deaths = $wpdb->get_results("SELECT `state`, `death` as deaths FROM {$wpdb->prefix}hf_covid_19_records GROUP BY `state` ORDER BY deaths DESC LIMIT 10", ARRAY_A);

$states_active = array();
$active_values = array();
$state_deaths = array();
$death_values = array();
foreach ($top_states_active as $top_state) {
	$states_active[] = $top_state['state'];
	$active_values[] = $top_state['positive'];
}
foreach ($top_states_deaths as $top_state) {
	$state_deaths[] = $top_state['state'];
	$death_values[] = $top_state['deaths'];
}
?>

<?php
$arrayCodes = array();
$i=0;
foreach ($hf_us_state_abbrevs_names as $key => $value) {
	$value = strtolower($value);
	$value = str_replace(" ", "-", $value);
	$arrayCodes[$i]["code"] = strtolower($key);
	$arrayCodes[$i]["total"] = "--";
	$arrayCodes[$i]["positive"] = "--";
	$arrayCodes[$i]["value"] = 0;
	$arrayCodes[$i]["negative"] = "--";
	$arrayCodes[$i]["deaths"] = "--";
	$arrayCodes[$i]["hospitalized"] = "--";
	$arrayCodes[$i]["lastUpdateEt"] = "--";
	$arrayCodes[$i]["name"] = $value;
	$i++;
}
?>

<script type="text/javascript">

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

	var map_data = JSON.parse('<?php echo json_encode($arrayCodes); ?>');

	jQuery(document).ready(function() {

		var stateCodes = <?php echo json_encode($states_active); ?>;
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
					return numberWithCommas(val)
				},
				offsetX: 110,
				style: {
					colors: ['#333']
				}
			},
			series: [{
				name: 'Positive',
				data: <?php echo json_encode($active_values); ?>
			},
			{
				name: 'Deaths',
				data: <?php echo json_encode($death_values); ?>
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
						return numberWithCommas(value);
					}
				},
				title: {
					text: 'Number of cases in top 10 states',
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
						return numberWithCommas(value)
					},
				},
			},
		}

		var chart = new ApexCharts(document.querySelector("#chart"), options);

		chart.render();

		var s_data = jQuery('#state-records').data('states-records');
		jQuery.each(map_data, function () {
			this.code = this.code.toUpperCase();
			if(s_data[this.name] && s_data[this.name]["total"]){    		
				this.total = s_data[this.name]["total"];
			}
			if(s_data[this.name] && s_data[this.name]["positive"]){
				this.positive = s_data[this.name]["positive"];
				this.value = s_data[this.name]["positive"];
			}
			if(s_data[this.name] && s_data[this.name]["negative"]){ 		
				this.negative = s_data[this.name]["negative"];
			}
			if(s_data[this.name] && s_data[this.name]["deaths"]){	
				this.deaths = s_data[this.name]["deaths"];
			}
			if(s_data[this.name] && s_data[this.name]["hospitalized"]){	
				this.hospitalized = s_data[this.name]["hospitalized"];
			}
			if(s_data[this.name] && s_data[this.name]["lastUpdateEt"]){
				var str = s_data[this.name]["lastUpdateEt"];
				this.lastUpdateEt = str.replace("-", " ");
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
				enabled:false
			},
			legend: {
				title: {
                    text: 'Positive Cases',
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
                align: 'right',
                verticalAlign: 'top',
                floating: false,
                padding: 12,
                itemMarginBottom: 5,
                layout: 'vertical',
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
                    to: 50,
                    name: '1 - 50'
                }, {
                    from: 51,
                    to: 100,
                    name: '51 - 100'
                }, {
                    from: 101,
                    to: 500,
                    name: '101 - 500'
                }, {
                    from: 501,
                    to: 1000,
                    name: '501 - 1000'
                }, {
                    from: 1001,
                    to: 5000,
                    name: '1001 - 5000'
                }, {
                    from: 5000,
                    name: '5000 or more'
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
				name: 'Stats',
				tooltip: {
					headerFormat: '',
					pointFormat: '<b>{point.name}</b><br/><br/>Total: {point.total} <br/>Positive: {point.positive}  <br/>Negative: {point.negative} <br/>Deaths: {point.deaths} <br/>Hospitalized: {point.hospitalized} <br/>Last Updated: {point.lastUpdateEt}'
				}
			}]
		});

		// loadTwitterfeeds(false);

		jQuery('.buttons-trigger').on('click', function(e) {
			e.stopPropagation();
			jQuery(this).parent().toggleClass('open');

			jQuery('body').on('click', function() {
				jQuery('.action-buttons-wrapper').removeClass('open');
			});
		});
	});

	function loadTwitterfeeds(scroll_load){

		var max_id_param = '';
		if(jQuery('.twitter-max-id').length) {
			var max_id = jQuery('.twitter-max-id').last().data('feed-max-id');
			max_id_param = "&max_id="+max_id;
		}

		if(scroll_load==true){
			jQuery(".hf-social-right .hf-cssload-thecube").show();
			var box_height = jQuery('#twitter-feeds .mCSB_container').height();
			box_height  = box_height - 25 +'px';
			jQuery("#twitter-feeds .hf-cssload-thecube").css("top", box_height);
		}
		jQuery.ajax({
			url: '<?php echo $stylesheetDirectory; ?>/telethon-social-feeds.php',
			method: "POST",
			dataType: "html",
			data:  "load_th_feeds=twitter_feeds"+max_id_param
		}).success(function (data) {
			if(data){
				jQuery("#twitter-feeds").mCustomScrollbar({
					callbacks:{
						onTotalScroll:function(){
							loadTwitterfeeds(true);
						}
					}
				});

				jQuery(".hf-social-right .mCSB_container").append(data);
				jQuery("#twitter-feeds").mCustomScrollbar("update");
			}
		}).always(function() {
			jQuery(".hf-social-right .hf-cssload-thecube").hide();
		});
	}
</script>