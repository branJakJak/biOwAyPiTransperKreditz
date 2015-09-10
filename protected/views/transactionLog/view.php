<?php
/* @var $this TransactionLogController */
/* @var $model TransactionLog */

$this->breadcrumbs=array(
	'Transaction Logs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TransactionLog', 'url'=>array('index')),
	//array('label'=>'Create TransactionLog', 'url'=>array('create')),
	array('label'=>'Update TransactionLog', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TransactionLog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TransactionLog', 'url'=>array('admin')),
);
?>

<h1>View Transaction Log #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'freevoip_account',
		'to_username',
		'amount',
		'pincode',
		'date_created',
		'date_updated',
	),
)); ?>
