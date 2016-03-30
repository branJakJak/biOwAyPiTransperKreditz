<?php
/* @var $this ViciLogController */
/* @var $data ViciLogAction */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('action_type')); ?>:</b>
	<?php echo CHtml::encode($data->action_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('message')); ?>:</b>
	<?php echo CHtml::encode($data->message); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('topUpValue')); ?>:</b>
	<?php echo CHtml::encode($data->topUpValue); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('batch')); ?>:</b>
	<?php echo CHtml::encode($data->batch); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('logDate')); ?>:</b>
	<?php echo CHtml::encode($data->logDate); ?>
	<br />


</div>