<?php
/* @var $this ScheduledForceAgentController */
/* @var $model ScheduledForceAgent */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'scheduled-force-agent-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'scheduled_date'); ?>
		<?php echo $form->textField($model,'scheduled_date'); ?>
		<?php echo $form->error($model,'scheduled_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'account_id'); ?>
		<?php echo $form->textField($model,'account_id'); ?>
		<?php echo $form->error($model,'account_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'topup_amount'); ?>
		<?php echo $form->textField($model,'topup_amount'); ?>
		<?php echo $form->error($model,'topup_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'activate'); ?>
		<?php echo $form->textField($model,'activate'); ?>
		<?php echo $form->error($model,'activate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
		<?php echo $form->error($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'forceAgent'); ?>
		<?php echo $form->textField($model,'forceAgent'); ?>
		<?php echo $form->error($model,'forceAgent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_at'); ?>
		<?php echo $form->textField($model,'updated_at'); ?>
		<?php echo $form->error($model,'updated_at'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->