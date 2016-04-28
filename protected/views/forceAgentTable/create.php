<?php
/* @var $this ForceAgentTableController */
/* @var $model ForceAgentTable */

$this->breadcrumbs=array(
	'Force Agent Tables'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Show all options', 'url'=>array('index')),
	array('label'=>'Manage all options', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>