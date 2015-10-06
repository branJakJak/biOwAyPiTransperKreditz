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
	//setTimeout(updateChartData, 3 * 1000);
	', CClientScript::POS_READY);

?>



<div ng-app="sipAccountModule">
<div ng-controller="IndexCtrl as indexCtrl" >



<?php 

$this->widget('bootstrap.widgets.TbAlert', array(
    'fade'=>true, 
    'closeText'=>'×',
    'alerts'=>array( 
	    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success
	    'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // info
    ),
)); ?>



<hr>



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
			<div>
			</div>
			<td>{{value.main_user}}</td>
			<td>{{value.sub_user}}</td>
			<td>{{value.balance}}</td>
			<td>{{value.vici_user}}</td>
			<td>
				<input type="checkbox" ng-model="value.status"
           			ng-true-value="'ACTIVE'" ng-false-value="'INACTIVE'">
				
			</td>
			<td>{{value.campaign}}</td>
			<td>
				{{value.server_ip}}
			</td>
			<td><input ng-model="topUpCreditsVal" type="number" name="" class="" value="" min="0" max="" title=""></td>
			<td>
				<select ng-model="freeVoipUsername" ng-options="currentAcct.username for currentAcct in freeVoipAccts">
					 <option value="">-- Select Account --</option>
				</select>
			</td>
			<td>
				<a class="btn btn-default" href=""  ng-click="indexCtrl.topUpCredits(freeVoipUsername,value.main_user,value.main_pass, value.sub_user,value.sub_pass  ,topUpCreditsVal)">Top-up</a>
			</td>
			<td>
				<div class="btn-group">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cogs fa-lg"></i></a>
					<ul class="dropdown-menu">
						<li><a href="/subSipAccount/create?SubSipAccount[parent_sip]={{value.parent_sip_id}}"><i class="fa fa-plus-circle"></i> Add Sub Sip Account</a></li>
						<li class='hidden'><a href="#"><i class="fa fa-warning"></i> Delete account</a></li>
						<!-- <li><a href="#">Separated link</a></li> -->
					</ul>
				</div>
				
			</td>
		</tr>
	</tbody>
</table>
<hr>
<button ng-cloak type="button" class="btn btn-default" ng-click="indexCtrl.globalUpdate()">
	<i class="fa fa-spinner fa-spin" ng-show="globalUpdateText === 'Updating data...' "></i>
	{{globalUpdateText}}
</button>

</div>
</div>
<br>
<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>'Recent Logins',
	));
?>
<?php 
	$this->widget('zii.widgets.grid.CGridView', array(
	    'dataProvider' => UserRequest::model()->getRecentLogins(),
	    'template' => "{summary}\n{items}\n{pager}",
	    'columns'=>array(
			array(
				'name'=>'ip_address', 
				'header'=>'IP Address',
				'type'=>'raw',
				'value'=>'$data->ip_address',
			),
			array(
				'header'=>'Location',
				'type'=>'raw',
				'value'=>'$data->getFlagImageLabel()',
			),
			array(
				'name'=>'date_created', 
				'header'=>'Last access',
				'type'=>'raw',
				'value'=>'date("F j, Y, g:i a",strtotime("$data->date_created"))',
			),
		)
	));
?>
<?php
	$this->endWidget();
?>


<div class="clearfix"></div>
<hr>

<br>
<br>
<br>
<br>
<br>