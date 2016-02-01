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
                        array('label'=>'Dashboard', 'url'=>array('/site/index'),'visible'=>!Yii::app()->user->isGuest),
                        array('label'=>'Charts', 'url'=>array('/chart'),'visible'=>!Yii::app()->user->isGuest),
                        // array('label'=>'Campaigns', 'url'=>array('/campaigns/index'),'visible'=>!Yii::app()->user->isGuest),
                        array('label'=>'SIP Accounts', 'url'=>array('/sipAccount/index'),'visible'=>!Yii::app()->user->isGuest),
                        array('label'=>'Manage SIP Accounts', 'url'=>array('remoteDataCache/admin'),'visible'=>!Yii::app()->user->isGuest),
                        array('label'=>'Top-up <span class="caret"></span>','visible'=>!Yii::app()->user->isGuest ,'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array(
                            array('label'=>'Selected accounts', 'url'=>array('/subSipAccount/topUpSelected')),
                            // array('label'=>'My Tasks <span class="badge badge-important pull-right">112</span>', 'url'=>'#'),
                            // array('label'=>'My Invoices <span class="badge badge-info pull-right">12</span>', 'url'=>'#'),
                            // array('label'=>'Separated link', 'url'=>'#'),
                            // array('label'=>'One more separated link', 'url'=>'#'),
                        )),

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
                                array('label'=>'<i class="icon icon-home"></i>  Dashboard ', 'url'=>array('/site/index'),'itemOptions'=>array('class'=>'')),
                                array('label'=>'<i class=" icon-list"></i>  List Accounts ', 'url'=>array('/sipAccount/index'),'itemOptions'=>array('class'=>'')),
                            ),$this->menu);
                    }
                ?>
                <?php $this->widget('zii.widgets.CMenu',array(
                        'htmlOptions'=>array('class'=>'pull-left nav mySubNav'),
                        'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
                        'itemCssClass'=>'item-test',
                        'encodeLabel'=>false,
                        'items'=>$this->menu,
                )); ?>
            <?php endif ?>
    	</div><!-- container -->
    </div><!-- navbar-inner -->
</div><!-- subnav -->