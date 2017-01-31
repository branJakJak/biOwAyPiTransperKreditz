<?php
/* @var $this CreditsUsedLogsController */
/* @var $model CreditsUsedLogs */

$this->breadcrumbs=array(
	'Credits Used Logs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CreditsUsedLogs', 'url'=>array('index')),
	array('label'=>'Create CreditsUsedLogs', 'url'=>array('create')),
	array('label'=>'Update CreditsUsedLogs', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CreditsUsedLogs', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CreditsUsedLogs', 'url'=>array('admin')),
);
?>

<h1>View CreditsUsedLogs #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'credit_used',
		'log_date',
		'remote_data_cache_accout_id',
	),
)); ?>
