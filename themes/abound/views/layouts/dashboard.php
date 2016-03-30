<?php /* @var $this Controller */ ?>



<?php $this->beginContent('//layouts/main'); ?>


<style type="text/css">
	.menuWidgetsCol1 {
		list-style:none;
	}
	.menuWidgetsCol1 li {
		float:left;
	    padding: 25px;
	    background-color: #E9E9E9;
	    border-radius: 12px;
	    margin: 11px;
	    font-size: 17.5px;
	    text-align:center;	
	}

</style>


<div id="content">


<div>
	<?php 
	$headerMenu = array_merge(array(
			array('label'=>'<i class="icon icon-home"></i>  Dashboard ', 'url'=>array('/site/index'),'itemOptions'=>array('class'=>'')),
			array('label'=>'<img src="http://icons.iconarchive.com/icons/oxygen-icons.org/oxygen/64/Apps-preferences-contact-list-icon.png"><br> List Accounts ', 'url'=>array('/sipAccount/index'),'itemOptions'=>array('class'=>'')),
	), $this->menu);

	$this->widget('zii.widgets.CMenu', array(
			'encodeLabel'=>false,
			'items'=>$headerMenu,
			'htmlOptions'=>array('class'=>'menuWidgetsCol1')
		));

	?>
	<div class="clearfix"></div>
</div>
<hr>


	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
			'homeLink'=>CHtml::link('Dashboard'),
			'htmlOptions'=>array('class'=>'breadcrumb')
        )); ?><!-- breadcrumbs -->
    <?php endif?>
    
	<?php echo $content; ?>
</div><!-- content -->


<?php $this->endContent(); ?>