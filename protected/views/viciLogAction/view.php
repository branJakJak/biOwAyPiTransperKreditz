<?php
/* @var $this ViciLogActionController */
/* @var $model ViciLogAction */

$this->breadcrumbs=array(
	'Vici Log Actions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ViciLogAction', 'url'=>array('index')),
	array('label'=>'Create ViciLogAction', 'url'=>array('create')),
	array('label'=>'Update ViciLogAction', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ViciLogAction', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ViciLogAction', 'url'=>array('admin')),
);
?>

<h1>View ViciLogAction #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'action_type',
		'message',
		'topUpValue',
		'batch',
		'logDate',
	),
)); ?>
