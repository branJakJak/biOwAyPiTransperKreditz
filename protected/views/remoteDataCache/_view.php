<?php
/* @var $this RemoteDataCacheController */
/* @var $data RemoteDataCache */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('main_user')); ?>:</b>
	<?php echo CHtml::encode($data->main_user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('main_pass')); ?>:</b>
	<?php echo CHtml::encode($data->main_pass); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sub_user')); ?>:</b>
	<?php echo CHtml::encode($data->sub_user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sub_pass')); ?>:</b>
	<?php echo CHtml::encode($data->sub_pass); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vici_user')); ?>:</b>
	<?php echo CHtml::encode($data->vici_user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo CHtml::encode($data->is_active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_balance')); ?>:</b>
	<?php echo CHtml::encode($data->last_balance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('balance')); ?>:</b>
	<?php echo CHtml::encode($data->balance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exact_balance')); ?>:</b>
	<?php echo CHtml::encode($data->exact_balance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_balance_since_topup')); ?>:</b>
	<?php echo CHtml::encode($data->last_balance_since_topup); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campaign')); ?>:</b>
	<?php echo CHtml::encode($data->campaign); ?>
	<br />

	<?php /*

	<b><?php echo CHtml::encode($data->getAttributeLabel('ip_address')); ?>:</b>
	<?php echo CHtml::encode($data->ip_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('num_lines')); ?>:</b>
	<?php echo CHtml::encode($data->num_lines); ?>
	<br />

	*/ ?>

</div>