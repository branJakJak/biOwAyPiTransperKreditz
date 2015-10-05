<?php
/* @var $this UserRequestController */
/* @var $model UserRequest */

$this->breadcrumbs=array(
	'User Requests'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UserRequest', 'url'=>array('index')),
	array('label'=>'Manage UserRequest', 'url'=>array('admin')),
);
?>

<h1>Create UserRequest</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>