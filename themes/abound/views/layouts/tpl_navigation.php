<?php 
Yii::app()->clientScript->registerCss('quickNavFix', '

.mySubNav > li > a{
    color: black !important;
}
');

?>
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
    <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
     
          <!-- Be sure to leave the brand out there if you want it shown -->
          <a class="brand" href="#"><?php echo Yii::app()->name ?></a>
          
          <div class="nav-collapse">
			<?php $this->widget('zii.widgets.CMenu',array(
                    'htmlOptions'=>array('class'=>'pull-right nav'),
                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
					'itemCssClass'=>'item-test',
                    'encodeLabel'=>false,
                    'items'=>array(
                        // array('label'=>'Dashboard', 'url'=>array('/site/index'),'visible'=>!Yii::app()->user->isGuest),
                        array('label'=>'Home', 'url'=>array('/sipAccount/index'),'visible'=>!Yii::app()->user->isGuest),
                        array('label'=>'Accounts', 'url'=>array('/remoteDataCache/admin'),'visible'=>!Yii::app()->user->isGuest),
                        array('label'=>'Credits Used', 'url'=>array('/creditsUsed/index'),'visible'=>!Yii::app()->user->isGuest),
                        // array('label'=>'Control', 'url'=>array('/control/index'),'visible'=>!Yii::app()->user->isGuest),
                        // array('label'=>'Charts', 'url'=>array('/chart'),'visible'=>!Yii::app()->user->isGuest),
                        array('label'=>'Active Monitor', 'url'=>array('/activeMonitor'),'visible'=>!Yii::app()->user->isGuest),
                        array('label'=>'Group action <span class="caret"></span>','visible'=>!Yii::app()->user->isGuest ,'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"),
                        'items'=>array(
                            array('label'=>'Top up', 'url'=>array('/subSipAccount/topUpSelected')),
                            array('label'=>'Activate', 'url'=>array('/subSipAccount/activateGroup')),
                            array('label'=>'Deactivate', 'url'=>array('/subSipAccount/deactivateGroup')),
                        )),
                        array('label'=>'Configuration <span class="caret"></span>','visible'=>!Yii::app()->user->isGuest ,'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"),
                        'items'=>array(
                            array('label'=>'Auto top-up Configuration', 'url'=>array('/config/autoTopUp')),
                        )),
                        // array('label'=>'Logs', 'url'=>array('/logs'),'visible'=>!Yii::app()->user->isGuest),                            
                        array('label'=>'Login', 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest),
                        array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                    ),
                )); ?>
    	</div>
    </div>
	</div>
</div>

<div class="subnav navbar navbar-fixed-top">
    <div class="navbar-inner">
    	<div class="container">
            <?php if (isset($this->menu)): ?>
                <?php 
                    if (!Yii::app()->user->isGuest) {
                        $this->menu = array_merge(
                            array(
                            ),$this->menu);
                    }
                ?>

            <?php endif ?>
    	</div><!-- container -->
    </div><!-- navbar-inner -->
</div><!-- subnav -->