<?php
/* @var $this ForceAgentTableController */
/* @var $data ForceAgentTable */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('force_agent_lbl')); ?>:</b>
	<?php echo CHtml::encode($data->force_agent_lbl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('force_agent_value')); ?>:</b>
	<?php echo CHtml::encode($data->force_agent_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_created')); ?>:</b>
	<?php echo CHtml::encode($data->date_created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_updated')); ?>:</b>
	<?php echo CHtml::encode($data->date_updated); ?>
	<br />


</div>