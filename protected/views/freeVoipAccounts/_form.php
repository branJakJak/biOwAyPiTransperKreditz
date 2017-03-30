<?php
/* @var $this FreeVoipAccountsController */
/* @var $model FreeVoipAccounts */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'free-voip-accounts-form',
	'enableAjaxValidation'=>false,
)); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>255,'style'=>'width: 90%')); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div s="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->textField($model,'password',array('size'=>60,'maxlength'=>255,'style'=>'width: 90%')); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'credits'); ?>
		<?php echo $form->textField($model,'credits',array('size'=>60,'maxlength'=>255,'style'=>'width: 90%')); ?>
		<?php echo $form->error($model,'credits'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',['style'=>'width: 90%']); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
	<hr>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary btn-block','style'=>'width: 95%')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->