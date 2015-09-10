<?php
/* @var $this FreeVoipAccountsController */
/* @var $model FreeVoipAccounts */

$this->breadcrumbs=array(
	'Free Voip Accounts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List accounts', 'url'=>array('index')),
	array('label'=>'Create accounts', 'url'=>array('create')),
	array('label'=>'Update accounts', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete accounts', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage accounts', 'url'=>array('admin')),
);
?>

<h1>View FreeVoipAccounts #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'password',
		'date_created',
		'date_updated',
	),
)); ?>
