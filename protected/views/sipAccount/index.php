<?php



/* @var $this SipAccountController */
/* @var $dataProvider CActiveDataProvider */
$baseUrl = Yii::app()->theme->baseUrl; 
$cs = Yii::app()->getClientScript();


// ==================================================================
//
// Declare some supplementary data to widgets
//
// ------------------------------------------------------------------

$this->breadcrumbs=array(
	'Sip Accounts',
);
$this->menu=array(
	array('label'=>'Manage SIP Account', 'url'=>array('create')),
);


// ==================================================================
//
// Include scripts
//
// ------------------------------------------------------------------

/*angular*/
$cs->registerScriptFile($baseUrl.'/bower_components/angular/angular.js'  , CClientScript::POS_END);
/*moment js library */
$cs->registerScriptFile($baseUrl.'/bower_components/moment/min/moment-with-locales.min.js'  , CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/bower_components/moment-timezone/moment-timezone.js'  , CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/bower_components/moment/min/moment-timezone-data.js'  , CClientScript::POS_END);

// jstz
$cs->registerScriptFile($baseUrl.'/js/jstz.min.js'  , CClientScript::POS_END);

/* angular external modules*/
$cs->registerScriptFile($baseUrl.'/js/angular-cookies.js'  , CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/bower_components/angular-moment/angular-moment.min.js'  , CClientScript::POS_END);
// $cs->registerScriptFile($baseUrl.'/bower_components/momentjs/min/locales.js'  , CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/bower_components/angular-tooltips/dist/angular-tooltips.min.js'  , CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/bower_components/humanize-duration/humanize-duration.js'  , CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/bower_components/angular-timer/dist/angular-timer.min.js'  , CClientScript::POS_END);






/*dumb logic codes*/
$cs->registerScriptFile($baseUrl.'/js/sipaccount.js'  , CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/js/sipAccountChart.js'  , CClientScript::POS_END);



$cs->registerScriptFile($baseUrl.'/js/alertify.min.js'  , CClientScript::POS_END);
$cs->registerCssFile($baseUrl.'/css/alertify.css');


$cs->registerCssFile($baseUrl.'/css/sipAccount.css');

$cs->registerCssFile($baseUrl.'/bower_components/angular-tooltips/dist/angular-tooltips.min.css');










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
<div class="well">
	<div class="span5">
		<h2 style="margin-top: 25px;">
			 {{sipAccounts.length}} Sip Accounts Balance
			<small style="font-size: 19px;color:black">
				({{indexCtrl.getTotalBalance() | currency:"&#8364;"}})
			</small>
		</h2>
	</div>
	<div class="span7">
		<div class="span3" ng-repeat="(key, value) in freeVoipAccts">
			<h4>
				<small>
					<!-- will show this soon -->
					<a tooltips title="Since last update" >
						{{value.last_updated}}
					</a>
				</small>
				<br>
					{{value.username}}
				<br>
				<strong>
					{{value.credits}}
				</strong>
			</h4>
		</div>
		
	</div>
	<div class="clearfix"></div>
	<div class="span5">
		<h4>
			<span class='icon-ok'></span>
			{{  (sipAccounts|filter:{is_active:"ACTIVE"}:true).length   }}
			Active Accounts
		</h4>
		<h4>
			<span class='icon-remove'></span>
			{{  (sipAccounts |filter:{is_active:'INACTIVE'} ).length   }}
			Inactive Accounts
				
		</h4>
	</div>
	<div class="span5 hidden">
		<h2>
			<small>
				Time till next update : 
				<timer end-time="endTimeTillNextUpdate">{{minutes}} minutes, {{seconds}} seconds.</timer>
			</small>
		</h2>
	</div>
	<div class="clearfix"></div>
</div>
<hr>
<div class='well'>
	<div class="">
		<table class="table">
			<thead>
				<tr>
					<th></th>
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
					<th>Get latest balance</th>
					<th>Last update</th>
					<th>Delete</th>

				</tr>
			</thead>
			<tbody ng-cloak>
				<tr>
					<td colspan="14" ng-hide="sipAccounts.length !== 0">
						<i class="fa fa-spinner fa-spin"></i> Loading ...
					</td>
				</tr>
				<tr ng-repeat="(key, value) in sipAccounts | filter:{main_user:'Prion1967' }" ng-class="indexCtrl.getRowClass(value)">
					<td>
						<h4>CC Account</h4>
					</td>
					<td>{{value.balance}}</td>
					<td>{{value.vici_user}}</td>
					<td>
						<input ng-change="" type="checkbox" ng-model="value.is_active"
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
					<td><input ng-model="topUpCreditsVal" type="number" ></td>
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
						<a class="btn btn-default" href="" ng-click="indexCtrl.quickUpdateBalance(value)"> Update balance</a>
					</td>
					
					<td>
						{{ value.date_updated }}
					</td>
					<td>
						<a class="btn btn-default" href="/sipAccount/quickDelete?cacheid={{value.id}}" onclick="return confirm('Are you sure you want to delete this ? ')">
							delete
						</a>
					</td>
				</tr>
			</tbody>
		</table>		
	</div>	
	
</div>

<hr>
<div class="well">
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
	<div class="span5 offset2 topUpAllContainer">
		<input type="number" ng-model="creditsToTopUpAll" class="form-control" value="" min="0" max="" step="" required="required" title="" placeholder='Amount of credits to top-up.'>
		<div ng-show="freeVoipAccts.length == 0">
			<i  class="fa fa-spinner fa-spin"></i>
		</div>
		<select ng-show="freeVoipAccts.length != 0" ng-model="freeVoipUsernameAll" ng-options="currentAcct.username for currentAcct in freeVoipAccts">
			<option value="">Balance From</option>
		</select>
		<button ng-click="indexCtrl.currentshowExclusionPanel()" type="button" class="btn btn-default"  style="margin-top: -10px;">
            Top-Up
        </button>
		<br>

		<div ng-show="topUpSelectContainerShow">
			<label>Select an account  : </label>
			<ul style="list-style: none">
				<li ng-repeat="(key, value) in sipAccounts ">
					<div class="checkbox">
						<label>
							<input type="checkbox" ng-model="value.isIncluded">
							{{value.sub_user}}
						</label>
					</div>
				</li>
			</ul>
			<br>

			<button ng-click="indexCtrl.topUpAll(freeVoipUsernameAll,creditsToTopUpAll)" type="button" class="btn btn-default" style="margin-top: -10px;">

			<span ng-show="topUpCompletedCount != 0"> <i class="fa fa-spinner fa-spin"></i> {{topUpCompletedCount}} / {{  (topUpAllStack.length / 2) | number:0   }}</span>
			{{topUpMessageLabel}}

			</button>
			<hr>
		</div>


	</div>
</div>
<hr>
<table class="table">
	<thead>
		<tr>
			<th>#</th>
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
			<th></th>
			<th>Get latest balance</th>
			<th>Last update</th>
			<th>Delete</th>

		</tr>
	</thead>
	<tbody ng-cloak>
		<tr>
			<td colspan="14" ng-hide="sipAccounts.length !== 0">
				<i class="fa fa-spinner fa-spin"></i> Loading ...
			</td>
		</tr>

		<tr ng-repeat="(key, value) in sipAccounts | filter:'!Prion1967'" ng-class="indexCtrl.getRowClass(value)">
			<td>{{key+1}}</td>
			<td>{{value.main_user}}</td>
			<td>{{value.sub_user}}</td>
			<td>{{value.balance}}</td>
			<td>{{value.vici_user}}</td>
			<td>
				<input ng-change="" type="checkbox" ng-model="value.is_active"
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
			<td><input ng-model="topUpCreditsVal" type="number" ></td>
			<td  ng-hide="true">
				<select ng-model="freeVoipUsername" ng-options="currentAcct.username for currentAcct in freeVoipAccts">
					 <option value="">-- Select Account --</option>
				</select>
			</td>
			<td>
				<a  ng-hide="true" class="btn btn-default" href=""  ng-click="indexCtrl.topUpCredits(value,freeVoipUsername,value.main_user,value.main_pass, value.sub_user,value.sub_pass  ,topUpCreditsVal)" ng-init="value.topUpText='Top-up'">
					<i class="fa fa-spinner fa-spin" ng-show="value.topUpText !== 'Top-up' "></i>
					{{value.topUpText}} 
				</a>
			</td>
			<td>
				<a class="btn btn-default" href="" ng-click="indexCtrl.quickUpdateBalance(value)"> Update balance</a>
			</td>
			
			<td>
				{{ value.date_updated }}
			</td>
			<td>
				<a class="btn btn-default" href="/sipAccount/quickDelete?cacheid={{value.id}}" onclick="return confirm('Are you sure you want to delete this ? ')">
					delete
				</a>
			</td>
		</tr>
	</tbody>
</table>
<hr>
<button ng-hide="true" ng-disabled="globalUpdateText === 'Updating data...' || globalUpdateText === 'Loading data...' " ng-cloak type="button" class="btn btn-default" ng-click="indexCtrl.globalUpdate()">
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
