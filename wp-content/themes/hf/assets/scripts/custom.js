jQuery(document).ready(function($) {
	
	if($("#classyCampaignID").length) {
		console.log($("#classyCampaignID").val());

		$.ajax({
			url: ajax_object.ajaxurl,
			method: "POST",
			dataType: "json",
			data: {
				action: 'fetch_top_fundraisers',
				classyCampaignID: $("#classyCampaignID").val(),
				telethonEventID: $("#telethonEventID").val(),
			}

		}).success(function (data) {
			console.log(data);
			$("#fundraisers").show().append(data.content);
		});
	}
});

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
jQuery(document).ready(function($) {

	if($("#isCampaignStats").length) {

		var states = JSON.parse($("#hf_us_state_abbrevs_names").val());
		var keys = Object.keys(states);
		var stateCodes = JSON.parse($("#states").val());
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
				data: JSON.parse($("#values").val())
			},
			{
				name: 'Pledges',
				data: JSON.parse($("#pledge_values").val())
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

		var totalRaised = $("#totalCollected").val();
		totalRaised = jQuery.parseHTML(totalRaised);
		var num_raised = totalRaised[0].data.trim();
		var unit_raised = '';
		if(totalRaised.length > 1) {
			unit_raised = totalRaised[1].innerHTML;
		}
		var totalDonations = $("#totalDonations").val();
		totalDonations = jQuery.parseHTML(totalDonations);
		var num_donated = totalDonations[0].data.trim();
		var unit_donated = '';
		if(totalDonations.length > 1) {
			unit_donated = totalDonations[1].innerHTML;
		}
		var percent_donations = $("#percent_donations").val();
		var percent_pledges = $("#percent_pledges").val();
		var percent_total = $("#percent_total").val();

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
						margin: 0,
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
		var goal = $("#goal").val();
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
	}
});