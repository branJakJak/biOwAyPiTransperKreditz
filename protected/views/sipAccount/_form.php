<?php
/* @var $this SipAccountController */
/* @var $model SipAccount */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sip-account-form',
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'vicidial_identification'); ?>
		<?php echo $form->textField($model,'vicidial_identification',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'vicidial_identification'); ?>
	</div>


	<div class="row">
		<button type="submit" class="btn btn-primary">Create</button>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->