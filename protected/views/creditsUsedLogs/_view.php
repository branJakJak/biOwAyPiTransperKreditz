<?php
/* @var $this CreditsUsedLogsController */
/* @var $data CreditsUsedLogs */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('credit_used')); ?>:</b>
	<?php echo CHtml::encode($data->credit_used); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('log_date')); ?>:</b>
	<?php echo CHtml::encode($data->log_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('remote_data_cache_accout_id')); ?>:</b>
	<?php 
		$remoteDataCache = $data->getRemoteDataCache();
		$remoteDataCacheUser = ($remoteDataCache) ? $remoteDataCache->sub_user:"n/a";
	?>
	<?php echo CHtml::encode(  $remoteDataCacheUser ); ?>
	<br />


</div>