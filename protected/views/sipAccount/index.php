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
$cs->registerScriptFile($baseUrl.'/js/angular-cookies.js'  , CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/js/sipaccount.js'  , CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/js/sipAccountChart.js'  , CClientScript::POS_END);


$cs->registerScriptFile($baseUrl.'/js/alertify.min.js'  , CClientScript::POS_END);
$cs->registerCssFile($baseUrl.'/css/alertify.css');


$cs->registerCssFile($baseUrl.'/css/sipAccount.css');


Yii::app()->clientScript->registerScript('sipAccountCharts', $javascriptCode, CClientScript::POS_READY);




?>


<style type="text/css">
	.topUpAllContainer{
		margin: 0px 5px;
	}
	.topUpAllContainer > input{
	    width: 138px;
	}
	.blockedAccount a.editCampaignLink {
	  background-color: #ff284c !important;
	  color: white;		
	}
</style>



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

<h1>
    Sip Accounts ({{sipAccounts.length}}) <small>[bestvoipreselling]</small>
</h1>
<hr>
<div class="span12">
	<div class="span2">
		<strong>
			<input ng-model="activateAllAccounts" type="checkbox" style="margin: 0px;" name="globalstatusEffect">
			<strong >Activate All</strong>
		</strong>		
	</div>
	<div class="span2">
		<strong style="margin-left: 40px;">
			<input ng-model="deactivateAllAccounts" type="checkbox" style="margin: 0px;" name="globalstatusEffect">
			<strong >Deactivate All</strong>
		</strong>		
	</div>
	<div class="span5 offset1 topUpAllContainer">
		<input type="number" ng-model="creditsToTopUpAll" class="form-control" value="" min="0" max="" step="" required="required" title="" placeholder='Amount of credits to top-up.'>
		<select ng-model="freeVoipUsernameAll" ng-options="currentAcct.username for currentAcct in freeVoipAccts">
			<option value="">Balance From</option>
		</select>
		<button ng-click="indexCtrl.currentshowExclusionPanel()" type="button" class="btn btn-default">Top-Up</button>
		<br>
		<div ng-show="topUpSelectContainerShow">
			<label>Select account to EXCLUDE : </label>
			<ul>
				<li ng-repeat="(key, value) in sipAccounts">
					<div class="checkbox">
						<label>
							<input type="checkbox" ng-model="value.isExcluded">
							{{value.sub_user}}
						</label>
					</div>
				</li>
			</ul>
			<br>
			<button ng-click="indexCtrl.topUpAll(freeVoipUsernameAll,creditsToTopUpAll)" type="button" class="btn btn-default" style="margin-top: -10px;">
			<span ng-show="topUpCompletedCount != 0"> <i class="fa fa-spinner fa-spin"></i> {{topUpCompletedCount}} / {{sipAccounts.length}}</span>
			{{topUpMessageLabel}}
			</button>
		</div>
	</div>
</div>
<hr>
<table class="table">
	<thead>
		<tr>
			<th>Main Account</th>
			<th>Sub User</th>
			<th>Balance</th>
			<th>Vici User</th>
			<th>Active</th>
			<th>
				Campaign
			</th>
			<th>IP Address</th>
			<th> # of lines </th>
			<th>Add Balance</th>
			<th>Balance From</th>
			<th></th>
			<th>Last update</th>

		</tr>
	</thead>
	<tbody ng-cloak>
		<tr>
			<td colspan="8" ng-hide="sipAccounts.length !== 0">
				<i class="fa fa-spinner fa-spin"></i> Loading ...
			</td>
		</tr>

		<tr ng-repeat="(key, value) in sipAccounts" ng-class="indexCtrl.getRowClass(value)">
			<td>{{value.main_user}}</td>
			<td>{{value.sub_user}}</td>
			<td>{{value.balance}}</td>
			<td>{{value.vici_user}}</td>
			<td>
				<input ng-change="indexCtrl.alertUserStatusChange()" type="checkbox" ng-model="value.status"
           			ng-true-value="'ACTIVE'" ng-false-value="'INACTIVE'">
				
			</td>
			<td ng-init="value.showEditCampaign = false;value.showEditCampaignLoadingImg = false">
				<div ng-click="value.showEditCampaign = true" ng-show="!value.showEditCampaign">
					<a href="" class='editCampaignLink'>
						<i ng-show="value.showEditCampaignLoadingImg" class="fa fa-spinner fa-spin"></i> {{value.campaign}}
					</a>
				</div>
				<input ng-show="value.showEditCampaign" ng-blur="indexCtrl.updateCampaignName(value)" ng-model="value.campaign" type="text" class="form-control" required="required" placeholder="Campaign">
			</td>
			<td>
				{{value.ip_address}}
			</td>
			<td>
				{{value.num_lines}}
			</td>
			<td><input ng-model="topUpCreditsVal" type="number" name="" class="" value="" min="0" title=""></td>
			<td>
				<select ng-model="freeVoipUsername" ng-options="currentAcct.username for currentAcct in freeVoipAccts">
					 <option value="">-- Select Account --</option>
				</select>
			</td>
			<td>
				<a class="btn btn-default" href=""  ng-click="indexCtrl.topUpCredits(value,freeVoipUsername,value.main_user,value.main_pass, value.sub_user,value.sub_pass  ,topUpCreditsVal)" ng-init="value.topUpText='Top-up'">
					<i class="fa fa-spinner fa-spin" ng-show="value.topUpText !== 'Top-up' "></i>
					{{value.topUpText}} 
				</a>
			</td>
			<td>
				{{value.last_update}}
			</td>

		</tr>
	</tbody>
</table>
<hr>
<button ng-disabled="globalUpdateText === 'Updating data...' || globalUpdateText === 'Loading data...' " ng-cloak type="button" class="btn btn-default" ng-click="indexCtrl.globalUpdate()">
	<i class="fa fa-spinner fa-spin" ng-show="globalUpdateText === 'Updating data...' || globalUpdateText === 'Loading data...' "></i>
	{{globalUpdateText}} {{updateDataReport}}
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