<?php echo $header; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<div id="content">
  <h2>Visitors' browsers:</h2>
  <div id="visitorBrowser" style="width:400px;height:300px;"></div>
  <h2>Visitors' countries:</h2>
  <div id="visitorCountry" style="width:400px;height:300px;"></div>
  <h2>Products rank by number of reviews:</h2>
  <div id="reviewRank" style="width:400px;height:300px;"></div>
</div>
<script type="text/javascript" src="catalog/view/javascript/jquery/flot/jquery.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/flot/jquery.flot.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/flot/jquery.flot.categories.js"></script>
<script type="text/javascript">
$(function() {

		var visitorBrowserData = [<?php echo $browserDataOutput; ?>];
		var visitorCountryData = [<?php echo $countryDataOutput; ?>];
		var reviewRankData = [<?php echo $rankDataOutput; ?>];

		$.plot("#visitorBrowser", [ visitorBrowserData ], {
			series: {
				bars: {
					show: true,
					barWidth: 0.6,
					align: "center"
				}
			},
			xaxis: {
				mode: "categories",
				tickLength: 0
			}
		});
		
		$.plot("#visitorCountry", [ visitorCountryData ], {
			series: {
				bars: {
					show: true,
					barWidth: 0.6,
					align: "center"
				}
			},
			xaxis: {
				mode: "categories",
				tickLength: 0
			}
		});
		
		$.plot("#reviewRank", [ reviewRankData ], {
			series: {
				bars: {
					show: true,
					barWidth: 0.6,
					align: "center"
				}
			},
			xaxis: {
				mode: "categories",
				tickLength: 0
			}
		});

	});
</script>
<?php echo $footer; ?> 