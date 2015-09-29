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
$seriesDataStr = "[";
foreach ($seriesData as $currentSeriesData) {
	$seriesDataStr .= $currentSeriesData.',';
}
rtrim($seriesDataStr,',');
$seriesDataStr .= ']';


$javascriptCode = <<<EOL

	options = {
            chart: {
            	renderTo:"chartContainer",
                type: 'bar'
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
	window.chartObj = new Highcharts.Chart(options);    


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
		  	window.chartObj.series[0].setData(data);
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