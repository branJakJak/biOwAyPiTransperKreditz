<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div id="content">
	<?php echo $content; ?>
</div><!-- content -->
<div>
	  <?php $this->widget('zii.widgets.CMenu', array(
	/*'type'=>'list',*/
	'encodeLabel'=>false,
	'items'=>array(
		array('label'=>'<i class="icon icon-home"></i>  Dashboard <span class="label label-info pull-right">home</span>', 'url'=>array('/site/index'),'itemOptions'=>array('class'=>'')),
		array('label'=>'<i class=" icon-list"></i>  List Accounts ', 'url'=>array('/sipAccount/index'),'itemOptions'=>array('class'=>'')),
		array('label'=>'OPERATIONS','items'=>$this->menu),
	),
	));?>
</div>
<hr>
<?php $this->endContent(); ?>