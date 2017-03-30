<?php
/* @var $this RemoteDataCacheController */
/* @var $model RemoteDataCache */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'remote-data-cache-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<fieldset>
		<legend>Position</legend>
		<div class="row">
			<div class="span6">
				<?php echo $form->labelEx($model,'priority'); ?>
				<?php echo CHtml::activeDropDownList($model, 'priority', array('top'=>'Top','bottom'=>'Bottom')); ?>
				<?php echo $form->error($model,'priority'); ?>
			</div>
		</div>
	</fieldset>


	<fieldset>
		<legend>Account Information : </legend>
		<div class="row">
			<div class="span3">
				<?php echo $form->labelEx($model,'main_user'); ?>
				<?php echo $form->textField($model,'main_user',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'main_user'); ?>
			</div>
			<div class="span3">
				<?php echo $form->labelEx($model,'main_pass'); ?>
				<?php echo $form->textField($model,'main_pass',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'main_pass'); ?>
			</div>
		</div>
		<div class="row">
			<div class="span3">
				<?php echo $form->labelEx($model,'sub_user'); ?>
				<?php echo $form->textField($model,'sub_user',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'sub_user'); ?>
			</div>
			<div class="span3">
				<?php echo $form->labelEx($model,'sub_pass'); ?>
				<?php echo $form->textField($model,'sub_pass',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'sub_pass'); ?>
			</div>
		</div>
	</fieldset>
	<br>
	<fieldset>
		<legend>Balance Information</legend>
		<div class="row">
			<div class="span3">
				<?php echo $form->labelEx($model,'is_active'); ?>
				<?php echo CHtml::activeDropDownList($model, 'is_active', array('ACTIVE'=>'ACTIVE','INACTIVE'=>"INACTIVE")); ?>
				<?php echo $form->error($model,'is_active'); ?>
			</div>
			<div class="span3">
				<?php echo $form->labelEx($model,'last_balance'); ?>
				<?php echo $form->textField($model,'last_balance'); ?>
				<?php echo $form->error($model,'last_balance'); ?>
			</div>
		</div>
		<div class="row">
			<div class="span3">
				<?php echo $form->labelEx($model,'balance'); ?>
				<?php echo $form->textField($model,'balance'); ?>
				<?php echo $form->error($model,'balance'); ?>
			</div>
			<div class="span3">
				<?php echo $form->labelEx($model,'exact_balance'); ?>
				<?php echo $form->textField($model,'exact_balance'); ?>
				<?php echo $form->error($model,'exact_balance'); ?>
			</div>
		</div>
		<div class="row">
			<div class="span3">
				<?php echo $form->labelEx($model,'last_balance_since_topup'); ?>
				<?php echo $form->textField($model,'last_balance_since_topup'); ?>
				<?php echo $form->error($model,'last_balance_since_topup'); ?>
			</div>
		</div>


	</fieldset>
	<br>
	<fieldset>
		<legend>Other Information</legend>
		<div class="row">
			<div class="span3">
				<?php echo $form->labelEx($model,'vici_user'); ?>
				<?php echo $form->textField($model,'vici_user'); ?>
				<?php echo $form->error($model,'vici_user'); ?>
			</div>
			<div class="span3">
				<?php echo $form->labelEx($model,'ip_address'); ?>
				<?php echo $form->textField($model,'ip_address',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'ip_address'); ?>
			</div>
		</div>
		<div class="row">
			<div class="span3">
				<?php echo $form->labelEx($model,'num_lines'); ?>
				<?php echo $form->textField($model,'num_lines'); ?>
				<?php echo $form->error($model,'num_lines'); ?>
			</div>
			<div class="span3">
				<?php echo $form->labelEx($model,'campaign'); ?>
				<?php echo $form->textField($model,'campaign'); ?>
				<?php echo $form->error($model,'campaign'); ?>
			</div>
		</div>
	</fieldset>
	<fieldset>
		<legend></legend>
		<div class="row">
			<div class="span6">
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary btn-block')); ?>
			</div>
		</div>
	</fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->