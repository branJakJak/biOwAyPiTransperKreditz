<?php
/* @var $this ScheduledForceAgentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Scheduled Force Agents',
);

$this->menu=array(
	array('label'=>'Create ScheduledForceAgent', 'url'=>array('create')),
	array('label'=>'Manage ScheduledForceAgent', 'url'=>array('admin')),
);
?>

<h1>Scheduled Force Agents</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
