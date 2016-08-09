<?php
/* @var $this AccountChargeLogController */
/* @var $model AccountChargeLog */

$this->breadcrumbs=array(
	'Account Charge Logs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AccountChargeLog', 'url'=>array('index')),
	array('label'=>'Create AccountChargeLog', 'url'=>array('create')),
	array('label'=>'Update AccountChargeLog', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AccountChargeLog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AccountChargeLog', 'url'=>array('admin')),
);
?>

<h1>View AccountChargeLog #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'account_id',
		'charge',
		'date_created',
		'date_updated',
	),
)); ?>
