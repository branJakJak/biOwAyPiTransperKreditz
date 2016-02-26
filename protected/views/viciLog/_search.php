<?php
/* @var $this ViciLogController */
/* @var $model ViciLogAction */
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
		<?php echo $form->label($model,'action_type'); ?>
		<?php echo $form->textField($model,'action_type',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'message'); ?>
		<?php echo $form->textField($model,'message',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'topUpValue'); ?>
		<?php echo $form->textField($model,'topUpValue'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'batch'); ?>
		<?php echo $form->textField($model,'batch',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'logDate'); ?>
		<?php echo $form->textField($model,'logDate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->