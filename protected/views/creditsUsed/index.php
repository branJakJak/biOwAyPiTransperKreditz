<?php
/* @var $this CreditsUsedController */

$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();
/*angular*/
$cs->registerScriptFile($baseUrl . '/bower_components/angular/angular.js', CClientScript::POS_END);
/* angular external modules*/
$cs->registerScriptFile($baseUrl.'/js/angular-cookies.js'  , CClientScript::POS_END);


/*sip account*/
$cs->registerScriptFile($baseUrl.'/js/angular-cookies.js'  , CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/bower_components/angular-moment/angular-moment.min.js'  , CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/bower_components/angular-tooltips/dist/angular-tooltips.min.js'  , CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/bower_components/humanize-duration/humanize-duration.js'  , CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/bower_components/angular-timer/dist/angular-timer.min.js'  , CClientScript::POS_END);


/*sip account*/
$cs->registerScriptFile($baseUrl.'/js/sipaccount.js'  , CClientScript::POS_END);


$this->breadcrumbs = array(
    'Credits Used',
);
$this->menu = array();
?>



<div ng-app="sipAccountModule">
    <div ng-controller="IndexCtrl as indexCtrl">
        <div class="span3 text-center">
            <?php
                $this->beginWidget('zii.widgets.CPortlet', array(
                    'title'=>' ',
                ));
            ?>
            <h2>
                Overall Used Credits
                <small class="small">
                    {{ indexCtrl.getTotalCreditsUsed() }}
                </small>
            </h2>
            <?php
                $this->endWidget();
            ?>
        </div>
        

        <!-- Main Remote Data Cache -->
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Main Account</th>
                <th>Sub User</th>
                <th>Balance</th>
                <th>Credit used</th>
            </tr>
            </thead>
            <tbody ng-cloak>
            <tr>
                <td colspan="14" ng-hide="sipAccounts.length !== 0">
                    <i class="fa fa-spinner fa-spin"></i> Loading ...
                </td>
            </tr>

            <tr ng-repeat="(key, value) in sipAccounts " ng-class="indexCtrl.getRowClass(value)">
                <td>{{key+1}}</td>
                <td>
                    <a target="_blank" href="https://www.voipinfocenter.com/Login.aspx?username={{value.main_user}}&password={{value.main_pass}}">
                        {{value.main_user}}
                    </a>
                </td>
                <td>{{value.sub_user}}</td>
                <td>{{value.balance}}</td>
                <td>{{ indexCtrl.getCreditUsed(value)  }}</td>
            </tr>
            </tbody>
        </table>

    </div>
</div>