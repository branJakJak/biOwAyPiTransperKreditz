<?php
/* @var $this ViciLogController */
/* @var $model ViciLogAction */

$this->breadcrumbs=array(
	'Vici Log Actions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ViciLogAction', 'url'=>array('index')),
	array('label'=>'Manage ViciLogAction', 'url'=>array('admin')),
);
?>

<h1>Create ViciLogAction</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>