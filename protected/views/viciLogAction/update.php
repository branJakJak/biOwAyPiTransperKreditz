<?php
/* @var $this ViciLogActionController */
/* @var $model ViciLogAction */

$this->breadcrumbs=array(
	'Vici Log Actions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ViciLogAction', 'url'=>array('index')),
	array('label'=>'Create ViciLogAction', 'url'=>array('create')),
	array('label'=>'View ViciLogAction', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ViciLogAction', 'url'=>array('admin')),
);
?>

<h1>Update ViciLogAction <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>