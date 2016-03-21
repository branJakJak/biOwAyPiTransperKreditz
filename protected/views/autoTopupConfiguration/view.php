<?php
/* @var $this AutoTopupConfigurationController */
/* @var $model AutoTopupConfiguration */

$this->breadcrumbs=array(
	'Auto Topup Configurations'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AutoTopupConfiguration', 'url'=>array('index')),
	array('label'=>'Create AutoTopupConfiguration', 'url'=>array('create')),
	array('label'=>'Update AutoTopupConfiguration', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AutoTopupConfiguration', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AutoTopupConfiguration', 'url'=>array('admin')),
);
?>

<h1>View AutoTopupConfiguration #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'activated',
		'topUpValue',
		'budget',
		'freeVoipAccount',
		'remote_data_cache',
		'date_created',
		'date_updated',
	),
)); ?>
