<?php
/* @var $this SipAccountController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sip Accounts',
);
$this->menu=array(
	array('label'=>'<i class="icon-plus-sign"></i> Register new SIP Account', 'url'=>array('create')),
);

$baseUrl = Yii::app()->theme->baseUrl; 
$cs = Yii::app()->getClientScript();
/*angular*/
$cs->registerScriptFile($baseUrl.'/bower_components/angular/angular.min.js'  , CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/js/sipaccount.js'  , CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/js/sipAccountChart.js'  , CClientScript::POS_END);


$cs->registerScriptFile($baseUrl.'/js/alertify.min.js'  , CClientScript::POS_END);
$cs->registerCssFile($baseUrl.'/css/alertify.css');
$cs->registerCssFile($baseUrl.'/css/sipAccount.css');
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

Yii::app()->clientScript->registerScript('updateChartData', '
	setTimeout(updateChartData, 3 * 1000);
	', CClientScript::POS_READY);

?>



<div ng-app="sipAccountModule">
<div ng-controller="IndexCtrl as indexCtrl" >

<?php if (false): ?>
	
<div class='headerBtnToggle' ng-show="false" ng-cloak>
	<button type="button" class="btn btn-default">
		<img src="<?php echo $baseUrl ?>/img/chart-icon.png"> 
		Show Chart
	</button>
	<button type="button" class="btn btn-default">
		<img src="<?php echo $baseUrl ?>/img/Generate-tables-icon.png"> 
		Show Table
	</button>
</div>

<?php endif ?>

<hr>


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
</h1>
<hr>
<strong>
	<input ng-model="activateAllAccounts" type="checkbox" style="margin: 0px;" name="globalstatusEffect">
	<strong >Activate All</strong>
</strong>
<strong style="margin-left: 40px;">
	<input ng-model="deactivateAllAccounts" type="checkbox" style="margin: 0px;" name="globalstatusEffect">
	<strong >Deactivate All</strong>
</strong>
<hr>
<table class="table">
	<thead>
		<tr>
			<th>Main Account</th>
			<th>Sub User</th>
			<th>Balance</th>
			<th>Vici User</th>
			<th>Active</th>
			<th>Campaign</th>
			<th>IP Address</th>
			<th>Add Balance</th>
			<th>Balance From</th>
			<th></th>
		</tr>
	</thead>
	<tbody ng-cloak>
		<tr>
			<td colspan="8" ng-hide="sipAccounts.length !== 0">
				<i class="fa fa-spinner fa-spin"></i> Loading ...
			</td>
		</tr>
		<tr ng-repeat="(key, value) in sipAccounts" ng-class="indexCtrl.getRowClass(value)">
			<td>{{value.username}}</td>
			<td>{{value.subSipAccounts[0].customer_name}}</td>
			<td>{{value.subSipAccounts[0].balance}}</td>
			<td>{{value.vicidial_identification}}</td>
			<td>
				<input ng-click="indexCtrl.updateSingleRow(value)"  type="checkbox" ng-model="value.account_status"
           			ng-true-value="'active'" ng-false-value="'blocked'">
			</td>
			<td>{{value.campaign_name}}</td>
			<td>
				{{value.vici_ip_address}}
			</td>
			<td><input ng-model="topUpCreditsVal" type="number" name="" class="" value="" min="0" max="" title=""></td>
			<td>
				<select ng-model="freeVoipUsername" ng-options="currentAcct.username for currentAcct in freeVoipAccts">
					 <option value="">-- Select Account --</option>
				</select>
			</td>
			<td>
				<a class="btn btn-default" href=""  ng-click="indexCtrl.topUpCredits(freeVoipUsername,value.parent_sip_id,value.subSipAccounts[0].sub_sip_id,topUpCreditsVal)">Top-up</a>
			</td>

		</tr>
	</tbody>
</table>
<hr>
<button ng-cloak type="button" class="btn btn-default" ng-click="indexCtrl.globalUpdate()">{{globalUpdateText}}</button>

</div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>