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
		<div class="span4">
			<?php echo $form->label($model,'log_date'); ?>
			<?php
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
			    'model'=>$model,
			    'attribute'=>'log_date',
			    'language'=>'en',
			    'options'=>[
			    	'changeMonth'=>true,
			    	'changeYear'=>true
			    ]
			));
			?>
		</div>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->