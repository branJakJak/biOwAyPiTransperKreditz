<?php
/* @var $this ScheduledForceAgentController */
/* @var $model ScheduledForceAgent */

$this->breadcrumbs=array(
	'Scheduled Force Agents'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ScheduledForceAgent', 'url'=>array('index')),
	array('label'=>'Create ScheduledForceAgent', 'url'=>array('create')),
	array('label'=>'View ScheduledForceAgent', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ScheduledForceAgent', 'url'=>array('admin')),
);
?>

<h1>Update ScheduledForceAgent <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>