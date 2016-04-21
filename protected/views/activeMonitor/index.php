<?php
/* @var $this ActiveMonitorController */

$this->breadcrumbs=array(
	'Active Monitor'=>array("/activeMonitor/index"),
);
$hasSelectedMonitoredAccounts = false;
//get all cookies , if monitorAccount is present
if (isset(Yii::app()->request->cookies['monitoredAccounts'])) {
	$hasSelectedMonitoredAccounts = true;
	// Yii::app()->clientScript->registerScript('openDialog', '
	// 	$("#loadPastAccounts").dialog("open");
	// ', CClientScript::POS_READY);
}

?>

<?php 
	$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
	    'id'=>'loadPastAccounts',
	    'options'=>array(
	        'title'=>'Load accounts',
	        'modal'=>true,
	        'width'=>'570px',
	        'autoOpen'=>$hasSelectedMonitoredAccounts,
	    ),
	));
?>
	<br>
	<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		You currently have monitored accounts. Would you like to clear them ? 
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
	</div>
	<br>
	<?php echo CHtml::link('<span class="icon icon-remove icon-white"></span> Yes - clear them all', array('/activeMonitor/clear'), array('class'=>'btn btn-warning','style'=>'color: white')); ?>
	<?php echo CHtml::link('<span class="icon icon-ok icon-white"></span> No - Load previously monitored accounts', array('/activeMonitor/monitor'), array('class'=>'btn btn-primary','style'=>'color: white')); ?>
<?php 
	$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<div class="row-fluid">
	<div class="span6 offset3">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Monitor Account',
			));
		?>
			<?php echo CHtml::errorSummary($form); ?>
			<?php echo CHtml::beginForm(array('/activeMonitor/index'), 'POST',array('style'=>'padding: 20px')); ?>
				<?php echo CHtml::activeLabelEx($form, 'accountsMonitor'); ?>
				<?php
					$this->widget('yiiwheels.widgets.select2.WhSelect2', array(
					'model' => $form,
					'attribute' => 'accountsMonitor',
					'asDropDownList' => false,
					'pluginOptions' => array(
					    'tags' => $allSipAccounts,
					    'placeholder' => 'type accounts',
					    'width' => '80%',
					    'tokenSeparators' => array(',', ' ')
					)));
				?>
				<?php echo CHtml::error($form, 'accountsMonitor'); ?>
				<br>
				<br>
				<button type='submit' class='btn btn-lg btn-primary'>Submit</button>
			<?php echo CHtml::endForm(); ?>
			<div class="clearfix"></div>
		<?php
			$this->endWidget();
		?>
	</div>
</div>
