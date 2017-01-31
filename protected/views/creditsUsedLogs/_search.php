<?php
/* @var $this CreditsUsedLogsController */
/* @var $model CreditsUsedLogs */
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
		<?php echo $form->label($model,'credit_used'); ?>
		<?php echo $form->textField($model,'credit_used'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'log_date'); ?>
		<?php echo $form->textField($model,'log_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'remote_data_cache_accout_id'); ?>
		<?php echo $form->textField($model,'remote_data_cache_accout_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->