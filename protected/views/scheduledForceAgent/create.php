<?php
/* @var $this ScheduledForceAgentController */
/* @var $model ScheduledForceAgent */

$this->breadcrumbs=array(
	'Scheduled Force Agents'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ScheduledForceAgent', 'url'=>array('index')),
	array('label'=>'Manage ScheduledForceAgent', 'url'=>array('admin')),
);
?>

<h1>Create ScheduledForceAgent</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>