<?php
/* @var $this SipAccountController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sip Accounts',
);
$this->menu=array(
	array('label'=>'<i class="icon-plus-sign"></i> Register new SIP Account', 'url'=>array('create')),
	//array('label'=>'Manage SipAccount', 'url'=>array('admin')),
);

$baseUrl = Yii::app()->theme->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/alertify.min.js'  , CClientScript::POS_END);
$cs->registerCssFile($baseUrl.'/css/alertify.min.css');
$cs->registerScriptFile($baseUrl.'/bower_components/highcharts-release/highcharts.js'  , CClientScript::POS_END);

// $cs->registerCssFile($baseUrl.'/bower_components/angular-chart.js/dist/angular-chart.css');
// $cs->registerScriptFile($baseUrl.'/bower_components/angular/angular.min.js'  , CClientScript::POS_END);
// $cs->registerScriptFile($baseUrl.'/bower_components/angular-chart.js/angular-chart.js'  , CClientScript::POS_END);
// $cs->registerScriptFile($baseUrl.'/js/Chart.min.js'  , CClientScript::POS_END);
// $cs->registerScriptFile($baseUrl.'/js/sipAccountChart.js'  , CClientScript::POS_END);

Yii::app()->clientScript->registerScript('liveupdatelistview', '

	function updateListViewData() {
		alertify.success("Updating data.. Please wait....");
		$.fn.yiiListView.update("sipAccountListView");
		setTimeout(updateListViewData, 60 * 1000);
	}
	setTimeout(updateListViewData, 60 * 1000);

', CClientScript::POS_READY);




$sipAccounts = SipAccount::getSipAccountsAsArr();
$sipAccountsStr = "[";
foreach ($sipAccounts as $currentSipAccount) {
	$sipAccountsStr .= "\"$currentSipAccount\"".',';
}
rtrim($sipAccountsStr,',');
$sipAccountsStr .= ']';

$seriesData = SipAccount::getSeriesDataAsArr();
foreach ($seriesData as $key => $currentSeriesData) {
    $curDataContainer = array();
    $curDataContainer = array("y"=>$currentSeriesData,"color"=>"#".ColorGenerator::generateHexColor());
    $seriesData[$key] = $curDataContainer;
}

$seriesDataStr = json_encode($seriesData);


$javascriptCode = <<<EOL

	window.options = {
            chart: {
            	renderTo:"chartContainer",
                type: 'bar'
            },
	 		title: {
	            text: 'Credit Balance'
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
                        //formatter: function() {return this.x + ': ' this.y},
                        inside: true,
                        //rotation: 270
                    },
                    pointPadding: 0.1,
                    groupPadding: 0
                }
            },

            series: [{
                data: $seriesDataStr
            }]
        };
	
	window.originalColor = [];
	//iterate all original color
	jQuery.each(window.options.series[0].data, function(index, val) {
		window.originalColor.push(val.color);
		if (val.y < 10) {
			window.options.series[0].data[index].color = "red";
		}
	  //iterate through array or object
	});

	window.chartObj = new Highcharts.Chart(window.options);


EOL;
Yii::app()->clientScript->registerScript('sipAccountCharts', $javascriptCode, CClientScript::POS_READY);

Yii::app()->clientScript->registerScript('updateChartData', '
	setTimeout(updateChartData, 3 * 1000);
	', CClientScript::POS_READY);

?>

<style type="text/css">
	.account-panels {
		min-width : 350px;
		max-width : 450px;
		float:left;
		margin: 10px 5px;

		padding: 10px;
	}
	.list-view .summary {
		text-align: left;
	}
</style>


<script type="text/javascript">
	function updateChartData () {
		jQuery.ajax({
		  url: '/sipAccount/getBarChartReportData',
		  type: 'GET',
		  dataType: 'json',
		  success: function(data, textStatus, xhr) {

			jQuery.each(data, function(index, val) {
				//console.log(val.y)
			  if (val.y < 10) {
			  	data[index].color =  "red";
			  }else if(val.y >= 10 && window.chartObj.series[0].data[index].color == "red"){
			  	data[index].color = window.originalColor[index];

			  	// if (window.chartObj.series[0].data[index].color == 'red') {
			  	// 	//@TDODO - load color before
			  	// 	window.chartObj.series[0].data[index].color = window.originalColor[index];
			  	// }else{
			  	// 	data[index].color = window.chartObj.series[0].data[index].color;
			  	// 	//val.color = window.chartObj.series[0].data[index].color;
			  	// }
			  }else{
			  	data[index].color = window.chartObj.series[0].data[index].color;
			  }
			});

		  	window.chartObj.series[0].setData(data,true);

			jQuery.each(window.chartObj.series[0].data, function(index, val) {
			  val.setState('hover');
			  val.setState();
			  //console.log(val);
			});
		  	
		  },
		});
		setTimeout(updateChartData, 3 * 1000);
	}
</script>



<div ng-app="angularChart">
<div ng-controller="IndexCtrl">
	



<?php 

$this->widget('bootstrap.widgets.TbAlert', array(
    'fade'=>true, 
    'closeText'=>'×',
    'alerts'=>array( 
	    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success
	    'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // info
    ),
)); ?>


<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>'SIP Account Balance',
	));
?>

<div id="chartContainer"></div>

<?php
	$this->endWidget();
?>
<hr>


<h1>
    Sip Accounts <small>[bestvoipreselling]</small>
	<small id="updateCounterContainer"></small>
</h1>
<hr>


<?php $this->widget('zii.widgets.CListView', array(
	'id'=>'sipAccountListView',
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'template'=>'<div class="pull-left" >{summary}<h5>{sorter}</h5></div><div class="clearfix"></div><br><hr>{items}<br>{pager}',
   	'sortableAttributes'=>array(
        'username',
        'account_status',
        'date_created'=>'Date Created',
    ),	
)); ?>

</div>
</div>