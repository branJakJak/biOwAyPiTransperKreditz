<?php
/* @var $this ScheduledForceAgentController */
/* @var $model ScheduledForceAgent */

$this->breadcrumbs=array(
	'Scheduled Force Agents'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ScheduledForceAgent', 'url'=>array('index')),
	array('label'=>'Create ScheduledForceAgent', 'url'=>array('create')),
	array('label'=>'Update ScheduledForceAgent', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ScheduledForceAgent', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ScheduledForceAgent', 'url'=>array('admin')),
);
?>

<h1>View ScheduledForceAgent #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'scheduled_date',
		'account_id',
		'topup_amount',
		'activate',
		'created_at',
		'updated_at',
	),
)); ?>
