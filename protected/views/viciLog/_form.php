<?php
/* @var $this ViciLogController */
/* @var $model ViciLogAction */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vici-log-action-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'action_type'); ?>
		<?php echo $form->textField($model,'action_type',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'action_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'message'); ?>
		<?php echo $form->textField($model,'message',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'message'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'topUpValue'); ?>
		<?php echo $form->textField($model,'topUpValue'); ?>
		<?php echo $form->error($model,'topUpValue'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'batch'); ?>
		<?php echo $form->textField($model,'batch',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'batch'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'logDate'); ?>
		<?php echo $form->textField($model,'logDate'); ?>
		<?php echo $form->error($model,'logDate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->