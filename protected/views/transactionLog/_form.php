<?php
/* @var $this TransactionLogController */
/* @var $model TransactionLog */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transaction-log-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'freevoip_account'); ?>
		<?php echo $form->textField($model,'freevoip_account'); ?>
		<?php echo $form->error($model,'freevoip_account'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'to_username'); ?>
		<?php echo $form->textField($model,'to_username',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'to_username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->textField($model,'amount',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pincode'); ?>
		<?php echo $form->textField($model,'pincode',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'pincode'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->