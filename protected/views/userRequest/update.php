<?php
/* @var $this UserRequestController */
/* @var $model UserRequest */

$this->breadcrumbs=array(
	'User Requests'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UserRequest', 'url'=>array('index')),
	array('label'=>'Create UserRequest', 'url'=>array('create')),
	array('label'=>'View UserRequest', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage UserRequest', 'url'=>array('admin')),
);
?>

<h1>Update UserRequest <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>