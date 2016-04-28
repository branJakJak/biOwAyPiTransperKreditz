<?php
/* @var $this ForceAgentTableController */
/* @var $model ForceAgentTable */
/* @var $form CActiveForm */
?>

<div class="form">
<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>'Create new option',
		'htmlOptions'=>array('class'=>'offset3 span5 portlet'),
	));
?>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'force-agent-table-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
		
	)); ?>

		<p class="note">Fields with <span class="required">*</span> are required.</p>

		<?php echo $form->errorSummary($model); ?>

		<div class="span12">
			<?php echo $form->labelEx($model,'force_agent_lbl'); ?>
			<?php echo $form->textField($model,'force_agent_lbl',array('size'=>60,'maxlength'=>255,'class'=>'span11')); ?>
			<?php echo $form->error($model,'force_agent_lbl'); ?>
		</div>

		<div class="span12">
			<?php echo $form->labelEx($model,'force_agent_value'); ?>
			<?php echo $form->textField($model,'force_agent_value',array('size'=>60,'maxlength'=>255,'class'=>'span11')); ?>
			<?php echo $form->error($model,'force_agent_value'); ?>
		</div>
		<hr>
		<div class="span12 buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'span11 btn btn-primary')); ?>
		</div>
		<div class="clearfix"></div>

	<?php $this->endWidget(); ?>

	</div><!-- form -->
	<div class="clearfix"></div>

<?php
	$this->endWidget();
?>