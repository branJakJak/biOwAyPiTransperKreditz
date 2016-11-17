<?php
/* @var $this RemoteDataCacheController */
/* @var $model RemoteDataCache */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'main_user'); ?>
		<?php echo $form->textField($model,'main_user',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'main_pass'); ?>
		<?php echo $form->textField($model,'main_pass',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sub_user'); ?>
		<?php echo $form->textField($model,'sub_user',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sub_pass'); ?>
		<?php echo $form->textField($model,'sub_pass',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vici_user'); ?>
		<?php echo $form->textField($model,'vici_user'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_active'); ?>
		<?php echo $form->textField($model,'is_active',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'last_balance'); ?>
		<?php echo $form->textField($model,'last_balance'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'balance'); ?>
		<?php echo $form->textField($model,'balance'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'exact_balance'); ?>
		<?php echo $form->textField($model,'exact_balance'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ip_address'); ?>
		<?php echo $form->textField($model,'ip_address',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'num_lines'); ?>
		<?php echo $form->textField($model,'num_lines'); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'campaign'); ?>
		<?php echo $form->textField($model,'campaign'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->