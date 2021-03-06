<?php 


$baseUrl = Yii::app()->theme->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/sipAccountChart.js'  , CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/js/alertify.min.js'  , CClientScript::POS_END);
$cs->registerCssFile($baseUrl.'/css/alertify.css');
$cs->registerScriptFile($baseUrl.'/bower_components/highcharts-release/highcharts.js'  , CClientScript::POS_END);
$javascriptCode = <<<EOL
	window.originalColorMap = new Object();
	window.options = {
            chart: {
            	renderTo:"chartContainer",
                type: 'bar'
            },
	 		title: {
	            text: 'Credit Balance'
	        },
			credits: {
			   enabled: false
			},
            legend: { enabled: false},
            xAxis: {
                categories: $sipAccountsStr,
	  			title: {
	                text: null
	            },
            },
	 		yAxis: {
	            title: {
	                text: null,
	            },
	        },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        color: '#000',
                        style: {fontWeight: 'bolder'},
                        inside: true,
                    },
                    pointPadding: 0.1,
                    groupPadding: 0
                }
            },

            series: [{
                data: $seriesDataStr
            }]
        };
	
	
	window.chartObj = new Highcharts.Chart(window.options);
EOL;
Yii::app()->clientScript->registerScript('sipAccountCharts', $javascriptCode, CClientScript::POS_READY);


Yii::app()->clientScript->registerScript('updateChartDataInterval', '
function updateChartDataInterval(){
	jQuery.ajax({
	  url: "/sipAccount/getBarChartReportData",
	  type: "POST",
	  dataType: "json",
	  success: function(data, textStatus, xhr) {
	  	window.updateChartData(data);
	  	setTimeout(updateChartDataInterval, 1000);
	  },
	});
}
setTimeout(updateChartDataInterval, 1 * 1000);
', CClientScript::POS_READY);


// Yii::app()->clientScript->registerScript('blinkingChart', '
// 		window.blinkerInterval = setInterval(window.chartBlink, 600);
// 	', CClientScript::POS_READY);




?>




<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>'SIP Account Balance',
		'htmlOptions'=>array(
		)
	));
?>

<div id="chartContainer" style="height: 1500px"></div>

<hr>
<button id="updateInformationBtn" type="button" class="btn btn-default btn-info btn-block" onclick="updateInformation()">
	Update Information
</button>
<?php
	$this->endWidget();
?>
<hr>

<script type="text/javascript">
	function updateInformation() {
		var updateInformationBtn = jQuery("#updateInformationBtn");
		updateInformationBtn.html("Updating...");
		setTimeout(function() {
			updateInformationBtn.html("Content updated");
			setTimeout(function() {
				updateInformationBtn.html("Update Information");
			}, 500);
		}, 1000);
	}
</script>