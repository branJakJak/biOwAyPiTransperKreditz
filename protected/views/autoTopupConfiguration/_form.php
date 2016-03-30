<?php
/* @var $this AutoTopupConfigurationController */
/* @var $model AutoTopupConfiguration */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'auto-topup-configuration-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'activated'); ?>
		<?php echo $form->textField($model,'activated'); ?>
		<?php echo $form->error($model,'activated'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'topUpValue'); ?>
		<?php echo $form->textField($model,'topUpValue'); ?>
		<?php echo $form->error($model,'topUpValue'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'budget'); ?>
		<?php echo $form->textField($model,'budget'); ?>
		<?php echo $form->error($model,'budget'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'freeVoipAccount'); ?>
		<?php echo $form->textField($model,'freeVoipAccount'); ?>
		<?php echo $form->error($model,'freeVoipAccount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'remote_data_cache'); ?>
		<?php echo $form->textField($model,'remote_data_cache'); ?>
		<?php echo $form->error($model,'remote_data_cache'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_created'); ?>
		<?php echo $form->textField($model,'date_created'); ?>
		<?php echo $form->error($model,'date_created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_updated'); ?>
		<?php echo $form->textField($model,'date_updated'); ?>
		<?php echo $form->error($model,'date_updated'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->