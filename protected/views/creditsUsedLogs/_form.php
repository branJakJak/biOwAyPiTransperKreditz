<?php
/* @var $this CreditsUsedLogsController */
/* @var $model CreditsUsedLogs */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'credits-used-logs-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'credit_used'); ?>
		<?php echo $form->textField($model,'credit_used'); ?>
		<?php echo $form->error($model,'credit_used'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'log_date'); ?>
		<?php echo $form->textField($model,'log_date'); ?>
		<?php echo $form->error($model,'log_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'remote_data_cache_accout_id'); ?>
		<?php echo $form->textField($model,'remote_data_cache_accout_id'); ?>
		<?php echo $form->error($model,'remote_data_cache_accout_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->