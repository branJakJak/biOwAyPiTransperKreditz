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


<?php if (Yii::app()->user->hasFlash('success')): ?>
<div class="alert in fade alert-success">
    <a href="#" class="close" data-dismiss="alert">×</a>
        <?php echo Yii::app()->user->getFlash('success') ?>
</div>

<?php endif ?>

<div ng-app="sipAccountModule">
    <div ng-controller="IndexCtrl as indexCtrl">
        <div class="span3 text-center">
            <?php
                $this->beginWidget('zii.widgets.CPortlet', array(
                    'title'=>'<strong class="pull-left">Overall Used Credits</strong> <a href="resetAll" class="pull-right">Reset All</a> <div class="clearfix"></div> ',
                ));
            ?>
            <h2>
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
                <th>Date</th>
                <th></th>
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
                    <a target="_blank" href="/index.php/remoteDataCache/{{value.id}}">
                        {{value.main_user}}
                    </a>
                </td>
                <td>{{value.sub_user}}</td>
                <td>{{value.balance}}</td>
                <td>{{ indexCtrl.getCreditUsed(value)  }}</td>

                <td>{{ value.last_credit_update  }}</td>
                <td>
                    <a class='btn btn-sm' href="reset?account={{ value.id }}">Reset Credit Used</a>
                </td>

            </tr>
            </tbody>
        </table>

    </div>
</div>