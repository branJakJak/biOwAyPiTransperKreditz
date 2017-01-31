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
	<?php echo CHtml::hiddenField('account', $remote_data_cache); ?>

	<div class="row">
		<div class="span4">
			<label>Log Date</label>
			<?php
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
			    'name'=>'log_date',
			    'language'=>'en',
			    'options'=>[
			    	'dateFormat' => 'yy-mm-dd',
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