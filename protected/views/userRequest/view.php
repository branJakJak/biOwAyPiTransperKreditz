<?php
/* @var $this UserRequestController */
/* @var $model UserRequest */

$this->breadcrumbs=array(
	'User Requests'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List UserRequest', 'url'=>array('index')),
	array('label'=>'Create UserRequest', 'url'=>array('create')),
	array('label'=>'Update UserRequest', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UserRequest', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserRequest', 'url'=>array('admin')),
);
?>

<h1>View UserRequest #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_agent',
		'ip_address',
		'url_refferer',
		'date_created',
		'date_updated',
	),
)); ?>
