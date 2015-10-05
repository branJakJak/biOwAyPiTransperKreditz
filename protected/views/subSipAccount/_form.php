<?php
/* @var $this SubSipAccountController */
/* @var $model SubSipAccount */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sub-sip-account-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'parent_sip'); ?>
		<?php echo CHtml::activeDropDownList($model, 'parent_sip', CHtml::listData(SipAccount::model()->findAll(), 'id', 'username'), array('prompt'=>"Choose parent SIP Account")); ?>
		<?php echo $form->error($model,'parent_sip'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'customer_name'); ?>
		<?php echo $form->textField($model,'customer_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'customer_name'); ?>
	</div>

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

<!-- 
	<div class="row">
		<?php echo $form->labelEx($model,'last_checked_bal'); ?>
		<?php echo $form->textField($model,'last_checked_bal',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'last_checked_bal'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'balance'); ?>
		<?php echo $form->textField($model,'balance',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'balance'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'exact_balance'); ?>
		<?php echo $form->textField($model,'exact_balance',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'exact_balance'); ?>
	</div> -->

	<div class="row buttons">
		<button type="submit" class="btn btn-primary">Create</button>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->